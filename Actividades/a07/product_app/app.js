$(document).ready(function(){
    let edit = false;

    $('#product-result').hide();
    listarProductos();

    function listarProductos() {
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',
            success: function(response) {
                console.log("Respuesta del servidor:", response);
                // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                const productos = JSON.parse(response);
                // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
                if(Object.keys(productos).length > 0) {
                    // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                    let template = '';

                    productos.forEach(producto => {
                        // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                        let descripcion = '';
                        descripcion += '<li>precio: '+producto.precio+'</li>';
                        descripcion += '<li>unidades: '+producto.unidades+'</li>';
                        descripcion += '<li>modelo: '+producto.modelo+'</li>';
                        descripcion += '<li>marca: '+producto.marca+'</li>';
                        descripcion += '<li>detalles: '+producto.detalles+'</li>';
                    
                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger" onclick="eliminarProducto()">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                    $('#products').html(template);
                }
            }
        });
    }

    $('#search').keyup(function() {
        if($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: './backend/product-search.php?search='+$('#search').val(),
                data: {search},
                type: 'GET',
                success: function (response) {
                    console.log(response);
                    if(!response.error) {
                        // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                        const productos = JSON.parse(response);
                        
                        // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
                        if(Object.keys(productos).length > 0) {
                            // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                            let template = '';
                            let template_bar = '';

                            productos.forEach(producto => {
                                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                                let descripcion = '';
                                descripcion += '<li>precio: '+producto.precio+'</li>';
                                descripcion += '<li>unidades: '+producto.unidades+'</li>';
                                descripcion += '<li>modelo: '+producto.modelo+'</li>';
                                descripcion += '<li>marca: '+producto.marca+'</li>';
                                descripcion += '<li>detalles: '+producto.detalles+'</li>';
                            
                                template += `
                                    <tr productId="${producto.id}">
                                        <td>${producto.id}</td>
                                        <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                        <td><ul>${descripcion}</ul></td>
                                        <td>
                                            <button class="product-delete btn btn-danger">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                `;

                                template_bar += `
                                    <li>${producto.nombre}</il>
                                `;
                            });
                            // SE HACE VISIBLE LA BARRA DE ESTADO
                            $('#product-result').show();
                            // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                            $('#container').html(template_bar);
                            // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                            $('#products').html(template);    
                        }
                    }
                }
            });
        }
        else {
            $('#product-result').hide();
        }
    });

    // Validación especial del nombre en el servidor
    $("#nombre").keyup(function() {
        const nombre = $(this).val();

        if(nombre != '') {
            $.get('./backend/product-search.php?nombre=' + nombre, function(response){
                const data = JSON.parse(response);
                if(Object.keys(data).length > 0) {
                    html = '<li style="color: red; list-style:none;">El producto ya existe en la BD</li>';
                    $("#product-result").show();
                    $("#container").html(html);
                } else {
                    $("#container").html("");
                    $("#product-result").hide();
                }
            });
        }
    });

    // Validar campos individuales cuando el usuario sale del input
$("#product-form input, #product-form textarea").on("blur", function () {
    const campo = $(this).attr("id");
    const valor = ($(this).val() ?? "").toString().trim();

    // Se ejecuta la validación según el tipo de campo
    const resultado = validarCampo(campo, valor);

    if (resultado.status === "error") {
        mostrarErroresEnBarra(campo, resultado.message);
    } else {
        actualizarErrores(campo);
    }
});


$('#product-form').on('submit', function (e) {
    e.preventDefault();

    // Construcción del objeto con todos los campos del formulario
    const postData = {
        nombre: $('#nombre').val()?.trim() || '',
        marca: $('#marca').val()?.trim() || '',
        modelo: $('#modelo').val()?.trim() || '',
        precio: $('#precio').val()?.trim() || '',
        unidades: $('#unidades').val()?.trim() || '',
        detalles: $('#detalles').val()?.trim() || '',
        imagen: $('#imagen').val()?.trim() || '',
        id: $('#productId').val()?.trim() || ''
    };

    // Validación del producto antes de enviarlo
    if (!validarProducto(postData)) {
        return;
    }

    // Determina si es agregar o editar
    const url = edit ? './backend/product-edit.php' : './backend/product-add.php';

    $.post(url, postData, function (response) {
        try {
            const res = JSON.parse(response);

            const barraHTML = `
                <li style="list-style: none;">Estado: ${res.status}</li>
                <li style="list-style: none;">Mensaje: ${res.message}</li>
            `;

            $('#product-form')[0].reset();
            $('#product-result').show();
            $('#container').html(barraHTML);
            listarProductos();
            edit = false;
        } catch (err) {
            console.error("Error al procesar la respuesta del servidor:", err, response);
            $('#container').html(`<li style="color:red; list-style:none;">Error al procesar respuesta del servidor.</li>`);
            $('#product-result').show();
        }
    });
});


    $(document).on('click', '.product-delete', (e) => {
        if(confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(this)[0].activeElement.parentElement.parentElement;
            const id = $(element).attr('productId');
            $.post('./backend/product-delete.php', {id}, (response) => {
                $('#product-result').hide();
                listarProductos();
            });
        }
    });

    $(document).on('click', '.product-item', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(element).attr('productId');
        $.post('./backend/product-single.php', {id}, (response) => {
            // SE CONVIERTE A OBJETO EL JSON OBTENIDO
            let product = JSON.parse(response);
            // SE INSERTAN LOS DATOS ESPECIALES EN LOS CAMPOS CORRESPONDIENTES
            $('#nombre').val(product.nombre);
            $('#marca').val(product.marca);
            $('#modelo').val(product.modelo);
            $('#precio').val(product.precio);
            $('#unidades').val(product.unidades);
            $('#detalles').val(product.detalles);
            $('#imagen').val(product.imagen);
            // EL ID SE INSERTA EN UN CAMPO OCULTO PARA USARLO DESPUÉS PARA LA ACTUALIZACIÓN
            $('#productId').val(product.id);
            
            // SE PONE LA BANDERA DE EDICIÓN EN true
            edit = true;
        });
        e.preventDefault();
    });    
});
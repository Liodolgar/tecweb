// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

// INICIALIZACIÓN CON JQUERY
$(document).ready(function() {
    init();

    // Manejar submit del formulario de agregar producto
    $('#product-form').submit(function(e){
        e.preventDefault();
        agregarProducto();
    });

    // Manejar submit del formulario de búsqueda
    $('#search').closest('form').submit(function(e){
        e.preventDefault();
        buscarProducto();
    });
    
    $('#search').on('input', function() {
buscarProducto();
});


    // Delegar click de eliminar producto en la tabla
    $('#products').on('click', '.product-delete', function() {
        eliminarProducto($(this).closest('tr').attr('productId'));
    });
});

// FUNCIONES
function init() {
    $('#description').val(JSON.stringify(baseJSON, null, 2));
    listarProductos();
}

function listarProductos() {
    $.get('./backend/product-list.php', function(response){
        let productos = JSON.parse(response);
        let template = '';

        productos.forEach(producto => {
            let descripcion = `
                <li>precio: ${producto.precio}</li>
                <li>unidades: ${producto.unidades}</li>
                <li>modelo: ${producto.modelo}</li>
                <li>marca: ${producto.marca}</li>
                <li>detalles: ${producto.detalles}</li>
            `;
            template += `
                <tr productId="${producto.id}">
                    <td>${producto.id}</td>
                    <td>${producto.nombre}</td>
                    <td><ul>${descripcion}</ul></td>
                    <td>
                        <button class="product-delete btn btn-danger">Eliminar</button>
                    </td>
                </tr>
            `;
        });

        $('#products').html(template);
    });
}

function buscarProducto() {
    let search = $('#search').val();
    $.get('./backend/product-search.php', {search: search}, function(response){
        let productos = JSON.parse(response);
        let template = '';
        let template_bar = '';

        productos.forEach(producto => {
            let descripcion = `
                <li>precio: ${producto.precio}</li>
                <li>unidades: ${producto.unidades}</li>
                <li>modelo: ${producto.modelo}</li>
                <li>marca: ${producto.marca}</li>
                <li>detalles: ${producto.detalles}</li>
            `;
            template += `
                <tr productId="${producto.id}">
                    <td>${producto.id}</td>
                    <td>${producto.nombre}</td>
                    <td><ul>${descripcion}</ul></td>
                    <td>
                        <button class="product-delete btn btn-danger">Eliminar</button>
                    </td>
                </tr>
            `;
            template_bar += `<li>${producto.nombre}</li>`;
        });

        $('#product-result').removeClass('d-none').addClass('d-block');
        $('#container').html(template_bar);
        $('#products').html(template);
    });
}

function agregarProducto() {
    let nombre = $('#name').val().trim();
    let jsonText = $('#description').val().trim();
    let finalJSON;

    // Validar que haya un nombre
    if(nombre === "") {
        alert("Debes ingresar el nombre del producto");
        return;
    }

    // Validar que el JSON sea válido
    try {
        finalJSON = JSON.parse(jsonText);
    } catch(e) {
        alert("JSON inválido. Revisa la sintaxis.");
        return;
    }

    // Validar que falten campos importantes
    const requiredFields = ["precio","unidades","modelo","marca","detalles","imagen"];
    for(let field of requiredFields){
        if(!(field in finalJSON)) {
            alert(`Falta el campo "${field}" en el JSON`);
            return;
        }
    }

    // Agregar el nombre al JSON
    finalJSON['nombre'] = nombre;

    // Enviar al backend
    $.ajax({
        url: './backend/product-add.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(finalJSON),
        success: function(response){
            let respuesta = JSON.parse(response);
            let template_bar = `
                <li style="list-style: none;">status: ${respuesta.status}</li>
                <li style="list-style: none;">message: ${respuesta.message}</li>
            `;
            $('#product-result').removeClass('d-none').addClass('d-block');
            $('#container').html(template_bar);
            listarProductos();
        }
    });
}


function eliminarProducto(id) {
    if(confirm("De verdad deseas eliminar el Producto")) {
        $.get('./backend/product-delete.php', {id: id}, function(response) {
            let respuesta = JSON.parse(response);
            let template_bar = `
                <li style="list-style: none;">status: ${respuesta.status}</li>
                <li style="list-style: none;">message: ${respuesta.message}</li>
            `;
            $('#product-result').removeClass('d-none').addClass('d-block');
            $('#container').html(template_bar);
            listarProductos();
        });
    }
}

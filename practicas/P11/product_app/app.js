// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
  };


// FUNCION COMPATIBLE CON NAVEGADORES PARA AJAX
function getXMLHttpRequest() {
    var objetoAjax;
    try {
        objetoAjax = new XMLHttpRequest();
    } catch (err1) {
        try {
            objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (err2) {
            try {
                objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (err3) {
                objetoAjax = false;
            }
        }
    }
    return objetoAjax;
}

// FUNCIÓN CALLBACK DE BOTÓN "Buscar"
function buscarID(e) {
    e.preventDefault();

    // SE OBTIENE EL ID A BUSCAR
    var id = document.getElementById('search').value;

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n'+client.responseText);
            
            let productos = JSON.parse(client.responseText);
            
            if(Object.keys(productos).length > 0) {
                let descripcion = '';
                    descripcion += '<li>precio: '+productos.precio+'</li>';
                    descripcion += '<li>unidades: '+productos.unidades+'</li>';
                    descripcion += '<li>modelo: '+productos.modelo+'</li>';
                    descripcion += '<li>marca: '+productos.marca+'</li>';
                    descripcion += '<li>detalles: '+productos.detalles+'</li>';
                
                let template = '';
                    template += `
                        <tr>
                            <td>${productos.id}</td>
                            <td>${productos.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;

                document.getElementById("productos").innerHTML = template;
            }
        }
    };
    client.send("id="+id);
}

/* ============================================================
   NUEVA FUNCIÓN: buscarProducto()
   Permite buscar por parte del nombre, marca o detalles
   usando GET y mostrando todos los resultados coincidentes.
   ============================================================ */
function buscarProducto(e) {
    e.preventDefault();

    var criterio = document.getElementById('search').value;

    var client = new XMLHttpRequest();
    client.open('GET', './backend/read.php?criterio=' + encodeURIComponent(criterio), true);
    client.onreadystatechange = function() {
        if (client.readyState === 4 && client.status === 200) {
            var productos = JSON.parse(client.responseText);
            var tbody = document.getElementById("productos");
            tbody.innerHTML = '';

            productos.forEach(prod => {
                let descripcion = `
                    <li>precio: ${prod.precio}</li>
                    <li>unidades: ${prod.unidades}</li>
                    <li>modelo: ${prod.modelo}</li>
                    <li>marca: ${prod.marca}</li>
                    <li>detalles: ${prod.detalles}</li>
                `;
                tbody.innerHTML += `
                    <tr>
                        <td>${prod.id}</td>
                        <td>${prod.nombre}</td>
                        <td><ul>${descripcion}</ul></td>
                    </tr>
                `;
            });
        }
    };
    client.send();
}


// FUNCIÓN CALLBACK DE BOTÓN "Agregar Producto"
function agregarProducto(e) {
    e.preventDefault();

    var nombre = document.getElementById('name').value.trim();
    var productoJsonString = document.getElementById('description').value.trim();

    if (!nombre || !productoJsonString) {
        alert('Debes llenar nombre y JSON del producto');
        return;
    }

    var finalJSON = JSON.parse(productoJsonString);
    finalJSON['nombre'] = nombre; // aseguramos que el nombre venga del input

    // Validaciones simples de campos obligatorios
    if (!finalJSON.marca || !finalJSON.modelo || !finalJSON.precio || !finalJSON.detalles || !finalJSON.unidades) {
        alert('El JSON debe contener marca, modelo, precio, detalles y unidades');
        return;
    }

    var client = getXMLHttpRequest();
    client.open('POST', './backend/create.php', true);
    client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");
    client.onreadystatechange = function () {
        if (client.readyState == 4 && client.status == 200) {
            var resp = JSON.parse(client.responseText);
            alert(resp.message); // mostramos el mensaje del servidor
        }
    };
    client.send(JSON.stringify(finalJSON));
}


function init() {
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
}
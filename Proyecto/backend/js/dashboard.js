// ============================================
// CONFIGURACIÓN - API SLIM
// ============================================
const API_URL = 'http://localhost/tecweb/Proyecto/backend/public';

// Variables globales
let recursos = [];
let currentEditId = null;

// ============================================
// VERIFICAR SESIÓN AL CARGAR
// ============================================
window.addEventListener('load', async () => {
    await verificarSesion();
    await cargarRecursos();
    await cargarEstadisticas();
});

// ============================================
// VERIFICAR SESIÓN
// ============================================
async function verificarSesion() {
    try {
        const response = await fetch(`${API_URL}/check_session`);
        const data = await response.json();
        
        if (data.status !== 'success') {
            window.location.href = 'login.html';
            return;
        }
        
        // Actualizar info del usuario
        document.querySelector('.user-name').textContent = data.user.username;
        document.querySelector('.user-email').textContent = data.user.email || 'Administrador';
    } catch (error) {
        console.error('Error verificando sesión:', error);
        window.location.href = 'login.html';
    }
}

// ============================================
// NAVEGACIÓN ENTRE SECCIONES
// ============================================
const navButtons = document.querySelectorAll('.nav-btn');
const contentSections = document.querySelectorAll('.content-section');

navButtons.forEach(button => {
    button.addEventListener('click', () => {
        navButtons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
        
        contentSections.forEach(section => section.classList.remove('active'));
        
        const sectionId = button.getAttribute('data-section');
        document.getElementById(sectionId).classList.add('active');
        
        // Cerrar formulario al cambiar de sección
        const formRecurso = document.getElementById('formRecurso');
        if (formRecurso) {
            formRecurso.style.display = 'none';
            btnNuevoRecurso.classList.remove('active');
            btnNuevoRecurso.textContent = 'Nuevo recurso';
        }
        
        // Recargar datos según sección
        if (sectionId === 'estadisticas') {
            cargarEstadisticas();
        }
    });
});

// ============================================
// CERRAR SESIÓN
// ============================================
document.querySelector('.logout-btn').addEventListener('click', async () => {
    try {
        await fetch(`${API_URL}/logout`, { method: 'POST' });
        localStorage.removeItem('user');
        window.location.href = 'login.html';
    } catch (error) {
        console.error('Error al cerrar sesión:', error);
        window.location.href = 'login.html';
    }
});

// ============================================
// BOTÓN NUEVO RECURSO
// ============================================
const btnNuevoRecurso = document.getElementById('btnNuevoRecurso');
const formRecurso = document.getElementById('formRecurso');

btnNuevoRecurso.addEventListener('click', () => {
    if (formRecurso.style.display === 'none' || formRecurso.style.display === '') {
        formRecurso.style.display = 'block';
        btnNuevoRecurso.classList.add('active');
        btnNuevoRecurso.textContent = 'Cerrar formulario';
        currentEditId = null;
        document.querySelector('#formRecurso h2').textContent = 'Registrar Recurso';
        document.querySelector('#formRecurso form').reset();
    } else {
        formRecurso.style.display = 'none';
        btnNuevoRecurso.classList.remove('active');
        btnNuevoRecurso.textContent = 'Nuevo recurso';
    }
});

// ============================================
// GUARDAR RECURSO (CREAR/ACTUALIZAR)
// ============================================
document.querySelector('#formRecurso form').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    
    // Para tu API necesitamos enviar JSON
    const jsonData = {
        nombre: formData.get('nombre'),
        autor: formData.get('autor'),
        departamento: formData.get('departamento'),
        empresa_institucion: formData.get('empresa'),
        fecha_creacion: formData.get('fecha'),
        descripcion: formData.get('descripcion'),
        archivo: 'temp.pdf', // Placeholder, necesitarías subir el archivo por separado
        eliminado: 0
    };
    
    if (currentEditId) {
        jsonData.id = currentEditId;
    }
    
    try {
        const url = currentEditId ? `${API_URL}/recursos` : `${API_URL}/recursos`;
        const method = currentEditId ? 'PUT' : 'POST';
        
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(jsonData)
        });
        
        const data = await response.json();
        
        if (data.status === 'success') {
            alert(data.message);
            formRecurso.style.display = 'none';
            btnNuevoRecurso.classList.remove('active');
            btnNuevoRecurso.textContent = 'Nuevo recurso';
            e.target.reset();
            currentEditId = null;
            await cargarRecursos();
            await cargarEstadisticas();
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al guardar el recurso');
    }
});

// ============================================
// CARGAR RECURSOS
// ============================================
async function cargarRecursos() {
    try {
        const response = await fetch(`${API_URL}/recursos`);
        const data = await response.json();
        
        recursos = data;
        mostrarRecursos(recursos);
    } catch (error) {
        console.error('Error cargando recursos:', error);
    }
}

// ============================================
// MOSTRAR RECURSOS EN TABLA
// ============================================
function mostrarRecursos(recursos) {
    const tbody = document.querySelector('#tablaRecursos tbody');
    tbody.innerHTML = '';
    
    if (!Array.isArray(recursos) || recursos.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align:center;">No hay recursos disponibles</td></tr>';
        return;
    }
    
    recursos.forEach(recurso => {
        const tr = document.createElement('tr');
        
        // Obtener extensión del archivo
        const extension = recurso.archivo.split('.').pop().toLowerCase();
        const icono = getIconoPorExtension(extension);
        
        tr.innerHTML = `
            <td>${recurso.id}</td>
            <td>${recurso.nombre}</td>
            <td>${recurso.autor || 'N/A'}</td>
            <td>${recurso.empresa_institucion || 'N/A'}</td>
            <td>
                <span style="font-size: 24px; cursor: pointer;" title="Descargar ${extension}" onclick="descargarRecurso(${recurso.id})">
                    ${icono}
                </span>
            </td>
            <td>
                <button onclick="editarRecurso(${recurso.id})" style="background:#333; color:#fff; border:1px solid #555; padding:6px 12px; border-radius:5px; cursor:pointer; margin-right:5px;">✏️ Editar</button>
                <button onclick="eliminarRecurso(${recurso.id})" style="background:#500; color:#fff; border:1px solid #700; padding:6px 12px; border-radius:5px; cursor:pointer;">🗑️ Eliminar</button>
            </td>
        `;
        
        tbody.appendChild(tr);
    });
}

// ============================================
// ICONOS POR TIPO DE ARCHIVO
// ============================================
function getIconoPorExtension(ext) {
    const iconos = {
        'pdf': '📄', 'doc': '📝', 'docx': '📝',
        'xls': '📊', 'xlsx': '📊',
        'ppt': '📽️', 'pptx': '📽️',
        'zip': '🗜️', 'rar': '🗜️', '7z': '🗜️',
        'txt': '📃', 'json': '📋', 'xml': '📋',
        'csv': '📊', 'sql': '🗃️',
        'exe': '⚙️', 'jar': '☕',
        'jpg': '🖼️', 'jpeg': '🖼️', 'png': '🖼️', 'gif': '🖼️',
        'mp3': '🎵', 'mp4': '🎬', 'avi': '🎬', 'mkv': '🎬'
    };
    return iconos[ext] || '📦';
}

// ============================================
// DESCARGAR RECURSO
// ============================================
window.descargarRecurso = function(id) {
    window.open(`${API_URL}/download/${id}`, '_blank');
}

// ============================================
// EDITAR RECURSO
// ============================================
window.editarRecurso = async function(id) {
    const recurso = recursos.find(r => r.id == id);
    if (!recurso) return;
    
    currentEditId = id;
    
    // Llenar formulario
    document.querySelector('[name="nombre"]').value = recurso.nombre;
    document.querySelector('[name="autor"]').value = recurso.autor || '';
    document.querySelector('[name="departamento"]').value = recurso.departamento || '';
    document.querySelector('[name="empresa"]').value = recurso.empresa_institucion || '';
    document.querySelector('[name="fecha"]').value = recurso.fecha_creacion || '';
    document.querySelector('[name="descripcion"]').value = recurso.descripcion || '';
    
    // Mostrar formulario
    formRecurso.style.display = 'block';
    btnNuevoRecurso.classList.add('active');
    btnNuevoRecurso.textContent = 'Cerrar formulario';
    document.querySelector('#formRecurso h2').textContent = 'Editar Recurso';
    
    // Hacer archivo opcional
    document.querySelector('[name="archivo"]').removeAttribute('required');
}

// ============================================
// ELIMINAR RECURSO
// ============================================
window.eliminarRecurso = async function(id) {
    if (!confirm('¿Estás seguro de eliminar este recurso?')) return;
    
    try {
        const response = await fetch(`${API_URL}/recursos/${id}`, {
            method: 'DELETE'
        });
        
        const data = await response.json();
        
        if (data.status === 'success') {
            alert('Recurso eliminado correctamente');
            await cargarRecursos();
            await cargarEstadisticas();
        } else {
            alert('Error al eliminar: ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al eliminar el recurso');
    }
}

// ============================================
// BUSCAR RECURSOS
// ============================================
document.getElementById('BuscarRecurso').addEventListener('input', (e) => {
    const busqueda = e.target.value.toLowerCase();
    const recursosFiltrados = recursos.filter(r => 
        r.nombre.toLowerCase().includes(busqueda) ||
        (r.autor && r.autor.toLowerCase().includes(busqueda)) ||
        (r.departamento && r.departamento.toLowerCase().includes(busqueda))
    );
    mostrarRecursos(recursosFiltrados);
});

// ============================================
// CARGAR ESTADÍSTICAS Y GRÁFICAS
// ============================================
let chartTipos = null;
let chartRecursos = null;

async function cargarEstadisticas() {
    try {
        const response = await fetch(`${API_URL}/recursos`);
        const recursos = await response.json();
        
        if (!Array.isArray(recursos)) return;
        
        // Contar tipos de archivo
        const tiposCount = {};
        recursos.forEach(r => {
            const ext = r.archivo.split('.').pop().toLowerCase();
            tiposCount[ext] = (tiposCount[ext] || 0) + 1;
        });
        
        // Preparar datos para gráficas
        const labels = Object.keys(tiposCount);
        const valores = Object.values(tiposCount);
        
        // Destruir gráficas anteriores
        if (chartTipos) chartTipos.destroy();
        if (chartRecursos) chartRecursos.destroy();
        
        // Crear gráficas
        crearGraficaTipos(labels, valores);
        crearGraficaRecursos(recursos);
        
    } catch (error) {
        console.error('Error cargando estadísticas:', error);
    }
}

function crearGraficaTipos(labels, valores) {
    const ctx = document.getElementById('chartTipos');
    if (!ctx) return;
    
    chartTipos = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels.map(l => l.toUpperCase()),
            datasets: [{
                data: valores,
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                    '#FF9F40', '#FF6384', '#C9CBCF', '#4BC0C0', '#FF9F40'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { 
                    position: 'right',
                    labels: { color: '#fff' }
                },
                title: {
                    display: true,
                    text: 'Recursos por Tipo de Archivo',
                    color: '#fff',
                    font: { size: 18 }
                }
            }
        }
    });
}

function crearGraficaRecursos(recursos) {
    const ctx = document.getElementById('chartRecursos');
    if (!ctx) return;
    
    // Top 5 recursos
    const top5 = recursos.slice(0, 5);
    
    chartRecursos = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: top5.map(r => r.nombre.substring(0, 20)),
            datasets: [{
                label: 'ID del Recurso',
                data: top5.map(r => r.id),
                backgroundColor: '#36A2EB',
                borderColor: '#2E8BC0',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { 
                    beginAtZero: true,
                    ticks: { color: '#fff' }
                },
                x: { 
                    ticks: { color: '#fff' }
                }
            },
            plugins: {
                legend: { 
                    labels: { color: '#fff' }
                },
                title: {
                    display: true,
                    text: 'Recursos Recientes',
                    color: '#fff',
                    font: { size: 18 }
                }
            }
        }
    });
}
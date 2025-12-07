// Seleccionar todos los botones de navegación
const navButtons = document.querySelectorAll('.nav-btn');
const contentSections = document.querySelectorAll('.content-section');

const btnNuevoRecurso = document.getElementById("btnNuevoRecurso");
const formRecurso = document.getElementById("formRecurso");

// Agregar evento click a cada botón
navButtons.forEach(button => {
    button.addEventListener('click', () => {

        // Quitar active a todos
        navButtons.forEach(btn => btn.classList.remove('active'));

        // Activar botón actual
        button.classList.add('active');

        // Ocultar todas las secciones
        contentSections.forEach(section => section.classList.remove('active'));

        // Mostrar solo la seleccionada
        const sectionId = button.getAttribute('data-section');
        document.getElementById(sectionId).classList.add('active');

        // Al cambiar de sección, ocultar formulario de recursos
        if (formRecurso) {
            formRecurso.style.display = "none";
            btnNuevoRecurso.classList.remove("active");
            btnNuevoRecurso.textContent = "Nuevo recurso";
        }
    });
});

// Botón Nuevo Recurso
btnNuevoRecurso.addEventListener("click", () => {

    if (formRecurso.style.display === "none" || formRecurso.style.display === "") {

        formRecurso.style.display = "block";
        btnNuevoRecurso.classList.add("active");
        btnNuevoRecurso.textContent = "Cerrar formulario";

    } else {

        formRecurso.style.display = "none";
        btnNuevoRecurso.classList.remove("active");
        btnNuevoRecurso.textContent = "Nuevo recurso";

    }
});

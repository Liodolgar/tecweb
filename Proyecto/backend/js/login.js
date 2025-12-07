document.getElementById("loginForm").addEventListener("submit", async function(e) {
    console.log("login.js cargado");
    e.preventDefault();

    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    const data = {
        username: email,
        password: password
    };

    try {
        const response = await fetch("http://localhost/tecweb/Proyecto/backend/public/index.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data)
        });

        // Imprimir la respuesta completa para ver el error
        const text = await response.text();
        console.log("RESPUESTA COMPLETA:", text);

        // Intentar parsear como JSON
        const result = JSON.parse(text);
        console.log("Resultado:", result);

        if (result.status === "success") {
            localStorage.setItem("user", JSON.stringify(result.user));
            window.location.href = "../frontend/dashboard.html";
        } else {
            const error = document.getElementById("errorMsg");
            error.textContent = result.message || "Credenciales incorrectas";
            error.style.display = "block";
        }
    } catch (error) {
        console.error("Error completo:", error);
        const errorMsg = document.getElementById("errorMsg");
        errorMsg.textContent = "Error al conectar con el servidor";
        errorMsg.style.display = "block";
    }
});
function validarFormulario() {
    const nombre = document.getElementById("nombre").value.trim();
    const correo = document.getElementById("correo").value.trim();
    const telefono = document.getElementById("telefono").value.trim();
    const contrasena = document.getElementById("contrasena").value;

    if (nombre === "" || correo === "" || telefono === "" || contrasena === "") {
        alert("Todos los campos son obligatorios.");
        return false;
    }

    const correoValido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!correoValido.test(correo)) {
        alert("El correo electrónico no es válido.");
        return false;
    }

    if (telefono.length < 7 || telefono.length > 15) {
        alert("El número de teléfono debe tener entre 7 y 15 dígitos.");
        return false;
    }

    if (contrasena.length < 6) {
        alert("La contraseña debe tener al menos 6 caracteres.");
        return false;
    }

    return true;
}

 

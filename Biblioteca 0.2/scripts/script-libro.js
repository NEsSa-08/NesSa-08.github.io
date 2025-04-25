let cantidad = 0;
  const contador = document.getElementById("contador");
  const boton = document.getElementById("sumar");

  boton.addEventListener("click", () => {
    cantidad++;
    contador.textContent = cantidad;
  });
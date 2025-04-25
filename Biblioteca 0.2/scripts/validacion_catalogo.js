function generarIDLibro(titulo, editorial, autor) {
    const limpiar = str => str.trim().toUpperCase().replace(/[^A-Z0-9]/g, '');
    const id = (limpiar(titulo).substring(0, 3) +
                 limpiar(editorial).substring(0, 3) +
                 limpiar(autor).substring(0, 2)).substring(0, 8);
    return id;
  }
  
  document.getElementById('form-agregar-libro').addEventListener('submit', function(e) {
    const titulo = this.titulo.value;
    const editorial = this.editorial.value;
    const autor = this.autor.value;
  
    const idLibro = generarIDLibro(titulo, editorial, autor);
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'id_libro';
    hiddenInput.value = idLibro;
    this.appendChild(hiddenInput);
  });
  
  function mostrarFormulario(tipo) {
    document.querySelectorAll('.catalogo-tabs .tab').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.formulario').forEach(form => form.classList.remove('active'));

    document.querySelector(`#form-${tipo}`).classList.add('active');
    event.target.classList.add('active');
  }
  function mostrarVentana(id) {
    const ventanas = document.querySelectorAll('.ventana');
    ventanas.forEach(v => v.style.display = 'none'); // Oculta todas
    document.getElementById(id).style.display = 'block'; // Muestra solo una
  }
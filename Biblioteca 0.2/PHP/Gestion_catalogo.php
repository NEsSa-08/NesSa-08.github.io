<?php
include 'Conexion.php';

// Función para guardar imagen
function guardarImagen($archivo) {
    $rutaCarpeta = "portadas/";
    
    // Verifica si la carpeta existe, si no, la crea
    if (!file_exists($rutaCarpeta)) {
        mkdir($rutaCarpeta, 0777, true);
    }

    $nombreArchivo = basename($archivo["name"]);
    $rutaDestino = $rutaCarpeta . uniqid() . "_" . $nombreArchivo;
    move_uploaded_file($archivo["tmp_name"], $rutaDestino);
    return $rutaDestino;
}

// Función para generar el ID del libro
function generarIDLibro($titulo, $autor, $editorial) {
    // Limpiar texto y extraer primeras letras
    $t = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $titulo), 0, 2));
    $a = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $autor), 0, 2));
    $e = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $editorial), 0, 2));

    // Letras y números aleatorios
    $letras = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 2);
    $numero = rand(0, 9);

    return $t . $a . $e . $letras[0] . $numero;
}

if (isset($_POST['agregar'])) {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $editorial = $_POST['editorial'];
    $seccion = $_POST['seccion'];
    $descripcion = $_POST['descripcion'];
    $disponible = $_POST['disponible'];
    $imagen = guardarImagen($_FILES['portada']);

    // Generar ID único
    $id_libro = generarIDLibro($titulo, $autor, $editorial);

    $stmt = $conexion->prepare("INSERT INTO libros (id_libro, titulo, autor, editorial, seccion, descripcion, imagen) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $id_libro, $titulo, $autor, $editorial, $seccion, $descripcion, $imagen);
    $stmt->execute();

    $stmt2 = $conexion->prepare("INSERT INTO inventario (id_libro, cantidad_total) VALUES (?, ?)");
    $stmt2->bind_param("si", $id_libro, $disponible);
    $stmt2->execute();

    echo "Libro agregado correctamente con ID: $id_libro";
}

if (isset($_POST['editar'])) {
    $id_libro = $_POST['id_libro'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $editorial = $_POST['editorial'];
    $seccion = $_POST['seccion'];
    $descripcion = $_POST['descripcion'];
    $disponible = $_POST['disponible'];
    $imagen = !empty($_FILES['portada']['name']) ? guardarImagen($_FILES['portada']) : null;

    if ($imagen) {
        $stmt = $conexion->prepare("UPDATE libros SET titulo=?, autor=?, editorial=?, seccion=?, descripcion=?, imagen=? WHERE id_libro=?");
        $stmt->bind_param("sssssss", $titulo, $autor, $editorial, $seccion, $descripcion, $imagen, $id_libro);
    } else {
        $stmt = $conexion->prepare("UPDATE libros SET titulo=?, autor=?, editorial=?, seccion=?, descripcion=? WHERE id_libro=?");
        $stmt->bind_param("ssssss", $titulo, $autor, $editorial, $seccion, $descripcion, $id_libro);
    }
    $stmt->execute();

    $stmt2 = $conexion->prepare("UPDATE inventario SET cantidad_total=? WHERE id_libro=?");
    $stmt2->bind_param("is", $disponible, $id_libro);
    $stmt2->execute();

    echo "Libro editado correctamente.";
}
?>

<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $nacionalidad = $_POST['nacionalidad'];
    $imagen = '';

    if ($_FILES['imagen']['name']) {
        $target_dir = "uploads/artistas/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
            $imagen = $target_file;
        } else {
            echo "Error subiendo la imagen.";
        }
    }

    $sql = "UPDATE artista SET nombre='$nombre', apellido='$apellido', fecha_nacimiento='$fecha_nacimiento', nacionalidad='$nacionalidad'";
    if ($imagen) {
        $sql .= ", imagen='$imagen'";
    }
    $sql .= " WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Artista actualizado correctamente.";
        // Redireccionar a la página principal después de 2 segundos
        echo "<script>setTimeout(function() { window.location.href = 'index.php'; }, 500);</script>";
    } else {
        echo "Error actualizando el artista: " . $conn->error;
    }
} else {
    echo "Error: No se recibieron datos válidos para actualizar.";
}
?>

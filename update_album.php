<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $numero_album = $_POST['numero_album'];
    $titulo = $_POST['titulo'];
    $genero = $_POST['genero'];
    $ano_lanzamiento = $_POST['ano_lanzamiento'];
    $discografia = $_POST['discografia'];
    $artista_id = $_POST['artista_id'];
    $imagen = '';

    if ($_FILES['imagen']['name']) {
        $target_dir = "uploads/albumes/";
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

    $sql = "UPDATE album SET numero_album='$numero_album', titulo='$titulo', genero='$genero', ano_lanzamiento='$ano_lanzamiento', discografia='$discografia', artista_id='$artista_id'";
    if ($imagen) {
        $sql .= ", imagen='$imagen'";
    }
    $sql .= " WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Álbum actualizado correctamente.";
         // Redireccionar a la página principal después de 2 segundos
         echo "<script>setTimeout(function() { window.location.href = 'index.php'; }, 500);</script>";
    } else {
        echo "Error actualizando el álbum: " . $conn->error;
    }
} else {
    echo "Error: No se recibieron datos válidos para actualizar.";
}
?>

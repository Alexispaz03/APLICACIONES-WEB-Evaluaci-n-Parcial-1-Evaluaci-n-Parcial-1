<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM artista WHERE id = $id");
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Eliminar Artista</title>
            <link rel="stylesheet" href="style.css">
        </head>
        <body>
            <div class="container">
                <h1>Eliminar Artista</h1>
                <p>¿Estás seguro que deseas eliminar al artista <?php echo $row['nombre'] . " " . $row['apellido']; ?>?</p>
                <form action="delete_artist.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit">Eliminar</button>
                    <a href="index.php">Cancelar</a>
                </form>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Artista no encontrado.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Primero, eliminar los álbumes asociados al artista
    $sql_delete_albums = "DELETE FROM album WHERE artista_id = $id";
    if ($conn->query($sql_delete_albums) === TRUE) {
        // Luego, eliminar el artista de la base de datos
        $sql_delete_artist = "DELETE FROM artista WHERE id = $id";
        if ($conn->query($sql_delete_artist) === TRUE) {
            echo "Artista y álbumes asociados eliminados correctamente.";
            // Redireccionar a la página principal después de 2 segundos
            echo "<script>setTimeout(function() { window.location.href = 'index.php'; }, 500);</script>";
        } else {
            echo "Error al eliminar el artista: " . $conn->error;
        }
    } else {
        echo "Error al eliminar los álbumes asociados al artista: " . $conn->error;
    }
} else {
    echo "ID de artista no especificado.";
}
?>

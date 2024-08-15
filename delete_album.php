<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM album WHERE id = $id");
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Eliminar Álbum</title>
            <link rel="stylesheet" href="style.css">
        </head>
        <body>
            <div class="container">
                <h1>Eliminar Álbum</h1>
                <p>¿Estás seguro que deseas eliminar el álbum "<?php echo $row['titulo']; ?>"?</p>
                <form action="delete_album.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit">Eliminar</button>
                    <a href="index.php">Cancelar</a>
                </form>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Álbum no encontrado.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Primero, eliminar cualquier referencia en otras tablas (ejemplo ficticio)
    // Aquí puedes añadir el código necesario para eliminar referencias de otras tablas si existen

    // Luego, eliminar el álbum de la base de datos
    $sql_delete_album = "DELETE FROM album WHERE id = $id";
    if ($conn->query($sql_delete_album) === TRUE) {
        echo "Álbum eliminado correctamente.";
        // Redireccionar a la página principal después de 2 segundos
        echo "<script>setTimeout(function() { window.location.href = 'index.php'; }, 500);</script>";
    } else {
        echo "Error al eliminar el álbum: " . $conn->error;
    }
} else {
    echo "ID de álbum no especificado.";
}
?>

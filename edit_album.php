<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM album WHERE id = $id");
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Mostrar formulario de edición
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Editar Álbum</title>
            <link rel="stylesheet" href="style.css">
        </head>
        <body>
            <h1>Editar Álbum</h1>
            <div class="container">
                <form action="update_album.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <label for="numero_album">Número de Álbum:</label>
                    <input type="text" id="numero_album" name="numero_album" value="<?php echo $row['numero_album']; ?>" required><br>
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" value="<?php echo $row['titulo']; ?>" required><br>
                    <label for="genero">Género:</label>
                    <input type="text" id="genero" name="genero" value="<?php echo $row['genero']; ?>" required><br>
                    <label for="ano_lanzamiento">Año de Lanzamiento:</label>
                    <input type="number" id="ano_lanzamiento" name="ano_lanzamiento" value="<?php echo $row['ano_lanzamiento']; ?>" required><br>
                    <label for="discografia">Discografía:</label>
                    <input type="text" id="discografia" name="discografia" value="<?php echo $row['discografia']; ?>" required><br>
                    <label for="artista_id">Artista:</label>
                    <select id="artista_id" name="artista_id" required>
                        <?php
                        $result_artista = $conn->query("SELECT * FROM artista");
                        while ($row_artista = $result_artista->fetch_assoc()) {
                            $selected = ($row_artista['id'] == $row['artista_id']) ? 'selected' : '';
                            echo "<option value='" . $row_artista['id'] . "' $selected>" . $row_artista['nombre'] . " " . $row_artista['apellido'] . "</option>";
                        }
                        ?>
                    </select><br>
                    <label for="imagen">Imagen:</label>
                    <input type="file" id="imagen" name="imagen"><br>
                    <?php if ($row['imagen']) : ?>
                        <img src="<?php echo $row['imagen']; ?>" alt="Imagen actual" style="max-width: 100px; max-height: 100px; object-fit: cover;"><br>
                    <?php endif; ?>
                    <button type="submit">Guardar Cambios</button>
                </form>
                <a href="index.php">Volver al inicio</a>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Álbum no encontrado.";
    }
} else {
    echo "ID de álbum no especificado.";
}
?>

<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Álbum</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Agrega Tu Álbum Favorito</h1>
    <div class="container">
        <form action="add_album.php" method="POST" enctype="multipart/form-data">
            <label for="numero_album">Número de Álbum:</label>
            <input type="text" id="numero_album" name="numero_album" required><br>
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required><br>
            <label for="genero">Género:</label>
            <input type="text" id="genero" name="genero" required><br>
            <label for="ano_lanzamiento">Año de Lanzamiento:</label>
            <input type="number" id="ano_lanzamiento" name="ano_lanzamiento" required><br>
            <label for="discografia">Discografía:</label>
            <input type="text" id="discografia" name="discografia" required><br>
            <label for="artista_id">ID del Artista:</label>
            <select id="artista_id" name="artista_id" required>
                <?php
                $result = $conn->query("SELECT * FROM artista");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . " " . $row['apellido'] . "</option>";
                }
                ?>
            </select><br>
            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" name="imagen"><br>
            <button type="submit">Agregar</button>
        </form>
        <a href="index.php">Volver al inicio</a>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $numero_album = $_POST['numero_album'];
            $titulo = $_POST['titulo'];
            $genero = $_POST['genero'];
            $ano_lanzamiento = $_POST['ano_lanzamiento'];
            $discografia = $_POST['discografia'];
            $artista_id = $_POST['artista_id'];
            $imagen = '';

            if ($_FILES['imagen']['name']) {
                $target_dir = "uploads/albums/";
                $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
                if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
                    $imagen = $target_file;
                } else {
                    echo "Error subiendo la imagen.";
                }
            }

            $sql = "INSERT INTO album (numero_album, titulo, genero, ano_lanzamiento, discografia, artista_id, imagen) VALUES ('$numero_album', '$titulo', '$genero', '$ano_lanzamiento', '$discografia', '$artista_id', '$imagen')";

            if ($conn->query($sql) === TRUE) {
                echo "Nuevo álbum agregado con éxito";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        ?>
    </div>
</body>
</html>

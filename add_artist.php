<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Artista</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Agrega Tu Artista Favorito</h1>
    <div class="container">
        <form action="add_artist.php" method="POST" enctype="multipart/form-data">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required><br>
            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required><br>
            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required><br>
            <label for="nacionalidad">Nacionalidad:</label>
            <input type="text" id="nacionalidad" name="nacionalidad" required><br>
            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" name="imagen"><br>
            <button type="submit">Agregar</button>
        </form>
        <a href="index.php">Volver al inicio</a>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $nacionalidad = $_POST['nacionalidad'];
            $imagen = '';

            if ($_FILES['imagen']['name']) {
                $target_dir = "uploads/artistas/";
                // Crear directorio si no existe
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

            $sql = "INSERT INTO artista (nombre, apellido, fecha_nacimiento, nacionalidad, imagen) VALUES ('$nombre', '$apellido', '$fecha_nacimiento', '$nacionalidad', '$imagen')";

            if ($conn->query($sql) === TRUE) {
                echo "Nuevo artista agregado con éxito";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        ?>
    </div>
</body>
</html>

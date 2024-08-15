<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM artista WHERE id = $id");
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Mostrar formulario de edición
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Editar Artista</title>
            <link rel="stylesheet" href="style.css">
        </head>
        <body>
            <h1>Editar Artista</h1>
            <div class="container">
                <form action="update_artist.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo $row['nombre']; ?>" required><br>
                    <label for="apellido">Apellido:</label>
                    <input type="text" id="apellido" name="apellido" value="<?php echo $row['apellido']; ?>" required><br>
                    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $row['fecha_nacimiento']; ?>" required><br>
                    <label for="nacionalidad">Nacionalidad:</label>
                    <input type="text" id="nacionalidad" name="nacionalidad" value="<?php echo $row['nacionalidad']; ?>" required><br>
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
        echo "Artista no encontrado.";
    }
} else {
    echo "ID de artista no especificado.";
}
?>

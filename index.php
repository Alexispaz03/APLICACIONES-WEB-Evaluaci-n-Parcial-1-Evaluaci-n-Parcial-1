<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Música</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Estilos del sitio */
        .container {
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1, h2 {
            color: #ff4500;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        td img {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
        }
        .button {
            display: inline-block;
            background-color: #ff4500;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            margin: 10px 0;
            border-radius: 5px;
            text-align: center;
        }
        .actions a {
            display: inline-block;
            margin-right: 10px;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
        }
        .actions a.delete {
            background-color: #ff4500;
        }
        .actions a.edit {
            background-color: #4CAF50;
        }
        /* Estilos del cuadro de búsqueda */
        .search-container {
            margin-bottom: 20px;
        }
        .search-container input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Sistema de Gestión de Música</h1>
    <div class="container">
        <a href="add_artist.php" class="button">Agregar Artista</a>
        <a href="add_album.php" class="button">Agregar Álbum</a>

        <!-- Cuadro de búsqueda para artistas -->
        <div class="search-container">
            <input type="text" id="searchArtists" onkeyup="searchArtistsTable()" placeholder="Buscar por apellido...">
        </div>

        <h2>Artistas</h2>
        <table id="artistsTable">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Nacionalidad</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM artista");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['nombre'] . "</td>";
                    echo "<td>" . $row['apellido'] . "</td>";
                    echo "<td>" . $row['fecha_nacimiento'] . "</td>";
                    echo "<td>" . $row['nacionalidad'] . "</td>";
                    echo "<td>";
                    if ($row['imagen']) {
                        echo "<img src='" . $row['imagen'] . "' alt='Imagen de " . $row['nombre'] . "'>";
                    }
                    echo "</td>";
                    echo "<td class='actions'>";
                    echo "<a href='delete_artist.php?id=" . $row['id'] . "' class='delete' onclick='return confirm(\"¿Estás seguro que deseas eliminar a " . $row['nombre'] . " " . $row['apellido'] . "?\");'>Eliminar</a>";
                    echo "<a href='edit_artist.php?id=" . $row['id'] . "' class='edit'>Editar</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Cuadro de búsqueda para álbumes -->
        <div class="search-container">
            <input type="text" id="searchAlbums" onkeyup="searchAlbumsTable()" placeholder="Buscar por género ...">
        </div>

        <h2>Álbumes</h2>
        <table id="albumsTable">
            <thead>
                <tr>
                    <th>Número de Álbum</th>
                    <th>Título</th>
                    <th>Género</th>
                    <th>Año de Lanzamiento</th>
                    <th>Discografía</th>
                    <th>Artista</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT album.*, artista.nombre AS artista_nombre, artista.apellido AS artista_apellido FROM album JOIN artista ON album.artista_id = artista.id");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['numero_album'] . "</td>";
                    echo "<td>" . $row['titulo'] . "</td>";
                    echo "<td>" . $row['genero'] . "</td>";
                    echo "<td>" . $row['ano_lanzamiento'] . "</td>";
                    echo "<td>" . $row['discografia'] . "</td>";
                    echo "<td>" . $row['artista_nombre'] . " " . $row['artista_apellido'] . "</td>";
                    echo "<td>";
                    if ($row['imagen']) {
                        echo "<img src='" . $row['imagen'] . "' alt='Imagen de " . $row['titulo'] . "'>";
                    }
                    echo "</td>";
                    echo "<td class='actions'>";
                    echo "<a href='delete_album.php?id=" . $row['id'] . "' class='delete' onclick='return confirm(\"¿Estás seguro que deseas eliminar el álbum " . $row['titulo'] . " de " . $row['artista_nombre'] . " " . $row['artista_apellido'] . "?\");'>Eliminar</a>";
                    echo "<a href='edit_album.php?id=" . $row['id'] . "' class='edit'>Editar</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // Función de búsqueda para la tabla de artistas
        function searchArtistsTable() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchArtists");
            filter = input.value.toLowerCase();
            table = document.getElementById("artistsTable");
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) { 
                tr[i].style.display = "none";
                td = tr[i].getElementsByTagName("td");
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        }
                    }
                }
            }
        }

        // Función de búsqueda para la tabla de álbumes
        function searchAlbumsTable() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchAlbums");
            filter = input.value.toLowerCase();
            table = document.getElementById("albumsTable");
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) { 
                tr[i].style.display = "none";
                td = tr[i].getElementsByTagName("td");
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        }
                    }
                }
            }
        }
    </script>
</body>
</html>

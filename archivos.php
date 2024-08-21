<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_banco";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se han enviado archivos
if (isset($_FILES['files'])) {
    $fileCount = count($_FILES['files']['name']);
    
    for ($i = 0; $i < $fileCount; $i++) {
        $fileName = $_FILES['files']['name'][$i];
        $fileTmpName = $_FILES['files']['tmp_name'][$i];
        $fileSize = $_FILES['files']['size'][$i];
        $fileError = $_FILES['files']['error'][$i];
        $fileType = $_FILES['files']['type'][$i];

        // Verificar si el archivo se ha subido correctamente
        if ($fileError === UPLOAD_ERR_OK) {
            // Leer el contenido del archivo
            $fileContent = file_get_contents($fileTmpName);
            $fileContent = $conn->real_escape_string($fileContent);
            
            // Consulta para insertar el archivo en la base de datos
            $sql = "INSERT INTO archivos (nombre, tipo, contenido) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $fileName, $fileType, $fileContent); // O usa "ssb" si cambias la columna tipo a BLOB            

            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Archivo '$fileName' subido exitosamente.</div>";
            } else {
                echo "<div class='alert alert-danger'>Error al subir el archivo '$fileName': " . $stmt->error . "</div>";
            }

            $stmt->close();
        } else {
            echo "<div class='alert alert-danger'>Error al subir el archivo '$fileName': " . $fileError . "</div>";
        }
    }
} else {
    echo "<div class='alert alert-warning'>No se han enviado archivos.</div>";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Archivos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('images/imgfon1.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar-custom {
            background-color: #FFC107; 
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .navbar-nav .nav-link {
            color: #343a40; 
        }
        .navbar-custom .navbar-brand:hover,
        .navbar-custom .navbar-nav .nav-link:hover {
            color: #495057; 
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9); 
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
        .btn-primary {
            background-color: #007bff; 
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3; 
            border-color: #004085;
        }
        .form-control-file {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <a class="navbar-brand" href="#">Sube tus arvivos</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="principal.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="versolicitudes.php">Ver las solicitudes de tarjetas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="datosusuario.php">Datos de usuario</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="mb-4 text-center">Subir Archivos</h2>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="files">Selecciona archivos:</label>
                <input type="file" class="form-control-file" id="files" name="files[]" multiple>
            </div>
            <button type="submit" name="guardar" class="btn btn-primary btn-block">Subir Archivos</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

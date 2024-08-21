<?php
session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['email'])) {
    die("No estás autorizado para ver esta página.");
}

// Incluye el archivo de conexión
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

// Obtén el email del usuario que ha iniciado sesión
$user_email = $_SESSION['email'];

// Consulta para obtener los datos del usuario autenticado
$sql = "SELECT email, nombre, ciudad, clave, contrasena FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

if (isset($_POST['actualizar'])) {
    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $ciudad = $_POST['ciudad'];
    $clave = $_POST['clave'];
    $contrasena = $_POST['contrasena'];

    // Actualizar datos en la base de datos
    $update_sql = "UPDATE usuarios SET nombre = ?, ciudad = ?, clave = ?, contrasena = ? WHERE email = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssss", $nombre, $ciudad, $clave, $contrasena, $user_email);

    if ($update_stmt->execute()) {
        $success_message = "Datos actualizados correctamente.";
    } else {
        $error_message = "Error al actualizar los datos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos de Usuario</title>
    <!-- Enlace a Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('images/imgfon1.jpg') no-repeat center center fixed;
            color: #fff;
        }
        /* Estilo personalizado para la navbar */
        .navbar {
            background-color: #fdd835; /* Amarillo */
        }
        .navbar-brand, .nav-link {
            color: #004d40; /* Azul oscuro */
        }
        .navbar-brand:hover, .nav-link:hover {
            color: #00332a; /* Azul más oscuro en hover */
        }
        .card {
            border: none;
            border-radius: 20px; /* Borde más redondeado */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 600px; /* Tamaño máximo de la tarjeta */
            margin: 20px auto; /* Centrar la tarjeta */
        }
        .card-body {
            background-color: #e1f5fe; /* Color de fondo claro */
            color: #000; /* Texto en color negro */
        }
        .card-title {
            color: #00796b; /* Azul oscuro */
        }
        .card-subtitle {
            color: #004d40; /* Azul oscuro */
        }
        .card-text strong {
            color: #00796b; /* Azul oscuro */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">Mis Datos de usuario</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="principal.php">Inicio <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="versolicitudes.php">Solicitudes de tarjeta</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="formulario2.php">Solicitar tarjeta</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <?php
            if ($result->num_rows > 0) {
                // Mostrar los datos en cards
                while($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['nombre']); ?></h5>
                                <h6 class="card-subtitle mb-2"><?php echo htmlspecialchars($row['email']); ?></h6>
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label for="nombre">Nombre:</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($row['nombre']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="ciudad">Ciudad:</label>
                                        <input type="text" class="form-control" id="ciudad" name="ciudad" value="<?php echo htmlspecialchars($row['ciudad']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="clave">Clave:</label>
                                        <input type="text" class="form-control" id="clave" name="clave" value="<?php echo htmlspecialchars($row['clave']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="contrasena">Contraseña:</label>
                                        <input type="password" class="form-control" id="contrasena" name="contrasena" value="<?php echo htmlspecialchars($row['contrasena']); ?>" required>
                                    </div>
                                    <button type="submit" name="actualizar" class="btn btn-primary">Actualizar Datos</button>
                                </form>
                                <?php
                                if (isset($success_message)) {
                                    echo "<div class='alert alert-success mt-2' role='alert'>" . htmlspecialchars($success_message) . "</div>";
                                }
                                if (isset($error_message)) {
                                    echo "<div class='alert alert-danger mt-2' role='alert'>" . htmlspecialchars($error_message) . "</div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p class='col-md-12 text-center'>No se encontraron datos para el usuario.</p>";
            }

            $stmt->close();
            $conn->close();
            ?>
        </div>
    </div>

    <!-- Enlace a Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

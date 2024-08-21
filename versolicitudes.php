<?php
session_start();
if (!isset($_SESSION['nombre'])) {
    header("Location: login.php");
    exit();
}

include 'config.php'; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $ingreso = $_POST['ingreso'];
    $fecha = $_POST['fecha'];
    $tipo = $_POST['tipo'];

    $sql = "UPDATE solicitudes SET ingreso = ?, fecha = ?, tipo = ? WHERE nombre = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("sssi", $ingreso, $fecha, $tipo, $id);

    if (!$stmt->execute()) {
        die("Error al ejecutar la consulta: " . $stmt->error);
    }

    echo '<div class="alert alert-success" role="alert">Solicitud actualizada con éxito.</div>';
    $stmt->close();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Obtener los datos actuales de la solicitud
$sql = "SELECT * FROM solicitudes WHERE nombre = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se obtienen datos
if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
} else {
    $data = null; // O manejar el caso cuando no hay datos
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Solicitud</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('images/imgfon1.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: yellow;
        }
        .navbar-nav .nav-link {
            color: black;
        }
        .navbar-nav .nav-link:hover {
            color: #333;
        }
        .container {
            margin-top: 20px;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .card-body {
            padding: 30px;
        }
        .card-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">Banco</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Inicio <span class="sr-only">(actual)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Servicios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contacto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Sobre Nosotros</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Editar Solicitud</h5>
                <form method="post" action="versolicitudes.php">
                    <div class="form-group">
                        <label for="ingreso">Ingreso Mensual</label>
                        <input type="text" class="form-control" id="ingreso" name="ingreso" value="<?php echo htmlspecialchars($data['ingreso'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha de Cita</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo htmlspecialchars($data['fecha'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo">Tipo de Tarjeta</label>
                        <select class="form-control" id="tipo" name="tipo" required>
                            <option value="Cobre" <?php echo ($data['tipo'] ?? '') === 'Cobre' ? 'selected' : ''; ?>>Cobre</option>
                            <option value="Platino" <?php echo ($data['tipo'] ?? '') === 'Platino' ? 'selected' : ''; ?>>Platino</option>
                            <option value="Oro" <?php echo ($data['tipo'] ?? '') === 'Oro' ? 'selected' : ''; ?>>Oro</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

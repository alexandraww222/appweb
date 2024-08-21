<?php
require_once 'db_conexion.php';

if (isset($_POST['guardar'])) {
    $nombre_usuario = $_POST['nombre'];
    $ingreso = $_POST['ingreso'];
    $fecha = $_POST['fecha'];
    $tipo = $_POST['tipo'];

    if (!empty($nombre_usuario) && !empty($ingreso) && !empty($fecha) && !empty($tipo)) {
        $insertQuery = $cnnPDO->prepare("INSERT INTO solicitudes (nombre, ingreso, fecha, tipo) VALUES (:nombre, :ingreso, :fecha, :tipo)");

        $insertQuery->bindParam(':nombre', $nombre_usuario);
        $insertQuery->bindParam(':ingreso', $ingreso);
        $insertQuery->bindParam(':fecha', $fecha);
        $insertQuery->bindParam(':tipo', $tipo);

        if ($insertQuery->execute()) {
            $to = 'cliente@example.com'; 
            $subject = "Solicitud de Tarjeta de Crédito Recibida";
            $message = '<html>
            <body>  
                <h1>Solicitud Recibida</h1>
                <p>Tu solicitud para la tarjeta de crédito ha sido recibida.</p>
                <p><b>Nombre de Usuario:</b> ' . htmlspecialchars($nombre_usuario) . '</p>
                <p><b>Ingreso Mensual:</b> ' . htmlspecialchars($ingreso) . '</p>
                <p><b>Fecha de Cita:</b> ' . htmlspecialchars($fecha) . '</p>
                <p><b>Tipo de Tarjeta:</b> ' . htmlspecialchars($tipo) . '</p>
            </body>
            </html>';
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
            $headers .= "From: ROCKET@email.com" . "\r\n";
            mail($to, $subject, $message, $headers);
            header('Location: principal.php');
            exit(); 
        } else {
            $error_message = 'Error al enviar la solicitud.';
        }
    } else {
        $error_message = 'Por favor complete todos los campos.';
    }
}

$fechaOcupadaQuery = $cnnPDO->prepare("SELECT fecha FROM solicitudes");
$fechaOcupadaQuery->execute();
$fechasOcupadas = $fechaOcupadaQuery->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Tarjeta de Crédito</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
          background: url('images/imgfon1.jpg') no-repeat center center fixed;
          color: #fff;
        }
        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .form-card, .info-card {
            max-width: 600px;
            background-color: #fff;
            color: #000; 
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #000;
        }
        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
        
.navbar {
    background-color: yellow; 
}

.navbar-brand {
    color: black; 
}

.navbar-nav .nav-link {
    color: black; 
}

.navbar-nav .nav-link:hover {
    color: #333; 
}
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">Registrate para solicitar tu tarjeta</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="principal.php">Incio <span class="sr-only">(current)</span></a>
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
    <div class="container">
        <div class="form-card">
            <h2 class="text-center">Solicitud de Tarjeta de Crédito</h2>
            
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            
            <form action="" method="post">
                <div class="form-group">
                    <label for="nombre">Nombre de Usuario:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese su nombre de usuario" required>
                </div>

                <div class="form-group">
                    <label for="ingreso">Ingreso Mensual:</label>
                    <input type="number" class="form-control" id="ingreso" name="ingreso" placeholder="Ingrese su ingreso mensual" required>
                </div>

                <div class="form-group">
                    <label for="fecha">Fecha de Cita:</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" required>
                </div>

                <div class="form-group">
                    <label for="tipo">Tipo de Tarjeta:</label>
                    <select class="form-control" id="tipo" name="tipo" required>
                        <option value="cobre">Cobre</option>
                        <option value="platino">Platino</option>
                        <option value="dorado">Dorado</option>
                    </select>
                </div>

                <button type="submit" name="guardar" class="btn btn-primary btn-custom">Solicitar Tarjeta</button>

            </form>
        </div>
        
        <div class="info-card">
            <h3>Fechas Ocupadas</h3>
            <ul>
                <?php if (!empty($fechasOcupadas)): ?>
                    <?php foreach ($fechasOcupadas as $fecha): ?>
                        <li><?php echo htmlspecialchars($fecha); ?></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>No hay fechas ocupadas.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</body>
</html>

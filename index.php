<?php
require_once 'db_conexion.php';

if (isset($_POST['guardar'])) {
    $email = $_POST['email'];
    $nombre = $_POST['nombre'];
    $ciudad = $_POST['ciudad'];
    $clave = $_POST['clave'];

    if (!empty($email) && !empty($nombre) && !empty($ciudad) && !empty($clave)) {
        $insertQuery = $cnnPDO->prepare("INSERT INTO usuarios (email, nombre, ciudad, clave) VALUES (:email, :nombre, :ciudad, :clave)");

        $insertQuery->bindParam(':email', $email);
        $insertQuery->bindParam(':nombre', $nombre);
        $insertQuery->bindParam(':ciudad', $ciudad);
        $insertQuery->bindParam(':clave', $clave);

        if ($insertQuery->execute()) {
            $to = $email;
            $subject = "Registro Exitoso";
            $message = '<html>
            <body>  
                <h1>Hola ' . htmlspecialchars($nombre) . '</h1>
                <p>Tu registro en nuestro sitio ha sido exitoso.</p>
                <p>Gracias por unirte a nosotros.</p>
            </body>
            </html>';
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
            $headers .= "From: ROCKET@email.com" . "\r\n";

            mail($to, $subject, $message, $headers);

            echo '<div class="alert alert-success" role="alert">Registro con éxito!</div>';
        } 
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('images/imgfon1.jpg');
            background-size: cover;
            color: #fff;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
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

        .btn-custom {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center" style="color: black;">Crea tu cuenta con Nostros</h2>
        <form class="form-horizontal" action="" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Ingrese su Email" required>
            </div>

            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ingrese su Nombre" required>
            </div>

            <div class="form-group">
                <label for="ciudad">Ciudad:</label>
                <select id="ciudad" name="ciudad" required>
                    <option value="">Selecciona una ciudad</option>
                    <option value="Saltillo">Saltillo</option>
                    <option value="Zacatecas">Zacatecas</option>
                    <option value="Guadalajara">Guadalajara</option>
                    <option value="CDMX">CDMX</option>
                    <option value="Oaxaca">Oaxaca</option>
                </select>
            </div>

            <div class="form-group">
                <label for="clave">Clave:</label>
                <input type="password" id="clave" name="clave" placeholder="Ingrese una Clave" required>
            </div>

            <div class="form-group">
                <label for="confirmar_clave">Verificar Clave:</label>
                <input type="password" id="confirmar_clave" name="confirmar_clave" placeholder="Repita la Clave" required>
            </div>

            <button type="submit" name="guardar" class="btn btn-primary btn-custom">REGISTRATE</button>
            <a href="login.php" class="btn btn-secondary btn-custom">Iniciar Sesión</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('button[type="submit"]').addEventListener('click', function(event) {
                let formatoemail = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;

                if (!formatoemail.test(document.getElementById('email').value)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Email incorrecto',
                        text: 'Utilice un correo válido'
                    });
                    event.preventDefault();
                } else if (document.getElementById('nombre').value === "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Nombre incompleto',
                        text: 'Por favor llena el campo'
                    });
                    event.preventDefault();
                } else if (document.getElementById('ciudad').value === "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ciudad no seleccionada',
                        text: 'Selecciona una ciudad'
                    });
                    event.preventDefault();
                } else if (document.getElementById('clave').value === "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Clave incompleta',
                        text: 'Llena este campo'
                    });
                    event.preventDefault();
                } else if (document.getElementById('clave').value !== document.getElementById('confirmar_clave').value) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Contraseñas no coinciden',
                        text: 'Por favor confirma la contraseña'
                    });
                    event.preventDefault();
                }
            });
        });
    </script>
</body>
</html>

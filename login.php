<?php
require_once 'db_conexion.php';

session_start();

if (isset($_POST['buscar'])) {
    $nombre = $_POST['nombre'];

    $query = $cnnPDO->prepare('SELECT * FROM usuarios WHERE nombre = :nombre');
    $query->bindParam(':nombre', $nombre);
    $query->execute();

    $count = $query->rowCount();
    $campo = $query->fetch();

    if ($count && $_POST['clave'] == $campo['clave']) {
        $_SESSION['email'] = $campo['email'];
        $_SESSION['clave'] = $campo['clave'];
        $_SESSION['nombre'] = $campo['nombre']; 

        header("Location: principal.php");
        exit();
    } else {
        echo "<strong><font color='red'>El Usuario o la Contraseña son Incorrectos</font></strong>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <title>SESION</title>
    <style>
        body {
          background-image: url('images/imgfon1.jpg');
            background-size: cover;
            color: #fff;
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        
        .container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
        }
        
        .container h2 {
            text-align: center;
            color: #333;
        }
        
        .form-container {
            margin-top: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }
        
        .form-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        
        .form-button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        
        .form-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-warning">
  <a class="navbar-brand text-primary" href="#">Vamos ven y mira todo lo nuevo</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link text-primary" href="index.php">Registrarse</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-primary" href="#">Acerca de</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-primary" href="#">Contacto</a>
      </li>
    </ul>
  </div>
</nav>

    <div class="container">
        <h2>BIENVENIDO</h2>
        <div class="form-container">
            <form action="" method="post" name="Form">
                <label class="form-label" for="nombre">Nombre de usuario</label>
                <input class="form-input" type="text" id="nombre" name="nombre" placeholder=" Ingrese su Nombre de usuario">
                
                <label class="form-label" for="password">Contraseña</label>
                <input class="form-input" type="password" id="password" name="clave" placeholder=" Ingrese su Contraseña">
                
                <button class="form-button" type="submit" name="buscar">INICIAR SESION</button>
            </form>
        </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="script.js"></script>
</body>
</html>
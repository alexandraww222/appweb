<?php
    require_once 'db_conexion.php';
    session_start();

    if (isset($_POST['cerrar_sesion'])) {
        session_destroy();
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('images/imgfon3.avif');
            background-size: cover;
            color: #fff;
        }
        
        nav {
            background-color: goldenrod;
        }
        
        .card {
            margin-bottom: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
        }
        
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        
        .card-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .card-text {
            font-size: 16px;
            margin-bottom: 20px;
        }
        
        .card-link {
            color: #fff;
            font-weight: bold;
            text-decoration: none;
        }
        
        .card-link:hover {
            text-decoration: underline;
        }
        
        .carousel-item {
            height: 300px;
        }
        
        .carousel-item img {
            height: 300px;
            object-fit: cover;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Bienvendio a nuestra pagina</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php
                if (isset($_SESSION['nombre']) && isset($_SESSION['email'])) {
                    $nombre = $_SESSION['nombre'];
                    $email = $_SESSION['email'];
                    echo '
                        <li class="nav-item">
                            <a class="nav-link" href="versolicitudes.php">Ver tus solictudes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="formulario2.php">Solicitar Tarjeta</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="datosusuario.php">Datos de Usuario</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="archivos.php">Subir archivos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="document.querySelector(\'form[name=\\\'logout-form\\\']\').submit(); return false;">Cerrar Sesión</a>
                            <form name="logout-form" action="" method="post" style="display: none;">
                                <input type="hidden" name="cerrar_sesion">
                            </form>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link">Bienvenido, ' . $nombre . '</span>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link">' . $email . '</span>
                        </li>
                    ';
                } else {
                    // Usuario no ha iniciado sesión
                    echo '
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="formulario.php">Crear Cuenta</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Iniciar Sesión</a>
                        </li>

                      
                    ';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

            </div>
        </div>
    </nav>

    <div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <img src="images/imgp1.jpg" class="card-img-top" alt="Tarjeta Básica">
                <div class="card-body">
                    <h5 class="card-title">Tarjeta Básica</h5>
                    <p class="card-text">Beneficios esenciales y sin costo anual.</p>
                    <a href="#" class="card-link">Ver detalles</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <img src="images/imgp2.jpg" class="card-img-top" alt="Tarjeta Premium">
                <div class="card-body">
                    <h5 class="card-title">Tarjeta Premium</h5>
                    <p class="card-text">Acceso a exclusivos beneficios y recompensas.</p>
                    <a href="#" class="card-link">Ver detalles</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <img src="images/imgp3.jpg" class="card-img-top" alt="Tarjeta Platino">
                <div class="card-body">
                    <h5 class="card-title">Tarjeta Platino</h5>
                    <p class="card-text">Beneficios premium y acceso a servicios exclusivos.</p>
                    <a href="#" class="card-link">Ver detalles</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="images/imgp4.jpg" class="d-block w-100" alt="Servicio Bancario 1">
                    </div>
                    <div class="carousel-item">
                        <img src="images/imgp3.jpg" class="d-block w-100" alt="Servicio Bancario 2">
                    </div>
                    <div class="carousel-item">
                        <img src="images/imgp5.jpg" class="d-block w-100" alt="Servicio Bancario 3">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <img src="images/imgp7.jpg" class="card-img-top" alt="Atención al Cliente">
                <div class="card-body">
                    <h5 class="card-title">Atención al Cliente</h5>
                    <p class="card-text">Asistencia personalizada para resolver tus dudas.</p>
                    <a href="#" class="card-link">Contactar</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <img src="images/imgp6.avif" class="card-img-top" alt="Beneficios Bancarios">
                <div class="card-body">
                    <h5 class="card-title">Beneficios Bancarios</h5>
                    <p class="card-text">Conoce los beneficios de ser cliente de nuestro banco.</p>
                    <a href="#" class="card-link">Ver Beneficios</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <img src="images/imgp5.jpg" class="card-img-top" alt="Tarjeta Premium">
                <div class="card-body">
                    <h5 class="card-title">Tarjeta Premium</h5>
                    <p class="card-text">Explora nuestras opciones de tarjetas premium.</p>
                    <a href="#" class="card-link">Solicitar</a>
                </div>
            </div>
        </div>
    </div>
</div>


    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-UxThTf1Q2WU1MfIyn9G9z3yPrBn4A0P7+dfYHYwNKqoztTlsKgd5AOLjhu5zoxsG" crossorigin="anonymous"></script>
</body>
</html>
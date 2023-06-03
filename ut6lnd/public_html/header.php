<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../public_html/styles_ejlndut6.css">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>LND - UT6</title>
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-light nav-underline bg-light mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">LND - UT6</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php
                    if ((strpos($_SERVER['REQUEST_URI'], "usuarios") === false) && (strpos($_SERVER['REQUEST_URI'], "productos") === false)) {
                        echo '<li class="nav-item"><a class="nav-link" href="usuarios">Usuarios</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="productos">Productos</a></li>';
                    }
                    if ((strpos($_SERVER['REQUEST_URI'], "usuarios") !== false) || (strpos($_SERVER['REQUEST_URI'], "productos") !== false)) {
                        echo '<li class="nav-item"><a class="nav-link" href="../">Volver</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <main>
        <div class="container d-flex flex-column align-items-center">
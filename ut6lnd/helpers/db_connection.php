<?php

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verificar la conexión
if (!$conn) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

<?php

include '../config/env.php';
include '../helpers/db_connection.php';

// Si no hay datos, error 500
if (!isset($_GET["id"])) {
    http_response_code(500);
    exit();
}

$id = $_GET["id"];
// Consulta SQL para eliminar un usuario
$query = "DELETE FROM Usuarios WHERE id = '$id'";
$result = mysqli_query($conn, $query);
// Cerrar la conexión a la base de datos
mysqli_close($conn);

// Return
echo json_encode($result);

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
if ($result && mysqli_affected_rows($conn) > 0) {
    $response = array('ok' => true);
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    $response = array('ok' => false);
    header('Content-Type: application/json');
    echo json_encode($response);
}
// Cerrar la conexión a la base de datos
mysqli_close($conn);

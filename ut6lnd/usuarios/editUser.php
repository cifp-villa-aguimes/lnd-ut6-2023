<?php

include '../config/env.php';
include '../helpers/db_connection.php';

$payload = json_decode(file_get_contents("php://input"));
// Si no hay datos, error 500
if (!$payload) {
    http_response_code(500);
    exit;
}

// Extraer Payload
$id = mysqli_real_escape_string($conn, $payload->_id);
$name = mysqli_real_escape_string($conn, $payload->name);
$email = mysqli_real_escape_string($conn, $payload->email);
$rol = mysqli_real_escape_string($conn, $payload->rol);

// Consulta SQL para guardar los datos
$query = "UPDATE Usuarios SET nombre = '$name', email = '$email', token = '$token', rol_id = '$rol' WHERE id = '$id'";
$result = mysqli_query($conn, $query);
if ($result && mysqli_affected_rows($conn) > 0) {
    $response = array('ok' => true, "id" => $id);
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    $response = array('ok' => false, "id" => $id);
    header('Content-Type: application/json');
    echo json_encode($response);
}
// Cerrar la conexión a la base de datos
mysqli_close($conn);

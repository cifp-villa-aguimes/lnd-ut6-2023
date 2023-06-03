<?php

include '../config/env.php';
include '../helpers/db_connection.php';

$payload = json_decode(file_get_contents("php://input"));

// Si no hay datos, error 500
if (!$payload) {
    http_response_code(500);
    exit;
}
// Extraer Values
$name = $payload->name;
$email = $payload->email;
$rol = $payload->rol;
$token = substr(md5(rand()), 0, 16);

// Consulta SQL para guardar los datos
$query = "INSERT INTO Usuarios (nombre, email, token, rol_id) VALUES ('$name', '$email', '$token', '$rol')";
$result = mysqli_query($conn, $query);
$id = mysqli_insert_id($conn);
// Cerrar la conexión a la base de datos
mysqli_close($conn);
// Return
$response = array(
    "ok" => false,
    "id" => null
);
if ($result) {
    $response = array(
        "ok" => true,
        "id" => $id
    );
} else {
    http_response_code(500);
    exit;
}
// Establecer las cabeceras para indicar que la respuesta es JSON
header('Content-Type: application/json');
// Convertir el array en una cadena JSON
$jsonResponse = json_encode($response);
// Imprimir la respuesta JSON
echo $jsonResponse;

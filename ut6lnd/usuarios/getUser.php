<?php

include '../config/env.php';
include '../helpers/db_connection.php';

// Si no hay datos, error 500
if (!isset($_GET["id"])) {
    http_response_code(500);
    exit();
}

$id = $_GET["id"];
// Consulta SQL para obtener el usuario
$query = "SELECT * FROM Usuarios WHERE id = '$id'";
$result = mysqli_query($conn, $query);
// Verificar si hay resultado
$response = array(
    "ok" => false,
    "user" => null
);
if ($result) {
    $user = mysqli_fetch_assoc($result);
    if ($user) {
        $response = array(
            "ok" => true,
            "user" => $user
        );
    } else {
        http_response_code(404);
        $response = array(
            "ok" => false,
            "user" => null,
        );
    }
} else {
    http_response_code(404);
    $response = array(
        "ok" => false,
        "user" => null,
        "error" => "Error en la consulta: " . mysqli_error($conn)
    );
}
// Cerrar la conexión a la base de datos
mysqli_close($conn);
// Establecer las cabeceras para indicar que la respuesta es JSON
header('Content-Type: application/json');
// Convertir el array en una cadena JSON
$jsonResponse = json_encode($response);
// Imprimir la respuesta JSON
echo $jsonResponse;

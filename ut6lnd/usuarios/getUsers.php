<?php

include '../config/env.php';
include '../helpers/db_connection.php';
// Consulta SQL para obtener los datos
$query = "SELECT Usuarios.id, Usuarios.nombre, Usuarios.email, Usuarios.token, Roles.nombre AS rol FROM Usuarios JOIN Roles ON Usuarios.rol_id = Roles.id;";

$result = mysqli_query($conn, $query);

// Verificar si hay resultados
if (mysqli_num_rows($result) > 0) {
    $data = array();

    // Recorrer los resultados y agregarlos al arreglo de datos
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Convertir los datos a formato JSON y enviar la respuesta
    $json = json_encode($data);

    // Establecer las cabeceras para indicar que la respuesta es JSON
    header('Content-Type: application/json');

    // Enviar la respuesta JSON
    echo $json;
} else {
    http_response_code(404);
    echo "No hay datos";
}
// Cerrar la conexión a la base de datos
mysqli_close($conn);

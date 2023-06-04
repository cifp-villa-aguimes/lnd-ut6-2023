<?php

if (strpos($_SERVER['REQUEST_URI'], "users.php") !== false) {
    header("Location: /ut6lnd/usuarios/");
    exit;
}
// Obtener el esquema (http o https), el host y el puerto del servidor actual
$http = "http";
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $http = "https";
}
$host = $_SERVER['HTTP_HOST'];
// URL del archivo getUsers.php
$url = "{$_SERVER['REQUEST_URI']}getUsers.php";

// Combinar la URL del servidor con la URL relativa del archivo getUsers.php
$pathUrl = "$http://$host$url";

// Realizar la solicitud HTTP
$response = file_get_contents($pathUrl);

// Verificar si se recibió una respuesta
if ($response !== false) {
    // Decodificar la respuesta JSON
    $data = json_decode($response, true);
?>
    <div id="users-table" class="table-container">
        <table class="table table-striped caption-top">
            <caption class="fs-5">Lista de usuarios <i class="bi bi-people"></i></caption>
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Email</th>
                    <th scope="col">Rol</th>
                    <th scope="col">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#addEditUserModal" class="btn btn-outline-primary btn-sm float-end" onclick="onOpenModal()">Añadir
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z" />
                            </svg>
                        </button>
                    </th>
                </tr>
            </thead>
            <?php if ($data !== null) { ?>
                <tbody>
                    <?php foreach ($data as $row) { ?>
                        <tr class="user-id-<?php echo $row['id']; ?>">
                            <th scope="row"><?php echo $row['id']; ?></th>
                            <td class="text-truncate"><?php echo $row['nombre']; ?></td>
                            <td class="text-truncate"><?php echo $row['email']; ?></td>
                            <td class="text-truncate"><?php echo $row['rol']; ?></td>
                            <td>
                                <button onclick="deleteUser(<?php echo $row['id']; ?>)" class="delete btn btn-danger float-end">
                                    Eliminar <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-dash" viewBox="0 0 16 16">
                                        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7ZM11 12h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1 0-1Zm0-7a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" />
                                        <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z" />
                                    </svg>
                                </button>
                                <button onclick="onLoadUser(<?php echo $row['id']; ?>)" class="edit btn btn-warning float-end me-2">
                                    Editar <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            <?php } ?>
        </table>
    </div>
<?php
    // <!-- Toast -->
    include './components/Toast.html';
    // <!-- Modal -->
    include './components/Modal.html';
    // <!-- JS para Usuarios -->
    // Opcion 1:
    echo '<script src="./usuarios.js"></script>';
    // opcion 2:
    // echo '<script>';
    // Opcion 2a:
    // include './usuarios.js';
    // Opcion 2b:
    // readfile('./usuarios.js');
    // echo '</script>';
} else {
    // <!-- ERROR HTTP -->
    include './components/ErrorHTTP.html';
}
?>
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
                        <button type="button" data-bs-toggle="modal" data-bs-target="#addEditUserModal" class="btn btn-outline-primary btn-sm float-end">Añadir
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
                                <button onclick="deleteUser(<?php echo $row['id']; ?>)" class="btn btn-danger float-end">
                                    Eliminar <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-dash" viewBox="0 0 16 16">
                                        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7ZM11 12h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1 0-1Zm0-7a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" />
                                        <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z" />
                                    </svg>
                                </button>
                                <button onclick="editUser(<?php echo $row['id']; ?>)" class="btn btn-warning float-end me-2">
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
} else {
    echo "Error al realizar la solicitud HTTP.";
}
?>
<!-- Toast -->
<div class="toast-container p-3">
    <div id="toastWarnMsg" class="toast">
        <div class="toast-header">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <strong class="mx-auto">Aviso</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Algo ha ido mal !!!
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="addEditUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addEditUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addEditUserModalLabel">Añadir Usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="success-msg" class="alert alert-success text-center visually-hidden" role="alert">
                    <i class="bi bi-check-circle-fill"></i> Usuario añadido !!!
                </div>
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <form>
                    <div class="mb-3">
                        <label for="inputFormControlInputName" class="form-label">Nombre</label>
                        <input type="name" class="form-control" id="inputFormControlInputName" placeholder="name ..." required value="mi nombre">
                    </div>
                    <div class="mb-3">
                        <label for="inputFormControlInputEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="inputFormControlInputEmail" placeholder="email@example.com" pattern="/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/" required value="email@mail.com">
                    </div>
                    <div class="mb-3">
                        <label for="inputFormControlInputRol" class="form-label">Rol</label>
                        <select id="inputFormControlInputRol" class="form-select" aria-label="Default select example">
                            <option value="1">Administrador</option>
                            <option value="2">Editor</option>
                            <option value="3">Usuario Registrado</option>
                            <option selected value="4">Invitado</option>
                        </select>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitAddUserForm()">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    const submitAddUserForm = async () => {
        const reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+.)+[A-Z]{2,4}$/i;
        const inputName = document.getElementById('inputFormControlInputName');
        const inputEmail = document.getElementById('inputFormControlInputEmail');
        const inputRol = document.getElementById('inputFormControlInputRol');
        const elementMsgSuccess = document.getElementById('success-msg');
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastWarnMsg);

        if (inputName.value || inputEmail.value) {
            if (inputEmail.value.trim() && !reg.test(inputEmail.value)) {
                toastBootstrap._element.children[1].innerText = "Escribe un email válido";
                toastBootstrap.show();
                return inputEmail.focus();
            }
            // El payload a enviar a PHP
            const payload = {
                name: inputName.value,
                email: inputEmail.value,
                rol: inputRol.value
            };
            const body = JSON.stringify(payload);
            // Request
            try {
                const responseRaw = await fetch("saveUser.php", {
                    method: "POST",
                    body,
                });
                // Response
                const response = await responseRaw.json();
                if (response && response.ok) {
                    elementMsgSuccess.classList.remove("visually-hidden");
                    setTimeout(() => elementMsgSuccess.classList.add("visually-hidden"), 5000);
                    inputName.value = inputEmail.value = "";
                    inputRol.value = "4";
                    const roles = {
                        "1": "Administrador",
                        "2": "Editor",
                        "3": "Usuario Registrado",
                        "4": "Invitado",
                    }
                    // Obtener una referencia al elemento <tbody>
                    const tbody = document.querySelector("#users-table tbody");
                    // Crear el código HTML de la fila
                    const filaHTML = `<tr class="user-id-${response.id}">
                      <th scope="row">${response.id}</th>
                      <td class="text-truncate">${payload.name}</td>
                      <td class="text-truncate">${payload.email}</td>
                      <td class="text-truncate">${roles[payload.rol]}</td>
                      <td>
                          <button onclick="deleteUser(${response.id})" class="btn btn-danger float-end">
                              Eliminar <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-dash" viewBox="0 0 16 16">
                                        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7ZM11 12h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1 0-1Zm0-7a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" />
                                        <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z" />
                                    </svg>
                          </button>
                          <!-- <button class="btn btn-warning float-end me-2">
                                    Editar <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                    </svg>
                                </button> -->
                      </td>
                  </tr>`;
                    // Insertar la fila en el <tbody> como el último elemento
                    tbody.insertAdjacentHTML("beforeend", filaHTML);
                } else {
                    toastBootstrap._element.children[1].innerText = "Algo ha ido mal al guardar los datos !!!";
                    toastBootstrap.show();
                }
            } catch (e) {
                toastBootstrap._element.children[1].innerText = "Algo ha ido mal al guardar los datos !!!";
                toastBootstrap.show();
            }
            return
        }
        toastBootstrap._element.children[1].innerText = "Algunos campos están vacios";
        return toastBootstrap.show();
    }
    const editUser = async (userId) => {
        const reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+.)+[A-Z]{2,4}$/i;
        const inputName = document.getElementById('inputFormControlInputName');
        const inputEmail = document.getElementById('inputFormControlInputEmail');
        const inputRol = document.getElementById('inputFormControlInputRol');
        const formElement = document.querySelector('#addEditUserModal form');

        const myModalToEditUser = new bootstrap.Modal('#addEditUserModal');
        try {
            const responseRaw = await fetch("getUser.php?id=" + userId, {
                method: "GET",
            });
            // Response
            const response = await responseRaw.json();
            if (response) {
                console.log("TEST - USER", response);
            } else {
                toastBootstrap._element.children[1].innerText = "Algo ha ido mal al eliminar el ususario con id #" + userId + " !!!";
                toastBootstrap.show();
            }
        } catch (e) {
            toastBootstrap._element.children[1].innerText = "Algo ha ido mal al eliminar el ususario con id #" + userId + " !!!";
            toastBootstrap.show();
        }



        inputName.value = userName;
        inputEmail.value = userEmail;
        inputRol.value = userRol;

        myModalToEditUser.show();
    }
    const deleteUser = async (userId) => {
        if (confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
            try {
                const responseRaw = await fetch("deleteUser.php?id=" + userId, {
                    method: "DELETE",
                });
                // Response
                const response = await responseRaw.json();
                if (response) {
                    const elementUserRow = document.querySelector('.user-id-' + userId);
                    elementUserRow.remove();
                } else {
                    toastBootstrap._element.children[1].innerText = "Algo ha ido mal al eliminar el ususario con id #" + userId + " !!!";
                    toastBootstrap.show();
                }
            } catch (e) {
                toastBootstrap._element.children[1].innerText = "Algo ha ido mal al eliminar el ususario con id #" + userId + " !!!";
                toastBootstrap.show();
            }
        }
    }
</script>
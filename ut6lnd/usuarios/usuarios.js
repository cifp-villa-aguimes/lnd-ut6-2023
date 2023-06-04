// Funciones para Usuarios:

const onLoadToastBootstrap = () =>
  bootstrap.Toast.getOrCreateInstance(toastWarnMsg);

const onLoadMyModalUsers = () =>
  bootstrap.Modal.getOrCreateInstance(addEditUserModal);
// const onLoadMyModalUsers = () =>  new bootstrap.Modal("#addEditUserModal");

// Add Listener:
const onAddOnClick = (userId) => {
  const btnSubmitModal = document.getElementById("btnSubmitAddEditUser");
  btnSubmitModal.addEventListener("click", () =>
    onSubmitAddEditUserForm(userId ? "edit" : "create", userId)
  );
};
// Remove Listener:
const onRemoveOnClick = () => {
  const btnSubmitModal = document.getElementById("btnSubmitAddEditUser");
  btnSubmitModal.removeEventListener("click", () =>
    onSubmitAddEditUserForm("edit", "")
  );
  // Clonar el elemento para remover el listener
  const clonedElement = btnSubmitModal.cloneNode(true);
  // Reemplazar el elemento original con el clon
  btnSubmitModal.parentNode.replaceChild(clonedElement, btnSubmitModal);
};

// Open Modal:
const onOpenModal = () => onAddOnClick();

// Close Modal: Reset input fields
const onCloseModal = () => {
  const modalTitle = document.getElementById("addEditUserModalLabel");
  const inputName = document.getElementById("inputFormControlInputName");
  const inputEmail = document.getElementById("inputFormControlInputEmail");
  const inputRol = document.getElementById("inputFormControlInputRol");
  modalTitle.innerText = "Añadir Usuario";
  inputName.value = "";
  inputName.disabled = false;
  inputEmail.value = "";
  inputEmail.disabled = false;
  inputRol.value = 4;
  inputRol.disabled = false;
  onRemoveOnClick();
};

// Load User:
const onLoadUser = async (userId) => {
  try {
    const toastBootstrap = onLoadToastBootstrap();
    const modalTitle = document.getElementById("addEditUserModalLabel");
    // Inputs
    const inputName = document.getElementById("inputFormControlInputName");
    const inputEmail = document.getElementById("inputFormControlInputEmail");
    const inputRol = document.getElementById("inputFormControlInputRol");
    // Button Edit
    const elementBtnEdit = document.querySelector(
      "#users-table tbody tr.user-id-" + userId + " td button.edit"
    );
    elementBtnEdit.disabled = true;
    elementBtnEdit.innerHTML = `
      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
      Loading ...
    `;
    inputName.disabled = true;
    inputEmail.disabled = true;
    inputRol.disabled = true;
    // REQUEST USER
    const responseRaw = await fetch("getUser.php?id=" + userId, {
      method: "GET",
    });
    // Response
    const response = await responseRaw.json();
    if (response && response.ok) {
      modalTitle.innerText = "Editar Usuario";
      const user = response.user;
      inputName.value = user.nombre;
      inputName.disabled = false;
      inputEmail.value = user.email;
      inputEmail.disabled = false;
      inputRol.value = user.rol_id;
      inputRol.disabled = false;
      // Añadir el event onClick listener:
      onAddOnClick(userId);
      setTimeout(() => {
        onLoadMyModalUsers().show();
        // Habilitar el botón y restaurar su contenido original
        elementBtnEdit.disabled = false;
        elementBtnEdit.innerHTML = `
          Editar <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
          </svg>
        `;
      }, 500);
    } else {
      toastBootstrap._element.children[1].innerText =
        "Algo ha ido mal al cargar el ususario con id #" + userId + " !!!";
      toastBootstrap.show();
    }
  } catch (e) {
    toastBootstrap._element.children[1].innerText =
      "Algo ha ido mal al cargar el ususario con id #" + userId + " !!!";
    toastBootstrap.show();
  }
};

// Save/Edit User:
const onSubmitAddEditUserForm = async (action, userId) => {
  const reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+.)+[A-Z]{2,4}$/i;
  const inputName = document.getElementById("inputFormControlInputName");
  const inputEmail = document.getElementById("inputFormControlInputEmail");
  const inputRol = document.getElementById("inputFormControlInputRol");
  const elementMsgSuccess = document.getElementById("success-msg");
  const toastBootstrap = onLoadToastBootstrap();
  if (inputName.value || inputEmail.value) {
    if (inputEmail.value.trim() && !reg.test(inputEmail.value)) {
      toastBootstrap._element.children[1].innerText = "Escribe un email válido";
      toastBootstrap.show();
      return inputEmail.focus();
    }
    // El payload a enviar a PHP
    const payload = {
      _id: userId,
      name: inputName.value,
      email: inputEmail.value,
      rol: inputRol.value,
    };
    const body = JSON.stringify(payload);
    // Request
    try {
      let responseRaw;
      if (action === "create") {
        responseRaw = await fetch("createUser.php", {
          method: "POST",
          body,
        });
      } else if (action === "edit" && userId) {
        responseRaw = await fetch("editUser.php", {
          method: "PUT",
          body,
        });
      }
      // Response
      const response = await responseRaw.json();
      if (response && response.ok) {
        elementMsgSuccess.innerHTML = `<i class="bi bi-check-circle-fill"></i> Usuario editado !!!`;
        elementMsgSuccess.classList.remove("visually-hidden");
        setTimeout(() => {
          elementMsgSuccess.classList.add("visually-hidden");
          elementMsgSuccess.innerHTML = `<i class="bi bi-check-circle-fill"></i> Usuario añadido !!!`;
        }, 5000);
        inputName.value = inputEmail.value = "";
        inputRol.value = "4";
        const roles = {
          1: "Administrador",
          2: "Editor",
          3: "Usuario Registrado",
          4: "Invitado",
        };
        if (action === "create") {
          // Obtener una referencia al elemento <tbody>
          const tbody = document.querySelector("#users-table tbody");
          // Crear el código HTML de la fila
          const filaHTML = `<tr class="user-id-${response.id}">
                    <th scope="row">${response.id}</th>
                    <td class="text-truncate">${payload.name}</td>
                    <td class="text-truncate">${payload.email}</td>
                    <td class="text-truncate">${roles[payload.rol]}</td>
                    <td>
                        <button onclick="deleteUser(${
                          response.id
                        })" class="delete btn btn-danger float-end">
                            Eliminar <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-dash" viewBox="0 0 16 16">
                                      <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7ZM11 12h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1 0-1Zm0-7a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" />
                                      <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z" />
                                  </svg>
                        </button>
                        <button onclick="onLoadUser(${
                          response.id
                        })" class="edit btn btn-warning float-end me-2">
                             Editar <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                      <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                  </svg>
                        </button>
                    </td>
                </tr>`;
          // Insertar la fila en el <tbody> como el último elemento
          tbody.insertAdjacentHTML("beforeend", filaHTML);
        } else if (action === "edit" && userId) {
          // Obtener una referencia al elemento <tbody>
          const trUserId = document.querySelector(
            "#users-table tbody tr.user-id-" + userId
          );
          // Actualiza el contenido del elemento
          trUserId.innerHTML = `<tr class="user-id-${response.id}">
                    <th scope="row">${response.id}</th>
                    <td class="text-truncate">${payload.name}</td>
                    <td class="text-truncate">${payload.email}</td>
                    <td class="text-truncate">${roles[payload.rol]}</td>
                    <td>
                        <button onclick="deleteUser(${
                          response.id
                        })" class="delete btn btn-danger float-end">
                            Eliminar <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-dash" viewBox="0 0 16 16">
                                      <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7ZM11 12h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1 0-1Zm0-7a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" />
                                      <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z" />
                                  </svg>
                        </button>
                        <button onclick="onLoadUser(${
                          response.id
                        })" class="edit btn btn-warning float-end me-2">
                             Editar <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                      <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                  </svg>
                        </button>
                    </td>
                </tr>`;
        }
      } else {
        toastBootstrap._element.children[1].innerText =
          "Algo ha ido mal al guardar los datos !!!";
        toastBootstrap.show();
      }
    } catch (e) {
      toastBootstrap._element.children[1].innerText =
        "Algo ha ido mal al guardar los datos !!!";
      toastBootstrap.show();
    }
    onRemoveOnClick();
    return setTimeout(() => onLoadMyModalUsers().hide(), 1500);
  }
  toastBootstrap._element.children[1].innerText = "Algunos campos están vacios";
  return toastBootstrap.show();
};

// Delete User:
const deleteUser = async (userId) => {
  if (
    confirm(
      "¿Estás seguro de que deseas eliminar al ususario con id #" +
        userId +
        " ?"
    )
  ) {
    const toastBootstrap = onLoadToastBootstrap();
    try {
      const responseRaw = await fetch("deleteUser.php?id=" + userId, {
        method: "DELETE",
      });
      // Response
      const response = await responseRaw.json();
      if (response && response.ok) {
        const elementUserRow = document.querySelector(".user-id-" + userId);
        elementUserRow.remove();
      } else {
        toastBootstrap._element.children[1].innerText =
          "Algo ha ido mal al eliminar el ususario con id #" + userId + " !!!";
        toastBootstrap.show();
      }
    } catch (e) {
      toastBootstrap._element.children[1].innerText =
        "Algo ha ido mal al eliminar el ususario con id #" + userId + " !!!";
      toastBootstrap.show();
    }
  }
};

<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PHP Form - How to create PHP forms</title>
    <meta name="description" content="PHP Form - Modal Add User">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
        Add User
    </button>

    <!-- Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addUserModalLabel">Add User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="inputFormControlInputName" class="form-label">Name</label>
                            <input type="name" class="form-control" id="inputFormControlInputName" placeholder="name ..." required>
                        </div>
                        <div class="mb-3">
                            <label for="inputFormControlInputEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="inputFormControlInputEmail" placeholder="email@example.com" pattern="/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitAddUserForm()">Save</button>
                    <button type="button" id="submitAddUserForm" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script>
        const btnSubmitAddUserForm = document.querySelector("#submitAddUserForm");
        btnSubmitAddUserForm.onclick = async () => {
            return alert("SUBMITTED");
        }

        const submitAddUserForm = async () => {
            const reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+.)+[A-Z]{2,4}$/i;
            const inputName = document.getElementById('inputFormControlInputName');
            const inputEmail = document.getElementById('inputFormControlInputEmail');

            if (inputName.value || inputEmail.value) {
                if (inputEmail.value.trim() && !reg.test(inputEmail.value)) {
                    alert("SUBMITTED: Please enter valid email.");
                    return inputEmail.focus();
                }
                return alert("SUBMITTED: " + "Name: " + inputName.value + ", Email: " + inputEmail.value);
                // El payload a enviar a PHP
                const payload = {
                    name: inputName.value,
                    email: inputEmail.value,
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
                    if (response) {
                        alert("Submitted success !!!");
                        inputName.value = inputEmail.value = "";
                    } else {
                        alert("Submitted failed !!!");
                    }
                } catch (e) {
                    alert("Submitted failed !!!");
                }
                return
            }
            return alert("SUBMITTED is empty")

        }
    </script>

</body>

</html>
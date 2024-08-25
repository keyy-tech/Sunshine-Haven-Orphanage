<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <title>Sunshine Shelter | Signin</title>
    <style>
        body {
            font-family: "Poppins";
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }
    </style>
</head>

<body>
    <form action="" class="form-floating border-success p-3 w-25 h-auto shadow-lg needs-validation container d-flex justify-content-center flex-column rounded-4 text-bg-light" novalidate>
        <h1 class="text-center fw-light mt-2">Sign In</h1>
        <p class="text-center fw-light pb-3">Sunshine Shelter</p>
        <div class="form-floating mb-4 mt-2">
            <input type="text" class="form-control" id="floatingInput" placeholder="STFOO1" required maxlength="6">
            <label for="floatingInput">Staff ID </label>
            <div class="invalid-feedback">
                Please enter a valid staff id.
            </div>
        </div>
        <div class="form-floating mb-4">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" required minlength="5">
            <label for="floatingPassword">Password</label>
            <div class="invalid-feedback" id="passwordFeedback">
                Password is required and must be at least 5 characters long.
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary mt-2 mb-3 w-50">Login</button>
        </div>
    </form>
</body>
<script>
    (function() {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        var passwordInput = document.getElementById('floatingPassword');
        var passwordFeedback = document.getElementById('passwordFeedback');

        passwordInput.addEventListener('input', function() {
            if (passwordInput.value.length < 8) {
                passwordInput.setCustomValidity('Password is too short.');
            } else {
                passwordInput.setCustomValidity('');
            }
            passwordInput.reportValidity();
        });

    })();
</script>

</html>
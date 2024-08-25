<?php

require_once("config.php");

if (isset($_POST['submit'])) {
    $NAME = ucwords($_POST['name']);
    $STAFFID = $_POST['id'];
    $ROLE = $_POST['role'];
    $CONTINFO = ucwords($_POST['continfo']);
    $GENDER = ucwords($_POST['gender']);
    $CERTIFICATION = $_POST['certificaion'];

    $query = "INSERT INTO staff VALUES('$STAFFID','$NAME','$ROLE','$GENDER','$CONTINFO','$CERTIFICATION')";

    $result = mysqli_query($config, $query);

    if ($result) {
        $message = "Staff's Record Successfully added to the database";
    } else {
        $message = "Staff's Record was not successfully added to the database";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Sunshine Shelter | Staff</title>
    <style>
        body {
            font-family: "Poppins";
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .invalid-feedback {
            display: none;
        }

        .was-validated .form-control:invalid,
        .was-validated .form-select:invalid {
            border-color: #dc3545;
        }

        .was-validated .form-control:invalid~.invalid-feedback,
        .was-validated .form-select:invalid~.invalid-feedback {
            display: block;
        }

        .alert {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body class="d-flex justify-content-center flex-column">
    <?php if (isset($message)): ?>
        <div class="alert alert-info alert-dismissible fade show m-2 w-50 text-center" role="alert">
            <?php echo $message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <form action="" method="post" class="w-50 m-3 text-bg-dark p-3 shadow-lg needs-validation container" novalidate>
        <h1 class="text-center fw-bold">Staff Registration</h1>
        <h2 class="text-center fw-light fs-3">Sunshine Shelter Orphange</h2>

        <div class="px-4 position-relative">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control " required />
            <div class="valid-tooltip">
                Looks good!
            </div>
            <div class="invalid-tooltip">
                Enter a valid name.
            </div>
        </div>
        <div class="row m-2">
            <div class="col position-relative">
                <label for="id" class="form-label">StaffID</label>
                <input type="text" name="id" id="id" maxlength="6" class="form-control" required />
                <div class="invalid-tooltip">
                    Enter a valid id.
                </div>
            </div>
            <div class="col position-relative">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-select">
                    <option value="user1">User 1</option>
                    <option value="user2">User 2</option>
                    <option value="user3">User 3</option>
                    <option value="user4">User 4</option>
                    <option value="user5">User 5</option>
                    <option value="user6">User 6</option>
                </select>
                <div class="invalid-tooltip">
                    Enter a valid role
                </div>
            </div>
        </div>

        <div class="row m-2">
            <div class="col position-relative">
                <label for="continfo" class="form-label">Contact Information</label>
                <input type="text" name="continfo" id="continfo" class="form-control" required maxlength="10" />
                <div class="invalid-tooltip">
                    Enter a valid Contact Information
                </div>
            </div>
            <div class="col position-relative">
                <label for="gender" class="form-label">Gender</label>
                <select name="gender" id="gender" class="form-select">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <div class="invalid-tooltip">
                    Choose a gender.
                </div>
            </div>
        </div>
        <div class="px-3">
            <label for="needs" class="form-label">Certifications</label>
            <textarea name="certificaion" id="certification" cols="20" rows="10" class="form-control"></textarea>
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary mt-4 d-flex justify-content-center w-25" name="submit">Submit</button>
        </div>

    </form>
</body>
<script>
    (function() {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>

</html>
<?php
include 'connections/db_connect.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>Donations</title>
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <main>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
            <h1 class="h4">Update Donations</h1>
        </div>
        <form action="" method="post" class="form-floating border-success p-3 shadow-lg needs-validation text-bg-light rounded-4" novalidate>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingFullName" name="full_name" placeholder="Full Name" required>
                <label for="floatingFullName">Name</label>
                <div class="invalid-feedback">
                    Please provide a full name.
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingFullName" name="full_name" placeholder="Full Name" required>
                <label for="floatingFullName">Amount</label>
                <div class="invalid-feedback">
                    Please provide a full name.
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingFullName" name="full_name" placeholder="Full Name" required>
                <label for="floatingFullName">Purpose</label>
                <div class="invalid-feedback">
                    Please provide a full name.
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="date" class="form-control" id="dob" name="dob" required>
                <label for="dob">Date Of Donations</label>
                <div class="invalid-feedback">
                    Please provide a valid date of birth.
                </div>
            </div>
            <button type="submit" class="btn btn-outline-primary mt-1">Save Record</button>
            <a href="view_donations.php" class="btn btn-outline-secondary mt-1 ms-3">View Records</a>
        </form>

    </main>
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
    })();
</script>

</html>
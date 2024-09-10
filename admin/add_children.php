<?php
include '../connections/db_connect.php';

// Initialize message variable
$message = '';
$alert_class = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $full_name = $_POST["full_name"];
    $dob = $_POST["dob"];
    $gender = isset($_POST["gender"]) ? $_POST["gender"] : '';
    $nationality = $_POST["nationality"];
    $special_needs = $_POST["special_needs"];

    // Check for duplicate record
    $stmt = $db_connect->prepare("SELECT * FROM children WHERE full_name = ? AND dob = ?");
    $stmt->bind_param("ss", $full_name, $dob);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Duplicate record found
        $message = "Record already exists!";
        $alert_class = "alert-danger";
    } else {
        // Prepare and bind
        $stmt = $db_connect->prepare("INSERT INTO children (full_name, dob, gender, nationality, special_needs) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $full_name, $dob, $gender, $nationality, $special_needs);

        // Execute and check if the record was added successfully
        if ($stmt->execute()) {
            $message = "New record created successfully";
            $alert_class = "alert-success";
        } else {
            $message = "Error: " . $stmt->error;
            $alert_class = "alert-danger";
        }

        $stmt->close();
    }
    $db_connect->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../style.css">
    <title>Children</title>
</head>

<body>
    <?php include '../admin_sidebar.php'; ?>
    <main>
        <div class="container">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
                <h1 class="h4">Children</h1>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert <?php echo $alert_class; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="" method="post" class="form-floating border-success p-3 shadow-lg needs-validation text-bg-light rounded-4" novalidate>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingFullName" name="full_name" placeholder="Full Name" required>
                    <label for="floatingFullName">Name</label>
                    <div class="invalid-feedback">
                        Please provide a full name.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="dob" name="dob" required>
                    <label for="dob">Date Of Birth</label>
                    <div class="invalid-feedback">
                        Please provide a valid date of birth.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="floatingSelectGender" name="gender" required>
                        <option value="" disabled selected>Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <label for="floatingSelectGender">Gender</label>
                    <div class="invalid-feedback">
                        Please select a gender.
                    </div>
                </div>
                <div class="form-floating mb-3 mt-3">
                    <input type="text" class="form-control" id="floatingNationality" name="nationality" placeholder="Nationality" required>
                    <label for="floatingNationality">Nationality</label>
                    <div class="invalid-feedback">
                        Please provide a nationality.
                    </div>
                </div>
                <div class="mb-3">
                    <textarea class="form-control" id="special_needs" name="special_needs" rows="10" placeholder="Special Needs"></textarea>
                    <label for="special_needs">Special Needs</label>
                </div>
                <button type="submit" class="btn btn-outline-primary mt-1">Save Record</button>
                <a href="view_children.php" class="btn btn-outline-secondary mt-1 ms-3">View Records</a>
            </form>

        </div>
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
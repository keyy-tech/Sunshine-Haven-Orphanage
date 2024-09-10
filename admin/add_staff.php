<?php
include '../connections/db_connect.php';

// Initialize message variable
$message = '';
$alert_class = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = trim($_POST["name"]);
    $contact_info = trim($_POST["contact_info"]);
    $role = trim($_POST["role"]);
    $certifications = trim($_POST["certifications"]);
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check for duplicate record
    $stmt = $db_connect->prepare("SELECT * FROM Staff WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Duplicate username found
        $message = "Username already exists!";
        $alert_class = "alert-danger";
    } else {
        // Prepare and bind for insertion
        $stmt = $db_connect->prepare("INSERT INTO Staff (name, contact_info, role, certifications, username, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $contact_info, $role, $certifications, $username, $hashed_password);

        // Execute and check if the record was added successfully
        if ($stmt->execute()) {
            $message = "New staff member added successfully";
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
    <title>Staff</title>
</head>

<body>
    <?php include '../admin_sidebar.php'; ?>
    <main>
        <div class="container">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
                <h1 class="h4">Add Staff Member</h1>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert <?php echo $alert_class; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="" method="post" class="form-floating border-success p-3 shadow-lg needs-validation text-bg-light rounded-4" novalidate>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingName" name="name" placeholder="Name" required>
                    <label for="floatingName">Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingContactInfo" name="contact_info" placeholder="Contact Information" required>
                    <label for="floatingContactInfo">Contact Information</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingRole" name="role" placeholder="Role" required>
                    <label for="floatingRole">Role</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="certifications" name="certifications" placeholder="Certifications" required></textarea>
                    <label for="certifications">Certifications</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingUsername" name="username" placeholder="Username" required>
                    <label for="floatingUsername">Username</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
                    <label for="floatingPassword">Password</label>
                </div>
                <button type="submit" class="btn btn-outline-primary mt-1">Save Record</button>
                <a href="view_staff.php" class="btn btn-outline-secondary mt-1 ms-3">View Records</a>
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

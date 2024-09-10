<?php
include '../connections/db_connect.php';

include '../connections/access_control.php'; // Path to the access control file

// Initialize message variable
$message = '';
$alert_class = '';

// Initialize variables for the form
$name = '';
$username = '';
$password = '';
$contact_info = '';
$role = '';
$certifications = '';
$update_mode = false;
$id = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;
    $name = trim($_POST["name"]);
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $contact_info = trim($_POST["contact_info"]);
    $role = trim($_POST["role"]);
    $certifications = trim($_POST["certifications"]);

    if ($id) {
        // Update record
        if (!empty($password)) {
            // Update with password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db_connect->prepare("UPDATE Staff SET name = ?, username = ?, password = ?, contact_info = ?, role = ?, certifications = ? WHERE id = ?");
            $stmt->bind_param("ssssssi", $name, $username, $hashed_password, $contact_info, $role, $certifications, $id);
        } else {
            // Update without password
            $stmt = $db_connect->prepare("UPDATE Staff SET name = ?, username = ?, contact_info = ?, role = ?, certifications = ? WHERE id = ?");
            $stmt->bind_param("sssssi", $name, $username, $contact_info, $role, $certifications, $id);
        }

        if ($stmt->execute()) {
            $message = "Staff record updated successfully.";
            $alert_class = "alert-success";
        } else {
            $message = "Error: " . $stmt->error;
            $alert_class = "alert-danger";
        }
        $stmt->close();
    } else {
        // Insert record
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db_connect->prepare("INSERT INTO Staff (name, username, password, contact_info, role, certifications) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $username, $hashed_password, $contact_info, $role, $certifications);
        if ($stmt->execute()) {
            $message = "Staff record added successfully.";
            $alert_class = "alert-success";
        } else {
            $message = "Error: " . $stmt->error;
            $alert_class = "alert-danger";
        }
        $stmt->close();
    }

    $db_connect->close();
}

// Fetch existing data if updating
if (isset($_GET['id']) && !$id) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM Staff WHERE id = ?";
    $stmt = $db_connect->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $staff_data = $result->fetch_assoc();
        $name = $staff_data['name'];
        $username = $staff_data['username'];
        $contact_info = $staff_data['contact_info'];
        $role = $staff_data['role'];
        $certifications = $staff_data['certifications'];
        $update_mode = true;
    } else {
        $message = 'Record not found.';
        $alert_class = 'alert-danger';
    }
    $stmt->close();
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
    <title><?php echo $update_mode ? 'Update Staff Record' : 'Add Staff Record'; ?></title>
</head>

<body>
    <?php include '../admin_sidebar.php'; ?>
    <main>
        <div class="container">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
                <h1 class="h4"><?php echo $update_mode ? 'Update Staff Record' : 'Add Staff Record'; ?></h1>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert <?php echo $alert_class; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="" method="post" class="form-floating border-success p-3 shadow-lg needs-validation text-bg-light rounded-4" novalidate>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingName" name="name" placeholder="Full Name" value="<?php echo htmlspecialchars($name); ?>" required>
                    <label for="floatingName">Full Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingUsername" name="username" placeholder="Username" value="<?php echo htmlspecialchars($username); ?>" required>
                    <label for="floatingUsername">Username</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                    <?php if ($update_mode): ?>
                        <small class="text-muted">Leave blank to keep the current password.</small>
                    <?php endif; ?>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingContactInfo" name="contact_info" placeholder="Contact Info" value="<?php echo htmlspecialchars($contact_info); ?>" required>
                    <label for="floatingContactInfo">Contact Info</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingRole" name="role" placeholder="Role" value="<?php echo htmlspecialchars($role); ?>" required>
                    <label for="floatingRole">Role</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingCertifications" name="certifications" placeholder="Certifications" value="<?php echo htmlspecialchars($certifications); ?>" required>
                    <label for="floatingCertifications">Certifications</label>
                </div>
                <button type="submit" class="btn btn-outline-primary mt-1"><?php echo $update_mode ? 'Update Record' : 'Save Record'; ?></button>
                <a href="view_staff.php" class="btn btn-outline-secondary mt-1 ms-3">View Records</a>
            </form>
        </div>
    </main>
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
</body>

</html>
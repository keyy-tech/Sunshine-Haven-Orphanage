<?php
include 'connection/db_connect.php';



// Initialize message variable
$message = '';
$alert_class = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $full_name = trim($_POST["full_name"]);
    $contact_info = trim($_POST["contactinfo"]);
    $role = trim($_POST["role"]);
    $certification = trim($_POST["certification"]);

    // Check for duplicate record
    $stmt = $conn->prepare("SELECT * FROM staff WHERE full_name = ? AND contact_info = ?");
    $stmt->bind_param("ss", $full_name, $contact_info);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Duplicate record found
        $message = "Record already exists!";
        $alert_class = "alert-danger";
    } else {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO staff (full_name, contact_info, role, certification) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $full_name, $contact_info, $role, $certification);

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
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>Staff</title>
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <main>
        <div class="container">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
                <h1 class="h4">Staff</h1>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert <?php echo $alert_class; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingFullName" name="full_name" placeholder="Full Name" required>
                    <label for="floatingFullName">Name</label>
                </div>
                <div class="form-floating mb-3 mt-3">
                    <input type="text" class="form-control" id="floatingContactInfo" name="contactinfo" placeholder="Contact Information" required>
                    <label for="floatingContactInfo">Contact Information</label>
                </div>
                <div class="form-floating mb-3 mt-3">
                    <input type="text" class="form-control" id="floatingRole" name="role" placeholder="Role" required>
                    <label for="floatingRole">Role</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="certification" name="certification" rows="10" placeholder="Certifications" required></textarea>
                    <label for="certification">Certifications</label>
                </div>
                <button type="submit" class="btn btn-primary mt-1">Add Staff</button>
            </form>
        </div>
    </main>
</body>

</html>
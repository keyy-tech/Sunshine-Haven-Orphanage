<?php
include '../connections/db_connect.php';
include '../connections/access_control.php'; // Path to the access control file


// Initialize variables
$message = '';
$alert_class = 'alert-success';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = trim($_POST['full_name']);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $nationality = trim($_POST['nationality']);
    $special_needs = isset($_POST['special_needs']) ? trim($_POST['special_needs']) : ''; // Optional field
    $id = isset($_POST['id']) ? intval($_POST['id']) : null; // Ensure ID is provided

    // Validate input
    if (empty($name) || empty($dob) || empty($gender) || empty($nationality) || !$id) {
        $message = 'Please fill in all required fields.';
        $alert_class = 'alert-danger';
    } else {
        // Update record in the database
        $query = "UPDATE Children SET 
                    full_name = ?, 
                    dob = ?, 
                    gender = ?, 
                    nationality = ?, 
                    special_needs = ? 
                  WHERE id = ?";
        $stmt = $db_connect->prepare($query);
        $stmt->bind_param('sssssi', $name, $dob, $gender, $nationality, $special_needs, $id);

        if ($stmt->execute()) {
            $message = 'Record updated successfully.';
        } else {
            $message = 'Error updating record: ' . $stmt->error;
            $alert_class = 'alert-danger';
        }
        $stmt->close();
    }
}

// Fetch existing record data for the form (Assuming ID is passed via query string)
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
if ($id) {
    $query = "SELECT * FROM Children WHERE id = ?";
    $stmt = $db_connect->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $name = $row['full_name'];
        $dob = $row['dob'];
        $gender = $row['gender'];
        $nationality = $row['nationality'];
        $special_needs = $row['special_needs'];
    } else {
        die('Record not found.');
    }
    $stmt->close();
} else {
    die('No ID specified.');
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
    <title>Update Child</title>
</head>

<body>
    <?php include '../admin_sidebar.php'; ?>
    <main>
        <div class="container">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
                <h1 class="h4">Update Child</h1>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert <?php echo htmlspecialchars($alert_class); ?> alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($message); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="" method="post" class="form-floating border-success p-3 shadow-lg needs-validation text-bg-light rounded-4" novalidate>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingFullName" name="full_name" placeholder="Full Name" value="<?php echo htmlspecialchars($name); ?>" required>
                    <label for="floatingFullName">Full Name</label>
                    <div class="invalid-feedback">
                        Please provide a full name.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="dob" name="dob" value="<?php echo htmlspecialchars($dob); ?>" required>
                    <label for="dob">Date Of Birth</label>
                    <div class="invalid-feedback">
                        Please provide a valid date of birth.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="floatingSelectGender" name="gender" required>
                        <option value="" disabled>Select Gender</option>
                        <option value="Male" <?php if ($gender === 'Male') echo 'selected'; ?>>Male</option>
                        <option value="Female" <?php if ($gender === 'Female') echo 'selected'; ?>>Female</option>
                    </select>
                    <label for="floatingSelectGender">Gender</label>
                    <div class="invalid-feedback">
                        Please select a gender.
                    </div>
                </div>
                <div class="form-floating mb-3 mt-3">
                    <input type="text" class="form-control" id="floatingNationality" name="nationality" placeholder="Nationality" value="<?php echo htmlspecialchars($nationality); ?>" required>
                    <label for="floatingNationality">Nationality</label>
                    <div class="invalid-feedback">
                        Please provide a nationality.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="special_needs" name="special_needs" rows="10" placeholder="Special Needs"><?php echo htmlspecialchars($special_needs); ?></textarea>
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
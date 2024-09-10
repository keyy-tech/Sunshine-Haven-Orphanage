<?php
include '../connections/db_connect.php';

// Initialize message variable
$message = '';
$alert_class = '';

// Retrieve record ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch existing record details
if ($id > 0) {
    $stmt = $db_connect->prepare("SELECT * FROM Families WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $record = $result->fetch_assoc();
    $stmt->close();

    if (!$record) {
        die("Record not found.");
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = trim($_POST["name"]);
        $contact_info = trim($_POST["contact_info"]);
        $parent_name = trim($_POST["parent_name"]);
        $occupation = trim($_POST["occupation"]);
        $address = trim($_POST["address"]);

        // Prepare and bind
        $stmt = $db_connect->prepare("UPDATE Families SET name = ?, contact_info = ?, parent_name = ?, occupation = ?, address = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $name, $contact_info, $parent_name, $occupation, $address, $id);

        // Execute and check if the record was updated successfully
        if ($stmt->execute()) {
            $message = "Record updated successfully";
            $alert_class = "alert-success";
        } else {
            $message = "Error: " . $stmt->error;
            $alert_class = "alert-danger";
        }

        $stmt->close();
    }

    $db_connect->close();
} else {
    die("Invalid ID.");
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
    <title>Update Family Record</title>
</head>

<body>
    <?php include '../admin_sidebar.php'; ?>
    <main>
        <div class="container">
            <h1 class="h4">Update Family Record</h1>
            <?php if (!empty($message)): ?>
                <div class="alert <?php echo $alert_class; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="" method="post" class="form-floating border-success p-3 shadow-lg needs-validation text-bg-light rounded-4" novalidate>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingName" name="name" value="<?php echo htmlspecialchars($record['name']); ?>" placeholder="Family Name" required>
                    <label for="floatingName">Family Name</label>
                    <div class="invalid-feedback">
                        Please provide the Family Name.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingContactInfo" name="contact_info" value="<?php echo htmlspecialchars($record['contact_info']); ?>" placeholder="Contact Info" required>
                    <label for="floatingContactInfo">Contact Info</label>
                    <div class="invalid-feedback">
                        Please provide Contact Info.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingParentName" name="parent_name" value="<?php echo htmlspecialchars($record['parent_name']); ?>" placeholder="Parent Name" required>
                    <label for="floatingParentName">Parent Name</label>
                    <div class="invalid-feedback">
                        Please provide the Parent Name.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingOccupation" name="occupation" value="<?php echo htmlspecialchars($record['occupation']); ?>" placeholder="Occupation" required>
                    <label for="floatingOccupation">Occupation</label>
                    <div class="invalid-feedback">
                        Please provide the Occupation.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingAddress" name="address" value="<?php echo htmlspecialchars($record['address']); ?>" placeholder="Address" required>
                    <label for="floatingAddress">Address</label>
                    <div class="invalid-feedback">
                        Please provide the Address.
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-primary mt-1">Save Record</button>
                <a href="view_families.php" class="btn btn-outline-secondary mt-1 ms-3">View Records</a>
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
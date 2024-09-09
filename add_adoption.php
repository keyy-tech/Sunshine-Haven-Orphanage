<?php
include 'connections/db_connect.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $child_id = $_POST['child_id'];
    $family_id = $_POST['family_id'];
    $status = $_POST['status'];
    $date_of_placement = $_POST['date_of_placement']; // New field

    // Prepare the SQL statement
    $sql = "INSERT INTO Adoption (child_id, family_id, status, date_of_placement) 
            VALUES (?, ?, ?, ?)";

    if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param("iiss", $child_id, $family_id, $status, $date_of_placement);

        // Execute the query
        if ($stmt->execute()) {
            $message = "Adoption record added successfully.";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "Error preparing statement: " . $db_connect->error;
    }
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
    <title>Add Adoption</title>
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <main>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
            <h1 class="h4">Add Adoption</h1>
        </div>

        <?php if (!empty($message)): ?>
            <div class="alert <?php echo $alert_class; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <form action="" method="post" class="form-floating border-success p-3 shadow-lg needs-validation text-bg-light rounded-4" novalidate>
            <div class="form-floating mb-3">
                <input type="number" class="form-control" id="child_id" name="child_id" placeholder="Child ID" required>
                <label for="child_id">Child ID</label>
                <div class="invalid-feedback">
                    Please provide the Child ID.
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="number" class="form-control" id="family_id" name="family_id" placeholder="Family ID" required>
                <label for="family_id">Family ID</label>
                <div class="invalid-feedback">
                    Please provide the Family ID.
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="status" name="status" placeholder="Status" required>
                <label for="status">Status</label>
                <div class="invalid-feedback">
                    Please provide the status.
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="date" class="form-control" id="date_of_placement" name="date_of_placement" required>
                <label for="date_of_placement">Date of Placement</label>
                <div class="invalid-feedback">
                    Please provide a valid date of placement.
                </div>
            </div>
            <button type="submit" class="btn btn-outline-primary mt-1">Save Record</button>
            <a href="view_adoptions.php" class="btn btn-outline-secondary mt-1 ms-3">View Records</a>
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
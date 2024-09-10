<?php
// Include the database connection file
require_once '../connections/db_connect.php';

// Initialize variables
$adoption = [];
$message = '';
$alert_class = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $id = $_POST['id'];
    $child_id = $_POST['child_id'];
    $family_id = $_POST['family_id'];
    $status = $_POST['status'];
    $placement_date = $_POST['placement_date'];

    // Validate input
    $errors = [];
    if (empty($child_id)) {
        $errors[] = 'Please provide a Child ID.';
    }
    if (empty($family_id)) {
        $errors[] = 'Please provide an Adoptive Family ID.';
    }
    if (empty($status)) {
        $errors[] = 'Please provide the Status.';
    }
    if (empty($placement_date)) {
        $errors[] = 'Please provide a valid date of placement.';
    } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $placement_date)) {
        $errors[] = 'Invalid date format. Please use YYYY-MM-DD.';
    }

    if ($errors) {
        $message = implode('<br>', $errors);
        $alert_class = 'alert-danger';
    } else {
        // Update record in the database
        $query = "UPDATE Adoption SET 
                    child_id = ?, 
                    family_id = ?, 
                    status = ?, 
                    placement_date = ? 
                  WHERE id = ?";
        $stmt = $db_connect->prepare($query);
        $stmt->bind_param('iisss', $child_id, $family_id, $status, $placement_date, $id);

        if ($stmt->execute()) {
            $message = 'Record updated successfully.';
            $alert_class = 'alert-success';
        } else {
            $message = 'Error updating record: ' . $db_connect->error;
            $alert_class = 'alert-danger';
        }
        $stmt->close();
    }
}

// Fetch existing data for the adoption if updating
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM Adoption WHERE id = ?";
    $stmt = $db_connect->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $adoption = $result->fetch_assoc();
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
    <title>Update Adoption</title>
</head>

<body>
    <?php include '../admin_sidebar.php'; ?>
    <main>
        <div class="container">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
                <h1 class="h4">Update Adoption</h1>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert <?php echo $alert_class; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="" method="post" class="form-floating border-success p-3 shadow-lg needs-validation text-bg-light rounded-4" novalidate>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($adoption['id']); ?>">

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingChildId" name="child_id" placeholder="Child ID" value="<?php echo htmlspecialchars($adoption['child_id']); ?>" required>
                    <label for="floatingChildId">Child ID</label>
                    <div class="invalid-feedback">
                        Please provide a Child ID.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingFamilyId" name="family_id" placeholder="Adoptive Family ID" value="<?php echo htmlspecialchars($adoption['family_id']); ?>" required>
                    <label for="floatingFamilyId">Adoptive Family ID</label>
                    <div class="invalid-feedback">
                        Please provide an Adoptive Family ID.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingStatus" name="status" placeholder="Status" value="<?php echo htmlspecialchars($adoption['status']); ?>" required>
                    <label for="floatingStatus">Status</label>
                    <div class="invalid-feedback">
                        Please provide the Status.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="placementDate" name="placement_date" value="<?php echo htmlspecialchars($adoption['placement_date']); ?>" required>
                    <label for="placementDate">Date Of Placement</label>
                    <div class="invalid-feedback">
                        Please provide a valid date of placement.
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-primary mt-1">Save Record</button>
                <a href="view_adoption.php" class="btn btn-outline-secondary mt-1 ms-3">View Records</a>
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
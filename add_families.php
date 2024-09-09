<?php
include 'connections/db_connect.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $man_name = $_POST['man_name'];
    $man_occupation = $_POST['man_occupation'];
    $woman_name = $_POST['woman_name'];
    $woman_occupation = $_POST['woman_occupation'];
    $contact_info = $_POST['contact_info'];
    $address = $_POST['address'];

    // Prepare the SQL statement
    $sql = "INSERT INTO Families (name, man_name, man_occupation, woman_name, woman_occupation, contact_info, address) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param("sssssss", $name, $man_name, $man_occupation, $woman_name, $woman_occupation, $contact_info, $address);

        // Execute the query
        if ($stmt->execute()) {
            $message = "Family record added successfully.";
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
    <title>Family</title>
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <main>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
            <h1 class="h4">Family</h1>
        </div>

        <!-- Alert Message -->
        <?php if (!empty($message)): ?>
            <div class="alert <?php echo $alert_class; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="" method="post" class="form-floating border-success p-3 shadow-lg needs-validation text-bg-light rounded-4" novalidate>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="name" name="name" placeholder="Family Name" required>
                <label for="name">Family Name</label>
                <div class="invalid-feedback">
                    Please provide a family name.
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="man_name" name="man_name" placeholder="Man's Name" required>
                <label for="man_name">Man's Name</label>
                <div class="invalid-feedback">
                    Please provide the man's name.
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="man_occupation" name="man_occupation" placeholder="Man's Occupation" required>
                <label for="man_occupation">Man's Occupation</label>
                <div class="invalid-feedback">
                    Please provide the man's occupation.
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="woman_name" name="woman_name" placeholder="Woman's Name" required>
                <label for="woman_name">Woman's Name</label>
                <div class="invalid-feedback">
                    Please provide the woman's name.
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="woman_occupation" name="woman_occupation" placeholder="Woman's Occupation" required>
                <label for="woman_occupation">Woman's Occupation</label>
                <div class="invalid-feedback">
                    Please provide the woman's occupation.
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="contact_info" name="contact_info" placeholder="Contact Information" required>
                <label for="contact_info">Contact Information</label>
                <div class="invalid-feedback">
                    Please provide contact information.
                </div>
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" id="address" name="address" rows="3" placeholder="Address" required></textarea>
                <label for="address">Address</label>
                <div class="invalid-feedback">
                    Please provide the address.
                </div>
            </div>
            <button type="submit" class="btn btn-outline-primary mt-1">Save Record</button>
            <a href="view_families.php" class="btn btn-outline-secondary mt-1 ms-3">View Records</a>
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
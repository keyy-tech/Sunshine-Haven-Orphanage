<?php
include '../connections/db_connect.php';
include '../connections/access_control.php'; // Path to the access control file

// Check access for admin



// Initialize message variables
$message = '';
$alert_class = '';

// Handle form submission for inserting a new donation record
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $amount = trim($_POST["amount"]);
    $purpose = trim($_POST["purpose"]);
    $donation_date = $_POST["donation_date"];

    // Prepare and bind for insert
    $stmt = $db_connect->prepare("INSERT INTO Donations (name, amount, purpose, donation_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $amount, $purpose, $donation_date);

    // Execute and check if the record was added successfully
    if ($stmt->execute()) {
        $message = "Donation record added successfully";
        $alert_class = "alert-success";
    } else {
        $message = "Error: " . $stmt->error;
        $alert_class = "alert-danger";
    }

    $stmt->close();
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
    <title>Add Donation Record</title>
</head>

<body>
    <?php include '../admin_sidebar.php'; ?>
    <main>
        <div class="container">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
                <h1 class="h4">Add Donation Record</h1>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert <?php echo $alert_class; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Insert form for a new donation record -->
            <form action="" method="post" class="form-floating border-success p-3 shadow-lg needs-validation text-bg-light rounded-4" novalidate>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingName" name="name" placeholder="Name" required>
                    <label for="floatingName">Name</label>
                    <div class="invalid-feedback">
                        Please provide a name.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingAmount" name="amount" placeholder="Amount" required>
                    <label for="floatingAmount">Amount</label>
                    <div class="invalid-feedback">
                        Please provide an amount.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingPurpose" name="purpose" placeholder="Purpose" required>
                    <label for="floatingPurpose">Purpose</label>
                    <div class="invalid-feedback">
                        Please provide a purpose.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="donationDate" name="donation_date" required>
                    <label for="donationDate">Date of Donation</label>
                    <div class="invalid-feedback">
                        Please provide a valid date.
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-primary mt-1">Save Record</button>
                <a href="view_donations.php" class="btn btn-outline-secondary mt-1 ms-3">View Records</a>
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
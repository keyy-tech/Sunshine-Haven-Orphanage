<?php
include '../connections/db_connect.php';

// Initialize message variable
$message = '';
$alert_class = '';

// Retrieve record ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch existing record details
if ($id > 0) {
    $stmt = $db_connect->prepare("SELECT * FROM Donations WHERE id = ?");
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
        $amount = trim($_POST["amount"]);
        $purpose = trim($_POST["purpose"]);
        $donation_date = $_POST["donation_date"];

        // Prepare and bind
        $stmt = $db_connect->prepare("UPDATE Donations SET name = ?, amount = ?, purpose = ?, donation_date = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $name, $amount, $purpose, $donation_date, $id);

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
    <title>Update Donation Record</title>
</head>

<body>
    <?php include '../sidebar.php'; ?>
    <main>
        <div class="container">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
                <h1 class="h4">Update Donation Record</h1>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert <?php echo $alert_class; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="" method="post" class="form-floating border-success p-3 shadow-lg needs-validation text-bg-light rounded-4" novalidate>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingName" name="name" value="<?php echo htmlspecialchars($record['name']); ?>" placeholder="Name" required>
                    <label for="floatingName">Name</label>
                    <div class="invalid-feedback">
                        Please provide a name.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingAmount" name="amount" value="<?php echo htmlspecialchars($record['amount']); ?>" placeholder="Amount" required>
                    <label for="floatingAmount">Amount</label>
                    <div class="invalid-feedback">
                        Please provide an amount.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingPurpose" name="purpose" value="<?php echo htmlspecialchars($record['purpose']); ?>" placeholder="Purpose" required>
                    <label for="floatingPurpose">Purpose</label>
                    <div class="invalid-feedback">
                        Please provide a purpose.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="donationDate" name="donation_date" value="<?php echo htmlspecialchars($record['donation_date']); ?>" required>
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
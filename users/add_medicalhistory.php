<?php
include '../connections/db_connect.php';
include '../connections/db_protect.php';

// Initialize message variable
$message = '';
$alert_class = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $child_id = trim($_POST["child_id"]);
    $record_date = trim($_POST["record_date"]);
    $vaccination = trim($_POST["vaccination"]);
    $allergies = trim($_POST["allergies"]);
    $treatments = trim($_POST["treatments"]);
    $id = isset($_POST["id"]) ? intval($_POST["id"]) : null; // Ensure ID is provided

    // Validate input
    if (empty($child_id) || empty($record_date)) {
        $message = 'Please fill in all required fields.';
        $alert_class = 'alert-danger';
    } else {
        // Check if record already exists
        $stmt = $db_connect->prepare("SELECT * FROM MedicalRecords WHERE child_id = ? AND record_date = ? AND (id != ? OR ? IS NULL)");
        $stmt->bind_param("isi", $child_id, $record_date, $id, $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Duplicate record found
            $message = "Record for this child on this date already exists!";
            $alert_class = "alert-danger";
        } else {
            if ($id) {
                // Update existing record
                $stmt = $db_connect->prepare("UPDATE MedicalRecords SET child_id = ?, record_date = ?, details = ? WHERE id = ?");
                $details = "Vaccination: $vaccination\nAllergies: $allergies\nTreatments: $treatments";
                $stmt->bind_param("issi", $child_id, $record_date, $details, $id);

                if ($stmt->execute()) {
                    $message = "Medical history record updated successfully";
                    $alert_class = "alert-success";
                } else {
                    $message = "Error: " . $stmt->error;
                    $alert_class = "alert-danger";
                }
            } else {
                // Insert new record
                $stmt = $db_connect->prepare("INSERT INTO MedicalRecords (child_id, record_date, details) VALUES (?, ?, ?)");
                $details = "Vaccination: $vaccination\nAllergies: $allergies\nTreatments: $treatments";
                $stmt->bind_param("iss", $child_id, $record_date, $details);

                if ($stmt->execute()) {
                    $message = "Medical history record added successfully";
                    $alert_class = "alert-success";
                } else {
                    $message = "Error: " . $stmt->error;
                    $alert_class = "alert-danger";
                }
            }
            $stmt->close();
        }
        $db_connect->close();
    }
}

// Fetch existing record data for the form (Assuming ID is passed via query string for update)
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
if ($id) {
    $query = "SELECT * FROM MedicalRecords WHERE id = ?";
    $stmt = $db_connect->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $child_id = $row['child_id'];
        $record_date = $row['record_date'];
        $details = $row['details'];

        // Split details into individual fields
        $details_array = explode("\n", $details);
        $vaccination = str_replace("Vaccination: ", "", $details_array[0] ?? '');
        $allergies = str_replace("Allergies: ", "", $details_array[1] ?? '');
        $treatments = str_replace("Treatments: ", "", $details_array[2] ?? '');
    } else {
        die('Record not found.');
    }
    $stmt->close();
} else {
    // Initialize form fields if adding a new record
    $child_id = '';
    $record_date = '';
    $vaccination = '';
    $allergies = '';
    $treatments = '';
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
    <title>Medical History</title>
</head>

<body>
    <?php include '../sidebar.php'; ?>
    <main>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
            <h1 class="h4"><?php echo $id ? 'Update Medical History' : 'Add Medical History'; ?></h1>
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
                <input type="number" class="form-control" id="floatingChildID" name="child_id" placeholder="Child ID" value="<?php echo htmlspecialchars($child_id); ?>" required>
                <label for="floatingChildID">Child ID</label>
                <div class="invalid-feedback">
                    Please provide the Child ID.
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="date" class="form-control" id="recordDate" name="record_date" value="<?php echo htmlspecialchars($record_date); ?>" required>
                <label for="recordDate">Date</label>
                <div class="invalid-feedback">
                    Please provide a valid date.
                </div>
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" id="vaccination" name="vaccination" rows="3" placeholder="Vaccination"><?php echo htmlspecialchars($vaccination); ?></textarea>
                <label for="vaccination">Vaccination</label>
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" id="allergies" name="allergies" rows="3" placeholder="Allergies"><?php echo htmlspecialchars($allergies); ?></textarea>
                <label for="allergies">Allergies</label>
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" id="treatments" name="treatments" rows="3" placeholder="Treatments"><?php echo htmlspecialchars($treatments); ?></textarea>
                <label for="treatments">Treatments</label>
            </div>

            <button type="submit" class="btn btn-outline-primary mt-1"><?php echo $id ? 'Update Record' : 'Save Record'; ?></button>
            <a href="view_medicalhistory.php" class="btn btn-outline-secondary mt-1 ms-3">View Records</a>
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

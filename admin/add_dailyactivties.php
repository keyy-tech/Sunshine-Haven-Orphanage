<?php
include 'connections/db_connect.php';

// Initialize message variable
$message = '';
$alert_class = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $child_id = intval($_POST["child_id"]);
    $activity = trim($_POST["activity"]);
    $time = $_POST["time"];

    // Check if child_id exists
    $check_stmt = $db_connect->prepare("SELECT id FROM Children WHERE id = ?");
    $check_stmt->bind_param("i", $child_id);
    $check_stmt->execute();
    $check_stmt->store_result();
    if ($check_stmt->num_rows == 0) {
        $message = "Invalid Child ID.";
        $alert_class = "alert-danger";
    } else {
        // Prepare and bind
        $stmt = $db_connect->prepare("INSERT INTO DailyActivities (child_id, activity, time) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $child_id, $activity, $time);

        // Execute and check if the record was added successfully
        if ($stmt->execute()) {
            $message = "Daily activity added successfully";
            $alert_class = "alert-success";
        } else {
            $message = "Error: " . $stmt->error;
            $alert_class = "alert-danger";
        }

        $stmt->close();
    }
    $check_stmt->close();
    $db_connect->close();
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
    <title>Daily Activities</title>
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <main>
        <div class="container">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
                <h1 class="h4">Daily Activities</h1>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert <?php echo $alert_class; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="" method="post" class="form-floating border-success p-3 shadow-lg needs-validation text-bg-light rounded-4" novalidate>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingChildId" name="child_id" placeholder="Child ID" required>
                    <label for="floatingChildId">Child ID</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingActivity" name="activity" placeholder="Activity" required>
                    <label for="floatingActivity">Activity</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="time" class="form-control" id="time" name="time" required>
                    <label for="time">Time</label>
                </div>
                <button type="submit" class="btn btn-outline-primary mt-1">Save Record</button>
                <a href="view_dailyactivties.php" class="btn btn-outline-secondary mt-1 ms-3">View Records</a>
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
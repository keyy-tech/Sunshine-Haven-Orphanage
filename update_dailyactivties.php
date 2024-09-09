<?php
include 'connections/db_connect.php';

// Initialize message variable
$message = '';
$alert_class = '';

// Initialize variables for the form
$child_id = '';
$activity = '';
$time = '';
$update_mode = false;
$id = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;
    $child_id = intval($_POST["child_id"]);
    $activity = trim($_POST["activity"]);
    $time = $_POST["time"];

    if ($id) {
        // Update record
        $stmt = $db_connect->prepare("UPDATE DailyActivities SET child_id = ?, activity = ?, time = ? WHERE id = ?");
        $stmt->bind_param("issi", $child_id, $activity, $time, $id);
        if ($stmt->execute()) {
            $message = "Daily activity updated successfully.";
            $alert_class = "alert-success";
        } else {
            $message = "Error: " . $stmt->error;
            $alert_class = "alert-danger";
        }
        $stmt->close();
    } else {
        // Insert record
        $stmt = $db_connect->prepare("INSERT INTO DailyActivities (child_id, activity, time) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $child_id, $activity, $time);
        if ($stmt->execute()) {
            $message = "Daily activity added successfully.";
            $alert_class = "alert-success";
        } else {
            $message = "Error: " . $stmt->error;
            $alert_class = "alert-danger";
        }
        $stmt->close();
    }

    $db_connect->close();
}

// Fetch existing data if updating
if (isset($_GET['id']) && !$id) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM DailyActivities WHERE id = ?";
    $stmt = $db_connect->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $activity_data = $result->fetch_assoc();
        $child_id = $activity_data['child_id'];
        $activity = $activity_data['activity'];
        $time = $activity_data['time'];
        $update_mode = true;
    } else {
        $message = 'Record not found.';
        $alert_class = 'alert-danger';
    }
    $stmt->close();
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
    <title><?php echo $update_mode ? 'Update Daily Activity' : 'Add Daily Activity'; ?></title>
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <main>
        <div class="container">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
                <h1 class="h4"><?php echo $update_mode ? 'Update Daily Activity' : 'Add Daily Activity'; ?></h1>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert <?php echo $alert_class; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="" method="post" class="form-floating border-success p-3 shadow-lg needs-validation text-bg-light rounded-4" novalidate>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingChildId" name="child_id" placeholder="Child ID" value="<?php echo htmlspecialchars($child_id); ?>" required>
                    <label for="floatingChildId">Child ID</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingActivity" name="activity" placeholder="Activity" value="<?php echo htmlspecialchars($activity); ?>" required>
                    <label for="floatingActivity">Activity</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="time" class="form-control" id="time" name="time" value="<?php echo htmlspecialchars($time); ?>" required>
                    <label for="time">Time</label>
                </div>
                <button type="submit" class="btn btn-outline-primary mt-1"><?php echo $update_mode ? 'Update Record' : 'Save Record'; ?></button>
                <a href="view_dailyactivties.php" class="btn btn-outline-secondary mt-1 ms-3">View Records</a>
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
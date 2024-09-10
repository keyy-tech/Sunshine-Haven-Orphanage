<?php
include '../connections/db_connect.php';
include '../connections/db_protect.php';

// Initialize message variable
$message = '';
$alert_class = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $child_id = trim($_POST["child_id"]);
    $grade_level = trim($_POST["grade_level"]);
    $school_attendance = trim($_POST["school_attendance"]);
    $academic_achievements = trim($_POST["academic_achievements"]);

    // Check for duplicate record
    $stmt = $db_connect->prepare("SELECT * FROM EducationalProgress WHERE child_id = ?");
    $stmt->bind_param("i", $child_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Duplicate record found
        $message = "Record already exists!";
        $alert_class = "alert-danger";
    } else {
        // Prepare and bind
        $stmt = $db_connect->prepare("INSERT INTO EducationalProgress (child_id, grade_level, school_attendance, academic_achievements) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $child_id, $grade_level, $school_attendance, $academic_achievements);

        // Execute and check if the record was added successfully
        if ($stmt->execute()) {
            $message = "New educational progress record added successfully";
            $alert_class = "alert-success";
        } else {
            $message = "Error: " . $stmt->error;
            $alert_class = "alert-danger";
        }

        $stmt->close();
    }
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
    <title>Educational Progress</title>
</head>

<body>
    <?php include '../sidebar.php'; ?>
    <main>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
            <h1 class="h4">Educational Progress</h1>
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
                <div class="invalid-feedback">
                    Please provide the Child ID.
                </div>
            </div>
            <div class="form-floating mb-3 mt-3">
                <input type="text" class="form-control" id="floatingGradeLevel" name="grade_level" placeholder="Grade Level" required>
                <label for="floatingGradeLevel">Grade Level</label>
                <div class="invalid-feedback">
                    Please provide the Grade Level.
                </div>
            </div>
            <div class="form-floating mb-3 mt-3">
                <input type="text" class="form-control" id="floatingSchoolAttendance" name="school_attendance" placeholder="School Attendance" required>
                <label for="floatingSchoolAttendance">School Attendance</label>
                <div class="invalid-feedback">
                    Please provide School Attendance.
                </div>
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" id="academicAchievements" name="academic_achievements" rows="10" placeholder="Academic Achievements" required></textarea>
                <label for="academicAchievements">Academic Achievements</label>
                <div class="invalid-feedback">
                    Please provide Academic Achievements.
                </div>
            </div>
            <button type="submit" class="btn btn-outline-primary mt-1">Save Record</button>
            <a href="view_educational.php" class="btn btn-outline-secondary mt-1 ms-3">View Records</a>
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
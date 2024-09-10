<?php
include '../connections/db_connect.php';

// Initialize message variable
$message = '';
$alert_class = '';

// Fetch existing record data for the form (Assuming ID is passed via query string for update)
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
if ($id) {
    // Fetch existing record data
    $stmt = $db_connect->prepare("SELECT * FROM EducationalProgress WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $child_id = $row['child_id'];
            $grade_level = $row['grade_level'];
            $school_attendance = $row['school_attendance'];
            $academic_achievements = $row['academic_achievements'];
        } else {
            die('Record not found.');
        }
        $stmt->close();
    } else {
        die('Failed to prepare statement.');
    }
} else {
    // Initialize form fields if adding a new record
    $child_id = '';
    $grade_level = '';
    $school_attendance = '';
    $academic_achievements = '';
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $child_id = trim($_POST["child_id"]);
    $grade_level = trim($_POST["grade_level"]);
    $school_attendance = trim($_POST["school_attendance"]);
    $academic_achievements = trim($_POST["academic_achievements"]);
    $id = isset($_POST["id"]) ? intval($_POST["id"]) : null; // Ensure ID is provided

    // Validate input
    if (empty($child_id) || empty($grade_level) || empty($school_attendance) || empty($academic_achievements)) {
        $message = 'Please fill in all required fields.';
        $alert_class = 'alert-danger';
    } else {
        if ($id) {
            // Update existing record
            $stmt = $db_connect->prepare("UPDATE EducationalProgress SET child_id = ?, grade_level = ?, school_attendance = ?, academic_achievements = ? WHERE id = ?");
            if ($stmt) {
                $stmt->bind_param("iissi", $child_id, $grade_level, $school_attendance, $academic_achievements, $id);

                if ($stmt->execute()) {
                    $message = "Educational progress record updated successfully";
                    $alert_class = "alert-success";
                } else {
                    $message = "Error: " . $stmt->error;
                    $alert_class = "alert-danger";
                }
                $stmt->close();
            } else {
                $message = "Failed to prepare statement.";
                $alert_class = "alert-danger";
            }
        } else {
            // Check for duplicate record
            $stmt = $db_connect->prepare("SELECT * FROM EducationalProgress WHERE child_id = ? AND grade_level = ? AND school_attendance = ? AND academic_achievements = ?");
            if ($stmt) {
                $stmt->bind_param("isss", $child_id, $grade_level, $school_attendance, $academic_achievements);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Duplicate record found
                    $message = "Record already exists!";
                    $alert_class = "alert-danger";
                } else {
                    // Insert new record
                    $stmt = $db_connect->prepare("INSERT INTO EducationalProgress (child_id, grade_level, school_attendance, academic_achievements) VALUES (?, ?, ?, ?)");
                    if ($stmt) {
                        $stmt->bind_param("iiss", $child_id, $grade_level, $school_attendance, $academic_achievements);

                        if ($stmt->execute()) {
                            $message = "New educational progress record added successfully";
                            $alert_class = "alert-success";
                        } else {
                            $message = "Error: " . $stmt->error;
                            $alert_class = "alert-danger";
                        }
                        $stmt->close();
                    } else {
                        $message = "Failed to prepare statement.";
                        $alert_class = "alert-danger";
                    }
                }
            } else {
                $message = "Failed to prepare statement.";
                $alert_class = "alert-danger";
            }
        }
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
    <?php include '../admin_sidebar.php'; ?>
    <main>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
            <h1 class="h4"><?php echo $id ? 'Update Educational Progress' : 'Add Educational Progress'; ?></h1>
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
                <input type="text" class="form-control" id="floatingChildId" name="child_id" placeholder="Child ID" value="<?php echo htmlspecialchars($child_id); ?>" required>
                <label for="floatingChildId">Child ID</label>
                <div class="invalid-feedback">
                    Please provide the Child ID.
                </div>
            </div>
            <div class="form-floating mb-3 mt-3">
                <input type="text" class="form-control" id="floatingGradeLevel" name="grade_level" placeholder="Grade Level" value="<?php echo htmlspecialchars($grade_level); ?>" required>
                <label for="floatingGradeLevel">Grade Level</label>
                <div class="invalid-feedback">
                    Please provide the Grade Level.
                </div>
            </div>
            <div class="form-floating mb-3 mt-3">
                <input type="text" class="form-control" id="floatingSchoolAttendance" name="school_attendance" placeholder="School Attendance" value="<?php echo htmlspecialchars($school_attendance); ?>" required>
                <label for="floatingSchoolAttendance">School Attendance</label>
                <div class="invalid-feedback">
                    Please provide School Attendance.
                </div>
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" id="academicAchievements" name="academic_achievements" rows="10" placeholder="Academic Achievements" required><?php echo htmlspecialchars($academic_achievements); ?></textarea>
                <label for="academicAchievements">Academic Achievements</label>
                <div class="invalid-feedback">
                    Please provide Academic Achievements.
                </div>
            </div>
            <button type="submit" class="btn btn-outline-primary mt-1"><?php echo $id ? 'Update Record' : 'Save Record'; ?></button>
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
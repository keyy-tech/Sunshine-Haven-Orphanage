<?php
include '../connections/db_connect.php';
include '../connections/access_control.php'; // Path to the access control file

// Get the child ID from the URL parameter
$child_id = isset($_GET['child_id']) ? intval($_GET['child_id']) : 0;

if ($child_id <= 0) {
    header("Location: select_child.php?error=invalid_id");
    exit();
}

// Fetch child details and related records
$report_query = "
    SELECT c.id, c.full_name, c.dob, c.gender, c.nationality, c.special_needs,
           d.activity, d.time AS activity_time,
           m.record_date, m.details AS medical_details,
           e.grade_level, e.school_attendance, e.academic_achievements,
           a.status AS adoption_status, a.date_of_placement,
           f.name AS family_name
    FROM Children c
    LEFT JOIN DailyActivities d ON c.id = d.child_id
    LEFT JOIN MedicalRecords m ON c.id = m.child_id
    LEFT JOIN EducationalProgress e ON c.id = e.child_id
    LEFT JOIN Adoption a ON c.id = a.child_id
    LEFT JOIN Families f ON a.family_id = f.id
    WHERE c.id = ?
    ORDER BY d.time, m.record_date, e.grade_level
";

$stmt = $db_connect->prepare($report_query);
if (!$stmt) {
    die("Prepare failed: " . $db_connect->error);
}

$stmt->bind_param("i", $child_id);
if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}

$report_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
    <link rel="stylesheet" href="../style.css">
    <title>Child Report</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .report-header {
            background-color: #f8f9fa;
            border-bottom: 2px solid black;
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
            border-radius: 5px;
        }

        .report-section {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .report-table th,
        .report-table td {
            padding: 12px;
            border: 1px solid #dee2e6;
        }

        .report-table th {
            background-color: #e9ecef;
        }

        .btn-print {
            margin: 20px 0;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .report-section h5 {
            border-bottom: 2px solid black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <?php include '../admin_view.php'; ?>
    <main>
        <div class="container">
            <div class="report-header">
                <h1 class="h3">Child Report</h1>
                <p class="text-muted">Date: <?php echo date('Y-m-d'); ?></p>
            </div>

            <?php if ($report_result->num_rows > 0): ?>
                <?php $row = $report_result->fetch_assoc(); ?>
                <div class="report-section">
                    <h5 class="mb-4">Child ID: <?php echo htmlspecialchars($row['id']); ?></h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($row['full_name']); ?></p>
                            <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($row['dob']); ?></p>
                            <p><strong>Gender:</strong> <?php echo htmlspecialchars($row['gender']); ?></p>
                            <p><strong>Nationality:</strong> <?php echo htmlspecialchars($row['nationality']); ?></p>
                            <p><strong>Special Needs:</strong> <?php echo htmlspecialchars($row['special_needs']); ?></p>
                        </div>
                    </div>

                    <div class="grid-container">
                        <?php if (!empty($row['activity'])): ?>
                            <div class="report-section">
                                <h5>Activities</h5>
                                <table class="table report-table">
                                    <thead>
                                        <tr>
                                            <th>Activity</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['activity']); ?></td>
                                            <td><?php echo htmlspecialchars($row['activity_time']); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($row['medical_details'])): ?>
                            <div class="report-section">
                                <h5>Medical Records</h5>
                                <table class="table report-table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['record_date']); ?></td>
                                            <td><?php echo htmlspecialchars($row['medical_details']); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($row['grade_level'])): ?>
                            <div class="report-section">
                                <h5>Educational Progress</h5>
                                <table class="table report-table">
                                    <thead>
                                        <tr>
                                            <th>Grade Level</th>
                                            <th>School Attendance</th>
                                            <th>Academic Achievements</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['grade_level']); ?></td>
                                            <td><?php echo htmlspecialchars($row['school_attendance']); ?></td>
                                            <td><?php echo htmlspecialchars($row['academic_achievements']); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($row['adoption_status'])): ?>
                            <div class="report-section">
                                <h5>Adoption</h5>
                                <table class="table report-table">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Date of Placement</th>
                                            <th>Family</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['adoption_status']); ?></td>
                                            <td><?php echo htmlspecialchars($row['date_of_placement']); ?></td>
                                            <td><?php echo htmlspecialchars($row['family_name']); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <p>No records found.</p>
            <?php endif; ?>

            <a href="javascript:window.print()" class="btn btn-outline-primary btn-print">Print Report</a>
        </div>
    </main>
</body>

</html>
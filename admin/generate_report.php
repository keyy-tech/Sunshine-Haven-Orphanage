<?php
include '../connections/db_connect.php';
include '../connections/access_control.php'; // Path to the access control file

// Get the child ID from the URL parameter
$child_id = isset($_GET['child_id']) ? intval($_GET['child_id']) : 0;

if ($child_id <= 0) {
    header("Location: select_child.php?error=invalid_id");
    exit();
}

// Fetch child details
$child_query = "SELECT id, full_name, dob, gender, nationality, special_needs FROM Children WHERE id = ?";
$stmt = $db_connect->prepare($child_query);
$stmt->bind_param("i", $child_id);
$stmt->execute();
$child_result = $stmt->get_result();
$child_details = $child_result->fetch_assoc();

// Fetch Daily Activities
$activities_query = "SELECT activity, time AS activity_time FROM DailyActivities WHERE child_id = ?";
$stmt = $db_connect->prepare($activities_query);
$stmt->bind_param("i", $child_id);
$stmt->execute();
$activities_result = $stmt->get_result();

// Fetch Medical Records
$medical_query = "SELECT record_date, details AS medical_details FROM MedicalRecords WHERE child_id = ?";
$stmt = $db_connect->prepare($medical_query);
$stmt->bind_param("i", $child_id);
$stmt->execute();
$medical_result = $stmt->get_result();

// Fetch Educational Progress
$education_query = "SELECT grade_level, school_attendance, academic_achievements FROM EducationalProgress WHERE child_id = ?";
$stmt = $db_connect->prepare($education_query);
$stmt->bind_param("i", $child_id);
$stmt->execute();
$education_result = $stmt->get_result();

// Check for duplicates using an array
$displayed_education_records = [];

// Fetch Adoption Details
$adoption_query = "SELECT a.status AS adoption_status, a.date_of_placement, f.name AS family_name 
                   FROM Adoption a LEFT JOIN Families f ON a.family_id = f.id WHERE a.child_id = ?";
$stmt = $db_connect->prepare($adoption_query);
$stmt->bind_param("i", $child_id);
$stmt->execute();
$adoption_result = $stmt->get_result();
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

            <?php if ($child_details): ?>
                <div class="report-section">
                    <h5 class="mb-4">Child ID: <?php echo htmlspecialchars($child_details['id']); ?></h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($child_details['full_name']); ?></p>
                            <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($child_details['dob']); ?></p>
                            <p><strong>Gender:</strong> <?php echo htmlspecialchars($child_details['gender']); ?></p>
                            <p><strong>Nationality:</strong> <?php echo htmlspecialchars($child_details['nationality']); ?></p>
                            <p><strong>Special Needs:</strong> <?php echo htmlspecialchars($child_details['special_needs']); ?></p>
                        </div>
                    </div>
                </div>

                <div class="grid-container">
                    <!-- Activities Section -->
                    <?php if ($activities_result->num_rows > 0): ?>
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
                                    <?php while ($activity = $activities_result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($activity['activity']); ?></td>
                                            <td><?php echo htmlspecialchars($activity['activity_time']); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                    <!-- Medical Records Section -->
                    <?php if ($medical_result->num_rows > 0): ?>
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
                                    <?php while ($medical = $medical_result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($medical['record_date']); ?></td>
                                            <td><?php echo htmlspecialchars($medical['medical_details']); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                    <!-- Educational Progress Section -->
                    <?php if ($education_result->num_rows > 0): ?>
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
                                    <?php while ($education = $education_result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($education['grade_level']); ?></td>
                                            <td><?php echo htmlspecialchars($education['school_attendance']); ?></td>
                                            <td><?php echo htmlspecialchars($education['academic_achievements']); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                    <!-- Adoption Details Section -->
                    <?php if ($adoption_result->num_rows > 0): ?>
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
                                    <?php while ($adoption = $adoption_result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($adoption['adoption_status']); ?></td>
                                            <td><?php echo htmlspecialchars($adoption['date_of_placement']); ?></td>
                                            <td><?php echo htmlspecialchars($adoption['family_name']); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <p class="alert alert-danger">Child with ID <?php echo htmlspecialchars($child_id); ?> not found.</p>
            <?php endif; ?>

            <button class="btn btn-primary btn-print" onclick="window.print()">Print Report</button>
        </div>
    </main>
</body>

</html>
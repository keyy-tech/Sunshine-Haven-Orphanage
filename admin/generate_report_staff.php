<?php
include '../connections/db_connect.php';

// Get the staff ID from the URL parameter
$staff_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($staff_id <= 0) {
    die("Invalid staff ID.");
}

// Fetch staff details
$report_query = "
    SELECT s.id, s.name, s.contact_info, s.role, s.certifications
    FROM Staff s
    WHERE s.id = ?
";

$stmt = $db_connect->prepare($report_query);
$stmt->bind_param("i", $staff_id);
$stmt->execute();
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
    <title>Staff Report</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .report-header {
            background-color: #f8f9fa;
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
    </style>
</head>

<body>
    <?php include '../admin_view.php'; ?>
    <main>
        <div class="container">
            <div class="report-header">
                <h1 class="h3">Staff Report</h1>
                <p class="text-muted">Date: <?php echo date('Y-m-d'); ?></p>
            </div>

            <?php if ($report_result->num_rows > 0): ?>
                <?php while ($row = $report_result->fetch_assoc()): ?>
                    <div class="report-section">
                        <h5 class="mb-4">Staff ID: <?php echo htmlspecialchars($row['id']); ?></h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Name:</strong> <?php echo htmlspecialchars($row['name']); ?></p>
                                <p><strong>Contact Information:</strong> <?php echo htmlspecialchars($row['contact_info']); ?></p>
                                <p><strong>Role:</strong> <?php echo htmlspecialchars($row['role']); ?></p>
                                <p><strong>Certifications:</strong> <?php echo htmlspecialchars($row['certifications']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No records found.</p>
            <?php endif; ?>

            <a href="javascript:window.print()" class="btn btn-outline-primary btn-print">Print Report</a>
        </div>
    </main>
</body>

</html>
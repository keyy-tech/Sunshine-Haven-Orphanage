<?php
include '../connections/db_connect.php';

// Fetch all children records for the dropdown
$children_query = "SELECT id, full_name FROM Children ORDER BY full_name";
$children_result = $db_connect->query($children_query);

if (!$children_result) {
    die("Query failed: " . $db_connect->error);
}
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
    <title>Select Record</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .container {
            max-width: 800px;
            /* Increased max-width for more space */
        }

        .form-group label {
            font-weight: 600;
        }

        .form-select {
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            /* Make the select input full width */
            max-width: 100%;
            /* Limit maximum width */
            padding: 10px;
            /* Increase padding for better appearance */
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .form-control {
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-inline {
            display: flex;
            flex-direction: column;
            gap: 15px;
            /* Add space between fields */
        }

        .form-group {
            margin-bottom: 20px;
        }

        .alert {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <?php include '../admin_sidebar.php'; ?>
    <main class="container mt-5">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
            <h1 class="h4">Select a Record to Generate Report</h1>
        </div>

        <?php if (isset($message)): ?>
            <div class="alert <?php echo isset($alert_class) ? htmlspecialchars($alert_class) : 'alert-info'; ?> alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="generate_report.php" method="get" class="form-inline border-success p-3 shadow-lg needs-validation text-bg-light rounded-4" novalidate>
            <div class="form-group mb-3">
                <label for="child_id" class="form-label">Generate Report for Child:</label>
                <select id="child_id" name="child_id" class="form-select" required>
                    <option value="">Select a Child</option>
                    <?php while ($row = $children_result->fetch_assoc()): ?>
                        <option value="<?php echo htmlspecialchars($row['id']); ?>">
                            <?php echo htmlspecialchars($row['full_name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <div class="invalid-feedback">
                    Please select a Child.
                </div>
                <button type="submit" class="btn btn-primary mt-3">Generate Report</button>
            </div>
        </form>

        <!-- Remove the staff report form as requested -->
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
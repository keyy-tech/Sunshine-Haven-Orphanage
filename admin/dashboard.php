<?php
include '../connections/db_connect.php';

// Fetch data for the bar chart
function fetchAgeDistribution()
{
    global $db_connect;
    $query = "SELECT 
                CASE 
                    WHEN TIMESTAMPDIFF(YEAR, dob, CURDATE()) BETWEEN 0 AND 5 THEN '0-5'
                    WHEN TIMESTAMPDIFF(YEAR, dob, CURDATE()) BETWEEN 6 AND 10 THEN '6-10'
                    WHEN TIMESTAMPDIFF(YEAR, dob, CURDATE()) BETWEEN 11 AND 15 THEN '11-15'
                    WHEN TIMESTAMPDIFF(YEAR, dob, CURDATE()) BETWEEN 16 AND 18 THEN '16-18'
                END AS age_group,
                COUNT(*) AS count
              FROM Children
              GROUP BY age_group";
    $result = mysqli_query($db_connect, $query);
    if (!$result) {
        die("Error in query: " . mysqli_error($db_connect));
    }
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[$row['age_group']] = (int)$row['count'];
    }
    return $data;
}

$ageData = fetchAgeDistribution();

// Fetch other counts
function fetchCount($table)
{
    global $db_connect;
    $query = "SELECT COUNT(*) AS count FROM $table";
    $result = mysqli_query($db_connect, $query);
    if (!$result) {
        die("Error in query: " . mysqli_error($db_connect));
    }
    $row = mysqli_fetch_assoc($result);
    return (int)$row['count'];
}

$childrenCount = fetchCount('Children');
$medicalHistoryCount = fetchCount('MedicalRecords');
$activitiesCount = fetchCount('DailyActivities');
$adoptionCount = fetchCount('Adoption');
$staffCount = fetchCount('Staff');

// Fetch Families and Donations count
$familiesCount = fetchCount('Families');
$donationsCount = fetchCount('Donations');

// Search for a name in multiple tables
$search_results = '';
if (isset($_GET['search'])) {
    $search_name = $_GET['search'];
    $search_query = "SELECT 'Children' AS source, full_name AS name FROM Children WHERE full_name LIKE ?
                     UNION ALL
                     SELECT 'Staff' AS source, name FROM Staff WHERE name LIKE ?";

    $stmt = $db_connect->prepare($search_query);
    $search_term = '%' . $search_name . '%';
    $stmt->bind_param("ss", $search_term, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $search_results .= "<p>Found in " . htmlspecialchars($row['source']) . ": " . htmlspecialchars($row['name']) . "</p>";
        }
    } else {
        $search_results = "<p>No results found for '" . htmlspecialchars($search_name) . "'</p>";
    }
    $stmt->close();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .search-form {
            display: flex;
            align-items: center;
        }

        .card {
            display: flex;
            align-items: center;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: left;
            border: 1px solid #dee2e6;
            height: 120px;
            margin-bottom: 1rem;
            padding: 10px;
            background-color: #f8f9fa;
            flex-direction: row;
        }

        .card-icon {
            font-size: 2.5rem;
            margin-right: 20px;
            color: black;
        }

        .card-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .card-content h4 {
            margin: 0;
            font-size: 1.1rem;
        }

        .card-content p {
            margin: 0;
            font-size: 1.4rem;
        }

        #ageDistributionChart {
            width: 100%;
            height: 600px;
        }

        .btn-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .btn-grid .btn {
            flex: 1 1 150px;
        }

        .vertical-divider {
            border-left: 1px solid #dee2e6;
            margin: 0 20px;
        }

        .dashboard-container {
            display: flex;
            align-items: flex-start;
        }

        .dashboard-header {
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            #ageDistributionChart {
                height: 400px;
            }

            .dashboard-sections {
                flex-direction: column;
            }

            .dashboard-header .search-form {
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <?php include '../admin_sidebar.php'; ?>

    <main>
        <div class="container mt-2">
            <!-- Dashboard Header and Search Form -->
            <div class="row align-items-center mb-3 border-bottom">
                <div class="col-md-6">
                    <h1 class="h4">Dashboard</h1>
                </div>
                <div class="col-md-6 d-flex justify-content-end pb-3">
                    <form action="" method="GET" class="search-form">
                        <input type="text" class="form-control me-2" name="search" placeholder="Search by Name" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" required>
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </form>
                </div>
            </div>

            <!-- Display Search Results -->
            <?php if (!empty($search_results)): ?>
                <div class="container mt-4">
                    <h5>Search Results for "<?php echo htmlspecialchars($_GET['search']); ?>"</h5>
                    <div>
                        <?php echo $search_results; ?>
                    </div>
                </div>
            <?php elseif (isset($_GET['search'])): ?>
                <div class="container mt-4">
                    <p>No results found for "<?php echo htmlspecialchars($_GET['search']); ?>".</p>
                </div>
            <?php endif; ?>
            <div class="dashboard-container">
                <div class="col-md-6">
                    <div class="row">
                        <!-- Dashboard Cards -->
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light">
                                <i class="fas fa-child card-icon"></i>
                                <div class="card-content">
                                    <h4>Children</h4>
                                    <p><?php echo $childrenCount; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light">
                                <i class="fas fa-user-tie card-icon"></i>
                                <div class="card-content">
                                    <h4>Staff</h4>
                                    <p><?php echo $staffCount; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light">
                                <i class="fas fa-list-alt card-icon"></i>
                                <div class="card-content">
                                    <h4>Activities</h4>
                                    <p><?php echo $activitiesCount; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light">
                                <i class="fas fa-handshake card-icon"></i>
                                <div class="card-content">
                                    <h4>Adoption</h4>
                                    <p><?php echo $adoptionCount; ?></p>
                                </div>
                            </div>
                        </div>
                        <!-- Dashboard Cards -->
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light">
                                <i class="fas fa-users card-icon"></i>
                                <div class="card-content">
                                    <h4>Families</h4>
                                    <p><?php echo $familiesCount; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light">
                                <i class="fas fa-donate card-icon"></i>
                                <div class="card-content">
                                    <h4>Donations</h4>
                                    <p><?php echo $donationsCount; ?></p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Action Buttons -->
                <div class="vertical-divider"></div>
                <div class="col-md-5">
                    <div class="btn-grid">
                        <a href="view_children.php" class="btn btn-primary">Manage Children</a>
                        <a href="view_medicalhistory.php" class="btn btn-secondary">Manage Medical History</a>
                        <a href="view_dailyactivties.php" class="btn btn-success">Manage Activities</a>
                        <a href="view_adoption.php" class="btn btn-info">Manage Adoption</a>
                        <a href="view_families.php" class="btn btn-warning">Manage Families</a>
                        <a href="view.s" class="btn btn-danger">Manage Donations</a>
                    </div>
                </div>
            </div>

            <!-- Age Distribution Chart -->
            <div class="row">
                <div class="col-md-12">
                    <canvas id="ageDistributionChart"></canvas>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('ageDistributionChart').getContext('2d');
            const ageData = <?php echo json_encode(array_values($ageData)); ?>;
            const ageLabels = <?php echo json_encode(array_keys($ageData)); ?>;
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ageLabels,
                    datasets: [{
                        label: 'Number of Children',
                        data: ageData,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        });
    </script>
</body>

</html>
<?php
include 'connections/db_connect.php';

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
$staffCount = fetchCount('Staff');
$activitiesCount = fetchCount('DailyActivities');
$adoptionCount = fetchCount('Adoption');
$familiesCount = fetchCount('Families');
$donationsCount = fetchCount('Donations');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Dashboard</title>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* General Card Styling */
        .card {
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
            text-align: center;
            border: 1px solid #dee2e6;
        }

        /* Count Card Styling */
        .count-card {
            height: 100%;
            display: flex;
            flex-direction: row;
            align-items: center;
            text-align: left;
            padding: 10px;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: #f8f9fa;
            font-size: 0.9rem;
        }

        .count-card h4 {
            font-size: 1rem;
        }

        .count-card p {
            font-size: 1.5rem;
            margin: 0;
        }

        .count-card .card-icon {
            font-size: 2rem;
            margin-right: 15px;
        }

        /* Button Styling */
        .btn {
            border-radius: 0.5rem;
        }

        /* Chart Container Styling */
        #ageDistributionChart {
            width: 100%;
            height: 600px;
            /* Increased height */
        }

        /* Counts Grid Styling */
        .btn-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .btn-grid .btn {
            flex: 1 1 150px;
        }

        /* Divider Styling */
        .vertical-divider {
            border-left: 1px solid #dee2e6;
            margin: 0 20px;
        }

        /* Flexbox Layout for Sections */
        .dashboard-sections {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        /* Container to hold the vertical line and section */
        .dashboard-container {
            display: flex;
            align-items: flex-start;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            #ageDistributionChart {
                height: 400px;
            }

            .dashboard-sections {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <main>
        <div class="container">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
                <h1 class="h4">Dashboard</h1>
            </div>

            <div class="dashboard-container">
                <!-- Counts Grid -->
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light count-card">
                                <div class="card-icon"><i class="fas fa-child"></i></div>
                                <div class="card-text">
                                    <h4>Children</h4>
                                    <p><?php echo $childrenCount; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light count-card">
                                <div class="card-icon"><i class="fas fa-users"></i></div>
                                <div class="card-text">
                                    <h4>Staff</h4>
                                    <p><?php echo $staffCount; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light count-card">
                                <div class="card-icon"><i class="fas fa-list-alt"></i></div>
                                <div class="card-text">
                                    <h4>Activities</h4>
                                    <p><?php echo $activitiesCount; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light count-card">
                                <div class="card-icon"><i class="fas fa-handshake"></i></div>
                                <div class="card-text">
                                    <h4>Adoption</h4>
                                    <p><?php echo $adoptionCount; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light count-card">
                                <div class="card-icon"><i class="fas fa-users"></i></div>
                                <div class="card-text">
                                    <h4>Families</h4>
                                    <p><?php echo $familiesCount; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light count-card">
                                <div class="card-icon"><i class="fas fa-donate"></i></div>
                                <div class="card-text">
                                    <h4>Donations</h4>
                                    <p><?php echo $donationsCount; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vertical Divider -->
                <div class="vertical-divider"></div>

                <!-- Buttons Grid -->
                <div class="col-md-6 me-2">
                    <div class="btn-grid me-5">
                        <a href="view_children.php" class="btn btn-primary btn-card text-center">Children</a>
                        <a href="view_staff.php" class="btn btn-secondary btn-card">Staff</a>
                        <a href="view_dailyactivities.php" class="btn btn-info btn-card">Daily Activities</a>
                        <a href="view_educational.php" class="btn btn-warning btn-card text-center">Educational Progress</a>
                        <a href="view_donations.php" class="btn btn-danger btn-card text-center">Donations</a>
                        <a href="view_families.php" class="btn btn-success btn-card">Families</a>
                        <a href="view_adoption.php" class="btn btn-info btn-card">Adoptions</a>
                    </div>
                </div>
            </div>

            <!-- Age Distribution Chart -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <canvas id="ageDistributionChart"></canvas>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctxAge = document.getElementById('ageDistributionChart').getContext('2d');

            var ageDistributionChart = new Chart(ctxAge, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode(array_keys($ageData)); ?>,
                    datasets: [{
                        label: 'Children by Age Group',
                        data: <?php echo json_encode(array_values($ageData)); ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>
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
$familiesCount = fetchCount('Families');
$donationsCount = fetchCount('Donations');
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
            /* Gap between icon and text */
            color: black;
            /* Change icon color */
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
            /* margin-top: 5px; */
            /* Adds a gap between the name and the number */
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
    <?php include '../sidebar.php'; ?>

    <main>
        <div class="container">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
                <h1 class="h4">Dashboard</h1>
            </div>

            <div class="dashboard-container">
                <div class="col-md-6">
                    <div class="row">
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
                                <i class="fas fa-file-medical card-icon"></i>
                                <div class="card-content">
                                    <h4>Medical History</h4>
                                    <p><?php echo $medicalHistoryCount; ?></p>
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

                <div class="vertical-divider"></div>

                <div class="col-md-6 me-2">
                    <div class="btn-grid me-5">
                        <a href="view_children.php" class="btn btn-primary btn-card text-center">Children</a>
                        <a href="view_medicalhistory.php" class="btn btn-secondary btn-card">Medical History</a>
                        <a href="view_dailyactivties.php" class="btn btn-info btn-card">Daily Activities</a>
                        <a href="view_educational.php" class="btn btn-warning btn-card text-center">Educational Progress</a>
                        <a href="view_donations.php" class="btn btn-danger btn-card text-center">Donations</a>
                        <a href="view_families.php" class="btn btn-success btn-card">Families</a>
                        <a href="view_adoption.php" class="btn btn-info btn-card">Adoptions</a>
                    </div>
                </div>
            </div>

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
            var ageData = <?php echo json_encode(array_values($ageData)); ?>;
            var ageLabels = <?php echo json_encode(array_keys($ageData)); ?>;
            var ageDistributionChart = new Chart(ctxAge, {
                type: 'bar',
                data: {
                    labels: ageLabels,
                    datasets: [{
                        label: 'Number of Children',
                        data: ageData,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>
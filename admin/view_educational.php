<?php
include '../connections/db_connect.php';
include '../connections/access_control.php'; // Path to the access control file



// Fetch data from the database
$query = "SELECT e.id, c.full_name, e.grade_level, e.school_attendance, e.academic_achievements
          FROM EducationalProgress e
          JOIN Children c ON e.child_id = c.id";
$result = mysqli_query($db_connect, $query);

if (!$result) {
    die("Error in query: " . mysqli_error($db_connect));
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
    <script src="javascript.js"></script>
    <title>Educational Progress Records</title>
</head>

<body>
    <?php include '../admin_view.php'; ?>
    <main>
        <div class="container">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
                <h1 class="h4">Educational Progress Records</h1>
            </div>

            <?php
            if (isset($_GET['message'])) {
                echo '<div class="alert alert-success" role="alert">';
                echo htmlspecialchars($_GET['message']);
                echo '</div>';
            }
            ?>

            <a href="add_educational.php" class="btn btn-outline-success mb-3 mt-2">Add New Record</a>

            <table class="table table-default table-striped table-hover border container">
                <thead class="p-3">
                    <tr>
                        <th scope="col">Record ID</th>
                        <th scope="col">Child Name</th>
                        <th scope="col">Grade Level</th>
                        <th scope="col">School Attendance</th>
                        <th scope="col">Academic Achievements</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $ID = $row['id'];
                        $NAME = $row['full_name'];
                        $GRADE_LEVEL = $row['grade_level'];
                        $SCHOOL_ATTENDANCE = $row['school_attendance'];
                        $ACHIEVEMENTS = $row['academic_achievements'];
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($ID); ?></td>
                            <td><?php echo htmlspecialchars($NAME); ?></td>
                            <td><?php echo htmlspecialchars($GRADE_LEVEL); ?></td>
                            <td><?php echo htmlspecialchars($SCHOOL_ATTENDANCE); ?></td>
                            <td><?php echo htmlspecialchars($ACHIEVEMENTS); ?></td>
                            <td>
                                <a href="update_educational.php?id=<?php echo urlencode($ID); ?>" type="button" class="btn btn-outline-primary">Update</a>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $ID; ?>">
                                    Delete
                                </button>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal<?php echo $ID; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $ID; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="deleteModalLabel<?php echo $ID; ?>">Confirm Deletion</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this record? This action cannot be undone.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <a href="delete_educational.php?id=<?php echo urlencode($ID); ?>" type="button" class="btn btn-danger">Confirm Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>
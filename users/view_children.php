<?php
include '../connections/db_connect.php';

$message = '';
$alert_class = '';

// Check for a message in the URL
if (isset($_GET['message'])) {
    $message = $_GET['message'];
    $alert_class = 'alert-success';
}

// Fetch data from the database
$query = "SELECT id, full_name, dob, gender, nationality, special_needs FROM Children";
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
    <title>Children Records</title>
</head>

<body>
    <?php include '../view_sidebar.php'; ?>
    <main>
        <div class="container">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
                <h1 class="h4">Children's Records</h1>
            </div>

            <!-- Display success message if available -->
            <?php if (!empty($message)): ?>
                <div class="alert <?php echo $alert_class; ?> alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($message); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <a href="add_children.php" class="btn btn-outline-success mb-3 mt-2">Add New Record</a>
            <table class="table table-default table-striped table-hover border container">
                <thead class="p-3">
                    <tr>
                        <th scope="col">Child ID</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Date Of Birth</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Nationality</th>
                        <th scope="col">Special Needs</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $ID = $row['id'];
                        $NAME = $row['full_name'];
                        $DOB = $row['dob'];
                        $GENDER = $row['gender'];
                        $NATIONALITY = $row['nationality'];
                        $SPECIAL_NEEDS = $row['special_needs'];
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($ID); ?></td>
                            <td><?php echo htmlspecialchars($NAME); ?></td>
                            <td><?php echo htmlspecialchars($DOB); ?></td>
                            <td><?php echo htmlspecialchars($GENDER); ?></td>
                            <td><?php echo htmlspecialchars($NATIONALITY); ?></td>
                            <td>
                                <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#specialNeedsModal<?php echo $ID; ?>">
                                    View Special Needs
                                </button>
                            </td>
                            <td>
                                <a href="update_children.php?id=<?php echo urlencode($ID); ?>" class="btn btn-outline-primary">Update</a>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $ID; ?>">
                                    Delete
                                </button>
                            </td>
                        </tr>

                        <!-- Special Needs Modal -->
                        <div class="modal fade" id="specialNeedsModal<?php echo $ID; ?>" tabindex="-1" aria-labelledby="specialNeedsModalLabel<?php echo $ID; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="specialNeedsModalLabel<?php echo $ID; ?>">Special Needs</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php echo htmlspecialchars($SPECIAL_NEEDS); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                        <a href="delete_children.php?id=<?php echo urlencode($ID); ?>" class="btn btn-danger">Confirm Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>
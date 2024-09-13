<?php
include '../connections/db_connect.php';
include '../connections/access_control.php'; // Path to the access control file




// Fetch data from the database
$query = "SELECT id, name, contact_info,parent_name,occupation,address FROM Families";
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
    <title>Families Records</title>
</head>

<body>
    <?php include '../admin_view.php'; ?>
    <main>
        <div class="container">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
                <h1 class="h4">Families Records</h1>
            </div>

            <?php
            if (isset($_GET['message'])) {
                echo '<div class="alert alert-success" role="alert">';
                echo htmlspecialchars($_GET['message']);
                echo '</div>';
            }
            ?>

            <a href="add_families.php" class="btn btn-outline-success mb-3 mt-2">Add New Record</a>

            <table class="table table-default table-striped table-hover border container">
                <thead class="p-3">
                    <tr>
                        <th scope="col">Record ID</th>
                        <th scope="col">Family Name</th>
                        <th scope="col">Contact Info</th>
                        <th scope="col">Details</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['contact_info']); ?></td>
                            <td>
                                <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#detailsModal<?php echo $row['id']; ?>">
                                    Details
                                </button>
                                <div class="modal fade" id="detailsModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="detailsModal<?php echo $row['id'];; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="detailsModal<?php echo $row['id']; ?>">Details</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Parent Name : </span> <?php echo htmlspecialchars($row['parent_name']); ?></p>
                                                <p>Occupation : <?php echo htmlspecialchars($row['occupation']); ?></p>
                                                <p> Address : <?php echo htmlspecialchars($row['address']); ?> </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="update_families.php?id=<?php echo urlencode($row['id']); ?>" class="btn btn-outline-primary">Update</a>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row['id']; ?>">
                                    Delete
                                </button>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel<?php echo $row['id']; ?>">Confirm Deletion</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this record? This action cannot be undone.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <a href="delete_families.php?id=<?php echo urlencode($row['id']); ?>" class="btn btn-danger">Confirm Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>
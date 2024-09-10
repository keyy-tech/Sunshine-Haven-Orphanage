<?php
include '../connections/db_connect.php';

// Fetch all staff records from the Staff table
$result = $db_connect->query("SELECT * FROM Staff");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../style.css">
    <title>View Staff Records</title>
</head>

<body>
    <?php include '../admin_view.php'; ?>
    <main>
        <div class="container">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
                <h1 class="h4">Staff Records</h1>
                <a href="add_staff.php" class="btn btn-outline-success mb-3 mt-2">Add New Record</a>
            </div>

            <table class="table table-default table-striped table-hover border">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Contact Info</th>
                        <th scope="col">Role</th>
                        <th scope="col">Certifications</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if there are records in the result set
                    if ($result->num_rows > 0) {
                        // Loop through the records and display them in the table
                        while ($row = $result->fetch_assoc()) {
                            $id = $row['id'];
                            $name = htmlspecialchars($row['name']);
                            $contact_info = htmlspecialchars($row['contact_info']);
                            $role = htmlspecialchars($row['role']);
                            $certifications = htmlspecialchars($row['certifications']);
                    ?>
                            <tr>
                                <td><?php echo $id; ?></td>
                                <td><?php echo $name; ?></td>
                                <td><?php echo $contact_info; ?></td>
                                <td><?php echo $role; ?></td>
                                <td><?php echo $certifications; ?></td>
                                <td>
                                    <!-- Update and Delete buttons -->
                                    <a href="update_staff.php?id=<?php echo $id; ?>" class="btn btn-outline-primary btn-sm">Update</a>
                                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $id; ?>">Delete</button>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal<?php echo $id; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $id; ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel<?php echo $id; ?>">Confirm Deletion</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this staff member? This action cannot be undone.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <a href="delete_staff.php?id=<?php echo $id; ?>" class="btn btn-danger">Confirm Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>
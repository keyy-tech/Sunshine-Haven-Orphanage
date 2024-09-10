<?php
include '../connections/db_connect.php';
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
    <title>Adoption</title>
</head>

<body>
    <?php include '../view_sidebar.php'; ?>
    <main>
        <div class="container">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
                <h1 class="h4">Staff Records</h1>
            </div>
        </div>
        <a href="add_staff.php" class="btn btn-outline-success mb-3 mt-2">
            Add New Record</a>
        <table class="table table-default table-striped table-hover border container">
            <thead class="p-3">
                <tr>
                    <th scope="col">Child ID</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Date Of Birth</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Nationality</th>
                    <th scope="col">Special Needs</th>
                </tr>
            </thead>
            <tbody>
                <!--    <?php
                        // while ($row = mysqli_fetch_assoc($result)) {
                        $ID = $row['EmployeeID'];
                        $NAME = $row['FullName'];
                        $PHONE = $row['PhoneNumber'];
                        $HIREDATE = $row['HireDate'];
                        $DEPARTMENT = $row['Department'];
                        $EMAIL = $row['Email'];
                        ?> -->
                <tr>
                    <td>ID </td>
                    <td>NAME </td>
                    <td>EMAIL </td>
                    <td>PHONE </td>
                    <td>HIREDATE </td>
                    <td>DEPARTMENT </td>
                    <td>
                        <!--    <a href="update.php?id=<?php echo $ID ?>" type="button" class="btn btn-outline-primary">Update</i></a> -->
                        <!-- Button trigger modal -->
                        <!--  <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Delete
                    </button> -->

                        <!-- Modal -->
                        <!--  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirm Deletion</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this item? This action cannot be undone.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                                    <a href="delete.php ?id=<?php echo $ID ?>" type="button" class="btn btn-danger">Confirm Delete</a>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    </td>
                </tr>

            </tbody>
        </table>
    </main>
</body>

</html>
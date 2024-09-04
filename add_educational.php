<?php
include 'connection/db_connect.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>Educational Progress</title>
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <main>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
            <h1 class="h4">Educational Progress</h1>
        </div>
        <form action="" method="post">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingFullName" name="full_name" placeholder="Full Name" required>
                <label for="floatingFullName">Child ID</label>
                <div class="invalid-feedback">
                    Please provide a full name.
                </div>
            </div>
            <div class="form-floating mb-3 mt-3">
                <input type="text" class="form-control" id="floatingNationality" name="nationality" placeholder="Nationality" required>
                <label for="floatingNationality">Grade Level</label>
                <div class="invalid-feedback">
                    Please provide a nationality.
                </div>
            </div>
            <div class="form-floating mb-3 mt-3">
                <input type="text" class="form-control" id="floatingNationality" name="nationality" placeholder="Nationality" required>
                <label for="floatingNationality">Attendance</label>
                <div class="invalid-feedback">
                    Please provide a nationality.
                </div>
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" id="special_needs" name="special_needs" rows="10" placeholder="Special Needs"></textarea>
                <label for="special_needs">Achievements</label>
                <div class="invalid-feedback">
                    Please provide special needs information if applicable.
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-1">Add Record</button>
        </form>
    </main>
</body>

</html>
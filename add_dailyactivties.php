<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>Staff</title>
</head>

<body>

    <?php include 'sidebar.php'; ?>
    <main>
        <div class="container">
            <h1 class="mb-3 text-center border-bottom pb-1">Daily Activities</h1>
            <form action="" method="post">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingFullName" name="full_name" placeholder="Full Name" required>
                    <label for="floatingFullName">Child ID</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingFullName" name="full_name" placeholder="Full Name" required>
                    <label for="floatingFullName">Staff ID</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="doa" name="doa">
                    <label for="doa">Date Of Activities</label>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="floatingSelectGender" name="depart" required>
                        <option value="" disabled selected>Select Activity Type</option>
                        <option value="activity1">Activity 1</option>
                        <option value="activity2">Activity 2</option>
                        <option value="activity3">Activity 3</option>
                        <option value="activity4">Activity 4</option>
                        <option value="activity5">Activity 5</option>
                        <option value="activity6">Activity 6</option>
                        <option value="activity7">Activity 7</option>
                        <option value="activity8">Activity 8</option>
                        <option value="activity9">Activity 9</option>
                        <option value="activity10">Activity 10</option>
                    </select>
                    <label for="floatingSelectGender">Activity Type</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control h-100" id="details" name="details" rows="10" placeholder="Details" required></textarea>
                    <label for="details">Details</label>
                </div>
                <button type="submit" class="btn btn-primary mt-1">Add Activites</button>
            </form>

        </div>
    </main>
</body>

</html>
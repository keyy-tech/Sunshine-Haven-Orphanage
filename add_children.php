<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>Children</title>
</head>

<body>
    <header class="navbar">
        <a class="navbar-brand fs-5 text-white ps-5" href="#">Sunshine Haven Orphange</a>
    </header>
    <nav class="sidebar">
        <ul class="top1 nav flex-column mb-auto">
            <li class="nav-item mb-2">
                <a href="#" class="nav-link dashboard " aria-current="page">
                    <i class="bi bi-house-door me-2"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="add_children" class="nav-link text-white active">
                    <i class="bi bi-person-plus me-2"></i>
                    Children
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="view_contact.php" class="nav-link text-white">
                    <i class="bi bi-people me-2"></i>
                    Staff
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="add_messages.php" class="nav-link text-white">
                    <i class="bi bi-envelope-fill me-2"></i>
                    Daily Activites
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="add_messages.php" class="nav-link text-white">
                    <i class="bi bi-envelope-fill me-2"></i>
                    Medical History
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="add_messages.php" class="nav-link text-white">
                    <i class="bi bi-envelope-fill me-2"></i>
                    Education Progress
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="add_messages.php" class="nav-link text-white">
                    <i class="bi bi-envelope-fill me-2"></i>
                    Family
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="add_messages.php" class="nav-link text-white">
                    <i class="bi bi-envelope-fill me-2"></i>
                    Adoption
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="add_messages.php" class="nav-link text-white">
                    <i class="bi bi-envelope-fill me-2"></i>
                    Donations
                </a>
            </li>
        </ul>
        <div class="sidebar-footer">
            <ul class="nav flex-column mb-auto">
                <li class="nav-item mb-1">
                    <a href="view_profile.php" class="nav-link text-white">
                        <i class="bi bi-person me-2"></i>
                        View Profile
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="update_profile.php" class="nav-link text-white">
                        <i class="bi bi-pencil-square me-2"></i>
                        Update Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="logout.php">
                        <i class="bi bi-door-closed me-2"></i>
                        Sign out
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <main>
        <div class="container">
            <h1 class="mb-3 text-center border-bottom pb-1">Children</h1>
            <form action="" method="post">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingFullName" name="full_name" placeholder="Full Name" required>
                    <label for="floatingFullName">Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="dob" name="dob">
                    <label for="dob">Date Of Birth</label>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="floatingSelectGender" name="depart" required>
                        <option value="" disabled selected>Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <label for="floatingSelectGender">Gender</label>
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="floatingFullName" name="nationality" placeholder="Nationality" required>
                        <label for="floatingNationality">Nationality</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control h-100" id="message_content" name="special_needs" rows="10" placeholder="Special Needs" required></textarea>
                        <label for="special_needs">Special Needs</label>
                    </div>
                    <button type="submit" class="btn btn-primary mt-1">Add Child</button>
            </form>

        </div>
    </main>
</body>

</html>
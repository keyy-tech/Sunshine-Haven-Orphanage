<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>Dashboard</title>
</head>

<body>
    <header class="navbar">
        <a class="navbar-brand fs-5 text-white ps-5" href="#">Sunshine Haven Orphange</a>
    </header>
    <nav class="sidebar">
        <ul class="top1 nav flex-column mb-auto">
            <li class="nav-item mb-2">
                <a href="#" class="nav-link dashboard active" aria-current="page">
                    <i class="bi bi-house-door me-2"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="add_children" class="nav-link text-white">
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
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
            <h1 class="h4">Dashboard</h1>
        </div>
    </main>
</body>

</html>
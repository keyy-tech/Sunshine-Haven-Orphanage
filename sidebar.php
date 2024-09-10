   <?php
    include '../connections/db_logout.php'; // Include the logout handler
    ?>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
   <header class="navbar">
       <a class="navbar-brand fs-5 text-white ps-5" href="#">Child Care Center </a>
       <a class="nav-link text-white pe-5" href="?logout=true">
           <i class="bi bi-door-closed"></i>
           Sign out
       </a>
   </header>
   <nav class="sidebar bg-dark">
       <ul class="top1 nav flex-column mb-auto">
           <li class="nav-item mb-3">
               <a href="dashboard.php" class="nav-link dashboard text-white" aria-current="page">
                   <i class="bi bi-house-door me-2"></i>
                   Dashboard
               </a>
           </li>
           <li class="nav-item mb-3">
               <a href="add_children.php" class="nav-link text-white">
                   <i class="bi bi-person-plus me-2"></i>
                   Children
               </a>
           </li>
           <!-- <li class="nav-item mb-3">
                <a href="add_staff.php" class="nav-link text-white">
                    <i class="bi bi-people me-2"></i>
                    Staff
                </a>
            </li> -->
           <li class="nav-item mb-3">
               <a href="add_dailyactivties.php" class="nav-link text-white">
                   <i class="bi bi-envelope-fill me-2"></i>
                   Daily Activities
               </a>
           </li>
           <li class="nav-item mb-3">
               <a href="add_medicalhistory.php" class="nav-link text-white">
                   <i class="bi bi-file-medical me-2"></i>
                   Medical History
               </a>
           </li>
           <li class="nav-item mb-3">
               <a href="add_educational.php" class="nav-link text-white">
                   <i class="bi bi-book-half me-2"></i>
                   Education Progress
               </a>
           </li>
           <li class="nav-item mb-3">
               <a href="add_families.php" class="nav-link text-white">
                   <i class="bi bi-people-fill me-2"></i>
                   Family
               </a>
           </li>
           <li class="nav-item mb-3">
               <a href="add_adoption.php" class="nav-link text-white">
                   <i class="bi bi-heart me-2"></i>
                   Adoption
               </a>
           </li>
           <li class="nav-item mb-3">
               <a href="add_donations.php" class="nav-link text-white">
                   <i class="bi bi-cash me-2"></i>
                   Donations
               </a>
           </li>
       </ul>
       <div class="sidebar-footer">
           <ul class="nav flex-column mb-auto">
               <!--      <li class="nav-item mb-1">
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
                </li> -->
               <li class="nav-item">
                   <a class="nav-link text-white" href="?logout=true>
                       <i class=" bi bi-door-closed me-2"></i>
                       Sign out
                   </a>
               </li>
           </ul>
       </div>
   </nav>
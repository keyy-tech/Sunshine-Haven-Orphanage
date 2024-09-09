<?php
include 'connections/db_connect.php';

// Fetch existing data for the child if updating (example)
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM Adoption WHERE id = ?";
    $stmt = $db_connect->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $adoption = $result->fetch_assoc();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <script src="javascript.js"></script>
    <title>Update Adoption</title>
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <main>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-3 border-bottom">
            <h1 class="h4">Update Adoption</h1>
        </div>

        <form action="update_adoption_process.php" method="post" class="form-floating border-success p-3 shadow-lg needs-validation text-bg-light rounded-4" novalidate>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($adoption['id']); ?>">

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingChildId" name="child_id" placeholder="Child ID" value="<?php echo htmlspecialchars($adoption['child_id']); ?>" required>
                <label for="floatingChildId">Child ID</label>
                <div class="invalid-feedback">
                    Please provide a Child ID.
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingFamilyId" name="family_id" placeholder="Adoptive Family ID" value="<?php echo htmlspecialchars($adoption['family_id']); ?>" required>
                <label for="floatingFamilyId">Adoptive Family ID</label>
                <div class="invalid-feedback">
                    Please provide an Adoptive Family ID.
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingStatus" name="status" placeholder="Status" value="<?php echo htmlspecialchars($adoption['status']); ?>" required>
                <label for="floatingStatus">Status</label>
                <div class="invalid-feedback">
                    Please provide the Status.
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="date" class="form-control" id="placementDate" name="placement_date" value="<?php echo htmlspecialchars($adoption['placement_date']); ?>" required>
                <label for="placementDate">Date Of Placement</label>
                <div class="invalid-feedback">
                    Please provide a valid date of placement.
                </div>
            </div>
            <button type="submit" class="btn btn-outline-primary mt-1">Save Record</button>
            <a href="view_adoption.php" class="btn btn-outline-secondary mt-1 ms-3">View Records</a>
        </form>
    </main>
    <script>
        (function() {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
        })();
    </script>
</body>

</html>
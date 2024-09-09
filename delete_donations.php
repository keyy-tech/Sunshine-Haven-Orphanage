<?php
include 'connections/db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the SQL statement
    $sql = "DELETE FROM donations WHERE id = ?";

    if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param("i", $id);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect to the view page with a success message
            header("Location: view_donations.php?message=Record deleted successfully");
            exit; // Ensure no further code is executed after redirection
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $db_connect->error;
    }
} else {
    echo "No ID specified for deletion.";
}

$db_connect->close();

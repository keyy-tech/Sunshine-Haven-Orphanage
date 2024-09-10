<?php
include '../connections/db_connect.php';

// Check if the `id` parameter is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the delete statement
    $stmt = $db_connect->prepare("DELETE FROM Staff WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // If the record is deleted successfully, redirect to the view staff page
        header("Location: view_staff.php?msg=deleted");
    } else {
        // Handle any errors that occurred during deletion
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
    $db_connect->close();
} else {
    echo "No ID specified for deletion.";
}

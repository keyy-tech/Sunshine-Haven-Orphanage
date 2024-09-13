<?php
include '../connections/db_connect.php';

// Check if the `id` parameter is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the delete statement
    $stmt = $db_connect->prepare("DELETE FROM Staff WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $message = "Record deleted successfully.";
    } else {
        $message = "Error deleting record: " . $db_connect->error;
    }

    $stmt->close();
    $db_connect->close();

    // Redirect with message
    header("Location: view_staff.php?message=" . urlencode($message));
    exit;
} else {
    die("No ID specified for deletion.");
}

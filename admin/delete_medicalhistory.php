<?php
include '../connections/db_connect.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Prepare and execute the delete query
    $query = "DELETE FROM MedicalRecords WHERE id = ?";
    $stmt = $db_connect->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $message = "Record deleted successfully.";
    } else {
        $message = "Error deleting record: " . $db_connect->error;
    }

    $stmt->close();
    $db_connect->close();

    // Redirect with message
    header("Location: view_medicalhistory.php?message=" . urlencode($message));
    exit;
} else {
    die("No ID specified for deletion.");
}

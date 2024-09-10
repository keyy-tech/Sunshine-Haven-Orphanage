<?php
include 'connections/db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the SQL statement
    $sql = "DELETE FROM Children WHERE id = ?";

    if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param("i", $id);

        // Execute the query
        if ($stmt->execute()) {
            header("Location: view_children.php?message=Record deleted successfully");
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

<?php
include 'connections/db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the SQL statement
    $sql = "DELETE FROM DailyActivities WHERE id = ?";

    if ($stmt = $db_connect->prepare($sql)) {
        $stmt->bind_param("i", $id);

        // Execute the query
        if ($stmt->execute()) {
            header("Location: view_dailyactivties.php?message=Record deleted successfully");
            exit; // Ensure that no further code is executed after redirection
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

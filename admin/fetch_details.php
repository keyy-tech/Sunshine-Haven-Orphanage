<?php
include '../connections/db_connect.php';

$source = $_GET['source'];
$id = $_GET['id'];

switch ($source) {
    case 'Children':
        $query = "SELECT * FROM Children WHERE id = ?";
        break;
    case 'Staff':
        $query = "SELECT * FROM Staff WHERE id = ?";
        break;
    case 'Families':
        $query = "SELECT * FROM Families WHERE id = ?";
        break;
    default:
        die('Invalid source');
}

$stmt = $db_connect->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo "<h4>Details for {$source}</h4>";
    echo "<pre>" . print_r($data, true) . "</pre>";
} else {
    echo "No details found.";
}

$stmt->close();

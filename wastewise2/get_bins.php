<?php
require_once 'config.php';

$sql = "SELECT * FROM bins";
$result = $conn->query($sql);

$bins = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $bins[] = array(
            "name" => $row["name"],
            "latitude" => $row["latitude"],
            "longitude" => $row["longitude"]
        );
    }
}

echo json_encode($bins);

$conn->close();
?>
<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $latitude = $_POST["latitude"];
    $longitude = $_POST["longitude"];

    $sql = "INSERT INTO bins (name, latitude, longitude) VALUES ('$name', $latitude, $longitude)";

    if ($conn->query($sql) === TRUE) {
        echo "Bin added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
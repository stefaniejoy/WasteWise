<?php
// Include necessary files and fetch bin data
require_once('includes/load.php');

// Function to add a new bin to the database
function add_bin_to_database($name, $latitude, $longitude) {
    global $db; // Assuming $db is your database connection object

    $name = $db->escape($name);
    $latitude = $db->escape($latitude);
    $longitude = $db->escape($longitude);

    $query = "INSERT INTO bins (name, latitude, longitude) VALUES ('{$name}', '{$latitude}', '{$longitude}')";

    return $db->query($query);
}

// Check if the form data is present in the POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bin_name = $_POST['bin-name'];
    $bin_latitude = $_POST['bin-latitude'];
    $bin_longitude = $_POST['bin-longitude'];

    // Add the new bin to the database
    $result = add_bin_to_database($bin_name, $bin_latitude, $bin_longitude);

    // Respond to the AJAX request
    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Bin added successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add bin to the database']);
    }
} else {
    // Handle invalid requests (non-POST requests)
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>

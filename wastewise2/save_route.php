<?php
// Include necessary files and initialize the database connection
require_once('includes/load.php');
require_once('includes/database.php'); // Adjust the path accordingly

// Ensure the MySqli_DB class is properly loaded
if (!class_exists('MySqli_DB')) {
    die('MySqli_DB class not found');
}

// Initialize the database connection
$db = new MySqli_DB();

// Ensure the database connection is open
if (!$db->is_connected()) {
    die('Database connection not established: ' . mysqli_connect_error());
}

// Retrieve data from the POST request
$routeName = isset($_POST['route-name']) ? $_POST['route-name'] : '';
$startLatitude = isset($_POST['start-latitude']) ? $_POST['start-latitude'] : '';
$startLongitude = isset($_POST['start-longitude']) ? $_POST['start-longitude'] : '';
$endLatitude = isset($_POST['end-latitude']) ? $_POST['end-latitude'] : '';
$endLongitude = isset($_POST['end-longitude']) ? $_POST['end-longitude'] : '';

// Perform database insertion
$insertQuery = "INSERT INTO routes (name, start_latitude, start_longitude, end_latitude, end_longitude) VALUES (?, ?, ?, ?, ?)";

// Prepare and bind
$stmt = mysqli_prepare($db->get_connection(), $insertQuery);

// Check if the prepare statement was successful
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'sdddd', $routeName, $startLatitude, $startLongitude, $endLatitude, $endLongitude);

    // Check if the insertion was successful
    if (mysqli_stmt_execute($stmt)) {
        echo "Route added successfully";
    } else {
        echo "Error executing statement: " . mysqli_stmt_error($stmt);
    }






    // Close the prepared statement
    mysqli_stmt_close($stmt);
} 
else {
    echo 'Error preparing statement: ' . mysqli_error($db->get_connection());
}

// Close the database connection
$db->db_disconnect();
?>

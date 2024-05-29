 <?php
// Include necessary files and fetch route data
require_once('includes/load.php');
require_once('includes/routes_functions.php'); // Include your routes functions file

$page_title = "Waste Management System";

// Function to fetch all routes
function find_all_routes_from_database() {
    global $db; // Assuming $db is your database connection object

    // Replace the following with your actual database query
    $result = $db->query("SELECT * FROM routes");
    $routes = [];
    
    while ($row = $db->fetch_assoc($result)) {
        $routes[] = $row;
    }

    return $routes;
}

// Fetch route data from the database
$routes = find_all_routes_from_database();
?>

<?php include_once('layouts/header.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 100%;
        }
    </style>
</head>

<body>
        <!-- Leaflet Map -->
        <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-map-marker"></span>
                <span>Map</span>
            </strong>
        </div>
        <div class="panel-body map-container" style="height: 400px;">
            <div id="map"></div>
        </div>
    </div>
    <!-- Include OpenRouteService library -->
    <script src="https://maps.openrouteservice.org/assets/js/openrouteservice.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />

    <!-- Leaflet map initialization script -->
    <script>
        // Display routes as lines on the map
        var routeLines = <?php echo json_encode($routes); ?>;

        var map = L.map('map').setView([18.1644, 120.4614], 10);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Add existing route lines to the map
        routeLines.forEach(function(route) {
            var startLatLng = L.latLng(route.start_latitude, route.start_longitude);
            var endLatLng = L.latLng(route.end_latitude, route.end_longitude);

            L.polyline([startLatLng, endLatLng], { color: 'blue' }).addTo(map).bindPopup(route.name + ' - Route');
        });

        // Add click event listener to get coordinates
        map.on('click', function(e) {
            var latitude = e.latlng.lat.toFixed(6);
            var longitude = e.latlng.lng.toFixed(6);

            // Update the form fields with the clicked coordinates
            $('#start-latitude').val(latitude);
            $('#start-longitude').val(longitude);
        });
    </script>
</body>

</html>

<?php include_once('layouts/footer.php'); ?>

<?php
// Include necessary files and fetch route data
require_once('includes/load.php');

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
    <title>Waste Management System</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>

<body>
    <!-- Your existing body content -->

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>
                        <span class="glyphicon glyphicon-road"></span>
                        <span>Add New Route</span>
                    </strong>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <form method="post" id="addRouteForm" class="clearfix">
                            <!-- Your existing form fields for adding a new route -->
                            <div class="form-group">
                                <label for="route-name">Route Name</label>
                                <input type="text" class="form-control" name="route-name" placeholder="Route Name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="start-latitude">Start Latitude</label>
                                <input type="text" class="form-control" name="start-latitude" placeholder="Start Latitude"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="start-longitude">Start Longitude</label>
                                <input type="text" class="form-control" name="start-longitude"
                                    placeholder="Start Longitude" required>
                            </div>
                            <div class="form-group">
                                <label for="end-latitude">End Latitude</label>
                                <input type="text" class="form-control" name="end-latitude" placeholder="End Latitude"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="end-longitude">End Longitude</label>
                                <input type="text" class="form-control" name="end-longitude"
                                    placeholder="End Longitude" required>
                            </div>
                            <button type="submit" class="btn btn-success">Add Route</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leaflet Map -->
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>
                        <span class="glyphicon glyphicon-map-marker"></span>
                        <span>Map</span>
                    </strong>
                </div>
                <div class="panel-body map-container" style="height: 435px;">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>

<!-- Include OpenRouteService library -->
<script src="https://maps.openrouteservice.org/assets/js/openrouteservice.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />

<!-- Your existing Leaflet map initialization script -->
<script>
    // Display routes as lines on the map
    var routeLines = <?php echo json_encode($routes); ?>;

    var map = L.map('map').setView([18.1644, 120.4614], 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Add existing route lines to the map
    routeLines.forEach(function (route) {
        var startLatLng = L.latLng(route.start_latitude, route.start_longitude);
        var endLatLng = L.latLng(route.end_latitude, route.end_longitude);

        L.polyline([startLatLng, endLatLng], { color: 'blue' }).addTo(map).bindPopup(route.name + ' - Route');
    });

    // Add click event listener to get coordinates
    map.on('click', function (e) {
        var latitude = e.latlng.lat.toFixed(6);
        var longitude = e.latlng.lng.toFixed(6);

        // Update the form fields with the clicked coordinates
        $('#start-latitude').val(latitude);
        $('#start-longitude').val(longitude);
    });
// Add a new route with Leaflet Routing Machine when submitting the form
$('#addRouteForm').submit(function (e) {
    e.preventDefault();

    // Get form data
    var formData = {
        'route-name': $('input[name="route-name"]').val(),
        'start-latitude': $('input[name="start-latitude"]').val(),
        'start-longitude': $('input[name="start-longitude"]').val(),
        'end-latitude': $('input[name="end-latitude"]').val(),
        'end-longitude': $('input[name="end-longitude"]').val()
    };

    // Clear the form fields after submission
    $('input[name="route-name"]').val('');
    $('input[name="start-latitude"]').val('');
    $('input[name="start-longitude"]').val('');
    $('input[name="end-latitude"]').val('');
    $('input[name="end-longitude"]').val('');

    // Add a new route with Leaflet Routing Machine
    L.Routing.control({
        waypoints: [
            L.latLng(formData['start-latitude'], formData['start-longitude']),
            L.latLng(formData['end-latitude'], formData['end-longitude'])
        ],
        routeWhileDragging: true, // Allow dragging waypoints
    }).addTo(map);

    // Update the map with the new route line
    var startLatLng = L.latLng(formData['start-latitude'], formData['start-longitude']);
    var endLatLng = L.latLng(formData['end-latitude'], formData['end-longitude']);

    L.polyline([startLatLng, endLatLng], { color: 'green' }).addTo(map).bindPopup(formData['route-name'] + ' - Route');

    // Make an AJAX request to save the new route to the database
    $.ajax({
        type: 'POST',
        url: 'save_route.php', // Correct path to your server-side script
        data: formData,
        success: function (response) {
            console.log('Route added to the database:', response);
        },
        error: function (error) {
            console.error('Error adding route to the database:', error);
        }
    });
});
</script>

</body>

</html>

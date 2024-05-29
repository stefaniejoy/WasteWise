<?php
// Include necessary files and fetch bin data
require_once('includes/load.php');

// Function to fetch all bins
function find_all_bins_from_database() {
    global $db; // Assuming $db is your database connection object

    // Replace the following with your actual database query
    $result = $db->query("SELECT * FROM bins");
    $bins = [];

    while ($row = $db->fetch_assoc($result)) {
        $bins[] = $row;
    }

    return $bins;
}

// Fetch bin data from the database
$bins = find_all_bins_from_database();
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
            height: 375px;
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

    <!-- Leaflet Map Initialization -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        // Display markers for existing bins
        var binMarkers = <?php echo json_encode($bins); ?>;

        // Set the initial center and zoom level for Ilocos Norte, Philippines
        var map = L.map('map').setView([18.1644, 120.4614], 10);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Add existing bin markers to the map
        binMarkers.forEach(function (bin) {
            L.marker([bin.latitude, bin.longitude]).addTo(map).bindPopup(bin.name + ' - Bin');
        });

        // Add click event listener to get coordinates
        map.on('click', function (e) {
            var latitude = e.latlng.lat.toFixed(6);
            var longitude = e.latlng.lng.toFixed(6);

            // Update the form fields with the clicked coordinates
            $('#bin-latitude').val(latitude);
            $('#bin-longitude').val(longitude);
        });
    </script>
</body>

</html>

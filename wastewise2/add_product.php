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
            height: 400px;
            width:100%;
        }
    </style>
</head>

<body>

    <div class="row">
        <div class="col-md-12">
            <?php echo display_msg($msg); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>
                        <span class="glyphicon glyphicon-trash"></span>
                        <span>Add New Bin</span>
                    </strong>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <form method="post" id="addBinForm" class="clearfix">
                            <!-- Your existing form fields for adding a new bin -->
                            <div class="form-group">
                                <label for="bin-name">Bin Name</label>
                                <input type="text" class="form-control" name="bin-name" placeholder="Bin Name" required>
                            </div>
                            <div class="form-group">
                                <label for="bin-latitude">Latitude</label>
                                <input type="text" class="form-control" name="bin-latitude" placeholder="Latitude" required>
                            </div>
                            <div class="form-group">
                                <label for="bin-longitude">Longitude</label>
                                <input type="text" class="form-control" name="bin-longitude" placeholder="Longitude" required>
                            </div>
                            <button type="submit" class="btn btn-danger">Add Bin</button>
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

        // Add form submission handling
        $('#addBinForm').submit(function (e) {
            e.preventDefault();

            // Get form data
            var formData = {
                'bin-name': $('input[name="bin-name"]').val(),
                'bin-latitude': $('input[name="bin-latitude"]').val(),
                'bin-longitude': $('input[name="bin-longitude"]').val()
            };

            // Update the map with the new bin marker
            var newBinMarker = L.marker([formData['bin-latitude'], formData['bin-longitude']])
                .addTo(map)
                .bindPopup(formData['bin-name'] + ' - Bin');

            // Make an AJAX request to save the new bin to the database
            $.ajax({
                type: 'POST',
                url: 'save_bin.php', // Correct path to your server-side script
                data: formData,
                success: function (response) {
                    console.log('Bin added to the database:', response);
                },
                error: function (error) {
                    console.error('Error adding bin to the database:', error);
                }
            });

            // Optionally, you can clear the form fields after submission
            $('input[name="bin-name"]').val('');
            $('input[name="bin-latitude"]').val('');
            $('input[name="bin-longitude"]').val('');
        });
    </script>
</body>

</html>

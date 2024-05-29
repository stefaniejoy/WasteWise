<?php
$page_title = 'Admin Home Page';
require_once('includes/load.php');
// Checking the user's permission level to view this page
page_require_level(1);
?>
<?php
$c_garbage_truck_drivers = count_by_id('users');
$c_waste_bins = count_by_id('categories');
$c_routes = count_by_id('products');
$c_sale = count_by_id('sales');
$garbage_truck_drivers = find_highest_selling_product('10'); // Assuming you want the highest selling drivers
$recent_routes = find_recent_product_added('5');
$recent_sales = find_recent_sale_added('5');
?>
<?php include_once('layouts/header.php'); ?>

<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <style>
        .map-container {
            margin-bottom: 20px; /* Adjust the value to your preference */
        }

        .dashboard-container {
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Align items to the top */
            flex-wrap: wrap;
            margin-top: 20px; /* Adjust the value to your preference */
        }

        .category-item {
            margin: 0 10px; /* Adjust spacing between items */
        }
    </style>
</head>

<!-- Leaflet Map -->
<div class="row">
    <div class="col-md-12 map-container">
        <div id="map" style="height: 400px;"></div>
    </div>
</div>

<!-- Your existing categories -->
<div class="row dashboard-container">
    <!-- Add the space between the map and the dashboard categories -->
    <div class="col-md-3 category-item">
        <a href="garbage_truck_drivers.php" style="color:black;" class="category-link">
            <div class="panel panel-box clearfix">
                <div class="panel-icon pull-left bg-secondary1">
                    <i class="glyphicon glyphicon-user"></i>
                </div>
                <div class="panel-value pull-right">
                    <h2 class="margin-top"> <?php echo $c_garbage_truck_drivers['total']; ?> </h2>
                    <p class="text-muted">Users</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-3 category-item">
        <a href="waste_bins.php" style="color:black;" class="category-link">
            <div class="panel panel-box clearfix">
                <div class="panel-icon pull-left bg-red">
                    <i class="glyphicon glyphicon-trash"></i>
                </div>
                <div class="panel-value pull-right">
                    <h2 class="margin-top"> <?php echo $c_waste_bins['total']; ?> </h2>
                    <p class="text-muted">Waste Bins</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-3 category-item">
        <a href="routes.php" style="color:black;" class="category-link">
            <div class="panel panel-box clearfix">
                <div class="panel-icon pull-left bg-blue2">
                    <i class="glyphicon glyphicon-map-marker"></i>
                </div>
                <div class="panel-value pull-right">
                    <h2 class="margin-top"> <?php echo $c_routes['total']; ?> </h2>
                    <p class="text-muted">Routes</p>
                </div>
            </div>
        </a>
    </div>

</div>

<div class="row">
    <!-- Your existing content for Highest Selling Garbage Truck Drivers, Latest Sales, and Recently Added Routes -->
</div>

<?php include_once('layouts/footer.php'); ?>

<!-- Leaflet Map Initialization -->
<script>
    // Set the initial center and zoom level for Ilocos Norte, Philippines
    var map = L.map('map').setView([18.1644, 120.4614], 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Display markers for existing routes
    routeMarkers.forEach(function (route) {
        L.marker([route.latitude, route.longitude]).addTo(map).bindPopup(route.name + ' - Route');
    });

    // Display markers for existing bins
    binMarkers.forEach(function (bin) {
        L.marker([bin.latitude, bin.longitude]).addTo(map).bindPopup(bin.name + ' - Bin');
    });

    // Function to add a new bin marker to the map
    function addBinMarker(bin) {
        L.marker([bin.latitude, bin.longitude]).addTo(map).bindPopup(bin.name + ' - Bin');
    }

    // Function to set the map center and zoom level
    function setMapCenterAndZoom(lat, lng, zoom) {
        map.setView([lat, lng], zoom);
    }

    // Assume you have a function to make an AJAX request, for example, using jQuery
    function addNewBin(binData) {
        // Make an AJAX request to add_bin.php to handle the addition of a new bin
        $.ajax({
            type: 'POST',
            url: 'add_bin.php',
            data: binData,
            success: function (response) {
                // Parse the JSON response
                var newBin = JSON.parse(response);

                // Update the map with the new bin marker
                addBinMarker(newBin);

                // Update the dashboard dynamically (append a new bin category)
                var newBinCategory = '<div class="col-md-3 category-item">' +
                    '<a href="#" style="color:black;" class="category-link">' +
                    '<div class="panel panel-box clearfix">' +
                    '<div class="panel-icon pull-left bg-red">' +
                    '<i class="glyphicon glyphicon-trash"></i>' +
                    '</div>' +
                    '<div class="panel-value pull-right">' +
                    '<h2 class="margin-top">' + newBin.name + '</h2>' +
                    '<p class="text-muted">Waste Bin</p>' +
                    '</div>' +
                    '</div>' +
                    '</a>' +
                    '</div>';

                $('.dashboard-container').append(newBinCategory);

                // Set the map center and zoom level to the new bin location
                setMapCenterAndZoom(newBin.latitude, newBin.longitude, 15);
            },
            error: function (error) {
                console.error('Error adding bin:', error);
            }
        });
    }

    // Example usage: call addNewBin with the new bin data
    var newBinData = {
        bin_name: 'New Bin', // Replace with the actual bin name
        bin_latitude: 18.1644, // Replace with the actual latitude
        bin_longitude: 120.4614 // Replace with the actual longitude
    };

    // Call addNewBin when you want to add a new bin, e.g., in response to a user action
    addNewBin(newBinData);
</script>

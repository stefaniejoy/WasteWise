<?php
$page_title = 'Home Page';
require_once('includes/load.php');
if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>

<?php
$c_waste_bins = count_by_id('bins');
$c_routes = count_by_id('routes');
$c_sales = count_by_id('sales');

$recent_routes = find_recent_product_added('5');
$recent_sales = find_recent_sale_added('5');
?>

<?php include_once('layouts/header.php'); ?>

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script> 
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></ script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <style>
        .map-container {
            margin-bottom: 20px; /* Adjust the value to your preference */
        }

        .dashboard-container {
            display: flex;
            justify-content: center;
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
        <div id="map" style="height: 400px; z-index: 1;"></div>
    </div>
</div>

<!-- Your existing categories -->
<div class="row dashboard-container">
    <!-- Add the space between the map and the dashboard categories -->
    <div class="col-md-3 category-item">
        <a href="waste_bins.php" style="color:black;" class="category-link">
            <div class="panel panel-box clearfix">
                <div class="panel-icon pull-left bg-red">
                    <i class="glyphicon glyphicon-trash"></i>
                </div>
                <div class="panel-value pull-right">
                    <h2 class="margin-top"> <?php echo htmlspecialchars($c_waste_bins['total']); ?> </h2>
                    <p class="text-muted">Waste Bins</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-3 category-item">
        <a href="routes_special.php" style="color:black;" class="category-link">
            <div class="panel panel-box clearfix">
                <div class="panel-icon pull-left bg-blue2">
                    <i class="glyphicon glyphicon-map-marker"></i>
                </div>
                <div class="panel-value pull-right">
                    <h2 class="margin-top"> <?php echo htmlspecialchars($c_routes['total']); ?> </h2>
                    <p class="text-muted">Routes</p>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row">
    <!-- Your existing content for Latest Sales and Recently Added Routes -->
</div>

<?php include_once('layouts/footer.php'); ?>

<!-- Leaflet Map Initialization -->
<script>
    // Set the initial center and zoom level for Ilocos Norte, Philippines
    var map = L.map('map').setView([18.1644, 120.4614], 10);

    // Leaflet tile layer for OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

</script>


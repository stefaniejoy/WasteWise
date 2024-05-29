<?php
require_once('includes/load.php');
require_once('includes/routes_functions.php'); // Include your routes functions file

$page_title = "Delete Route";

// Check if the route ID is provided in the URL
if (isset($_GET['id'])) {
    $route_id = (int)$_GET['id'];
    $route = find_route_by_id($route_id);

    // Check if the route exists
    if (!$route) {
        $session->msg("d", "Route not found!");
        redirect('sales.php');
    }
} else {
    $session->msg("d", "Route ID not provided!");
    redirect('sales.php');
}

// Check if the form is submitted
if (isset($_POST['delete_route'])) {
    // Delete the route
	$delete_result = delete_by_id('routes', $route_id);

    if ($delete_result) {
        $session->msg("s", "Route deleted successfully!");
        redirect('sales.php');
    } else {
        $session->msg("d", "Failed to delete route. Please try again.");
        redirect('delete_route.php?id=' . $route_id);
    }
}

include_once('layouts/header.php');
?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>Delete Route</strong>
            </div>
            <div class="panel-body">
                <p>Are you sure you want to delete this route?</p>
                <form method="post" action="delete_route.php?id=<?php echo $route_id; ?>">
                    <button type="submit" name="delete_route" class="btn btn-danger">Delete Route</button>
                    <a href="manage_routes.php" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>

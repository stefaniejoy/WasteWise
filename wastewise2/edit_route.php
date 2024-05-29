<?php

$page_title = "Edit Route";
require_once('includes/load.php');
require_once('includes/routes_functions.php'); // Include your routes functions file



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



if (isset($_POST['update_route'])) {
    // Handle the update logic here based on form submission
    $required_fields = array('name', 'start_latitude', 'start_longitude', 'end_latitude', 'end_longitude');
    validate_fields($required_fields);

    if (empty($errors)) {
        // Update bin details in the database
        $name = $db->escape($_POST['name']);
        $start_latitude = (double)$_POST['start_latitude'];
        $start_longitude = (double)$_POST['start_longitude'];
		$end_latitude = (double)$_POST['end_latitude'];
		$end_longitude = (double)$_POST['end_longitude'];
		
        $sql = "UPDATE routes SET name='{$name}', start_latitude={$start_latitude}, start_longitude={$start_longitude}, end_latitude={$end_latitude}, end_longitude={$end_longitude}WHERE id={$route_id}";
        $result = $db->query($sql);

        if ($result) {
            $session->msg('s', "Routes details updated.");
            redirect('sales.php'); // Adjust the redirection URL as needed
        } else {
            $session->msg('d', 'Failed to update routes details.');
        }
    } else {
        $session->msg("d", $errors);
        redirect("edit_route.php?id={$route_id}");
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
                <strong>Edit Route</strong>
            </div>
            <div class="panel-body">
                <form method="post" action="edit_route.php?id=<?php echo $route_id; ?>">
                    <div class="form-group">
                        <label for="name">Route Name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo remove_junk($route['name']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="start_latitude">Start Latitude</label>
                        <input type="text" class="form-control" name="start_latitude" value="<?php echo $route['start_latitude']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="start_longitude">Start Longitude</label>
                        <input type="text" class="form-control" name="start_longitude" value="<?php echo $route['start_longitude']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="end_latitude">End Latitude</label>
                        <input type="text" class="form-control" name="end_latitude" value="<?php echo $route['end_latitude']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="end_longitude">End Longitude</label>
                        <input type="text" class="form-control" name="end_longitude" value="<?php echo $route['end_longitude']; ?>">
                    </div>
                    <button type="submit" name="update_route" class="btn btn-primary">Update Route</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>

<?php
  $page_title = 'Manage Routes';
  require_once('includes/load.php');
  // Check the user's permission level
  page_require_level(3);
?>

<?php
// Include functions to work with routes
require_once('includes/routes_functions.php');

// Fetch all routes from the database
$routes = find_all_routes();
?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-road"></span>
          <span>Manage Routes</span>
        </strong>
        <div class="pull-right">
          <a href="add_sale2.php" class="btn btn-primary">See Route</a>
        </div>
      </div>
      <div class="panel-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th>Route Name</th>
              <th>Start Latitude</th>
              <th>Start Longitude</th>
              <th>End Latitude</th>
              <th>End Longitude</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($routes as $route):?>
              <tr>
                <td class="text-center"><?php echo $route['id']; ?></td>
                <td><?php echo remove_junk($route['name']); ?></td>
                <td><?php echo $route['start_latitude']; ?></td>
                <td><?php echo $route['start_longitude']; ?></td>
                <td><?php echo $route['end_latitude']; ?></td>
                <td><?php echo $route['end_longitude']; ?></td>
                  <div class="btn-group">
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>

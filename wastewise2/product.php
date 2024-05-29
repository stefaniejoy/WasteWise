<?php
  $page_title = 'All Bins'; // Updated page title
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);

  // Fetch data from bins table
  $bins = join_bins_table();

  // Check if the query was successful
  if ($bins === false) {
      // Handle the error, redirect, or display a message as needed
      die("Error fetching data from bins table.");
  }
?>





<?php include_once('layouts/header.php'); ?>
  <div class="row">
    <div class="col-md-12">
      <?php echo display_msg($msg); ?>
    </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <div class="pull-right">
            <a href="add_product.php" class="btn btn-primary">Add New</a> <!-- Adjust link based on your requirements -->
          </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Bin Name </th>
                <th class="text-center" style="width: 10%;"> Latitude </th>
                <th class="text-center" style="width: 10%;"> Longitude </th>
                <th class="text-center" style="width: 100px;"> Actions </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($bins as $bin): ?>
                <tr>
                  <td class="text-center"><?php echo htmlspecialchars($bin['id']); ?></td>
                  <td><?php echo htmlspecialchars($bin['name']); ?></td>
                  <td class="text-center"><?php echo htmlspecialchars($bin['latitude']); ?></td>
                  <td class="text-center"><?php echo htmlspecialchars($bin['longitude']); ?></td>
                  <td class="text-center">
                    <div class="btn-group">
                      <a href="edit_bin.php?id=<?php echo (int)$bin['id']; ?>" class="btn btn-info btn-xs" title="Edit" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-edit"></span>
                      </a>
                      <a href="delete_bin.php?id=<?php echo (int)$bin['id']; ?>" class="btn btn-danger btn-xs" title="Delete" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-trash"></span>
                      </a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>

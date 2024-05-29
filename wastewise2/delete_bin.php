<?php
  $page_title = 'Delete Bin';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);

  if (isset($_GET['id'])) {
    $bin_id = (int)$_GET['id'];
    $bin = find_by_id('bins', $bin_id);

    if (!$bin) {
      // Handle case where bin with specified ID is not found
      die("Bin not found.");
    }
  } else {
    // Handle case where ID is not provided in the URL
    die("Invalid request.");
  }

  if (isset($_POST['delete_bin'])) {
    // Handle the deletion logic here based on form submission
    $result = delete_by_id('bins', $bin_id);

    if ($result) {
      $session->msg('s', "Bin deleted.");
      redirect('product.php'); // Adjust the redirection URL as needed
    } else {
      $session->msg('d', 'Failed to delete bin.');
      redirect("delete_bin.php?id={$bin_id}");
    }
  }
?>
<?php include_once('layouts/header.php'); ?>

<!-- Confirmation prompt for deleting bin -->
<div class="container">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="panel panel-default">
        <div class="panel-body">
          <h4>Confirm Delete Bin</h4>
          <p>Are you sure you want to delete this bin?</p>
          <form method="post" action="delete_bin.php?id=<?php echo $bin_id; ?>">
            <button type="submit" name="delete_bin" class="btn btn-danger">Yes</button>
            <a href="product.php" class="btn btn-success">No</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>

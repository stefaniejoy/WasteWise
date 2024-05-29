<?php
$page_title = 'Edit Bin';
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

if (isset($_POST['update_bin'])) {
    // Handle the update logic here based on form submission
    $required_fields = array('name', 'latitude', 'longitude');
    validate_fields($required_fields);

    if (empty($errors)) {
        // Update bin details in the database
        $name = $db->escape($_POST['name']);
        $latitude = (double)$_POST['latitude'];
        $longitude = (double)$_POST['longitude'];

        $sql = "UPDATE bins SET name='{$name}', latitude={$latitude}, longitude={$longitude} WHERE id={$bin_id}";
        $result = $db->query($sql);

        if ($result) {
            $session->msg('s', "Bin details updated.");
            redirect('product.php'); // Adjust the redirection URL as needed
        } else {
            $session->msg('d', 'Failed to update bin details.');
        }
    } else {
        $session->msg("d", $errors);
        redirect("edit_bin.php?id={$bin_id}");
    }
}
?>
<?php include_once('layouts/header.php'); ?>

<!-- Edit bin information form -->
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4>Edit Bin Information</h4>
                    <form method="post" action="edit_bin.php?id=<?php echo $bin_id; ?>">
                        <div class="form-group">
                            <label for="name">Bin Name</label>
                            <input type="text" class="form-control" name="name" value="<?php echo $bin['name']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="latitude">Latitude</label>
                            <input type="text" class="form-control" name="latitude" value="<?php echo $bin['latitude']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="longitude">Longitude</label>
                            <input type="text" class="form-control" name="longitude" value="<?php echo $bin['longitude']; ?>" required>
                        </div>
                        <button type="submit" name="update_bin" class="btn btn-success">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>

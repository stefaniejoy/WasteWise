// add_bin.php

<?php
require_once('includes/load.php');

// Check the user's permission level
page_require_level(2);

// Validate and process the bin data
if (isset($_POST['add_bin'])) {
    $req_fields = array('bin-name', 'bin-latitude', 'bin-longitude');
    validate_fields($req_fields);

    if (empty($errors)) {
        $bin_name = remove_junk($db->escape($_POST['bin-name']));
        $bin_latitude = remove_junk($db->escape($_POST['bin-latitude']));
        $bin_longitude = remove_junk($db->escape($_POST['bin-longitude']));

        // Add the bin to the database or perform any necessary actions
        // ...

        // Return the new bin data as JSON
        $new_bin = array(
            'name' => $bin_name,
            'latitude' => $bin_latitude,
            'longitude' => $bin_longitude
        );

        echo json_encode($new_bin);
    } else {
        echo json_encode(array('error' => 'Failed to add bin.'));
    }
}
?>

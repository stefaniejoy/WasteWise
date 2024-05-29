<?php
$page_title = 'Waste Management System';
ob_start();
require_once('includes/load.php');
if ($session->isUserLoggedIn(true)) {
    redirect('home.php', false);
}
?>
<?php include_once('layouts/header.php'); ?>
<head>
    <title>Waste Management System</title>
</head>
<style>
     body { background-color: #e6ffe6; }
    .login-page {
        background-color: #fff;
        border: 1px solid #008000;
        border-radius: 10px;
        padding: 20px;
        max-width: 400px; /* Set a wider max-width */
        width: 100%; /* Take full width of the container */
        box-sizing: border-box; /* Include padding and border in the width */
    }
    .text-center { margin-bottom: 20px; }
    .login-page img { max-width: 100%; height: auto; margin-bottom: 20px; }
    h1, h4 { color: #008000; margin: 0; }
    label { color: #008000; }

    h4 
    .form-control { border: 1px solid #008000; }
    .btn-danger { background-color: #008000; border: 1px solid #008000; border-radius: 0%; }
    .btn-danger:hover { background-color: #005700; }
</style>
<div class="login-page">
    <div class="text-center">
        <img src="logo.jpg" alt="Your Logo" style="max-width: 100%; height: auto;">
        <h1>Waste Wise</h1><h4><strong>Waste Management System</strong></h4>
    </div>
    <?php echo display_msg($msg); ?>
    <form method="post" action="auth.php" class="clearfix">
        <div class="form-group">
            <label for="username" class="control-label">Username</label>
            <input type="name" class="form-control" name="username" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="Password" class="control-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-danger" style="border-radius:0%">Login</button>
        </div>
    </form>
</div>
<?php include_once('layouts/footer.php'); ?>

<?php
// Initialize the session
session_start();
require_once '../functions.php';
require_once '../config.php';
$company_name = get_company($_SESSION['username']);
$sites = get_sites($company_name);
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.</h1>
    </div>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>


    <h2>My building sites</h2>
    <a href='add-sites.php' class="btn btn-info">Add</a> <br>
    <?php
    foreach($sites as $site) {
        echo $site['code'] . '&nbsp;'; 
        echo $site['address'] . '<br>';
    }
    ?>

</body>
</html>
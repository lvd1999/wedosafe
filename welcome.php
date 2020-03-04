<?php
// Initialize the session
session_start();
require_once 'functions.php';
require_once 'config.php';

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$email = $_SESSION['email'];
$registeredSites = displayRegisteredSites($email);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Homepage</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Home</h1>
    </div>
    <p>
        <a href="profile/profile.php" class="btn btn-success">Profile</a>
        <a href="register-site.php" class="btn btn-info">Register a site</a>
        <a href="../reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
 
    <h2>Your registered sites¬</h2>
    <?php
    if(count($registeredSites) > 0)
    {
        foreach($registeredSites as $registeredSite) {
            echo $registeredSite['code'] . "\t" . $registeredSite['address'] . "<br>";
        }
    } else {
        echo "No registered site.";
    }
    ?>
</body>
</html>

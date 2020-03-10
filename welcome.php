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
$registeredSites = registeredSites($email);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Homepage</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity=   q"sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style type="text/css">
        body {
            font: 14px sans-serif;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="page-header">
        <h1>Home</h1>
    </div>
    <p>
        <a href="profile/profile.php" class="btn btn-success">Profile</a>
        <a href="request.php" class="btn btn-info">Enter site code</a>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>

    <h2>Your registered sites</h2>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Site Code</th>
            <th scope="col">Address</th>
            <th scope="col">Status</th>
        </tr>
        </thead>
       <tbody>
        <?php
if (count($registeredSites) > 0) {
    foreach ($registeredSites as $registeredSite) {
        echo "<tr scope='row'><td>" . $registeredSite['code'] . "</td>" .            
            "<td>" . $registeredSite['address'] . "</td>" . 
            '<td>' . $registeredSite['status'] . '</td>' . 
            "</tr>";
    }
} else {
    echo "No registered site.";
}
?>
    </tbody>
    </table>

</body>


<!-- <embed src="dummy.pdf" width="500" height="375"> -->

</html>
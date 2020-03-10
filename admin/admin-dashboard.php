<?php
// Initialize the session
session_start();
require_once '../functions.php';
require_once '../config.php';

//variables
$company_name = get_company($_SESSION['username']);
$sites = get_sites($company_name);
$requests = get_pendingrequest($_SESSION['username']);
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["adminloggedin"]) || $_SESSION["adminloggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
    
<table class="table">
<thead>
<tr>
<th scope="col">Code </th>
<th scope="col">Address</th>
</tr>
</thead>
<tbody>
    <?php
if (count($sites) > 0) {
    foreach ($sites as $site) {
        echo '<tr><th scope="row"><a href="site-member.php?site_id=' . $site['id'] . 
        '&site_code='. $site['code'] . 
        '">' . $site['code'] . '</a></th>';
        echo '<td>' . $site['address'] . '</td></tr>';
    } 
} else {
    echo "No building site. Please add one";
}
?>
</tbody>
</table>


    <h2>Pending Site Requests</h2>
    <?php
foreach ($requests as $request) {
    echo $request['firstname'] . "\t\t" . $request['surname'] . "\t" . $request['code'] . "\t\t" . $request['message'] .
        '<a href="accept-request.php?id=' . $request['id'] .
        '&email=' . $request['email'] .
        '&building_site_id=' . $request['bs_id'] .
        '"><button>Allow</button>' . "</a>" . "<br>";
}
?>
</body>
</html>
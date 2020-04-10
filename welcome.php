<?php

session_start();
require_once 'functions.php';
require_once 'config.php';

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$_SESSION['user'] = userDetails($_SESSION['email']);
$registeredSites = registeredSites($_SESSION['email']);
$documents = getDocuments($_SESSION['user']['id']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Homepage</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
        <a href="pdf-history.php" class="btn btn-warning">PDF History</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>

    <h2>Your registered sites</h2>
        <?php
if (count($registeredSites) > 0) {
    echo '
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Site Code</th>
            <th scope="col">Address</th>
            <th scope="col">Status</th>
            <th scope="col">Documents</th>
        </tr>
        </thead>
       <tbody>';
    foreach ($registeredSites as $registeredSite) {
        $site_id = getSite($registeredSite['id']);

        //if status allowed, put link, else, just code name
        if ($registeredSite['status'] == "allowed") {
            echo "<tr scope='row'><td>" . '<a href="user/show-pdf-site.php?siteid=' . $registeredSite['id'] . '&site_code=' . $registeredSite['code'] . '">' . $registeredSite['code'] . "</a></td>";
        } else {
            echo "<tr scope='row'><td>" . $registeredSite['code'] . "</td>";
        }
        echo "<td>" . $registeredSite['address'] . "</td>" .
        '<td>' . $registeredSite['status'] . '</td>' .
        //if all documents read in the site - tick, else - cross

        "</tr>";
    }
} else {
    echo "No registered site. Register one <a href='request.php'>here</a>";
}
?>
    </tbody>
    </table>

<h3>Urgent</h3>
    <?php
foreach ($documents as $document) {
    echo '<a href="user/show-pdf.php?id=' . $document['pdf_id'] . '">' . $document['title'] . '</a>(' . $document['company_name'] . ')<br>';
}
?>

</body>




</html>
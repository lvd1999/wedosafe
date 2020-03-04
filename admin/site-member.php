<?php
// Initialize the session
session_start();
require_once '../functions.php';
require_once '../config.php';

$members = siteMembers($_GET['site_id']);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View - Site members</title>
</head>
<body>
    <?php
    foreach($members as $member) {
        echo $member['email'] . "<br>";
    }
    ?>
</body>
</html>
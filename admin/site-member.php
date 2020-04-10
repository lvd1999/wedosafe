<?php
// Initialize the session
session_start();
require_once '../functions.php';
require_once '../config.php';


$pdfs = getSiteDocuments($_GET['site_id']);
$members = siteMembers($_GET['site_id']);
$site = getSiteByCode($_GET['site_code']);
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View - Site members</title>
</head>

<body>
    <h1><?php echo $site['code']; ?></h1>
    <h3>Address: <?php echo $site['address']; ?></h3>

    <?php
if (empty($members)) {
    echo 'No members on the site.';
} else {
    echo '<h1>Members</h1>
    <table>
        <tr>
            <th>Name</th>
            <th>Occupation</th>
            <th></th>
        </tr>';

    foreach ($members as $member) {
        echo '<tr><td>' .
            $member['firstname'] . ' ' . $member['surname'] . '</td>' .
            '<td>' . $member['occupation'] . '</td>' .
            '<td><a href="view-profile.php?email=' . $member['email'] . '"<button>View</button></td>' .
            '</tr>';
    }

    '</table>';

}
?>


<!-- PDFS ACCOCIATED WITH SITE -->
<?php 
    foreach($pdfs as $pdf) {
        echo '<embed src="../pdf/' . $pdf['name'] . '" />';
        echo $pdf['title'] . '<br>';
        // echo $pdf['title'];
    }
?>
</body>

</html>
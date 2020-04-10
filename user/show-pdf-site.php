<?php

session_start();
require_once '../functions.php';
require_once '../config.php';

$pdfs = getSiteDocuments($_GET['siteid']);
$site = getSiteByCode($_GET['site_code']);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
<h1><?php echo $site['code']; ?></h1>
<h3>Address: <?php echo $site['address']; ?></h3>
<?php 
    foreach($pdfs as $pdf) {
        echo '<embed src="../pdf/' . $pdf['name'] . '" />';
        echo $pdf['title'] . '<br>';
        // echo $pdf['title'];
    }
?>
  
</body>
</html>
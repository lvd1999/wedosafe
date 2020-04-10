<?php
session_start();
require_once 'functions.php';
require_once 'config.php';

$pdfs = readDocuments($_SESSION['user']['id']);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF History</title>
</head>
<body>
<button><a href="welcome.php">Back</a></button> <br>
    <?php
        foreach($pdfs as $pdf) {
            echo '<embed src="pdf/' . $pdf['name'] . '" />';
            echo $pdf['title'] .'('.$pdf['company_name'].')'.'<br>';
        }
    ?>
</body>
</html>
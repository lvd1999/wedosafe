<?php
session_start();
require_once '../functions.php';
require_once '../config.php';

$pdfs = get_pdf($_SESSION['admin']['id']);
?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Storage</title>
</head>

<body>
    <a href="admin-dashboard.php"><button>Dashboard</button></a>
    <a href="upload-pdf.php"><button>Upload PDF</button></a>
    <a href="send-pdf.php"><button>Send..</button></a> <br>

    <?php 
        foreach($pdfs as $pdf) {
            echo '<embed src="../pdf/' . $pdf['name'] . '" width="400px" height="400px" />';
            echo $pdf['title'] . '<br>';
        }
    ?>
</body>

</html>
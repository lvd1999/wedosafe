<?php
session_start();
require_once '../functions.php';
require_once '../config.php';

$pdfs = pdfByAdmin($_SESSION['admin']['id']);
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
    <a href="send-pdf-screen1.php"><button>Send to member</button></a> 
    <a href="send-pdf-site1.php"><button>Send to site</button></a> <br>

    <h1>Your PDFs</h1>
    <?php 
        foreach($pdfs as $pdf) {
            echo '<embed src="../pdf/' . $pdf['name'] . '" />';
            echo $pdf['title'] . '<br>';
        }
    ?>
</body>

</html>
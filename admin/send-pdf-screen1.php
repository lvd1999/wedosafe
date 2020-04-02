<?php
session_start();
require_once '../functions.php';
require_once '../config.php';
$pdfs = pdfByAdmin($_SESSION['admin']['id']);

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $_SESSION['selected-pdfs'] = $_POST['pdf'];
    header("Location: send-pdf-screen2.php");
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send PDF screen1</title>
</head>
<body>
    <h3>Select PDF</h3>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
    <?php
        foreach($pdfs as $pdf) {
            echo '<input type="checkbox" id="vehicle1" name="pdf[]" value="'.$pdf['id'].'">
            <label for="vehicle1">'.$pdf['title'].'</label><br>';
        }
    ?>
    
    <button type="submit">Next</button>
    </form>
</body>
</html>
<?php
session_start();
require_once '../functions.php';
require_once '../config.php';
$pdfs = pdfByAdmin($_SESSION['admin']['id']);

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $_SESSION['selected-pdfs'] = $_POST['pdf'];
    header("Location: send-pdf-site2.php");
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    
    <title>Send PDF screen1</title>
</head>
<body>
    

    <h1>Select PDF</h1>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
    <?php
        foreach($pdfs as $pdf) {
            echo '<input type="checkbox" id="site" name="pdf[]" value="'.$pdf['id'].'">
            <label for="site">'.$pdf['title'].'</label><br>';
        }
    ?>
    
    <button type="submit" id="checkBtn">Next</button>
    </form>
</body>
</html>

        <!-- check at least one box -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#checkBtn').click(function() {
        checked = $("input[type=checkbox]:checked").length;

        if(!checked) {
            alert("You must check at least one checkbox.");
            return false;
        }

        });
    });
    </script>
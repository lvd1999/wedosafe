<?php
session_start();
require_once '../functions.php';
require_once '../config.php';

$pdf_id = $_GET['id'];
$pdf = getPDFById($pdf_id);
$user_id = $_SESSION['user']['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare an insert statement
    $sql = "UPDATE pdf_status SET status='read' WHERE pdf_id=? AND user_id=?";
    $stmt = $pdo->prepare($sql);

    // Attempt to execute the prepared statement
    if ($stmt->execute([$pdf_id, $user_id])) {
        // Redirect to welcome page
        echo $sql;
        // header("location: ../welcome.php");
    } else {
        echo "Something went wrong. Please try again later.";
    }

    // Close statement
    unset($stmt);
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Read PDF</title>
</head>
<body>
<h1><?php echo $pdf_id;?></h1>
<h1><?php echo $user_id;?></h1>
<div class="embed-responsive embed-responsive-16by9">
<?php
echo '<embed src="../pdf/' . $pdf['name'] . '" width="400px" height="400px" />'
?>
</div>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
<input type="checkbox" name="c" title="Please read Terms and Condition" required>I had read this document and agreed to the Terms and Condition</input> <br>
<input type="submit" value="Confirm"> </input>
</form>
</body>


</html>
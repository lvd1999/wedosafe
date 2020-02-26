<?php
session_start();
require_once "../config.php";
require_once '../functions.php';
$_SESSION["loggedin"] = true;
$email = $_SESSION['email'];
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>screen 3</title>
</head>

<body>
    <h1>You are registered, <?php echo $_SESSION['firstname']; ?> . <br>
        If you wish to upload your certificates, continue</h1>
    <!-- <a href="safepass-front.php"><img src="../images/safe-pass.png" width='300' height='300'></a> -->

    <?php
if (isset($_SESSION['safepass'])) {
    echo '<button type="button" class="btn btn-success btn-lg btn-block">Safe Pass</button>';
} else {
    echo '<a href="safepass-front.php" class="text-decoration-none"><button type="button" class="btn btn-primary btn-lg btn-block">Safe Pass</button></a>';
}
?>

<!-- <a href="safepass-front.php" class="text-decoration-none"><button type="button" class="btn btn-primary btn-lg btn-block">Safe Pass</button></a> -->

    <!-- <?php
if (isset($_SESSION['cert'])) {
    foreach ($_SESSION["cert"] as $key => $val) {
        echo '<button type="button" class="btn btn-success btn-lg btn-block">' . $val . '</button>';
    }
}
?> -->

    <?php
    $certs = get_cert($email);

    if (count($certs) > 0) {
        foreach($certs as $cert) {
            echo '<button type="button" class="btn btn-success btn-lg btn-block">' . $cert['type'] . '</button>';
        }
    }      
?>







    <a href="add-other.php" class="text-decoration-none"><button type="button"
            class="btn btn-secondary btn-lg btn-block">Add Other</button></a>
    <a href="../profile.php">Skip</a>
</body>

</html>
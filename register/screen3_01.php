<?php
session_start();
require_once "../config.php";
require_once '../functions.php';

$_SESSION["loggedin"] = true;
$email = $_SESSION['email'];
$certs = get_cert($email);

?>
<html lang="en">

<head>
<title>Add Certificates</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="../images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../css/util.css">
	<link rel="stylesheet" type="text/css" href="../css/main.css">
<!--===============================================================================================-->
</head>

<body>
    
    <?php
if (isset($_SESSION['safepass'])) {
    echo '<button type="button" class="btn btn-success btn-lg btn-block">Safe Pass</button>';
} else {
    echo '<a href="safepass-front.php" class="text-decoration-none"><button type="button" class="btn btn-primary btn-lg btn-block">Safe Pass</button></a>';
}
?>



    

    <?php
    if (count($certs) > 0) {
        foreach($certs as $cert) {
            echo '<button type="button" class="btn btn-success btn-lg btn-block">' . $cert['type'] . '</button>';
        }
    }      
?>

    <a href="add-other.php" class="text-decoration-none"><button type="button"
            class="btn btn-secondary btn-lg btn-block">Add Other</button></a>
    <a href="../profile/profile.php">Skip</a>
</body>

</html>
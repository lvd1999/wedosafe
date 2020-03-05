<?php
session_start();
require_once '../functions.php';
require_once '../config.php';
//variables
$email = $_SESSION['email'];
$safepass = get_safepass($email);
$certs = get_cert($email);

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit certificates</title>
</head>

<body>
<a href='profile.php'><button>Back</button></a>
    <h3>Safe Pass</h3>
    <?php
if (empty($safepass)) {
    echo "No Safe Pass <br>
    <a href='add-safepass-front.php'><button>Add</button></a> <br>
    ";
} else {
    echo '<a href="delete-cert.php?name=' . $safepass['cert_image_front'] . '">Delete</a>';
    echo '<img src="../certificates/' . $safepass['cert_image_front'] . '" width="300" height = "300">';
    echo '<img src="../certificates/' . $safepass['cert_image_back'] . '" width="300" height = "300">';
}
?>
    <h3>Other Certificates</h3>

    <a href='add-certificate.php'><button>Add</button></a> <br>
    <?php
if (count($certs) > 0) {
    foreach ($certs as $cert) {
        echo '<a href="delete-cert.php?name=' . $cert['cert_image_front'] . '">Delete</a>';
        echo '<img src="../certificates/' . $cert['cert_image_front'] . '" width="300" height = "300">';
        echo $cert['type'] . '<br>';
    }
} else {
    echo 'No other certificates';
}
?>
</body>

</html>
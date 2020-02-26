<?php
session_start();
require_once 'functions.php';
require_once 'config.php';

$email = $_SESSION['email'];
$userDetail = get_details($email);
$safepass = get_safepass($email);

//profile image
if ($userDetail['profile_image']) {
    $profile_image = $userDetail['profile_image'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <title>Profile</title>
</head>

<body>
    <a href="welcome.php" class="btn">Back to Home</a>
    <a href="edit-profile.php" class="btn">Edit Profile</a>

        <div class="hovereffect text-center">

            <img src="<?php echo "profile-images/" . $userDetail['profile_image']; ?> " width='300' height='300'>
            
        </div>
        
    <p>UserName: <?php echo $userDetail['email']; ?></p>
    <p>First Name: <?php echo $userDetail['firstname']; ?></p>
    <p>SurName: <?php echo $userDetail['surname']; ?></p>
    <p>Date of Birth: <?php echo $userDetail['dob']; ?></p>
    <p>Sex: <?php echo $userDetail['sex']; ?></p>
    <p>Occupation: <?php echo $userDetail['occupation']; ?></p>
    <p>Position: <?php echo $userDetail['position']; ?></p>
    <p>English: <?php echo $userDetail['english']; ?></p>
    <p>Nationality: <?php echo $userDetail['nationality']; ?></p>
    <p>Phone: <?php echo $userDetail['phone']; ?></p>

    <!-- print certificates -->
    <h1>Certificates</h1>
    <h3>Safe Pass</h3>
    <?php
if (empty($safepass)) {
    echo "<h5>No Safe Pass</h5> <br>
    <a href='add-safepass.php'> Add Save Pass </a>";
} else {
    echo '<img src="certificates/' . $safepass['cert_image_front'] . '" width="300" height = "300">';
    echo '<img src="certificates/' . $safepass['cert_image_back'] . '" width="300" height = "300">';
}
?>
    <h3>Other Certificates</h3>

    <?php

$certs = get_cert($email);

if (count($certs) > 0) {
    foreach($certs as $cert) {
        echo $cert['type'] . '<br>';
    }
}      
?>

</body>

</html>

<script src="script.js"></script>
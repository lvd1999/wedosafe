<?php
session_start();
include_once 'functions.php';
include_once 'config.php';

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

    <div class="profile-img">
        <div class="hovereffect text-center">

            <img src="<?php echo "profile-images/" . $userDetail['profile_image']; ?> " width='300' height='300'
                onClick='triggerClick()' id='profileDisplay' class='rounded mx-auto d-block'>
            <div class="overlay d-none">
                <a class="info" onClick="triggerClick()">Update profile picture</a>
            </div>
        </div>
        <form action="uploadImage.php" method="post" enctype="multipart/form-data" id="upload_image">
            <?php if (!empty($msg)): ?>
            <div class="alert <?php echo $msg_class ?>" role="alert">
                <?php echo $$msg; ?>
            </div>
            <?php endif;?>
            <input type="file" name="profileImage" onChange="displayImage(this)" id="profileImage" class="form-control"
                style="display: none">
            <!-- <input type="file" accept="image/*" capture="camera" />         for mobile -->
            <button type="submit" name="save_profile" class="btn btn-primary btn-block" id="imageSubmit">Save
                Image</button>
        </form>
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

    <h1>Safe Pass</h1>

    <?php
if (empty($safepass)) {
    echo '<h4>No Safe Pass</h4>';
} else {
    echo '<img src="certificates/' . $safepass['cert_image_front'] . '" width="300" height = "300">';
    echo '<img src="certificates/' . $safepass['cert_image_back'] . '" width="300" height = "300">';
}
?>
</body>

</html>

<script src="script.js"></script>
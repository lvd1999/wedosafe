<?php
session_start();
require_once "../config.php";
$email = $_SESSION['email'];
$msg = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //for image
    $safepassImageName = time() . '-' . $_FILES['safepass']['name'];
    $target_dir = "../certificates/";
    $target_file = $target_dir . basename($safepassImageName);

    if ($_FILES["safepass"]["error"] == 4) {
        $msg = "Please upload image";
    }

    // validate image size. Size is calculated in Bytes
    if ($_FILES['safepass']['size'] > 200000) {
        $msg = "Image size should not be greated than 200Kb";
    }
    // check if file exists
    if (file_exists($target_file)) {
        $msg = "File already exists";
    }
    // Upload image only if no errors
    if (empty($error)) {
        move_uploaded_file($_FILES["safepass"]["tmp_name"], $target_file);
    }

    // Redirect to screen 3
    if (empty($msg)) {
        $_SESSION['safepass-front'] = $safepassImageName;
        header("location: safepass-back.php");
    }

}
?>



<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <title>safepass upload - front</title>
</head>

<body>
    <h1>Safe Pass - front </h1>

    <img src="../images/upload.png" width='500' height='300' onClick='triggerClick()' id='profileDisplay'>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">

        <div class="form-group <?php echo (!empty($msg)) ? 'has-error' : ''; ?>">
            <input type="file" name="safepass" onChange="displayImage(this)" id="profileImage" class="form-control">
            <span class="help-block"><?php echo $msg; ?></span>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Next">
        </div>
    </form>
</body>

</html>

<script src="../script.js"></script>
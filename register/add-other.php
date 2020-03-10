<?php
session_start();
require_once "../config.php";
$email = $_SESSION['email'];
$reg_err = '';
$cert = $reg_num = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //for image
    $safepassImageName = time() . '-' . $_FILES['safepass']['name'];
    $target_dir = "../certificates/";
    $target_file = $target_dir . basename($safepassImageName);

    // validate image size. Size is calculated in Bytes
    if ($_FILES['safepass']['size'] > 200000) {
        $msg = "Image size should not be greated than 200Kb";
        $msg_class = "alert-danger";
    }
    // check if file exists
    if (file_exists($target_file)) {
        $msg = "File already exists";
        $msg_class = "alert-danger";
    }
    // Upload image only if no errors
    if (empty($error)) {
        move_uploaded_file($_FILES["safepass"]["tmp_name"], $target_file);
    }

    //validate user input registration number & cert type
    if ($_POST['cert-type'] == 'default') {
        $reg_err = "Please select certification type";
    } else {
        $cert = $_POST['cert-type'];
    }
    if (empty(trim($_POST["reg_num"]))) {
        $reg_err = "Please Enter Registration Number";
    } else {
        $reg_num = trim($_POST["reg_num"]);
    }

    // $sql = "INSERT INTO certificates (email, type, cert_image_front, cert_image_back, reg_number) VALUES ('$email', 'safepass', :safepass_front, :safepass_back, :reg_num)";
    $sql = "INSERT INTO certificates (email, type, cert_image_front, reg_number) VALUES ('$email', '$cert', :safepass_front, :reg_num)";

    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":safepass_front", $param_safepass_front, PDO::PARAM_STR);
        // $stmt->bindParam(":safepass_back", $param_safepass_back, PDO::PARAM_STR);
        $stmt->bindParam(":reg_num", $param_reg_num, PDO::PARAM_STR);

        //set parameters
        $param_safepass_front = $safepassImageName;
        // $param_safepass_back = $_SESSION['safepass-back'];
        $param_reg_num = $reg_num;

        if (empty($reg_err)) {
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to screen 3
                $_SESSION['cert'][] = $cert;
                header("location: screen3.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
        // Close statement
        unset($stmt);
    }

}
?>



<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <title>safepass upload - front</title>
</head>

<body>
    <h1>Other Certificates</h1>




    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div class="form-group <?php echo (!empty($cert_err)) ? 'has-error' : ''; ?>">
            <select class="custom-select form-control" name="cert-type">
                <option selected value="default">Select...</option>
                <option value="CSSR">CSSR</option>
                <option value="First Aid">First Aid</option>
                <option value="Driving Manual">Driving Manual</option>
            </select>
        </div>

        <input type="file" name="safepass" onChange="displayImage(this)" id="profileImage" class="form-control d-none">
        <img src="../images/upload.png" width='500' height='300' onClick='triggerClick()' id='profileDisplay'>

        <div class="form-group <?php echo (!empty($reg_err)) ? 'has-error' : ''; ?>">
            <label>Registration Number: </label>
            <input type="text" name="reg_num" class="form-control">
            <span class="help-block"><?php echo $reg_err; ?></span>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Finish">
        </div>
    </form>
</body>

</html>

<script src="../script.js"></script>
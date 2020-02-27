<?php
session_start();
require_once "../config.php";
require_once '../functions.php';

$_SESSION["loggedin"] = true;
$email = $_SESSION['email'];
$certs = get_cert($email);

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
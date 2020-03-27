<?php
session_start();
require_once "../config.php";
require_once '../functions.php';

$_SESSION["loggedin"] = true;
$email = $_SESSION['email'];
$certs = get_cert($email);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //for image
    $safepassImageName = time() . '-' . $_FILES['safepass']['name'];
    $target_dir = "../certificates/";
    $target_file = $target_dir . basename($safepassImageName);

    // validate image size. Size is calculated in Bytes
    if ($_FILES['safepass']['size'] > 200000) {
        $msg = "Image size should not be greated than 200Kb";
    }
    // check if file exists
    if (file_exists($target_file)) {
        $msg = "File already exists";
    }

    //validate user input registration number & cert type
    if ($_POST['cert-type'] == 'default') {
        $msg = "Please select certification type";
    } else {
        $cert = $_POST['cert-type'];
    }

    // if(empty($_POST['reg_num'])) {
    //     $reg_num = '';
    // } else {
    //     $reg_num = $_POST['reg_num'];
    // }
    $reg_num = $_POST['reg_num'];

    if (empty($msg)) {
        $sql = "INSERT INTO certificates (email, type, cert_image_front, reg_number) VALUES ('$email', '$cert', :safepass_front, :reg_num)";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":safepass_front", $param_safepass_front, PDO::PARAM_STR);
            // $stmt->bindParam(":safepass_back", $param_safepass_back, PDO::PARAM_STR);
            $stmt->bindParam(":reg_num", $param_reg_num, PDO::PARAM_STR);

            //set parameters
            $param_safepass_front = $safepassImageName;
            // $param_safepass_back = $_SESSION['safepass-back'];
            $param_reg_num = $reg_num;

            move_uploaded_file($_FILES["safepass"]["tmp_name"], $target_file);
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to profile page
                header("location: edit-certificates.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
        // Close statement
        unset($stmt);
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Screen 3</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="../images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../css/util.css">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <!--===============================================================================================-->


</head>

<body>

    <div class="limiter">
        <div class="container-login100" style="background-image: url('../images/bg-02.jpg');">
            <div class="wrap-login104" style="width: 600px; height: fit-content;">
                <form class="login100-form validate-form" id="form" action="add-certificate.php" method="post"
                    enctype="multipart/form-data">
                    <span class="login100-form-title p-b-34 p-t-27">
                        Certificates
                    </span>
                    <ul class="list-group">
                        <?php
if (isset($_SESSION['safepass'])) {
    echo '<li class="list-group-item d-flex justify-content-between align-items-center">
        <button type="button" class="btn btn-lg btn-warning btn-block"
                style="width: 200px;">Safe Pass</button>
                <span class="badge badge-success badge-pill">✔</span>  
    </li>';
} else {
    echo '<li class="list-group-item d-flex justify-content-between align-items-center">
    <a href="safepass-front.php"><button type="button" class="btn btn-lg btn-warning btn-block"
             style="width: 200px;">Safe Pass</button></a>
    <a href="safepass-front.php" class="btn btn-danger" >
        <i class="fa fa-plus" aria-hidden="true"></i>
    </a>
</li>';
}

//print each other certificates before add new button
if (count($certs) > 0) {
    foreach ($certs as $cert) {
        echo '<li class="list-group-item d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-lg btn-warning btn-block"
                    style="width: 200px;">' . $cert['type'] . '</button>
                    <span class="badge badge-success badge-pill">✔</span>
        </li>';
    }
}

?>
                        <!-- static add other button -->
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="add-other.php"><button type="button" class="btn btn-lg btn-info btn-block"
                                     style="width: 200px;">Add Others</button></a>
                            <a href="add-other.php" class="btn btn-danger" data-toggle="collapse" data-target="#multiCollapse1"
                                aria-expanded="false" aria-controls="multiCollapse1">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </a>
                        </li>


                        
                    </ul>

                    <hr style="border: 1px solid black;">

                    <div class="container-login100-form-btn col">
                        <div class="row">
                            <button class="login100-form-btn">
                                <a href="screen2.php" style="color:black;">
                                    Back
                                </a>
                            </button>
                            <button class="login100-form-btn">
                                <a href="../profile/profile.php" style="color:black;">
                                    Finish
                                </a>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div id="dropDownSelect1"></div>

    <!-- scripts -->
    <script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="../vendor/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="../vendor/jquery-validation/dist/additional-methods.min.js"></script>
    <script src="../vendor/bootstrap/js/popper.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../vendor/select2/select2.min.js"></script>
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/jquery-steps/jquery.steps.min.js"></script>
    <script src="../js/main.js"></script>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {

                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.image-upload-wrap').hide();

                    $('.file-upload-image').attr('src', e.target.result);
                    $('.file-upload-content').show();

                    $('.image-title').html(input.files[0].name);
                };

                reader.readAsDataURL(input.files[0]);

            } else {
                removeUpload();
            }
        }

        function removeUpload() {
            $('.file-upload-input').replaceWith($('.file-upload-input').clone());
            $('.file-upload-content').hide();
            $('.image-upload-wrap').show();
        }
        $('.image-upload-wrap').bind('dragover', function () {
            $('.image-upload-wrap').addClass('image-dropping');
        });
        $('.image-upload-wrap').bind('dragleave', function () {
            $('.image-upload-wrap').removeClass('image-dropping');
        });
    </script>

</body>

</html>
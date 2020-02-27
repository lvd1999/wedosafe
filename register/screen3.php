<?php
session_start();
require_once "../config.php";
require_once '../functions.php';

$_SESSION["loggedin"] = true;
$email = $_SESSION['email'];
$certs = get_cert($email);
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
        <div class="container-login100" style="background-image: url('../images/bg-01.jpg');">
            <div class="wrap-login100" style="width: 600px; height: fit-content;">
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
                style="width: 180%;">Safe Pass</button>
        <span class="badge badge-success badge-pill">✔</span>
    </li>';
} else {
    echo '<li class="list-group-item d-flex justify-content-between align-items-center">
    <a href="#"><button type="button" class="btn btn-lg btn-warning btn-block"
            data-toggle="collapse" data-target="#multiCollapse1" aria-expanded="false"
            aria-controls="multiCollapse1" style="width: 160%;">Safe Pass</button></a>
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
                    style="width: 180%;">' . $cert['type'] . '</button>
            <span class="badge badge-success badge-pill">✔</span>
        </li>';
    }
}

?>
                        <!-- static add other button -->
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="#"><button type="button" class="btn btn-lg btn-info btn-block"
                                    data-toggle="collapse" data-target="#multiCollapse1" aria-expanded="false"
                                    aria-controls="multiCollapse1" style="width: 160%;">Add Others</button></a>
                            <a href="#" class="btn btn-danger" data-toggle="collapse" data-target="#multiCollapse1"
                                aria-expanded="false" aria-controls="multiCollapse1">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </a>
                        </li>


                        <div class="row">
                            <div class="col">
                                <div class="collapse multi-collapse" id="multiCollapse1">
                                    <div class="card card-body">
                                        <div id="example-async">
                                            <!-- First Step -->
                                            <h3>
                                                Step 1
                                            </h3>
                                            <section style="height: 300px;">
                                                <h2>Step 1 : Choose type of Certication</h2>
                                                <div class="form-group md-form">
                                                    <select id="input100" class="form-control" data-size="1"
                                                        name="cert-type">
                                                        <option selected>Type:</option>
                                                        <option>CSSR PASS</option>
                                                        <option>SKILLED OPERATOR CERT</option>
                                                        <option>MACHINE OPERATOR CERT</option>
                                                        <option>FIRST AID CERT</option>
                                                        <option>MANUAL HANDLING TRAINING</option>
                                                        <option>MEWP OPERATOR</option>
                                                        <option>FIRST AID COURSE</option>
                                                        <option>OTHER</option>
                                                    </select>
                                                </div>
                                            </section>

                                            <!-- Second Step -->
                                            <h3>
                                                Step 2
                                            </h3>
                                            <section style="height: 450px;">
                                                <h2>Step 2 : Upload Certication document</h2>
                                                <div class="form-group" style="width: 95%; display: inline-flex;">
                                                    <script class="jsbin"
                                                        src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js">
                                                    </script>
                                                    <div class="file-upload">
                                                        <div class="image-upload-wrap">
                                                            <input class="file-upload-input" type='file'
                                                                onchange="readURL(this);" accept="image/*"
                                                                name="safepass" />
                                                            <div class="drag-text">
                                                                <h2>Drag and drop a file or select add Image</h2>
                                                            </div>
                                                        </div>
                                                        <div class="file-upload-content">
                                                            <img class="file-upload-image" src="#" alt="your image" />
                                                            <div class="image-title-wrap">
                                                                <button type="button" onclick="removeUpload()"
                                                                    class="remove-image">Remove <span
                                                                        class="image-title">Uploaded
                                                                        Image</span></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>

                                            <!-- Third Step -->

                                            <h3>
                                                Step 3
                                            </h3>
                                            <section style="height: 200px;">
                                                <h2>Step 3 : Enter register Number</h2>
                                                <div class="form-group">
                                                    <input type="text" name="reg_num" id="registerNumber"
                                                        placeholder="registerNumber if required" />
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </ul>

                    <hr>

                    <div class="container-login100-form-btn col">
                        <div class="row">
                            <div class="col-sm-4 col-lg-6">
                                <button class="login100-form-btn">
                                    <a href="screen2.php">
                                        Back
                                    </a>
                                </button>
                            </div>
                            <div class="col-sm-4 col-lg-6">
                                <button class="login100-form-btn">
                                    <a href="../profile/profile.php">
                                        Finish
                                    </a>
                                </button>
                            </div>
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
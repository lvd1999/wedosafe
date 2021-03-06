<?php
session_start();
require_once "../config.php";
$email = $_SESSION['email'];

$cert = $reg_num = $msg = '';

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



<html lang="en">

<head>
<title>Safe Pass upload - Front</title>
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
<div class="limiter">
		<div class="container-login100" style="background-image: url('../images/bg-01.jpg');">
			<div class="wrap-login105"  style="width: fit-content; height: fit-content;">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
					<span class="login100-form-title p-b-34 p-t-27">
						Add other certificate
					</span>

                    <div class="form-group <?php echo (!empty($cert_err)) ? 'has-error' : ''; ?>">
        <select class="custom-select form-control" name="cert-type">
            <option selected value="default">Select...</option>
            <option value="CSSR">CSSR</option>
            <option value="First Aid">First Aid</option>
            <option value="Driving Manual">Driving Manual</option>
        </select>
    </div>

                    <div class="form-group">
                        <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
                        <div class="file-upload">

                        <div class="image-upload-wrap">
                            <input class="file-upload-input" type='file' onchange="readURL(this);" accept="image/*" name="safepass"/>
                            <div class="drag-text">
                            <h3>Drag and drop a file or select add Image</h3>
                            </div>
                        </div>
                        <div class="file-upload-content">
                            <img class="file-upload-image" src="#" alt="your image" />
                            <div class="image-title-wrap">
                            <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                            </div>
                        </div>
                        </div>

                    </div>

                    <hr style="border: 1px solid black;">

                    <div class="wrap-input100 validate-input" data-validate = "Registration Number">
						<input class="input100" type="number" name="reg_num" placeholder="Registration Number">
						<span class="focus-input100" data-placeholder="&#xf188;"></span>
                        <p class="text-danger"><?php echo $msg; ?></p>
                    </div>

                    <hr style="border: 1px solid black;">

                    <div class="container-login100-form-btn col">
                        <div class="row">
                            <div class="col-sm-4 col-lg-6">
                                <button class="login100-form-btn">
                                    <a href="profile.php" style="color: black;">
                                        Skip
                                    </a>
                                </button>
                            </div>
                            <div class="col-sm-4 col-lg-6">
                                <button class="login100-form-btn" type="submit">
                                       Done
                                </button>
                            </div>
                        </div>

                    </div>
				</form>
			</div>
		</div>
	</div>


	<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

    <script>
        function readURL(input) {
  if (input.files && input.files[0]) {

    var reader = new FileReader();

    reader.onload = function(e) {
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

<script src="../script.js"></script>
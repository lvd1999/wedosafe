<?php
session_start();
require_once '../functions.php';
require_once '../config.php';
//variables
$email = $_SESSION['email'];
$safepass = get_safepass($email);
$certs = get_cert($email);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Cert</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="../images/icons/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="../vendor/daterangepicker/daterangepicker.css">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="../vendor/acc-wizard-master/release/acc-wizard.min.js"></script>
    
    <link rel="stylesheet" href="../css/main.css">

    <!--============================================================================= ==================-->

</head>

<body>
<div class="limiter">
    <div class="container-login100" style="background-image: url('../images/bg-01.jpg');">
        <div class="wrap-login105">
            <form class="login100-form form-horizontal">
                <div class="container-login100-form-btn1">
                            <span class="login100-form-title1">Certification</span>
                </div>
                <hr>
                <fieldset>
                    <div class="form-group row">
                        <label for="cert" class="form-label" >Safe Pass</label>
                                                    <?php
if (empty($safepass)) {
    echo '<a href="add-safepass-front.php" class="btn btn-warning a-btn-slide-text">
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                            <span><strong>Add</strong></span>
                                        </a>';
} else {
    echo '<img src="../certificates/' . $safepass['cert_image_front'] . '" alt="" id="certImg2"><img src="../certificates/' . $safepass['cert_image_back'] . '" alt="" id="certImg2">

                                            <div id="delete">
                                                <a href="delete-cert.php?name=' . $safepass['cert_image_front'] . '" class="btn btn-danger a-btn-slide-text">
                                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                                     <span><strong>Delete</strong></span>
                                                 </a>

                                            </div>';
}
?>


                                                    <div id="expire" style="display: none;">
                                                        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <input type="text" class="form-control" id="added_date"
                                                                    name="added_date" readonly style="display: none;" />
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label>Expired Date</label>
                                                                <input type="date" class="form-control" id="end_date"
                                                                    name="end_date" onchange="cal()" />
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Warranty</label>
                                                                <input type="text" class="form-control" id="calc"
                                                                    name="calc" value="" readonly />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>

                                            <fieldset>
                                            <div class="form-group row">
                                            <div class="container-login100-form-btn1">
                                                <span class="login100-form-title1">Other</span>
                                            </div>
                                            <hr>
                                                <?php
                                            if (count($certs) > 0) {
                                                foreach ($certs as $cert) {
                                            echo '<div class="form-group">
                                            <label for="cert" class="form-label" style=" width: fit-content;">' . $cert['type'] . '</label>
                                            <img src="../certificates/' . $cert['cert_image_front'] . '" alt="" id="certImg2">

                                              <div id="delete2">
                                                  <a href="delete-cert.php?name=' . $cert['cert_image_front'] . '" class="btn btn-danger a-btn-slide-text">
                                                      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                                       <span><strong>Delete</strong></span>
                                                   </a>
                                              </div>
                                          </div>';
    }
} else {
    echo "No other certificates";
}
?>
                                                <div id="add2" style="display: block;">
                                                    <a href="add-certificate.php"
                                                        class="btn btn-warning a-btn-slide-text">
                                                        <span class="glyphicon glyphicon-plus"
                                                            aria-hidden="true"></span>
                                                        <span><strong>Add</strong></span>
                                                    </a>
                                                </div>
                                            </div>
                                            </fieldset>
                                            <button type="button" class="btn btn-success"
                                                    style="float: right;"><a href="profile.php">Done</a></button>
                                        </form>
                                    </div>
                                </div>
                            </div>

    <div id="dropDownSelect1"></div>

    <script src="../vendor/acc-wizard-master/release/acc-wizard.min.js"></script>
    <script src="../vendor/bootstrap/js/popper.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../vendor/select2/select2.min.js"></script>
    <script src="../vendor/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="../vendor/jquery-validation/dist/additional-methods.min.js"></script>
    <script src="../vendor/minimalist-picker/dobpicker.js"></script>
    <script src="../vendor/daterangepicker/moment.min.js"></script>
    <script src="../js/combodate.js"></script>
    <script src="../vendor/jquery-steps/jquery.steps.min.js"></script>

    <script>
        var todaydate = new Date();
        var day = todaydate.getDate();
        var month = todaydate.getMonth() + 1;
        var year = todaydate.getFullYear();
        var datestring = month + "/" + day + "/" + year;

        document.getElementById("added_date").value = datestring;

        function GetDays() {
            var dropdt = new Date(document.getElementById("end_date").value);
            var pickdt = new Date(document.getElementById("added_date").value);
            var dateDifference = Math.floor((Date.UTC(dropdt.getFullYear(), dropdt.getMonth(), dropdt.getDate()) - Date
                .UTC(pickdt.getFullYear(), pickdt.getMonth(), pickdt.getDate())) / (1000 * 60 * 60 * 24));

            return dateDifference;
        }

        function change() {
            var dropdt = new Date(document.getElementById("end_date").value);
            var x = dropdt - todaydate;
            if (x <= 0) {
                alert("already expired");
                document.getElementById("calc").style.color = "red";
            } else {
                document.getElementById("calc").style.color = "green";
            }

        }

        function cal() {
            if (document.getElementById("end_date")) {
                document.getElementById("calc").value = GetDays();
                change();
            }
        }
    </script>
</body>

</html>
<?php
session_start();
require_once '../functions.php';
require_once '../config.php';

//get details
$email = $_SESSION['email'];
$userDetail = get_details($email);
$safepass = get_safepass($email);
$certs = get_cert($email);

//profile image
if ($userDetail['profile_image']) {
    $profile_image = $userDetail['profile_image'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profile</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="../images/icons/favicon.ico" />

    <link rel="stylesheet" type="text/css" href="../vendor/daterangepicker/daterangepicker.css">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="../vendor/acc-wizard-master/release/acc-wizard.min.js"></script>

    <link rel="stylesheet" href="../css/profile.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <!--============================================================================= ==================-->

</head>

<body onload="javascipt:calc()">
    <div class="container-login100" style="background-image: url('../images/bg-01.jpg');">
        <div class="main">
            <div class="wrap-login100">
                <div class="container" id="display">
                    <button class="au-btn btn btn-warning btn-sm"><a href="../welcome.php">Back</a></button>
                    <span class="login100-form-logo float-right">
                        <div class="box1">
                            <img src="<?php echo "../profile-images/" . $userDetail['profile_image']; ?> "
                                id="profileDisplay">
                        </div>
                    </span>
                    <div class="acc-wizard">
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default active">
                                <div class="panel-heading" id="headingOne">
                                    <h3>
                                        <a href="edit-profile.php"><button type="button"
                                                class="btn btn-lg btn-warning btn-block"
                                                style="width: 180px; margin-left: 650px;">Edit Profile</button></a>
                                        <a href="#collapseOne" data-toggle="collapse" data-parent="#accordion">Basic
                                            infomation</a>

                                    </h3>
                                </div>

                                <div id="collapseOne" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <form method="POST" id="myeditable">
                                            <fieldset>
                                                <div class="form-row">
                                                    <div class="form-group">
                                                        <span>First Name : </span>
                                                        <?php echo $userDetail['firstname']; ?>
                                                    </div>

                                                    <div class="form-group">
                                                        <span>Surname : </span>
                                                        <?php echo $userDetail['surname']; ?>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group">
                                                        <span>Email : </span>
                                                        <?php echo $userDetail['email']; ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <span>Phone: </span>
                                                        <?php echo $userDetail['phone']; ?>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group">
                                                        <div class="form-date">
                                                            <label for="birth_date" class="form-label">Date of birth
                                                                :</label>
                                                            <div class="form-date-item">
                                                                <?php echo $userDetail['dob']; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="form-radio">
                                                            <label for="gender">Gender: </label>
                                                            <div class="form-flex">
                                                                <?php
if ($userDetail['sex'] == 'male') {
    echo '<label for="male" style="background-color: white;"><img
                                src="../images/icons/icon-male.png" alt="Male"></label>';
} elseif ($userDetail['sex'] == 'female') {
    echo '<label for="female" style="background-color: white;"><img
                                src="../images/icons/icon-female.png" alt="Female"></label>';
}
?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group">
                                                        <label for="options" class="form-label">Occupation :</label>
                                                        <?php echo $userDetail['occupation']; ?>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="options" class="form-label">Position :</label>
                                                        <?php echo $userDetail['position']; ?>
                                                    </div>

                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group">
                                                        <label for="country" class="form-label">Nationality :</label>
                                                        <?php echo $userDetail['nationality']; ?>
                                                    </div>
                                                </div>

                                            </fieldset>

                                            <fieldset>
                                                <div class="form-group">
                                                    <h3>Certication</h3>
                                                    <a href="edit-certificates.php"><button type="button"
                                                            class="btn btn-lg btn-warning btn-block"
                                                            style="width: 180px; margin-left: 650px;">Edit
                                                            Cert</button></a>



                                                    <label for="cert" class="form-label">Safe Pass</label>
                                                    <?php
if (empty($safepass)) {
    echo "<h5>No Safe Pass</h5> <br>";
} else {
    //get date
    $expDate = substr($safepass['reg_number'], -4);
    $expMonth = substr($expDate, 0, 2);
    $expYear = '20' . (substr($expDate, 2, 4));

    echo '<img src="../certificates/' . $safepass['cert_image_front'] . '">' .

        '<div class="form-row">

                        <div class="form-group col-md-6">
                          <input type="text" class="form-control" id="added_date" name="added_date" readonly
                            style="display: none;" />
                        </div>

                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label>Expired Date</label>
                          <input type="date" class="form-control" id="end_date" name="end_date" value="' . $expYear . '-' . $expMonth . '-01" readonly/>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Warranty</label>
                          <input type="text" class="form-control" id="calc" name="calc" value="" readonly />
                        </div>
                      </div>
                            ';}?>
                                                </div>
                                            </fieldset>

                                            <fieldset>
                                                <div class="form-group">
                                                    <h3>Other</h3>
                                                    <?php
if (count($certs) > 0) {
    foreach ($certs as $cert) {
        echo
            '<div class="form-group col-lg-6 col-sm-10">
                        <label for="cert" class="form-label">' . $cert['type'] . '</label>
                        <img src="../certificates/' . $cert['cert_image_front'] . '" alt="" id="certImg">
                      </div>';
    }
} else {
    echo 'No other certificates';
}
?>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="dropDownSelect1"></div>


</body>

</html>

<script src="../vendor/acc-wizard-master/release/acc-wizard.min.js"></script>
<script src="../vendor/bootstrap/js/popper.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../vendor/select2/select2.min.js"></script>
<script src="../vendor/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="../vendor/jquery-validation/dist/additional-methods.min.js"></script>
<script src="..vendor/minimalist-picker/dobpicker.js"></script>
<script src="../vendor/daterangepicker/moment.min.js"></script>
<script src="../js/combodate.js"></script>
<script src="../vendor/jquery-steps/jquery.steps.min.js"></script>

<script type="text/javascript">
    var todaydate = new Date();
    var day = todaydate.getDate();
    var month = todaydate.getMonth() + 1;
    var year = todaydate.getFullYear();
    var datestring = month + "/" + day + "/" + year;

    document.getElementById("added_date").value = datestring;

    function GetDays() {
        var dropdt = new Date(document.getElementById("end_date").value);
        var pickdt = new Date(document.getElementById("added_date").value);
        var dateDifference = Math.floor((Date.UTC(dropdt.getFullYear(), dropdt.getMonth(), dropdt.getDate()) - Date.UTC(
            pickdt.getFullYear(), pickdt.getMonth(), pickdt.getDate())) / (1000 * 60 * 60 * 24));

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



    function calc() {
        if (document.getElementById("end_date")) {
            document.getElementById("calc").value = GetDays();
            change();
        }
    }
</script>
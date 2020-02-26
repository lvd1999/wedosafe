<?php
session_start();
require_once "../config.php";
//data from screen 1
$firstname = $_SESSION['details'][0];
$surname = $_SESSION['details'][1];
$email = $_SESSION['details'][2];
$phone = $_SESSION['details'][3];
$password = $_SESSION['details'][4];
$_SESSION['firstname'] = $firstname;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dob = $_POST['date'];
    $sex = $_POST['sex'];
    $occupation = $_POST['occupation'];
    $position = $_POST['position'];
    $nationality = ucwords($_POST['nationality']);
    $english = $_POST['english'];

    //for image
    $profileImageName = time() . '-' . $_FILES['profileImage']['name'];
    $target_dir = "../profile-images/";
    $target_file = $target_dir . basename($profileImageName);

    // validate image size. Size is calculated in Bytes
    if ($_FILES['profileImage']['size'] > 200000) {
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
        move_uploaded_file($_FILES["profileImage"]["tmp_name"], $target_file);
    }

    // Prepare an insert statement
    $sql = "INSERT INTO users (email, password, firstname, surname, dob, sex, occupation, position, nationality, english, phone, profile_image) VALUES (:email, :password, :firstname, :surname, :dob, :sex, :occupation, :position, :nationality, :english, :phone, :profile_image)";

    if ($stmt = $pdo->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
        $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
        $stmt->bindParam(":firstname", $param_firstname, PDO::PARAM_STR);
        $stmt->bindParam(":surname", $param_surname, PDO::PARAM_STR);
        $stmt->bindParam(":dob", $param_dob, PDO::PARAM_STR);
        $stmt->bindParam(":sex", $param_sex, PDO::PARAM_STR);
        $stmt->bindParam(":occupation", $param_occupation, PDO::PARAM_STR);
        $stmt->bindParam(":position", $param_position, PDO::PARAM_STR);
        $stmt->bindParam(":nationality", $param_nationality, PDO::PARAM_STR);
        $stmt->bindParam(":english", $param_english, PDO::PARAM_STR);
        $stmt->bindParam(":phone", $param_phone, PDO::PARAM_STR);
        $stmt->bindParam(":profile_image", $param_profile_image, PDO::PARAM_STR);

        // Set parameters
        $param_email = $email;
        $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
        $param_firstname = $firstname;
        $param_surname = $surname;
        $param_dob = $dob;
        $param_sex = $sex;
        $param_occupation = $occupation;
        $param_position = $position;
        $param_nationality = $nationality;
        $param_english = $english;
        $param_phone = $phone;
        $param_profile_image = $profileImageName;

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to screen 3
            $_SESSION['cert'] = array();
            $_SESSION['email'] = $email;
            header("location: screen3.php");
        } else {
            echo "Something went wrong. Please try again later.";
        }

        // Close statement
        unset($stmt);
    }
}
?>

<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="../images/icons/favicon.ico" />

    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="../fonts/iconic/css/material-design-iconic-font.min.css">

    <link rel="stylesheet" type="text/css" href="../vendor/animate/animate.css">

    <link rel="stylesheet" type="text/css" href="../vendor/css-hamburgers/hamburgers.min.css">

    <link rel="stylesheet" type="text/css" href="../vendor/animsition/css/animsition.min.css">

    <link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">

    <link rel="stylesheet" type="text/css" href="../vendor/daterangepicker/daterangepicker.css">

    <link rel="stylesheet" type="text/css" href="../css/util.css">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" href="../css/hover.css">
    <link href="../dist/css/flags.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.min.js"></script>

    <title>Screen 2</title>
</head>

<body>
    <div class="limiter">
        <div class="container-login100" style="background-image: url('../images/bg-01.jpg');">
            <div class="wrap-login100" style="width: fit-content; height:fit-content;">
                <form class="login100-form validate-form form-horizontal"
                    action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                    enctype="multipart/form-data">
                    <span class="login100-form-logo float-right">

                        <img src="../images/blank-avatar.jpg" onClick='triggerClick()' id='profileDisplay'>
                        <input type="file" name="profileImage" onChange="displayImage(this)" id="profileImage"
                            class="form-control d-none">



                    </span>
                    <!-- fistname form -->
                    <div class="validate-input form-group row">
                        <label for="input100" class="col-sm-4 col-form-label"
                            style="color:aliceblue">First_Name:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="input100" placeholder="FirstName"
                                value="<?php echo $firstname; ?>">
                        </div>
                    </div>
                    <!-- surname form -->
                    <div class="validate-input form-group row">
                        <label for="input100" class="col-sm-4 col-form-label" style="color:aliceblue">Surname:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="input100" placeholder="Surname"
                                value="<?php echo $surname; ?>">
                        </div>
                    </div>

                    <!-- email form -->
                    <div class="validate-input form-group row">
                        <label for="input100" class="col-sm-4 col-form-label" style="color:aliceblue">Email:</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="input100" placeholder="Email"
                                value="<?php echo $email; ?>">
                        </div>
                    </div>

                    <!-- phone number form -->
                    <div class="row" style="width: fit-content; height: fit-content;">
                        <div class="col-sm-6">
                            <div class="validate-input form-group">
                                <label for="input100" class="col-sm-4 col-lg-4 control-label"
                                    style="color:aliceblue; margin-left:-15px;">Phone:</label>
                                <input type="text" class="form-control col-sm-8" id="input100" placeholder="Phone"
                                    value="<?php echo $phone; ?>">
                            </div>
                        </div>

                        <!-- calendar -->
                        <div class="col-sm-6">
                            <!-- <div class="form-group row"> -->
                            <div class="validate-input form-group">
                                <!-- Date input -->
                                <label class="control-label col-sm-8" for="date"
                                    style="color:aliceblue; margin-left:-15px;">Date Of Birth:</label>
                                <input class="form-control col-sm-8" id="date" name="date" placeholder="MM/DD/YYY"
                                    type="text" />
                            </div>
                        </div>
                        <!-- </div> -->
                    </div>
                    <!-- gender -->
                    <!-- <fieldset class="form-group validate-input" style="color: rgb(255, 255, 255);"> -->
                    <div class="row col-lg-12" style="width: fit-content; height: fit-content; color:aliceblue;"
                        id="gender">
                        <div class="form-inline form-group">
                            <div class=" col-sm-2 col-lg-2">
                                <label for="input100" class="col-sm-4 col-form-label"
                                    style="color:aliceblue;">Gender:</label>
                            </div>
                            <div class="col-sm-4 col-lg-5">
                                <div class="form-check form-inline">
                                    <label class="form-check-label col-sm-3 col-lg-4" for="inlineRadio1">Male</label>
                                    <input class="form-check-input col-sm-2 col-lg-2" type="radio" name="sex"
                                        id="inlineRadio1" style="margin-top: 1px;" value="male">
                                </div>
                            </div>
                            <div class="col-sm-4 col-lg-5">
                                <div class="form-check form-inline">
                                    <label class="form-check-label col-sm-3 col-lg-6" for="inlineRadio2">Female</label>
                                    <input class="form-check-input col-sm-2 col-lg-2" type="radio" name="sex"
                                        id="inlineRadio2" style="margin-top: 1px;" value="female">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- </fieldset> -->
                    <!-- occupation selection -->
                    <div class="form-group row validate-input">
                        <label class="control-label col-sm-4" for="date"
                            style="color:rgb(255, 255, 255)">Occupation:</label>
                        <div class="col-sm-10" style="margin-top: 2%;">
                            <select id="input100" class="form-control" data-size="1" name="occupation">
                                <option value="" selected style="margin-top: -5px;">Choose Occupation</option>
                                <option value="Contracts Manager">Contracts Manager</option>
                                <option value="Project Manager">Project Manager</option>
                                <option value="Architect">Architect</option>
                                <option value="Structural Engineer">Structural Engineer</option>
                                <option value="Mechanical Engineer">Mechanical Engineer</option>
                                <option value="Civil Engineer">Civil Engineer</option>
                                <option value="General Operatives">General Operatives</option>
                                <option value="Plumber">Plumber</option>
                                <option value="Electrician">Electrician</option>
                                <option value="Scaffoler">Scaffoler</option>
                                <option value="Plasterer">Plasterer</option>
                                <option value="Lift Installer">Lift Installer</option>
                                <option value="Fireproofing">Fireproofing</option>
                                <optgroup label="Machine Operator">
                                    <option value="Excavator Driver">Excavator Driver</option>
                                    <option value="Telehandler Driver">Telehandler Driver</option>
                                    <option value="Crane Operator">Crane Operator</option>
                                    <option value="Specialist Foreman">Specialist Foreman</option>
                                </optgroup>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <!-- position selected -->
                    <div class="form-group row validate-input">
                        <label class="control-label col-sm-4" for="date"
                            style="color:rgb(255, 255, 255)">Position:</label>
                        <div class="col-sm-10" style="margin-top: 2%;">
                            <select id="input100" class="form-control" data-size="1" name="position">
                                <option selected style="margin-top: -4px;">Choose Position</option>
                                <option>General</option>
                                <option>Manager</option>
                                <option>Foreman</option>
                                <option>Other</option>
                            </select>
                        </div>
                    </div>

                    <!-- nationality selected -->
                    <div class="form-group row validate-input">
                        <label class="control-label col-sm-4" for="date"
                            style="color:rgb(255, 255, 255)">Nationality:</label>
                        <div class="col-sm-10" style="margin-top: 2%;">
                            <select id="input100" class="form-control" data-size="1" name="nationality">
                                <option selected style="margin-top: -4px;">Choose Nationality</option>
                                <option value="irish">Irish</option>
                                <option value="british">British</option>
                                <option value="latvian">Latvian</option>
                                <option value="lithuanian">Lithuanian</option>
                                <option value="polish">Polish</option>
                                <option value="afghan">Afghan</option>
                                <option value="albanian">Albanian</option>
                                <option value="algerian">Algerian</option>
                                <option value="american">American</option>
                                <option value="andorran">Andorran</option>
                                <option value="angolan">Angolan</option>
                                <option value="antiguans">Antiguans</option>
                                <option value="argentinean">Argentinean</option>
                                <option value="armenian">Armenian</option>
                                <option value="australian">Australian</option>
                                <option value="austrian">Austrian</option>
                                <option value="azerbaijani">Azerbaijani</option>
                                <option value="bahamian">Bahamian</option>
                                <option value="bahraini">Bahraini</option>
                                <option value="bangladeshi">Bangladeshi</option>
                                <option value="barbadian">Barbadian</option>
                                <option value="barbudans">Barbudans</option>
                                <option value="batswana">Batswana</option>
                                <option value="belarusian">Belarusian</option>
                                <option value="belgian">Belgian</option>
                                <option value="belizean">Belizean</option>
                                <option value="beninese">Beninese</option>
                                <option value="bhutanese">Bhutanese</option>
                                <option value="bolivian">Bolivian</option>
                                <option value="bosnian">Bosnian</option>
                                <option value="brazilian">Brazilian</option>
                                <option value="bruneian">Bruneian</option>
                                <option value="bulgarian">Bulgarian</option>
                                <option value="burkinabe">Burkinabe</option>
                                <option value="burmese">Burmese</option>
                                <option value="burundian">Burundian</option>
                                <option value="cambodian">Cambodian</option>
                                <option value="cameroonian">Cameroonian</option>
                                <option value="canadian">Canadian</option>
                                <option value="cape verdean">Cape Verdean</option>
                                <option value="central african">Central African</option>
                                <option value="chadian">Chadian</option>
                                <option value="chilean">Chilean</option>
                                <option value="chinese">Chinese</option>
                                <option value="colombian">Colombian</option>
                                <option value="comoran">Comoran</option>
                                <option value="congolese">Congolese</option>
                                <option value="costa rican">Costa Rican</option>
                                <option value="croatian">Croatian</option>
                                <option value="cuban">Cuban</option>
                                <option value="cypriot">Cypriot</option>
                                <option value="czech">Czech</option>
                                <option value="danish">Danish</option>
                                <option value="djibouti">Djibouti</option>
                                <option value="dominican">Dominican</option>
                                <option value="dutch">Dutch</option>
                                <option value="east timorese">East Timorese</option>
                                <option value="ecuadorean">Ecuadorean</option>
                                <option value="egyptian">Egyptian</option>
                                <option value="emirian">Emirian</option>
                                <option value="equatorial guinean">Equatorial Guinean</option>
                                <option value="eritrean">Eritrean</option>
                                <option value="estonian">Estonian</option>
                                <option value="ethiopian">Ethiopian</option>
                                <option value="fijian">Fijian</option>
                                <option value="filipino">Filipino</option>
                                <option value="finnish">Finnish</option>
                                <option value="french">French</option>
                                <option value="gabonese">Gabonese</option>
                                <option value="gambian">Gambian</option>
                                <option value="georgian">Georgian</option>
                                <option value="german">German</option>
                                <option value="ghanaian">Ghanaian</option>
                                <option value="greek">Greek</option>
                                <option value="grenadian">Grenadian</option>
                                <option value="guatemalan">Guatemalan</option>
                                <option value="guinea-bissauan">Guinea-Bissauan</option>
                                <option value="guinean">Guinean</option>
                                <option value="guyanese">Guyanese</option>
                                <option value="haitian">Haitian</option>
                                <option value="herzegovinian">Herzegovinian</option>
                                <option value="honduran">Honduran</option>
                                <option value="hungarian">Hungarian</option>
                                <option value="icelander">Icelander</option>
                                <option value="indian">Indian</option>
                                <option value="indonesian">Indonesian</option>
                                <option value="iranian">Iranian</option>
                                <option value="iraqi">Iraqi</option>
                                <option value="israeli">Israeli</option>
                                <option value="italian">Italian</option>
                                <option value="ivorian">Ivorian</option>
                                <option value="jamaican">Jamaican</option>
                                <option value="japanese">Japanese</option>
                                <option value="jordanian">Jordanian</option>
                                <option value="kazakhstani">Kazakhstani</option>
                                <option value="kenyan">Kenyan</option>
                                <option value="kittian and nevisian">Kittian and Nevisian</option>
                                <option value="kuwaiti">Kuwaiti</option>
                                <option value="kyrgyz">Kyrgyz</option>
                                <option value="laotian">Laotian</option>
                                <option value="lebanese">Lebanese</option>
                                <option value="liberian">Liberian</option>
                                <option value="libyan">Libyan</option>
                                <option value="liechtensteiner">Liechtensteiner</option>
                                <option value="luxembourger">Luxembourger</option>
                                <option value="macedonian">Macedonian</option>
                                <option value="malagasy">Malagasy</option>
                                <option value="malawian">Malawian</option>
                                <option value="malaysian">Malaysian</option>
                                <option value="maldivan">Maldivan</option>
                                <option value="malian">Malian</option>
                                <option value="maltese">Maltese</option>
                                <option value="marshallese">Marshallese</option>
                                <option value="mauritanian">Mauritanian</option>
                                <option value="mauritian">Mauritian</option>
                                <option value="mexican">Mexican</option>
                                <option value="micronesian">Micronesian</option>
                                <option value="moldovan">Moldovan</option>
                                <option value="monacan">Monacan</option>
                                <option value="mongolian">Mongolian</option>
                                <option value="moroccan">Moroccan</option>
                                <option value="mosotho">Mosotho</option>
                                <option value="motswana">Motswana</option>
                                <option value="mozambican">Mozambican</option>
                                <option value="namibian">Namibian</option>
                                <option value="nauruan">Nauruan</option>
                                <option value="nepalese">Nepalese</option>
                                <option value="new zealander">New Zealander</option>
                                <option value="ni-vanuatu">Ni-Vanuatu</option>
                                <option value="nicaraguan">Nicaraguan</option>
                                <option value="nigerien">Nigerien</option>
                                <option value="north korean">North Korean</option>
                                <option value="northern irish">Northern Irish</option>
                                <option value="norwegian">Norwegian</option>
                                <option value="omani">Omani</option>
                                <option value="pakistani">Pakistani</option>
                                <option value="palauan">Palauan</option>
                                <option value="panamanian">Panamanian</option>
                                <option value="papua new guinean">Papua New Guinean</option>
                                <option value="paraguayan">Paraguayan</option>
                                <option value="peruvian">Peruvian</option>
                                <option value="portuguese">Portuguese</option>
                                <option value="qatari">Qatari</option>
                                <option value="romanian">Romanian</option>
                                <option value="russian">Russian</option>
                                <option value="rwandan">Rwandan</option>
                                <option value="saint lucian">Saint Lucian</option>
                                <option value="salvadoran">Salvadoran</option>
                                <option value="samoan">Samoan</option>
                                <option value="san marinese">San Marinese</option>
                                <option value="sao tomean">Sao Tomean</option>
                                <option value="saudi">Saudi</option>
                                <option value="scottish">Scottish</option>
                                <option value="senegalese">Senegalese</option>
                                <option value="serbian">Serbian</option>
                                <option value="seychellois">Seychellois</option>
                                <option value="sierra leonean">Sierra Leonean</option>
                                <option value="singaporean">Singaporean</option>
                                <option value="slovakian">Slovakian</option>
                                <option value="slovenian">Slovenian</option>
                                <option value="solomon islander">Solomon Islander</option>
                                <option value="somali">Somali</option>
                                <option value="south african">South African</option>
                                <option value="south korean">South Korean</option>
                                <option value="spanish">Spanish</option>
                                <option value="sri lankan">Sri Lankan</option>
                                <option value="sudanese">Sudanese</option>
                                <option value="surinamer">Surinamer</option>
                                <option value="swazi">Swazi</option>
                                <option value="swedish">Swedish</option>
                                <option value="swiss">Swiss</option>
                                <option value="syrian">Syrian</option>
                                <option value="taiwanese">Taiwanese</option>
                                <option value="tajik">Tajik</option>
                                <option value="tanzanian">Tanzanian</option>
                                <option value="thai">Thai</option>
                                <option value="togolese">Togolese</option>
                                <option value="tongan">Tongan</option>
                                <option value="trinidadian or tobagonian">Trinidadian or Tobagonian</option>
                                <option value="tunisian">Tunisian</option>
                                <option value="turkish">Turkish</option>
                                <option value="tuvaluan">Tuvaluan</option>
                                <option value="ugandan">Ugandan</option>
                                <option value="ukrainian">Ukrainian</option>
                                <option value="uruguayan">Uruguayan</option>
                                <option value="uzbekistani">Uzbekistani</option>
                                <option value="venezuelan">Venezuelan</option>
                                <option value="vietnamese">Vietnamese</option>
                                <option value="welsh">Welsh</option>
                                <option value="yemenite">Yemenite</option>
                                <option value="zambian">Zambian</option>
                                <option value="zimbabwean">Zimbabwean</option>
                            </select>
                        </div>
                    </div>

                    <!-- speak English level -->
                    <div class="row col-lg-12" style="width: fit-content; height: fit-content; color:aliceblue"
                        id="english">
                        <div class="form-inline form-group">
                            <div class=" col-sm-2 col-lg-2">
                                <label for="input100" class="col-sm-4 col-form-label"
                                    style="color:aliceblue">English:</label>
                            </div>
                            <div class="col-sm-5 col-lg-3">
                                <div class="form-check form-inline">
                                    <label class="form-check-label col-sm-3 col-lg-5" for="inlineRadiob">Poor</label>
                                    <input class="form-check-input col-sm-2 col-lg-3" type="radio" name="english"
                                        id="inlineRadiob" value="Poor">
                                </div>
                            </div>
                            <div class="col-sm-5 col-lg-3">
                                <div class="form-check form-inline">
                                    <label class="form-check-label col-sm-3 col-lg-5" for="inlineRadiog">Good</label>
                                    <input class="form-check-input col-sm-2 col-lg-4" type="radio" name="english"
                                        id="inlineRadiog" value="Good">
                                </div>
                            </div>
                            <div class="col-sm-5 col-lg-3">
                                <div class="form-check form-inline">
                                    <label class="form-check-label col-sm-3 col-lg-6" for="inlineRadiof">Fluent</label>
                                    <input class="form-check-input col-sm-2 col-lg-4" type="radio" name="english"
                                        id="inlineRadiof" value="Fluent">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-login100-form-btn">
                        <div class="row">
                            <div class="col-sm-4 col-lg-6">
                                <button class="login100-form-btn" style="width: 60%; height: 90%;">
                                    <a href="screen1.php">
                                        Back
                                    </a>
                                </button>
                            </div>
                            <div class="col-sm-4 col-lg-6">
                                <button class="login100-form-btn" style="width: 60%; height: 90%;" type="submit">
                                    
                                        Next
                                    
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="dropDownSelect1"></div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="../vendor/animsition/js/animsition.min.js"></script>
    <script src="../vendor/bootstrap/js/popper.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../vendor/select2/select2.min.js"></script>
    <script src="../vendor/daterangepicker/moment.min.js"></script>
    <script src="../vendor/daterangepicker/daterangepicker.js"></script>
    <script src="../vendor/countdowntime/countdowntime.js"></script>

    <script src="../js/main.js"></script>
    <!-- Include jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    <!-- Include Date Range Picker -->
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css" />

    <script>
        $(document).ready(function () {
            var date_input = $('input[name="date"]'); //our date input has the name "date"
            var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
            date_input.datepicker({
                format: 'yyyy/mm/dd',
                container: container,
                todayHighlight: false,
                autoclose: true,
            })
        })
    </script>

</body>

</html>
<script src="../script.js"></script>
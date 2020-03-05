<?php
session_start();
require_once '../functions.php';
require_once '../config.php';

//variables
$email = $_SESSION['email'];
$userDetail = get_details($email);
$safepass = get_safepass($email);

//user submit update form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//profile image
    if (!isset($_FILES['profileImage']) || $_FILES['profileImage']['error'] == UPLOAD_ERR_NO_FILE) {        //if no image changes, update with same photo
        $profileImageName = $userDetail['profile_image'];
    } else {
//for image upload
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
    }
    // for rest of details
    $firstname = $_POST['firstname'];
    $surname = $_POST['surname'];
    $phone = $_POST['phone'];
    $dob = $_POST['date'];
    $sex = $_POST['sex'];
    $occupation = $_POST['occupation'];
    $position = $_POST['position'];
    $nationality = ucwords($_POST['nationality']);
    $english = $_POST['english'];

    // Prepare an insert statement
    $sql = "UPDATE users SET firstname=?, surname=?, phone=?, dob=?, sex=?, occupation=?, position=?, nationality=?, english=?, profile_image=? WHERE email='$email'";
    $stmt = $pdo->prepare($sql);

    // Attempt to execute the prepared statement
    if ($stmt->execute([$firstname, $surname, $phone, $dob, $sex, $occupation, $position, $nationality, $english, $profileImageName])) {
        // Redirect to profile page
        header("location: profile.php");
    } else {
        echo "Something went wrong. Please try again later.";
    }

    // Close statement
    unset($stmt);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Profile</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="../images/icons/favicon.ico" />

    <link rel="stylesheet" type="text/css" href="../vendor/daterangepicker/daterangepicker.css">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="../vendor/acc-wizard-master/release/acc-wizard.min.js"></script>
    <!-- x-editable (bootstrap version) -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css"
        rel="stylesheet" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js">
    </script>
    <link rel="stylesheet" href="../css/profile.css">

    <!--============================================================================= ==================-->

</head>

<body>
    <div class="main">
        <a href="profile.php">Back </a>
        <div class="container">
            <span class="login100-form-logo float-right">
                <div class="box1">
                    <img src="<?php echo "../profile-images/" . $userDetail['profile_image']; ?> " onClick='triggerClick()' id='profileDisplay'>
                    <a class="info" onClick="triggerClick()"><button type="button" class="btn btn-primary btn-block"
                            >Change
                            Avatar</button></a>
                </div>
            </span>
            <!-- <div class="acc-wizard"> -->
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default active">
                        <div class="panel-heading" id="headingOne">
                            <h3>
                                <a href="#collapseOne" data-toggle="collapse" data-parent="#accordion">Basic
                                    infomation</a>
                            </h3>
                        </div>

                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                                    enctype="multipart/form-data">


                                    <input type="file" name="profileImage" onChange="displayImage(this)" id="profileImage" class="form-control"
            style="display: none">

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="firstname">Firstname</label>
                                            <input type="text" class="form-control" name="firstname"
                                                value=<?php echo $userDetail['firstname']; ?>>
                                        </div>

                                        <div class="form-group">
                                            <label for="surname">Surname</label>
                                            <input type="text" class="form-control" name="surname"
                                                value=<?php echo $userDetail['surname']; ?>>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" name="email"
                                                value=<?php echo $userDetail['email']; ?> readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input type="text" class="form-control" name="phone"
                                                value=<?php echo $userDetail['phone']; ?>>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <div class="form-date">

                                                <div class="form-group">
                                                    <label for="dob">Date of Birth</label>
                                                    <input type="date" class="form-control" name="date"
                                                        value=<?php echo $userDetail['dob']; ?>>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-radio">
                                                <label for="gender">Gender: </label>
                                                <div class="form-flex">
                                                    
                                                    <input type="radio" name="sex" <?=$userDetail['sex'] == "male" ? "checked" : ""?> value="male">
                                                    <label for="male"><img src="../images/icons/icon-male.png" alt="Male"></label>
                                                    <input type="radio" name="sex" <?=$userDetail['sex'] == "female" ? "checked" : ""?> value="female">
                                                    <label for="female"><img src="../images/icons/icon-female.png" alt="Female"></label>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="occupation">Occupation</label>
                                            <select name="occupation" class="custom-select">
                                                <option
                                                    <?=$userDetail['occupation'] == "Contracts Manager" ? "selected='selected'" : ""?>
                                                    value="Contracts Manager">Contracts Manager</option>
                                                <option
                                                    <?=$userDetail['occupation'] == "Project Manager" ? "selected='selected'" : ""?>
                                                    value="Project Manager">Project Manager</option>
                                                <option
                                                    <?=$userDetail['occupation'] == "Architect" ? "selected='selected'" : ""?>
                                                    value="Architect">
                                                    Architect</option>
                                                <option
                                                    <?=$userDetail['occupation'] == "Structural Engineer" ? "selected='selected'" : ""?>
                                                    value="Structural Engineer">Structural Engineer</option>
                                                <option
                                                    <?=$userDetail['occupation'] == "Mechanical Engineer" ? "selected='selected'" : ""?>
                                                    value="Mechanical Engineer">Mechanical Engineer</option>
                                                <option
                                                    <?=$userDetail['occupation'] == "Civil Engineer" ? "selected='selected'" : ""?>
                                                    value="Civil Engineer">
                                                    Civil Engineer</option>
                                                <option
                                                    <?=$userDetail['occupation'] == "General Operatives" ? "selected='selected'" : ""?>
                                                    value="General Operatives">General Operatives</option>
                                                <option
                                                    <?=$userDetail['occupation'] == "Plumber" ? "selected='selected'" : ""?>
                                                    value="Plumber">Plumber
                                                </option>
                                                <option
                                                    <?=$userDetail['occupation'] == "Electrician" ? "selected='selected'" : ""?>
                                                    value="Electrician">
                                                    Electrician</option>
                                                <option
                                                    <?=$userDetail['occupation'] == "Scaffoler" ? "selected='selected'" : ""?>
                                                    value="Scaffoler">Scaffoler
                                                </option>
                                                <option
                                                    <?=$userDetail['occupation'] == "Plasterer" ? "selected='selected'" : ""?>
                                                    value="Plasterer">Plasterer
                                                </option>
                                                <option
                                                    <?=$userDetail['occupation'] == "Lift Installer" ? "selected='selected'" : ""?>
                                                    value="Lift Installer">
                                                    Lift Installer</option>
                                                <option
                                                    <?=$userDetail['occupation'] == "Fireproofing" ? "selected='selected'" : ""?>
                                                    value="Fireproofing">
                                                    Fireproofing</option>
                                                <optgroup label="Machine Operator">
                                                    <option
                                                        <?=$userDetail['occupation'] == "Excavator Driver" ? "selected='selected'" : ""?>
                                                        value="Excavator Driver">Excavator Driver</option>
                                                    <option
                                                        <?=$userDetail['occupation'] == "Telehandler Driver" ? "selected='selected'" : ""?>
                                                        value="Telehandler Driver">Telehandler Driver</option>
                                                    <option
                                                        <?=$userDetail['occupation'] == "Crane Operator" ? "selected='selected'" : ""?>
                                                        value="Crane Operator">Crane Operator</option>
                                                    <option
                                                        <?=$userDetail['occupation'] == "Specialist Foreman" ? "selected='selected'" : ""?>
                                                        value="Specialist Foreman">Specialist Foreman</option>
                                                </optgroup>
                                                <option
                                                    <?=$userDetail['occupation'] == "Other" ? "selected='selected'" : ""?>
                                                    value="Other">Other</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="position" class="form-label">Position</label>
                                            <select name="position">
                                                <option
                                                    <?=$userDetail['position'] == "General" ? "selected='selected'" : ""?>
                                                    value="General">General
                                                </option>
                                                <option
                                                    <?=$userDetail['position'] == "Manager" ? "selected='selected'" : ""?>
                                                    value="Manager">Manager
                                                </option>
                                                <option
                                                    <?=$userDetail['position'] == "Foreman" ? "selected='selected'" : ""?>
                                                    value="Foreman">Foreman
                                                </option>
                                                <option
                                                    <?=$userDetail['position'] == "Other" ? "selected='selected'" : ""?>
                                                    value="Other">Other</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="nationality" class="form-label">Nationality</label>
                                            <select name="nationality">
                                                <option selected><?php echo $userDetail['nationality']; ?></option>
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
                                                <option value="trinidadian or tobagonian">Trinidadian or Tobagonian
                                                </option>
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
                                        <div class="form-group">
                                            <label for="english">English</label>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="english" value="Poor"
                                                    <?=$userDetail['english'] == "Poor" ? "checked" : ""?>>
                                                <label class="form-check-label" for="exampleRadios1">
                                                    Poor
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="english" value="Poor"
                                                    <?=$userDetail['english'] == "Good" ? "checked" : ""?>>
                                                <label class="form-check-label" for="exampleRadios1">
                                                    Good
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="english" value="Poor"
                                                    <?=$userDetail['english'] == "Fluent" ? "checked" : ""?>>
                                                <label class="form-check-label" for="exampleRadios1">
                                                    Fluent
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-submit">
                                        <button class="btn btn-success"  type="submit" value="Submit">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <!-- </div> -->
    </div>


    <!-- <div id="dropDownSelect1"></div> -->

    <!-- <script src="../vendor/acc-wizard-master/release/acc-wizard.min.js"></script> -->
    <script src="../vendor/bootstrap/js/popper.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../vendor/select2/select2.min.js"></script>
    <script src="../vendor/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="../vendor/jquery-validation/dist/additional-methods.min.js"></script>
    <script src="../vendor/minimalist-picker/dobpicker.js"></script>
    <script src="../vendor/daterangepicker/moment.min.js"></script>
    <script src="../js/combodate.js"></script>
    <script src="../vendor/jquery-steps/jquery.steps.min.js"></script>
    <script src="../js/editable.js"></script>
</body>

</html>
<script src="../script.js"></script>
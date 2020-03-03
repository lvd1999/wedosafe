<?php
session_start();
require_once "../config.php";
$email = $_SESSION['email'];
// Prepare an insert statement
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //validate user input registration number
    if (empty(trim($_POST["reg_num"]))) {
        $reg_err = "Please Enter Registration Number";
    } else {
        $reg_num = trim($_POST["reg_num"]);
    }

    $sql = "INSERT INTO certificates (email, type, cert_image_front, cert_image_back, reg_number) VALUES ('$email', 'safepass', :safepass_front, :safepass_back, :reg_num)";

    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":safepass_front", $param_safepass_front, PDO::PARAM_STR);
        $stmt->bindParam(":safepass_back", $param_safepass_back, PDO::PARAM_STR);
        $stmt->bindParam(":reg_num", $param_reg_num, PDO::PARAM_STR);

        //set parameters
        $param_safepass_front = $_SESSION['safepass-front'];
        $param_safepass_back = $_SESSION['safepass-back'];
        $param_reg_num = $reg_num;

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to profile
            $_SESSION['safepass'] = $reg_num;
            header("location: edit-certificates.php");
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>safe pass - registration number</title>
</head>
<body>
    <h1>Registration Number</h1>
    <img src="../certificates/<?php echo $_SESSION['safepass-front']; ?>">
    <img src="../certificates/<?php echo $_SESSION['safepass-back']; ?>">

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label>Registration Number: </label>
        <input type="text" name="reg_num">

        <input type="submit" class="btn btn-primary" value="Finish">
    </form>
</body>
</html>
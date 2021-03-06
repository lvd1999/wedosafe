<?php
session_start();
require_once "../config.php";
$email = $_SESSION['email'];
// Prepare an insert statement
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sql = "INSERT INTO certificates (email, type, cert_image_front, cert_image_back, reg_number) VALUES ('$email', 'safepass', :safepass_front, :safepass_back, :reg_num)";

    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":safepass_front", $param_safepass_front, PDO::PARAM_STR);
        $stmt->bindParam(":safepass_back", $param_safepass_back, PDO::PARAM_STR);
        $stmt->bindParam(":reg_num", $param_reg_num, PDO::PARAM_STR);

        //set parameters
        $param_safepass_front = $_SESSION['safepass-front'];
        $param_safepass_back = $_SESSION['safepass-back'];
        $param_reg_num = $_POST['number'];

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to screen 3
            $_SESSION['safepass'] = $_POST['number'];
            header("location: screen3.php");
        } else {
            echo "Something went wrong. Please try again later.";
        }

        // Close statement
        unset($stmt);
    }
}
?>
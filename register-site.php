<?php
session_start();
require_once 'functions.php';
require_once 'config.php';

//variables
$email = $_SESSION['email'];
$msg = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = $_POST['code'];
    $message = $_POST['message'];

    if (codeExists($code) === false) {
        $msg = "Code doesn't exist.";
    } else {
        // Prepare an insert statement
        $sql = "INSERT INTO requests (email, code ,message ,status) VALUES ('$email', :code, :message, 'pending')";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":code", $param_code, PDO::PARAM_STR);
            $stmt->bindParam(":message", $param_message, PDO::PARAM_STR);

            // Set parameters
            $param_code = $code;
            $param_message = $message;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to screen 3
                header("location: welcome.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Site</title>
</head>
<body>
<h5>Register for a site.</h5>
<a href='welcome.php'>Back</a>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        Code: <input type='text' name='code'>
        Message: <input type='text' name='message'>
        <input type="submit">
    </form>
    <?php echo $msg; ?>
</body>
</html>
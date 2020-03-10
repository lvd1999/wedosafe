<?php 
session_start();
require_once '../functions.php';
require_once '../config.php';

//variables
$company_name = get_company($_SESSION['username']);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $code = $_POST['code'];
    $address = $_POST['address'];

    // Prepare an insert statement
    $sql = "INSERT INTO building_sites (code,address,company_name) VALUES (:code, :address, '$company_name')";

    if ($stmt = $pdo->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":code", $param_code, PDO::PARAM_STR);
        $stmt->bindParam(":address", $param_address, PDO::PARAM_STR);

        // Set parameters
        $param_code = $code;
        $param_address = $address;

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to screen 3
            header("location: admin-dashboard.php");
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
    <title>Add Building Site</title>
</head>
<body>
<a href='admin-dashboard.php'>Back</a>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        Code: <input type='text' name='code' oninput="let p = this.selectionStart; this.value = this.value.toUpperCase();this.setSelectionRange(p, p);">
        Address: <input type='text' name='address'>
        <input type="submit">
    </form>
</body>
</html>
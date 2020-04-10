<?php
session_start();
require_once '../functions.php';
require_once '../config.php';

$sites = get_sites($_SESSION['admin']['company_name']);
$pdfs = $_SESSION['selected-pdfs'];
$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['site'] == "default") {
        $msg = "Please select a site.";
    } else {
        $site = $_POST['site'];
    }

    if (empty($msg)) {
        foreach ($pdfs as $pdf) {
            $sql = "INSERT INTO pdf_site(pdf_id, building_site_id) VALUES ($pdf,$site)";
            if ($stmt = $pdo->prepare($sql)) {

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    // Redirect to screen 3
                    echo "<script type='text/javascript'>alert('PDFs sent to site successfully.');</script>";
                    header("location: pdf.php");
                } else {
                    echo "Something went wrong. Please try again later.";
                }

                // Close statement
                unset($stmt);
            }
        }
    }
}

?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >

    <select class="custom-select" name="site">
        <option selected value="default">Site</option>
        <?php
$sites = get_sites($_SESSION['admin']['company_name']);
foreach ($sites as $site) {
    echo '<option value="' . $site['id'] . '">' . $site['code'] . '</option>';
}
?>
    </select>

    <button type="submit">Done</button>
    </form>
</body>

</html>
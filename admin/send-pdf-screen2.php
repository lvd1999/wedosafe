<?php
session_start();
require_once '../functions.php';
require_once '../config.php';

$sites = get_sites($_SESSION['admin']['company_name']);
$pdfs = $_SESSION['selected-pdfs'];
$admin_id = $_SESSION['admin']['id'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sending_members = $_POST['member'];

    foreach ($pdfs as $pdf) {
        for ($i = 0; $i < sizeof($sending_members); $i++) {
            $sql = "INSERT INTO pdf_status (admin_id, user_id, pdf_id, status) VALUES ($admin_id, $sending_members[$i], $pdf, 'unread')";
            echo $sql;
            if ($stmt = $pdo->prepare($sql)) {
            
              // Attempt to execute the prepared statement
              if ($stmt->execute()) {
                  // Redirect to screen 3
                  header("location: pdf.php");
              } else {
                  echo "Something went wrong. Please try again later.";
              }
      
              // Close statement
              unset($stmt);
            }
        }
    }
    header("Location: pdf.php");
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Send PDF 2</title>
</head>
<body>

Sending
<?php
foreach ($pdfs as $pdf) {
    echo '<div class="badge badge-primary text-wrap">' . $pdf . ' </div>';
}
?> To

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
<?php
foreach ($sites as $site) {
    echo '<h3>' . $site['code'] . '</h3>';
    $members = siteMembers($site['id']);
    foreach ($members as $member) {
        echo '<input type="checkbox" id="vehicle1" name="member[]" value="' . $member['id'] . '">
      <label for="vehicle1">' . $member['firstname'] . ' ' . $member['surname'] . '</label><br>';
    }
}
?>
  <button type="submit">Send</button>
</form>
</body>
</html>
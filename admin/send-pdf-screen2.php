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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Send PDF 2</title>
    <style type="text/css">
    table {
      border-collapse: collapse;
      border: 1px solid #999
    }

    th {
      background: #ccc;
      text-align: left;
    }
  </style>
    <script type="8e5a1e24468b1b010e898f68-text/javascript">
    function checkAll(frm, checkedOn) {

        // have we been passed an ID
        if (typeof frm == "string") {
            frm = document.getElementById(frm);
        }

        // Get all of the inputs that are in this form
        var inputs = frm.getElementsByTagName("input");

        // for each input in the form, check if it is a checkbox
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].type == "checkbox") {
                inputs[i].checked = checkedOn;
            }
        }
    }
</script>
</head>

<body>

    Sending
    <?php
foreach ($pdfs as $pdf) {
    echo '<div class="badge badge-primary text-wrap">' . $pdf . ' </div>';
}
?> To

    <!-- new form-->
    <!-- for each site, make a form, then for each sitemember, print checkbox -->
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
    <?php
foreach ($sites as $site) {
    echo '<div name="'.$site['code'].'" id="'.$site['code'].'">';
    $members = siteMembers($site['id']);
    echo '<p>' . $site['code'] . '</p>';
    echo '<table width="200" border="1" cellpadding="5">';
    echo '<tr>
            <th scope="col">
              <input type="checkbox" name="all" id="all"
                onclick="if (!window.__cfRLUnblockHandlers) return false; checkAll('. '\''. $site['code']. '\''.', this.checked);"
                data-cf-modified-8e5a1e24468b1b010e898f68-="" />
            </th>
            <th scope="col">Site Member</th>
          </tr>';
        foreach ($members as $member) {
            echo '<tr>
            <td><input type="checkbox" name="member[]" value="' . $member['id'] . '" /></td>
            <td>'. $member['firstname'] . ' ' . $member['surname'] .'</td>
                </tr>';
        }
    echo '</table>';
    echo '</div>';
}
?>

    <button type="submit">Send</button>
</form>

    <!-- <form action="#" method="get" name="test_form" id="test_form">
    <p>Your messages:</p>
    <table width="200" border="1" cellpadding="5">
      <tr>
        <th scope="col">
          <input type="checkbox" name="all" id="all"
            onclick="if (!window.__cfRLUnblockHandlers) return false; checkAll('test_form', this.checked);"
            data-cf-modified-8e5a1e24468b1b010e898f68-="" />
        </th>
        <th scope="col">From</th>
        <th scope="col">Message</th>
      </tr>
      <tr>
        <td><input type="checkbox" name="asp" id="asp" /></td>
        <td>Dave</td>
        <td>Hi, Stewart!</td>
      </tr>
</table>
</form> -->
<script src="https://ajax.cloudflare.com/cdn-cgi/scripts/7089c43e/cloudflare-static/rocket-loader.min.js"
    data-cf-settings="8e5a1e24468b1b010e898f68-|49" defer=""></script>
</body>

</html>



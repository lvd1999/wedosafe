<?php
session_start();
require_once '../functions.php';
require_once '../config.php';

$pdf_id = $_POST['pdfid'];
$user_id = $_POST['userid'];
// Prepare an insert statement
    $sql = "UPDATE pdf_status SET status='read' WHERE pdf_id=? AND user_id=?";
    $stmt = $pdo->prepare($sql);

    // Attempt to execute the prepared statement
    if ($stmt->execute([$pdf_id, $user_id])) {
        // Redirect to welcome page
         header("location: ../welcome.php");
    } else {
        echo "Something went wrong. Please try again later.";
    }

    // Close statement
    unset($stmt);

?>
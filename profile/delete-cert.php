<?php
session_start();

require_once "../config.php";
require_once '../functions.php';

$email = $_SESSION['email'];
$cert = $_GET['name'];

delete_cert($email, $cert);

header('location: edit-certificates.php');

?>
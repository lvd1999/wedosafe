<?php
// Initialize the session
session_start();
require_once '../functions.php';
require_once '../config.php';

$email = $_GET['email'];
$request_id = $_GET['id'];
$building_site_id = $_GET['building_site_id'];

acceptRequest($request_id, $email, $building_site_id);


header('location: admin-dashboard.php');


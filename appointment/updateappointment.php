<?php
require_once 'login.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointment_id = $_POST['appointment_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $donation_center_id = $_POST['donation_center'];
    $donor_ssn = $_POST['donor_ssn'];
}   
?>
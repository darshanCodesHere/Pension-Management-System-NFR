<?php
session_start();

header('Content-Type: application/json');

if (!isset($_POST['otp'])) {
    echo json_encode(['success' => false, 'message' => 'Please enter the OTP!']);
    exit();
}

if ($_POST['otp'] == $_SESSION['otp']) {
    echo json_encode(['success' => true]);
    unset($_SESSION['otp']);
} else {
    echo json_encode(['success' => false, 'message' => 'Incorrect OTP!']);
}
?>

<?php
session_start();
require_once 'db.php';
require_once 'mail_function.php';

if (!isset($_POST['employee_id'], $_POST['dob'], $_POST['contact_no'], $_POST['email'])) {
    echo json_encode(['success' => false, 'message' => 'Please fill all the fields!']);
    exit();
}

$otp = rand(100000, 999999);

$_SESSION['otp'] = $otp;
$_SESSION['employee_id'] = $_POST['employee_id'];
$_SESSION['dob'] = $_POST['dob'];
$_SESSION['contact_no'] = $_POST['contact_no'];
$_SESSION['email'] = $_POST['email'];

if ($stmt = $con->prepare('UPDATE `nfr_accounts` SET `OTP` = ? WHERE `Employee Id` = ? AND `DOB` = ? AND `Mobile No.` = ? AND `Email` = ?')) {
    $stmt->bind_param('sssss', $otp, $_POST['employee_id'], $_POST['dob'], $_POST['contact_no'], $_POST['email']);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        $mail_status = sendOTP($_POST['email'], $otp);
        if ($mail_status == 1) {
            echo json_encode(['success' => true, 'message' => 'OTP sent successfully!', 'otp' => $otp]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to send OTP to email.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update OTP. Please check your details.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Could not prepare statement!']);
}

$con->close();
?>

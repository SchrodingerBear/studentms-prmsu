<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

function sendEmail($stuid, $stuemail, $stuname, $verification_code)
{
  $mail = new PHPMailer(true);
  try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'support@prmsu-scstudenthandbook.website';
    $mail->Password = 'E&b2eWY#*dP|'; // Keep this secure
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('support@prmsu-scstudenthandbook.website', 'Studentms Mailer');
    $mail->addAddress($stuemail, $stuname);

    // Get the protocol (http or https)
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https" : "http";

    // Get the host and build the base URL
    $base_url = $protocol . "://" . $_SERVER['HTTP_HOST'] . "/studentms-prmsu";

    // Set message based on the verification code
    if ($verification_code === 'verifieduser') {
      // If the code indicates a verified user, send an approval message
      $mail->Subject = 'Registration Approved by Admin';
      $mail->Body = "<p>Hello $stuname,</p><p>Your registration has been approved by the admin. You can now log in to your account.</p>";
      $mail->AltBody = 'Your registration has been approved by the admin. You can now log in to your account.';
    } else {
      // Generate the verification URL for new users
      $url = "{$base_url}/verify.php?stuid={$stuid}&code={$verification_code}";
      $mail->Subject = 'Verify Your Account';
      $mail->Body = "<p>Hello $stuname,</p><p>Please verify your email to log in.</p><p><a href='$url'>Verify Account</a></p>";
      $mail->AltBody = 'Verify your account by visiting the link provided.';
    }

    $mail->isHTML(true);
    $mail->send();
    echo "Verification sent.";
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}

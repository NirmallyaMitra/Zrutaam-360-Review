<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'db.php';

// Fetch the next pending email
$stmt = $pdo->prepare("SELECT * FROM mail_original_table WHERE status = 'pending' ORDER BY unique_code ASC LIMIT 1");
$stmt->execute();
$email = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$email) {
  echo json_encode(['email' => '', 'status' => '🚫 No pending emails.', 'done' => true]);
  exit;
}

$mail = new PHPMailer(true);
$status = 'sent';
$error = '';

try {
  $mail->isSMTP();
  $mail->Host = 'smtp.hostinger.com';
  $mail->SMTPAuth = true;
  $mail->Username = 'survey@zrutaam.com';
  $mail->Password = '8LuLC35PiiK+';
  $mail->SMTPSecure = 'tls';
  $mail->Port = 587;

  $mail->setFrom('survey@zrutaam.com', 'Zrutaam');
  $mail->addAddress($email['emp_email'], $email['emp_name']);
  $mail->isHTML(true);
  $mail->Subject = '360 Survey';
  $mail->Body = "Dear {$email['emp_name']}, You have been invited for a survey. Please follow the link to take the survey. <br><br> <a href='https://zrutaam.com/version1/'>360 Degree survey</a> <br>Your code is {$email['unique_code']}.";

  $mail->send();
} catch (Exception $e) {
  $status = 'failed';
  $error = $mail->ErrorInfo;
}

// Update status in DB
$update = $pdo->prepare("UPDATE mail_original_table SET status = ? WHERE unique_code = ?");
$update->execute([$status, $email['unique_code']]);

echo json_encode([
  'email' => $email['emp_email'],
  'status' => $status === 'sent' ? '✅ Sent' : '❌ Failed: ' . $error,
  'done' => false
]);

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'db.php';

// Fetch the next pending email
// $stmt = $pdo->prepare("SELECT ce.email, ce.name, ce.unique_f_code, mot.emp_name FROM candidate_emails ce inner join mail_original_table mot on ce.unique_code = mot.unique_code WHERE ce.status = 'pending' ORDER BY ce.unique_f_code ASC LIMIT 1");

$stmt = $pdo->prepare("SELECT ce.email, ce.unique_f_code, mot.emp_name FROM candidate_emails ce inner join mail_original_table mot on ce.unique_code = mot.unique_code WHERE ce.status = 'pending' ORDER BY ce.unique_f_code ASC LIMIT 1");


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
  $mail->addAddress($email['email'], 'Perticipent');
  $mail->isHTML(true);
  $mail->Subject = '360 Survey';
  $mail->Body = "You have been invited for a survey of {$email['emp_name']}. Please follow the link to take the survey<br><a href='https://zrutaam.com/version1/others_index.php' target='_blank'>360 Survey</a>. <br>Your code is {$email['unique_f_code']}.";

  $mail->send();
} catch (Exception $e) {
  $status = 'failed';
  $error = $mail->ErrorInfo;
}

// Update status in DB
$update = $pdo->prepare("UPDATE candidate_emails SET status = ?, error = ? WHERE unique_f_code = ?");
$update->execute([$status, $error, $email['unique_f_code']]);

echo json_encode([
  'email' => $email['email'],
  'status' => $status === 'sent' ? '✅ Sent' : '❌ Failed: ' . $error,
  'done' => false
]);

<?php
session_start();
include './connection.php';
function generateRandomCode($length = 6)
{
  return substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
}

function generateUniqueCode($conn, $tableName, $columnName = 'unique_f_code', $length = 6)
{
  do {
    $code = generateRandomCode($length);
    $stmt = $conn->prepare("SELECT 1 FROM `$tableName` WHERE `$columnName` = ? LIMIT 1");
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $stmt->store_result();
    $exists = $stmt->num_rows > 0;
    $stmt->close();
  } while ($exists);

  return $code;
}

if (
  isset(
    $_POST['email1'],
    $_POST['email2'],
    $_POST['email3'],
    $_POST['email4'],
    $_POST['email5'],
    $_POST['email6'],
    $_POST['email7']
  ) &&
  !empty($_POST['email1']) &&
  !empty($_POST['email2']) &&
  !empty($_POST['email3']) &&
  !empty($_POST['email4']) &&
  !empty($_POST['email5']) &&
  !empty($_POST['email6']) &&
  !empty($_POST['email7']) &&
  isset($_SESSION['uni_code']) &&
  isset($_POST['submit_email']) &&
  isset($_GET['id'])
) {

  // Define the designations
  $designations = [
    'MANAGER',
    'PEER',
    'PEER',
    'PEER',
    'DIRECT REPORTEE',
    'DIRECT REPORTEE',
    'DIRECT REPORTEE'
  ];

  $i = 1;
  while ($i < 8) {
    $table = 'candidate_emails'; // change to your table name
    $uniqueCode = generateUniqueCode($conn, $table);
    $stmt = $conn->prepare("INSERT INTO candidate_emails(unique_code, email, unique_f_code, desg) VALUES(?, ?, ?, ?);");
    $stmt->bind_param("ssss", $_GET['id'], $_POST['email' . $i], $uniqueCode, $designations[$i - 1]);
    $stmt->execute();
    $i++;
  }
  header('location: ../Thankyou_page.php');
} else {
  header("location: ../index.php");
}

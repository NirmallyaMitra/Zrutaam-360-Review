<?php
session_start();
include 'connection.php'; // update this to match your actual DB config

// Get the unique ID from the URL
$unique_id = $_GET['id'] ?? null;

if (!$unique_id) {
  die("Unique ID not provided.");
}

// Fetch all question IDs from the database
$stmt = $conn->prepare("SELECT id FROM questions");
$stmt->execute();
$result = $stmt->get_result();

$i = 1;
while ($row = $result->fetch_assoc()) {
  $question_id = $row['id'];
  $answer_key = 'answer' . $i;

  // Check if the answer was submitted
  if (isset($_POST[$answer_key])) {
    $answer = $_POST[$answer_key];

    // Insert into candidate_response table
    $insertStmt = $conn->prepare("INSERT INTO others_response (unique_code, u_id, question_id, answer) VALUES (?, ?, ?, ?)");
    $insertStmt->bind_param("ssss", $unique_id, $_SESSION['u_c'], $question_id, $answer);
    $insertStmt->execute();
  }
  $i++;
}

$j = 1;
while ($j <= 10) {
  $improvement_area  = $_POST['commentPage' . $j . '_1'];
  $comment  = $_POST['commentPage' . $j . '_2'];

  $insertStmt2 = $conn->prepare("INSERT INTO comments (unique_code, uni_code, improvement_area, comment) VALUES (?, ?, ?, ?)");
  $insertStmt2->bind_param("ssss", $_SESSION['uni_code'], $_SESSION['u_c'], $improvement_area, $comment);
  $insertStmt2->execute();
  $j++;
}
header('location: ../Thankyou_page.php');

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
    $insertStmt = $conn->prepare("INSERT INTO candidate_response (unique_code, question_id, answer) VALUES (?, ?, ?)");
    $insertStmt->bind_param("sss", $unique_id, $question_id, $answer);
    $insertStmt->execute();
  }
  $i++;
}
header('location: ../email_list.php');

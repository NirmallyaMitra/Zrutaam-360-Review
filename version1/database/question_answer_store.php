<?php
// session_start();
// if (isset($_SESSION['uni_code']) && isset($_POST['question_submit'])) {
//   include './connection.php';
//   $total = 0;
//   for ($i = 1; $i <= 40; $i++) {
//     $total = $total + intval($_POST['answer' . $i]);
//   }
//   $stmt = $conn->prepare("INSERT INTO candidate_response VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?);");
//   $stmt->bind_param("sssssssssssssssssssssssssssssssssssssssssi", $_SESSION['uni_code'], $_POST['answer1'], $_POST['answer2'], $_POST['answer3'], $_POST['answer4'], $_POST['answer5'], $_POST['answer6'], $_POST['answer7'], $_POST['answer8'], $_POST['answer9'], $_POST['answer10'], $_POST['answer11'], $_POST['answer12'], $_POST['answer13'], $_POST['answer14'], $_POST['answer15'], $_POST['answer16'], $_POST['answer17'], $_POST['answer18'], $_POST['answer19'], $_POST['answer20'], $_POST['answer21'], $_POST['answer22'], $_POST['answer23'], $_POST['answer24'], $_POST['answer25'], $_POST['answer26'], $_POST['answer27'], $_POST['answer28'], $_POST['answer29'], $_POST['answer30'], $_POST['answer31'], $_POST['answer32'], $_POST['answer33'], $_POST['answer34'], $_POST['answer35'], $_POST['answer36'], $_POST['answer37'], $_POST['answer38'], $_POST['answer39'], $_POST['answer40'], $total);
//   $stmt->execute();
//   header('location: ../email_list.php');
// } else {
//   header("location: ../NotFound.php");
// }

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

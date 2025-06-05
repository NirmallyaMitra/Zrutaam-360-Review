<?php
session_start();
include './connection.php';

if (isset($_POST['step']) && isset($_POST['comment']) && isset($_SESSION['uni_code'])) {
  $step = intval($_POST['step']);
  $comment = trim($_POST['comment']);
  $uni_code = $_SESSION['uni_code']; // jar jonno korche
  $u_id = $_SESSION['u_c']; // j fillup korche

  $stmt = $conn->prepare("INSERT INTO comments (unique_code, uni_code, step, comment) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssis", $uni_code, $u_id, $step, $comment);

  if ($stmt->execute()) {
    echo "Comment saved successfully.";
  } else {
    echo "Failed to save comment.";
  }
} else {
  echo "Invalid request.";
}

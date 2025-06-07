<?php
  session_start();
  if(isset($_SESSION['uni_code']) && 
  isset($_POST['leaders_survey'])){
    include './connection.php';
    $stmt = $conn->prepare("INSERT INTO candidates_info VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
    $stmt->bind_param("ssssssssss",$_SESSION['uni_code'], $_POST['agegroup'], $_POST['gendergroup'], $_POST['department'], $_POST['organization'], $_POST['current-role'], $_POST['job-grade'], $_POST['educational-background'], $_POST['previous-role'], $_POST['location']);
    $stmt->execute();
    header('location: ../questions.php');
  } else {
      header("location: ../NotFound.php");
  }
?>
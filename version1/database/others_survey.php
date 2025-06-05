<?php
session_start();
if (
  isset($_SESSION['uni_code']) &&
  isset($_POST['others_survey'])
) {
  include './connection.php';
  $stmt = $conn->prepare("INSERT INTO others_info (uc, uni_code, RTL, tenure_in_org, dept, level_in_org, freq_wth_lea, location, age_group, gender) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
  $stmt->bind_param("ssssssssss", $_SESSION['u_c'], $_SESSION['uni_code'], $_POST['RTL'], $_POST['organization'], $_POST['department'], $_POST['level_wth_org'], $_POST['freq_wth_lea'], $_POST['location'], $_POST['agegroup'], $_POST['gendergroup']);
  $stmt->execute();
  header('location: ../others_questions.php');
} else {
  header("location: ../NotFound.php");
}

<?php
if (isset($_POST['submit_code'])) {
  include './database/connection.php';

  $code = trim($_POST['code_box']);

  $stmt = $conn->prepare("SELECT unique_code FROM candidate_emails WHERE unique_f_code = ?;");
  $stmt->bind_param('s', $code);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows == 0) {
    echo '<script>';
    echo 'if(confirm("Invalid Code")){';
    echo 'window.location.href = "./";';
    echo '}else{';
    echo 'window.location.href = "./";';
    echo '};';
    echo '</script>';
  } else {
    $row = $result->fetch_assoc();
    session_start();
    $_SESSION['uni_code'] = $row['unique_code']; // jar jonno fill up korchi
    $_SESSION['u_c'] = $code; // je fill up korche
    header('location: ./others_welcome.php');
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Page</title>
  <!-- ================================CSS LNK================================== -->
  <link rel="stylesheet" href="assets/CSS/index.css" />
  <!-- ================================CSS LNK================================== -->
  <!-- =====================================GOOGLE FONT================================= -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap" rel="stylesheet" />
  <!-- =====================================END GOOGLE FONT================================= -->
</head>

<body>
  <div id="" class="main-container">
    <div id="" class="container">
      <div id="" class="welcome-div">
        <h1 id="" class="welcome">
          <p id="" class="welcome-to">WELCOME TO</p>
          <p id="" class="review">
            <strong class="strong">360°</strong> REVIEW
          </p>
        </h1>
      </div>
      <div id="" class="seond-text">
        <p id="" class="lorem">
          Welcome to Your 360-Degree Leadership Assessment. Thank you for participating. Zrutaam is pleased to be facilitating this assessment on behalf of your organization. Your willingness to provide or receive thoughtful feedback is a vital part of building a stronger leadership culture.
        </p>
      </div>
      <div id="" class="form-div">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
          <label for="" class="text"><strong id="" class="emp">ENTER THE CODE</strong></label>
          <input type="text" name="code_box" id="" class="label-text" />
          <input type="submit" name="submit_code" value="SUBMIT" class="btn" />
        </form>
      </div>
    </div>
  </div>
</body>

</html>
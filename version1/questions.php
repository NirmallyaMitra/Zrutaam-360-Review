<?php
session_start();
if (isset($_SESSION['uni_code'])) {
  include './database/connection.php';
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Page 2</title>
    <!-- ================================CSS LNK================================== -->
    <link rel="stylesheet" href="./assets/CSS/questions.css" />
    <!-- ================================CSS LNK================================== -->
    <!-- =====================================GOOGLE FONT================================= -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap"
      rel="stylesheet" />
    <!-- =====================================END GOOGLE FONT================================= -->
  </head>

  <body>
    <div id="" class="main-container">
      <div id="" class="container">
        <!-- ===================== FORMS START HERE ======================== -->

        <form action="./database/question_answer_store.php?id=<?php echo $_SESSION['uni_code'] ?>" method="POST">
          <?php
          $stmt = $conn->prepare("SELECT * FROM questions;");
          $stmt->execute();
          $result = $stmt->get_result();
          $i = 1;
          $j = 1;
          while ($row = $result->fetch_assoc()) {
          ?>
            <!-- ====================== FORM 1 ========================== -->
            <div id="form<?php echo $i ?>" class="form">
              <p id="" class="q<?php echo $i ?> q">
                <?php echo $i ?> &rharu; <?php echo $row['question'] ?>
              </p>
              <div id="" class="input-box">
                <input type="radio"
                  name="answer<?php echo $i ?>"
                  class="change"
                  id="a<?php echo $j++ ?>"
                  value="1" />
                <label for="a<?php echo $j - 1 ?>" class="label-font change"><?php echo $row['op1'] ?></label>
                <input
                  type="radio"
                  name="answer<?php echo $i ?>"
                  value="2"
                  class="change"
                  id="a<?php echo $j++ ?>" />
                <label for="a<?php echo $j - 1 ?>" class="label-font change"><?php echo $row['op2'] ?></label>
                <input
                  type="radio"
                  value="3"
                  name="answer<?php echo $i ?>"
                  class="change"
                  id="a<?php echo $j++ ?>" />
                <label for="a<?php echo $j - 1 ?>" class="label-font change"><?php echo $row['op3'] ?></label>
                <input
                  type="radio"
                  name="answer<?php echo $i ?>"
                  value="4"
                  class="change"
                  id="a<?php echo $j++ ?>" />
                <label for="a<?php echo $j - 1 ?>" class="label-font change"><?php echo $row['op4'] ?></label>
                <input
                  type="radio"
                  name="answer<?php echo $i ?>"
                  value="5"
                  class="change"
                  id="a<?php echo $j++ ?>" />
                <label for="a<?php echo $j - 1 ?>" class="label-font change"><?php echo $row['op5'] ?></label>
                <input
                  type="radio"
                  name="answer<?php echo $i ?>"
                  value="0"
                  class="change"
                  id="a<?php echo $j++ ?>" />
                <label for="a<?php echo $j - 1 ?>" class="label-font change"><?php echo $row['op6'] ?></label>
              </div>
            </div>
          <?php
            $i += 1;
          }
          ?>
          <div id="" class="m-button">
            <button type="button" id="back" class="previous round">
              &lArr; Prev
            </button>
            <button type="button" id="next" class="next round">
              Next &rArr;
            </button>
            <input
              type="submit"
              value="SUBMIT"
              id="submit-button"
              name="question_submit"
              class="round" />
          </div>
        </form>
        <!-- ===================== FORMS END HERE ======================== -->
      </div>
    </div>

    <script src="assets/JS/main.js"></script>
  </body>

  </html>
<?php
} else {
  header('location: ./index.php');
}
?>
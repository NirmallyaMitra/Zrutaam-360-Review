<?php
session_start();
if (isset($_SESSION['uni_code'])) {
  include './database/connection.php';
  $stmt = $conn->prepare("SELECT * FROM questions;");
  $stmt->execute();
  $result = $stmt->get_result();
  $count = $result->num_rows;
  $k = 1;

  $stmt3 = $conn->prepare("SELECT emp_name FROM mail_original_table WHERE unique_code = ?;");
  $stmt3->bind_param('s', $_SESSION['uni_code']);
  $stmt3->execute();
  $result3 = $stmt3->get_result()->fetch_assoc();
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>360-Degree Feedback Survey</title>
    <link rel="stylesheet" href="styles.css" />
  </head>

  <body>
    <form action="./database/o_question_answer_store.php?id=<?php echo $_SESSION['uni_code'] ?>" method="POST" class="form-container" id="feedbackForm">
      <h1>360-Degree Feedback Survey</h1>
      <p>
        Please provide your honest feedback for <span style="font-weight: bold; color: black;"><?php echo $result3['emp_name']; ?></span> performance. Your
        responses will be kept confidential.
      </p>

      <div class="progress-bar">
        <div class="progress" id="progress"></div>
        <div class="progress-text" id="progressText">25%</div>
      </div>

      <div id="pages-container">
        <?php for ($i = 1; $i <= 10; $i++) { ?>
          <div class="page">
            <?php for ($j = 1; $j <= 4; $j++) {
              $row = $result->fetch_assoc();
            ?>
              <div class="question">
                <h3>
                  <span class="question-number"><?php echo $k . " of " . $count . ":"; ?></span> <?php echo $row['question']; ?>
                </h3>
                <div class="options">

                  <input type="radio" id="q<?php echo $k; ?>a" name="answer<?php echo $k; ?>" value="1" />
                  <label for="q<?php echo $k; ?>a"><?php echo $row['op1']; ?></label>

                  <input type="radio" id="q<?php echo $k; ?>b" name="answer<?php echo $k; ?>" value="2" />
                  <label for="q<?php echo $k; ?>b"><?php echo $row['op2']; ?></label>

                  <input type="radio" id="q<?php echo $k; ?>c" name="answer<?php echo $k; ?>" value="3" />
                  <label for="q<?php echo $k; ?>c"><?php echo $row['op3']; ?></label>

                  <input type="radio" id="q<?php echo $k; ?>d" name="answer<?php echo $k; ?>" value="4" />
                  <label for="q<?php echo $k; ?>d"><?php echo $row['op4']; ?></label>

                  <input type="radio" id="q<?php echo $k; ?>e" name="answer<?php echo $k; ?>" value="5" />
                  <label for="q<?php echo $k; ?>e"><?php echo $row['op5']; ?></label>

                  <input type="radio" id="q<?php echo $k; ?>f" name="answer<?php echo $k; ?>" value="0" />
                  <label for="q<?php echo $k; ?>f"><?php echo $row['op6']; ?></label>

                </div>
              </div>
            <?php
              $k++;
            } ?>
          </div>
        <?php } ?>
      </div>

      <!-- Comment boxes for page -->
      <?php for ($m = 1; $m <= 10; $m++) { ?>
        <div class="comment-boxes page<?php echo $m; ?>-comments" <?php if ($m != 1) echo "style='display: none'"; ?>>
          <div>
            <label for="commentPage<?php echo $m; ?>_1">What does the manager do well in communication?</label>
            <textarea
              id="commentPage<?php echo $m; ?>_1"
              name="commentPage<?php echo $m; ?>_1"
              maxlength="250"
              placeholder="Write your comment here..."></textarea>
          </div>
          <div>
            <label for="commentPage1_2">How could the manager improve in supporting the team?</label>
            <textarea
              id="commentPage<?php echo $m; ?>_2"
              name="commentPage<?php echo $m; ?>_2"
              maxlength="250"
              placeholder="Write your comment here..."></textarea>
          </div>
        </div>
      <?php } ?>

      <div class="btn-group">
        <button type="button" id="prevBtn" onclick="changePage(-1)" disabled>
          Previous
        </button>
        <button type="button" id="nextBtn" onclick="changePage(1)">Next</button>
        <button type="submit" id="submitBtn" style="display: none">
          Submit
        </button>
      </div>
    </form>

    <script>
      const pages = document.querySelectorAll(".page");
      const progress = document.getElementById("progress");
      const progressText = document.getElementById("progressText");
      const prevBtn = document.getElementById("prevBtn");
      const nextBtn = document.getElementById("nextBtn");
      const submitBtn = document.getElementById("submitBtn");
      let currentPage = 0;

      function showPage(index) {
        pages.forEach((page, i) => {
          page.classList.toggle("active", i === index);
        });
        prevBtn.disabled = index === 0;
        nextBtn.style.display =
          index === pages.length - 1 ? "none" : "inline-block";
        submitBtn.style.display =
          index === pages.length - 1 ? "inline-block" : "none";

        // Calculate and update percentage
        const percentage = Math.round(((index + 1) / pages.length) * 100);
        progress.style.width = `${percentage}%`;
        progressText.textContent = `${percentage}%`;
      }

      function changePage(direction) {
        if (direction === 1 && currentPage < pages.length - 1) currentPage++;
        else if (direction === -1 && currentPage > 0) currentPage--;
        showPage(currentPage);
      }

      document
        .getElementById("feedbackForm")
        .addEventListener("submit", function(e) {
          // Dynamically get all unique question names (radio groups)
          const questionNamesSet = new Set();
          const radioInputs = document.querySelectorAll('input[type="radio"]');
          radioInputs.forEach((input) => questionNamesSet.add(input.name));
          const questionNames = Array.from(questionNamesSet);

          let unanswered = [];
          questionNames.forEach((qName) => {
            const options = document.getElementsByName(qName);
            let answered = false;
            for (let opt of options) {
              if (opt.checked) {
                answered = true;
                break;
              }
            }
            if (!answered) {
              // Try to find label text for the first option of this question
              const firstOption = options[0];
              const label =
                document
                .querySelector(`label[for='${firstOption.id}']`)
                ?.closest(".question")
                ?.querySelector("h3")?.textContent || `Question ${qName}`;
              unanswered.push(`\n${label}`);
            }
          });

          if (unanswered.length > 0) {
            e.preventDefault();
            alert(
              "Please answer the following questions:" + unanswered.join("")
            );
          }
        });

      showPage(currentPage);
    </script>

    <script>
      function showPage(index) {
        pages.forEach((page, i) => {
          page.classList.toggle("active", i === index);
        });

        // Hide all comment boxes first
        document.querySelectorAll(".comment-boxes").forEach((box) => {
          box.style.display = "none";
        });

        // Show the comment boxes for the current page
        const currentCommentBox = document.querySelector(
          `.page${index + 1}-comments`
        );
        if (currentCommentBox) {
          currentCommentBox.style.display = "block";
        }

        prevBtn.disabled = index === 0;
        nextBtn.style.display =
          index === pages.length - 1 ? "none" : "inline-block";
        submitBtn.style.display =
          index === pages.length - 1 ? "inline-block" : "none";

        // Calculate and update percentage
        const percentage = Math.round(((index + 1) / pages.length) * 100);
        progress.style.width = `${percentage}%`;
        progressText.textContent = `${percentage}%`;
      }
    </script>

    <script>
      function changePage(direction) {
        if (direction === 1 && currentPage < pages.length - 1) currentPage++;
        else if (direction === -1 && currentPage > 0) currentPage--;
        showPage(currentPage);
        // Scroll to the top of the screen smoothly
        window.scrollTo({
          top: 0,
          behavior: "smooth"
        });
      }
    </script>
  </body>

  </html>
<?php
} else {
  header('location: ./');
}
?>
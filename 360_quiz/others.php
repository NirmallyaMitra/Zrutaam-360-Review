<?php
session_start();
if (isset($_SESSION['uni_code']) && isset($_SESSION['u_c'])) {
  include './database/connection.php';
  $stmt = $conn->prepare("SELECT desg FROM candidate_emails WHERE unique_f_code = ?;");
  $stmt->bind_param('s', $_SESSION['u_c']);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Page 6</title>
    <!-- ================================CSS LNK================================== -->
    <link rel="stylesheet" href="./assets/CSS/others.css" />
    <!-- ================================CSS LNK================================== -->
    <!-- =====================================GOOGLE FONT================================= -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap" rel="stylesheet" />
    <!-- =====================================END GOOGLE FONT================================= -->
  </head>

  <body>
    <div id="" class="main-container">
      <div id="" class="container">
        <form action="./database/others_survey.php" method="POST">
          <div class="div-others"><strong>For Others</strong></div>
          <div class="text-div">
            <label for="">Relationship to the Leader Being Rated</label>
            <input type="text" class="rated" value="<?php echo $row['desg']; ?>" disabled>
            <input type="hidden" name="RTL" value="<?php echo $row['desg']; ?>">
            <label for="">Tenure in the Organization</label>
            <select name="organization" id="organization" class="o-group">
              <option value="less1year">Less than 1 year</option>
              <option value="onetothreeyears">1-3 years</option>
              <option value="fourtosixyears">4-6 years</option>
              <option value="seventotenyears">7-10 years</option>
              <option value="morethantenyears">More than 10 years</option>
            </select>
            <label for="">Department / Function</label>
            <select name="department" id="department" class="d-group">
              <option value="pnt">PnT</option>
              <option value="cf">CF</option>
              <option value="iops">IOPS</option>
              <option value="hr">HR</option>
              <option value="finance">Finance</option>
            </select>
            <label for="">Level within the Organization</label>
            <select name="level_wth_org" id="level-organization" class="level">
              <option value="entry-level">Entry Level</option>
              <option value="mid-level">Mid-Level</option>
              <option value="senior-level">Senior Level</option>
              <option value="executive">Executive</option>
            </select>
            <label for="">Frequency of Interaction with the Leader</label>
            <select name="freq_wth_lea" id="Frequency-of-Interaction" class="interaction">
              <option value="daily">Daily</option>
              <option value="weekly">Weekly</option>
              <option value="monthly">Monthly</option>
              <option value="rarely">Rarely</option>
            </select>
            <label for="">Location</label>
            <select name="location" id="location-id" class="location">
              <option value="pune">Pune</option>
              <option value="Hyderabad">Hyderabad</option>
            </select>
            <label for="">Age Group :</label>
            <select name="agegroup" id="agegroup" class="a-group">
              <option value="under 25">Under 25</option>
              <option value="under 25-34">25-34</option>
              <option value="under 35-44">35-44</option>
              <option value="under 45-54">45-54</option>
              <option value="under 55-64">55-64</option>
              <option value="over 65">65 or older</option>
            </select>
            <label for="">Gender</label>
            <div class="ab">
              <select name="gendergroup" id="gendergroup" class="g-group">
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="third-gender">Non-binary / Third gender</option>
                <option value="self-describe">Prefer to self describe :</option>
                <option value="not-say">Prefer not to say</option>
              </select>
              <input type="text" name="prefer" id="self-1" />
            </div>
          </div>
          <div class="button">
            <input type="submit" value="SUBMIT" name="others_survey" class="btn" />
          </div>
        </form>
      </div>
    </div>
    <script src="./assets/JS/others.js"></script>
  </body>

  </html>
<?php
} else {
  header("location: ./");
}
?>
<?php
session_start();
if(isset($_SESSION['uni_code'])){
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Page 5</title>
    <!-- ================================CSS LNK================================== -->
    <link rel="stylesheet" href="./assets/CSS/leaders.css" />
    <!-- ================================CSS LNK================================== -->
    <!-- =====================================GOOGLE FONT================================= -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;400;500;600;700;800;900&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap"
      rel="stylesheet"
    />
    <!-- =====================================END GOOGLE FONT================================= -->
  </head>
  <body>
    <div id="" class="main-container">
      <div id="" class="container">
        <form action="./database/leaders_survey.php" method="POST">
          <div class="div-leaders"><strong>For Leaders</strong></div>
          <div class="text-div">
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
            <label for="">Department / Function</label>
            <select name="department" id="department" class="d-group">
              <option value="pnt">PnT</option>
              <option value="cf">CF</option>
              <option value="iops">IOPS</option>
              <option value="hr">HR</option>
              <option value="finance">Finance</option>
            </select>
            <label for="">Tenure in the Organization</label>
            <select name="organization" id="organization" class="o-group">
              <option value="less1year">Less than 1 year</option>
              <option value="onetothreeyears">1-3 years</option>
              <option value="fourtosixyears">4-6 years</option>
              <option value="seventotenyears">7-10 years</option>
              <option value="morethantenyears">More than 10 years</option>
            </select>
            <label for="">Tenure in Current Role</label>
            <select name="current-role" id="current-role" class="c-role">
              <option value="less1year">Less than 1 year</option>
              <option value="onetothreeyears">1-3 years</option>
              <option value="fourtosixyears">4-6 years</option>
              <option value="seventotenyears">7-10 years</option>
              <option value="morethantenyears">More than 10 years</option>
            </select>
            <label for="">Job Grade</label>
            <select name="job-grade" id="job-grade" class="job">
              <option value="8">8</option>
              <option value="7">7</option>
              <option value="6">6</option>
              <option value="5">5</option>
              <option value="4">4</option>
            </select>
            <label for="">Educational Background</label>
            <select
              name="educational-background"
              id="educational-background"
              class="education"
            >
              <option value="highschool">
                High School Diploma or Equivalent
              </option>
              <option value="Associates-Degree">Associate's Degree</option>
              <option value="Bachelors-Degree">Bachelor's Degree</option>
              <option value="Masters-Degree">Master's Degree</option>
              <option value="Doctoral-Degree">Doctorate or higher</option>
              <option value="other">Other</option>
            </select>
            <label for="Previous Roles">Previous Roles</label>
            <select name="previous-role" id="previous-role" class="previous">
              <option value="Within-the-organization-only">
                Within the organization only
              </option>
              <option value="Outside-the-organization-only">
                Outside the organization only
              </option>
              <option value="Both-within-and-outside-the-organization">
                Both within and outside the organization
              </option>
              <option value="This-is-my-first-leadership-role">
                This is my first leadership role
              </option>
            </select>
            <label for="">Location</label>
            <select name="location" id="location-id" class="location">
              <option value="pune">Pune</option>
              <option value="Hyderabad">Hyderabad</option>
            </select>
          </div>
          <div class="button">
            <input type="submit" value="SUBMIT" class="btn" name="leaders_survey"/>
          </div>
        </form>
      </div>
    </div>
    <script src="./assets/JS/leaders.js"></script>
  </body>
</html>
<?php
}else{
  header("loction: ./index.php");
}
?>
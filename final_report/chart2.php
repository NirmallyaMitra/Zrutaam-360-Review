<?php
include "../version1/database/connection.php";

$sql = "SELECT q.category,ROUND(AVG(s.answer), 2) AS average_score FROM candidate_response s JOIN questions q ON s.question_id = q.id WHERE s.unique_code = ? GROUP BY q.category ORDER BY q.category asc;";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$sql1 = "SELECT q.category, ROUND(AVG(o.answer), 2) AS average_score FROM others_response o JOIN questions q ON o.question_id = q.id WHERE o.unique_code = ?
GROUP BY q.category ORDEr BY q.category asc;";

$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param("i", $id);
$stmt1->execute();
$result1 = $stmt1->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Chart</title>
  <!-- ! ========================== CSS =============================================== -->
  <style>
    * {
      box-sizing: border-box;
    }

    .chart2-body {
      height: 100%;
      width: 100%;
      background-color: white;
    }

    .chart2-main-container {
      display: inline-block;
      position: relative;
      width: 21cm;
      height: 29.7cm;
      padding-left: 30px;
      margin: 0 auto;
    }

    .chart2-side-text {
      height: 560px;
      width: 50px;
      font-weight: 900;
      position: absolute;
      top: 380px;
      left: 720px;
      text-align: end;
    }

    .chart2-side-1 {
      padding-top: 26px;
    }

    .chart2-side-2 {
      padding-top: 34px;
    }

    .chart2-side-3 {
      padding-top: 34px;
    }

    .chart2-side-4 {
      padding-top: 34px;
    }

    .chart2-side-5 {
      padding-top: 32px;
    }

    .chart2-side-6 {
      padding-top: 32px;
    }

    .chart2-side-7 {
      padding-top: 32px;
    }

    .chart2-side-8 {
      padding-top: 32px;
    }

    .chart2-side-9 {
      padding-top: 32px;
    }

    .chart2-side-10 {
      padding-top: 32px;
    }

    .chart2-heading {
      display: block;
      width: 100%;
      text-align: center;
      margin-top: 100px;
    }

    .chart2-text {
      margin-top: 100px;
      margin-bottom: 100px;
    }

    .chart2-bigger-text {
      padding-bottom: 20px;
      color: gray;
    }

    .chart2-normal-text {
      width: 640px;
      color: gray;
    }

    /* ! ================================= UPPER TEXT ====================================== */

    .chart2-upper-text {
      display: block;
      height: 100px;
      width: 638px;
      position: absolute;
      top: 313px;
    }

    .chart2-competencies {
      padding-top: 73px;
      font-size: 20px;
      font-weight: 900;
      padding-right: 145px;
    }

    .chart2-level {
      display: block;
      text-align: end;
      font-weight: 900;
      padding-left: 10px;
      width: 20px;
      font-size: 12px;
    }

    .chart2-level-1 {
      margin-top: -70px;
      margin-left: 308px;
    }

    .chart2-level-2 {
      margin-top: -45px;
      margin-left: 385px;
    }

    .chart2-level-3 {
      margin-top: -59px;
      margin-left: 465px;
    }

    .chart2-level-4 {
      margin-top: -80px;
      margin-left: 545px;
    }

    .chart2-level-5 {
      padding-top: -40px;
      margin-top: -155px;
      margin-left: 618px;
    }

    /* ! ================================= END UPPER TEXT ====================================== */

    /* ! ================================= DASHED BORDER ====================================== */

    .chart2-dashed-border {
      display: block;
      position: absolute;
      height: 524px;
      width: 457px;
      top: 410px;
      left: 260px;
      z-index: 1;
    }

    .chart2-border-1 {
      border-right: 2px dashed black;
      height: 524px;
      width: 20%;
    }

    .chart2-border-2 {
      margin-top: -525px;
      margin-left: 78px;
      border-right: 2px dashed black;
      height: 524px;
      width: 20%;
    }

    .chart2-border-3 {
      border-right: 2px dashed black;
      margin-top: -525px;
      margin-left: 156px;
      height: 524px;
      width: 20%;
    }

    .chart2-border-4 {
      border-right: 2px dashed black;
      margin-top: -525px;
      margin-left: 234px;
      height: 524px;
      width: 20%;
    }

    .chart2-border-5 {
      border-right: 2px dashed black;
      margin-top: -525px;
      margin-left: 312px;
      height: 524px;
      width: 20%;
    }

    /* ! ================================= DASHED BORDER END ====================================== */

    /* ! ================================= TABLE ====================================== */

    .chart2-i {
      font-size: 13px;
      color: blue;
      font-weight: 900;
      height: 50px;
      width: 230px;
    }

    .chart2-j {
      width: 400px;
    }

    .chart2-table1 {
      border: 2px solid black;
      border-collapse: collapse;
    }

    .chart2-outer-bar {
      position: relative;
      height: 20px;
      width: 400px;
    }

    .chart2-inner-bar {
      padding-top: 3px;
      font-size: 12px;
      font-weight: 900;
      height: 20px;
      background-color: #00e4fe;
      border: 1px solid black;
    }

    .chart2-slider {
      position: absolute;
      border: 1px solid black;
      height: 27px;
      width: 1px;
      top: -3px;
    }

    /* ! ================================= TABLE ENDING ====================================== */

    /* ! ================================= CHART BOTTOM ====================================== */

    .chart2-chart-bottom {
      display: block;
      height: 30px;
      width: 200px;
      margin-top: 15px;
      font-size: 10px;
      font-weight: 900;
    }

    .chart2-blue {
      height: 18px;
      width: 45px;
      background-color: #00e4fe;
      border: 1px solid black;
      margin-right: 5px;
    }

    .chart2-bottom-text {
      margin-top: -15px;
      margin-left: 50px;
    }

    .chart2-small-div {
      display: block;
      position: absolute;
      left: 175px;
      top: 938px;
      margin-left: 5px;
      margin-right: 5px;
      border: 1px solid black;
      height: 25px;
      width: 8px;
    }

    .chart2-bottom-text-1 {
      margin-top: -10px;
      margin-left: 170px;
    }

    .chart2-oa {
      border-bottom: 1px solid black;
      height: 30px;
      width: 260px;
      margin-top: -4px;
      line-height: 15px;
      font-size: 10px;
      font-weight: 900;
    }

    .chart2-zrutam {
      font-size: 20px;
      color: gray;
      margin-top: 90px;
    }

    /* ! ================================= END CHART BOTTOM ====================================== */
  </style>
  <!-- ! ========================== END CSS =============================================== -->
</head>

<body class="chart2-body">
<div class="border12"></div>
  <div class="chart2-main-container">
    <div class="heading">
      <strong class="heading1">[<?php echo $var_name ?>]</strong>
    </div>
    <div class="chart2-text">
      <p class="chart2-bigger-text">EXECUTIVE SUMMARY</p>
      <p class="chart2-normal-text">
        This section provides a ranking order of your proficiency rating in
        all of the com-petencies, from your strongest area to the area needing
        the most development based on the average score of all respondents
        (does not include your self rating).
      </p>
    </div>
    <div class="chart2-side-text">
      <p class="chart2-side">Self</p>
      <?php
      $i = 1;
      $self_score = [];
      while ($row = $result->fetch_assoc()) {
        $self_score[$i - 1] = $row["average_score"];
      ?>
        <p class="chart2-side-<?php echo $i ?>"><?php echo $row["average_score"] ?></p>
      <?php
        $i++;
      }
      ?>
    </div>
    <div class="chart2-upper-text">
      <p class="chart2-competencies">Competencies</p>
      <div class="chart2-level chart2-level-1">Very Low Level 1</div>
      <div class="chart2-level chart2-level-2">Low Level 2</div>
      <div class="chart2-level chart2-level-3">Mod-erate Level 3</div>
      <div class="chart2-level chart2-level-4">High Level 4</div>
      <div class="chart2-level chart2-level-5">Very High Level 5</div>
    </div>
    <div class="chart2-dashed-border">
      <div class="chart2-border-1 chart2-border"></div>
      <div class="chart2-border-2 chart2-border"></div>
      <div class="chart2-border-3 chart2-border"></div>
      <div class="chart2-border-4 chart2-border"></div>
      <div class="chart2-border-5 chart2-border"></div>
    </div>
    <div class="chart2-chart">
      <table id="chart2-table" class="chart2-table1" border="black">
        <?php
        $i = 0;
        while ($row1 = $result1->fetch_assoc()) {
        ?>
          <tr>
            <td class="chart2-i"><?php echo $row1["category"] ?></td>
            <td class="chart2-j">
              <div class="chart2-outer-bar">
                <div class="chart2-inner-bar" style="width: <?php echo $row1["average_score"] * 10 ?>%" id="<?php echo $row1["category"] ?>">
                  <div class="chart2-slider" style="left: <?php echo $self_score[$i] * 10 ?>%" id="self-<?php echo $row1["category"] ?>"></div>
                  <?php echo $row1["average_score"] ?>
                </div>
              </div>
            </td>
          </tr>
        <?php
          $i++;
        }
        ?>
      </table>
    </div>
    <div class="chart2-chart-bottom">
      <div class="chart2-blue"></div>
      <p class="chart2-bottom-text">OA: Overall Average</p>
      <div class="chart2-small-div"></div>
      <p class="chart2-bottom-text-1">Self</p>
    </div>
    <div class="chart2-oa">
      OA: Overall Average of all your raters (self excluded).<br />
      Run Date:07/17/03
    </div>
    <div class="chart2-zrutam">360-degree Assessment Zrutam Inc</div>
  </div>
</body>

</html>
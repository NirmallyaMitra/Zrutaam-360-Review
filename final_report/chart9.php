<?php
include '../version1/database/connection.php';

$sql = "WITH my_avg AS ( 
    SELECT
    	q.id,
        q.question, 
        cr.answer AS my_a 
    FROM 
        candidate_response cr 
    INNER JOIN 
        questions q ON cr.question_id = q.id 
    WHERE 
        cr.unique_code = ? 
    GROUP BY 
        q.question
), 
overall_avg AS ( 
    SELECT 
    	q.id,
        q.question, 
        AVG(o.answer) AS o_a 
    FROM 
        others_response o 
    INNER JOIN 
        questions q ON o.question_id = q.id
    WHERE 
        o.unique_code = ? 
    GROUP BY 
        q.question
),
diffs AS (
    SELECT
    	my_avg.id,
        my_avg.question, 
        my_avg.my_a, 
        overall_avg.o_a, 
        ROUND(my_avg.my_a - overall_avg.o_a, 2) AS diff
    FROM 
        my_avg 
    JOIN 
        overall_avg ON my_avg.question = overall_avg.question 
),
ranked AS (
    SELECT *, 
        RANK() OVER (ORDER BY diff DESC) AS rnk 
    FROM diffs
)
SELECT *
FROM ranked
where rnk <= 10
ORDER BY rnk";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $id, $id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
  $combined[] = [
    'id'       => $row['id'],
    'question' => $row['question'],
    'my_a'     => $row['my_a'],
    'o_a'      => $row['o_a']
  ];
  $diff[] = $row['diff'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CHART 9</title>
  <style>
    .chart9-body {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    .chart9-main-container {
      display: inline-block;
      position: relative;
      width: 21cm;
      height: 29.7cm;
      padding-left: 30px;
    }

    .chart9-bold {
      position: absolute;
      top: 50px;
      left: 0;
      text-align: center;
      font-weight: bold;
      font-size: 14px;
      width: 793px;
    }

    .chart9-bold1 {
      position: absolute;
      top: 100px;
      left: 100px;
      font-weight: bold;
      font-size: 20px;
      width: 793px;
    }

    .chart9-center-text {
      position: absolute;
      top: 140px;
      left: 100px;
      width: 620px;
      font-weight: bold;
      font-size: 14px;
    }

    .chart9-text {
      position: absolute;
      font-size: 10px;
      font-weight: bold;
      top: 230px;
      left: 474px;
      text-align: right;
    }

    .chart9-text1 {
      position: absolute;
      font-size: 10px;
      font-weight: bold;
      top: 238px;
      left: 532px;
      text-align: right;
    }

    .chart9-text2 {
      position: absolute;
      font-size: 10px;
      font-weight: bold;
      top: 230px;
      left: 595px;
      text-align: right;
    }

    .chart9-text3 {
      position: absolute;
      font-size: 10px;
      font-weight: bold;
      top: 238px;
      left: 653px;
      text-align: right;
    }

    .chart9-text4 {
      position: absolute;
      font-size: 10px;
      font-weight: bold;
      top: 230px;
      left: 713px;
      text-align: right;
    }

    .chart9-text5 {
      position: absolute;
      font-size: 10px;
      font-weight: bold;
      top: 235px;
      left: 745px;
      text-align: right;
    }

    .chart9-redd {
      color: red;
    }

    .chart9-rb1 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      top: 300px;
      left: 745px;
      text-align: right;
    }

    .chart9-rb2 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      top: 358px;
      left: 745px;
      text-align: right;
    }

    .chart9-rb3 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      top: 405px;
      left: 745px;
      text-align: right;
    }

    .chart9-rb4 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      top: 455px;
      left: 745px;
      text-align: right;
    }

    .chart9-rb5 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      top: 519px;
      left: 745px;
      text-align: right;
    }

    .chart9-rb6 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      top: 570px;
      left: 745px;
      text-align: right;
    }

    .chart9-rb7 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      top: 620px;
      left: 745px;
      text-align: right;
    }

    .chart9-rb8 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      top: 680px;
      left: 745px;
      text-align: right;
    }

    .chart9-rb9 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      top: 730px;
      left: 745px;
      text-align: right;
    }

    .chart9-rb10 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      top: 790px;
      left: 745px;
      text-align: right;
    }

    .chart9-line {
      position: absolute;
      top: 280px;
      left: 495px;
      z-index: 20;
      width: 0px;
      height: 560px;
      border: 0.4px dashed black;
    }

    .chart9-line1 {
      position: absolute;
      top: 280px;
      left: 555px;
      z-index: 20;
      width: 0px;
      height: 560px;
      border: 0.4px dashed black;
    }

    .chart9-line2 {
      position: absolute;
      top: 280px;
      left: 615px;
      z-index: 20;
      width: 0px;
      height: 560px;
      border: 0.4px dashed black;
    }

    .chart9-line3 {
      position: absolute;
      top: 280px;
      left: 675px;
      z-index: 20;
      width: 0px;
      height: 560px;
      border: 0.4px dashed black;
    }

    .chart9-line4 {
      position: absolute;
      top: 280px;
      left: 735px;
      z-index: 20;
      width: 0px;
      height: 560px;
      border: 0.4px dashed black;
    }

    .chart9-table {
      position: absolute;
      top: 280px;
      left: 100px;
      width: 620px;
      height: auto;
      border: 1px solid black;
      border-collapse: collapse;
    }

    .chart9-td-left {
      width: 320px;
      padding: 3px 7px 3px 7px;
    }

    .chart9-blue {
      font-size: 14px;
      color: blue;
    }

    .chart9-td-right {
      width: 300px;
    }

    .chart9-div-red {
      height: 20px;
      width: 240px;
      font-weight: bold;
      padding-top: 2px;
      font-size: 13px;
      background-color: rgb(255, 109, 109);
    }

    .chart9-div-blue {
      height: 20px;
      width: 300px;
      font-weight: bold;
      padding-top: 2px;
      font-size: 13px;
      background-color: rgb(122, 122, 255);
      margin: 5px 0px;
    }

    .chart9-n1 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      bottom: 265px;
      left: 492px;
    }

    .chart9-n2 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      bottom: 265px;
      left: 550px;
    }

    .chart9-n3 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      bottom: 265px;
      left: 610px;
    }

    .chart9-n4 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      bottom: 265px;
      left: 670px;
    }

    .chart9-n5 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      bottom: 265px;
      left: 735px;
    }

    .chart9-small-blue {
      height: 20px;
      width: 70px;
      background-color: rgb(122, 122, 255);
      position: absolute;
      bottom: 200px;
      left: 100px;
      border: 1px solid black;
    }

    .chart9-oa {
      font-size: 14px;
      position: absolute;
      bottom: 200px;
      left: 180px;
    }

    .chart9-small-red {
      height: 20px;
      width: 70px;
      background-color: rgb(255, 109, 109);
      position: absolute;
      bottom: 200px;
      left: 350px;
      border: 1px solid black;
    }

    .chart9-self {
      font-size: 14px;
      position: absolute;
      bottom: 200px;
      left: 440px;
    }

    .chart9-bottom {
      position: absolute;
      bottom: 20px;
      left: 20px;
      color: gray;
    }
  </style>
</head>

<body class="chart9-body">
  <div class="chart9-main-container">
    <p class="chart9-bold">--------------360 Assessment Feedback for <?php echo $var_name ?>---------</p>
    <p class="chart9-bold1">TOP OPPORTUNITIES FOR DEVELOPMENT</p>
    <p class="chart9-center-text">To understand how others view your development needs and how they are defined in behaviors is important. Recognizing your own opportunities for development will help you to focus your developmental efforts where you can have the greatest impact.</p>
    <span class="chart9-text"> Very<br>Low<br>Level<br>1</span>
    <span class="chart9-text1">Low<br>Level<br>2</span>
    <span class="chart9-text2">Mod-<br>erate<br>Level<br>3</span>
    <span class="chart9-text3">High<br>Level<br>4</span>
    <span class="chart9-text4"> Very<br>High<br>Level<br>5</span>
    <span class="chart9-text5">Gap<br>(OA - <br>Self)</span>
    <?php $j = 1;
    foreach ($diff as $i) { ?>
      <span class="chart9-rb<?php echo $j ?>"><?php echo $i; ?></span>
    <?php $j++;
    } ?>
    <!-- <span class="chart9-rb2 chart9-redd">-1.67</span>
    <span class="chart9-rb3">-.57</span>
    <span class="chart9-rb4">.71</span>
    <span class="chart9-rb5">.71</span>
    <span class="chart9-rb6">.71</span>
    <span class="chart9-rb7 chart9-redd">-.57</span>
    <span class="chart9-rb8">.71</span>
    <span class="chart9-rb9">.71</span>
    <span class="chart9-rb10">.71</span> -->
    <div class="chart9-line"></div>
    <div class="chart9-line1"></div>
    <div class="chart9-line2"></div>
    <div class="chart9-line3"></div>
    <div class="chart9-line4"></div>
    <table class="chart9-table" border="1">
      <?php foreach ($combined as $j) { ?>
        <tr>
          <td class="chart9-td-left">
            <p class="chart9-blue"><?php echo $j['id'] . ". " . $j['question'] ?></p>
          </td>
          <td class="chart9-td-right">
            <div class="chart9-div-red" style="width: <?php echo $j['my_a'] * 20 ?>%"><?php echo $j['my_a'] ?></div>
            <div class="chart9-div-blue" style="width: <?php echo $j['o_a'] * 20 ?>%"><?php echo $j['o_a'] ?></div>
          </td>
        </tr>
      <?php } ?>
      <!-- <tr>
        <td class="chart9-td-left">
          <p class="chart9-blue">36. Prioritize activities and makes adjustments to maintain schedules.</p>
        </td>
        <td class="chart9-td-right">
          <div class="chart9-div-red">4.00</div>
          <div class="chart9-div-blue">4.71</div>
        </td>
      </tr>
      <tr>
        <td class="chart9-td-left">
          <p class="chart9-blue">33. Allows enough time to manage subordinates and complete own work assignments.</p>
        </td>
        <td class="chart9-td-right">
          <div class="chart9-div-red">4.00</div>
          <div class="chart9-div-blue">4.71</div>
        </td>
      </tr>
      <tr>
        <td class="chart9-td-left">
          <p class="chart9-blue">11. Makes an extra effort, through alternative choices, to satisfy customer demands.</p>
        </td>
        <td class="chart9-td-right">
          <div class="chart9-div-red">4.00</div>
          <div class="chart9-div-blue">4.71</div>
        </td>
      </tr>
      <tr>
        <td class="chart9-td-left">
          <p class="chart9-blue">24. Tests or simulates new theories or strategies that can help improve operations.</p>
        </td>
        <td class="chart9-td-right">
          <div class="chart9-div-red">4.00</div>
          <div class="chart9-div-blue">4.71</div>
        </td>
      </tr>
      <tr>
        <td class="chart9-td-left">
          <p class="chart9-blue">21. Shows creativity in developing new ideas/opportunities for growth or profit.</p>
        </td>
        <td class="chart9-td-right">
          <div class="chart9-div-red">4.00</div>
          <div class="chart9-div-blue">4.71</div>
        </td>
      </tr>
      <tr>
        <td class="chart9-td-left">
          <p class="chart9-blue">34. Efficiently utilizes available staff, resources and materials to complete work.</p>
        </td>
        <td class="chart9-td-right">
          <div class="chart9-div-red">4.00</div>
          <div class="chart9-div-blue">4.71</div>
        </td>
      </tr>
      <tr>
        <td class="chart9-td-left">
          <p class="chart9-blue">13. Makes timely decisions.</p>
        </td>
        <td class="chart9-td-right">
          <div class="chart9-div-red">4.00</div>
          <div class="chart9-div-blue">4.71</div>
        </td>
      </tr>
      <tr>
        <td class="chart9-td-left">
          <p class="chart9-blue">16. Clearly communicates dead-lines, options and resources for decision-making.</p>
        </td>
        <td class="chart9-td-right">
          <div class="chart9-div-red">4.00</div>
          <div class="chart9-div-blue">4.71</div>
        </td>
      </tr>
      <tr>
        <td class="chart9-td-left">
          <p class="chart9-blue">10. Effectively and quickly handles customer complaints.</p>
        </td>
        <td class="chart9-td-right">
          <div class="chart9-div-red">4.00</div>
          <div class="chart9-div-blue">4.71</div>
        </td>
      </tr> -->
    </table>
    <span class="chart9-n1">1</span>
    <span class="chart9-n2">2</span>
    <span class="chart9-n3">3</span>
    <span class="chart9-n4">4</span>
    <span class="chart9-n5">5</span>
    <div class="chart9-small-blue"></div>
    <span class="chart9-oa">OA: Overall Average</span>
    <div class="chart9-small-red"></div>
    <span class="chart9-self">Self</span>
    <p class="chart9-bottom">360-degree Assessment. Zrutam Inc</p>
  </div>
</body>

</html>
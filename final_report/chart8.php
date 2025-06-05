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
        RANK() OVER (ORDER BY diff ASC) AS rnk 
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
  <title>CHART 8</title>
  <style>
    .chart8-body {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    .chart8-main-container {
      display: inline-block;
      position: relative;
      width: 21cm;
      height: 29.7cm;
      padding-left: 30px;
    }

    .chart8-bold {
      position: absolute;
      top: 50px;
      left: 0;
      text-align: center;
      font-weight: bold;
      font-size: 14px;
      width: 793px;
    }

    .chart8-bold1 {
      position: absolute;
      top: 100px;
      left: 100px;
      font-weight: bold;
      font-size: 20px;
      width: 793px;
    }

    .chart8-center-text {
      position: absolute;
      top: 140px;
      left: 100px;
      width: 620px;
    }

    .chart8-text {
      position: absolute;
      font-size: 10px;
      font-weight: bold;
      top: 230px;
      left: 474px;
      text-align: right;
    }

    .chart8-text1 {
      position: absolute;
      font-size: 10px;
      font-weight: bold;
      top: 238px;
      left: 532px;
      text-align: right;
    }

    .chart8-text2 {
      position: absolute;
      font-size: 10px;
      font-weight: bold;
      top: 230px;
      left: 595px;
      text-align: right;
    }

    .chart8-text3 {
      position: absolute;
      font-size: 10px;
      font-weight: bold;
      top: 238px;
      left: 653px;
      text-align: right;
    }

    .chart8-text4 {
      position: absolute;
      font-size: 10px;
      font-weight: bold;
      top: 230px;
      left: 713px;
      text-align: right;
    }

    .chart8-text5 {
      position: absolute;
      font-size: 10px;
      font-weight: bold;
      top: 235px;
      left: 745px;
      text-align: right;
    }

    .chart8-rb1 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      top: 300px;
      left: 745px;
      text-align: right;
    }

    .chart8-rb2 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      top: 358px;
      left: 745px;
      text-align: right;
    }

    .chart8-rb3 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      top: 405px;
      left: 745px;
      text-align: right;
    }

    .chart8-rb4 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      top: 455px;
      left: 745px;
      text-align: right;
    }

    .chart8-rb5 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      top: 519px;
      left: 745px;
      text-align: right;
    }

    .chart8-rb6 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      top: 570px;
      left: 745px;
      text-align: right;
    }

    .chart8-rb7 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      top: 620px;
      left: 745px;
      text-align: right;
    }

    .chart8-rb8 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      top: 680px;
      left: 745px;
      text-align: right;
    }

    .chart8-rb9 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      top: 730px;
      left: 745px;
      text-align: right;
    }

    .chart8-rb10 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      top: 790px;
      left: 745px;
      text-align: right;
    }

    .chart8-line {
      position: absolute;
      top: 280px;
      left: 495px;
      z-index: 20;
      width: 0px;
      height: 560px;
      border: 0.4px dashed black;
    }

    .chart8-line1 {
      position: absolute;
      top: 280px;
      left: 555px;
      z-index: 20;
      width: 0px;
      height: 560px;
      border: 0.4px dashed black;
    }

    .chart8-line2 {
      position: absolute;
      top: 280px;
      left: 615px;
      z-index: 20;
      width: 0px;
      height: 560px;
      border: 0.4px dashed black;
    }

    .chart8-line3 {
      position: absolute;
      top: 280px;
      left: 675px;
      z-index: 20;
      width: 0px;
      height: 560px;
      border: 0.4px dashed black;
    }

    .chart8-line4 {
      position: absolute;
      top: 280px;
      left: 735px;
      z-index: 20;
      width: 0px;
      height: 560px;
      border: 0.4px dashed black;
    }

    .chart8-table {
      position: absolute;
      top: 280px;
      left: 100px;
      width: 620px;
      height: auto;
      border: 1px solid black;
      border-collapse: collapse;
    }

    .chart8-td-left {
      width: 320px;
      padding: 3px 7px 3px 7px;
    }

    .chart8-blue {
      font-size: 14px;
      color: blue;
    }

    .chart8-td-right {
      width: 300px;
    }

    .chart8-div-red {
      height: 20px;
      font-weight: bold;
      padding-top: 2px;
      font-size: 13px;
      background-color: rgb(255, 109, 109);
    }

    .chart8-div-blue {
      height: 20px;
      width: 300px;
      font-weight: bold;
      padding-top: 2px;
      font-size: 13px;
      background-color: rgb(122, 122, 255);
      margin: 5px 0px;
    }

    .chart8-n1 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      bottom: 265px;
      left: 492px;
    }

    .chart8-n2 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      bottom: 265px;
      left: 550px;
    }

    .chart8-n3 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      bottom: 265px;
      left: 610px;
    }

    .chart8-n4 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      bottom: 265px;
      left: 670px;
    }

    .chart8-n5 {
      position: absolute;
      font-size: 15px;
      font-weight: bold;
      bottom: 265px;
      left: 735px;
    }

    .chart8-small-blue {
      height: 20px;
      width: 70px;
      background-color: rgb(122, 122, 255);
      position: absolute;
      bottom: 200px;
      left: 100px;
      border: 1px solid black;
    }

    .chart8-oa {
      font-size: 14px;
      position: absolute;
      bottom: 200px;
      left: 180px;
    }

    .chart8-small-red {
      height: 20px;
      width: 70px;
      background-color: rgb(255, 109, 109);
      position: absolute;
      bottom: 200px;
      left: 350px;
      border: 1px solid black;
    }

    .chart8-self {
      font-size: 14px;
      position: absolute;
      bottom: 200px;
      left: 440px;
    }

    .chart8-bottom {
      position: absolute;
      bottom: 20px;
      left: 20px;
      color: gray;
    }
  </style>
</head>

<body class="chart8-body">
  <div class="chart8-main-container">
    <p class="chart8-bold">--------------360 Assessment Feedback for <?php echo $var_name ?>---------</p>
    <p class="chart8-bold1">TOP STRENGTHS</p>
    <p class="chart8-center-text">Recognizing your own strengths may help you build the same capabilities in others. Awareness of your particular strengths is also useful in planning your career.</p>
    <span class="chart8-text"> Very<br>Low<br>Level<br>1</span>
    <span class="chart8-text1">Low<br>Level<br>2</span>
    <span class="chart8-text2">Mod-<br>erate<br>Level<br>3</span>
    <span class="chart8-text3">High<br>Level<br>4</span>
    <span class="chart8-text4"> Very<br>High<br>Level<br>5</span>
    <span class="chart8-text5">Gap<br>(OA - <br>Self)</span>
    <?php $j = 1;
    foreach ($diff as $i) { ?>
      <span class="chart8-rb<?php echo $j ?>"><?php echo $i; ?></span>
    <?php $j++;
    } ?>
    <!-- <span class="chart8-rb2">1.67</span>
    <span class="chart8-rb3">.71</span>
    <span class="chart8-rb4">.71</span>
    <span class="chart8-rb5">.71</span>
    <span class="chart8-rb6">.71</span>
    <span class="chart8-rb7">.71</span>
    <span class="chart8-rb8">.71</span>
    <span class="chart8-rb9">.71</span>
    <span class="chart8-rb10">.71</span> -->
    <div class="chart8-line"></div>
    <div class="chart8-line1"></div>
    <div class="chart8-line2"></div>
    <div class="chart8-line3"></div>
    <div class="chart8-line4"></div>
    <table class="chart8-table" border="1">
      <?php foreach ($combined as $j) { ?>
        <tr>
          <td class="chart8-td-left">
            <p class="chart8-blue"><?php echo $j['id'] . ". " . $j['question'] ?></p>
          </td>
          <td class="chart8-td-right">
            <div class="chart8-div-red" style="width: <?php echo $j['my_a'] * 20 ?>%"><?php echo $j['my_a'] ?></div>
            <div class="chart8-div-blue" style="width: <?php echo $j['o_a'] * 20 ?>%"><?php echo $j['o_a'] ?></div>
          </td>
        </tr>
      <?php } ?>
      <!-- <tr>
        <td class="chart8-td-left">
          <p class="chart8-blue">19. Gives freedom to choose approach while maintaining resposibility.</p>
        </td>
        <td class="chart8-td-right">
          <div class="chart8-div-red">4.00</div>
          <div class="chart8-div-blue">4.71</div>
        </td>
      </tr>
      <tr>
        <td class="chart8-td-left">
          <p class="chart8-blue">3. Treats change or new situation as opportunities for learning and growth.</p>
        </td>
        <td class="chart8-td-right">
          <div class="chart8-div-red">4.00</div>
          <div class="chart8-div-blue">4.71</div>
        </td>
      </tr>
      <tr>
        <td class="chart8-td-left">
          <p class="chart8-blue">32. Helps employees feel valued and appriciated.</p>
        </td>
        <td class="chart8-td-right">
          <div class="chart8-div-red">4.00</div>
          <div class="chart8-div-blue">4.71</div>
        </td>
      </tr>
      <tr>
        <td class="chart8-td-left">
          <p class="chart8-blue">28 . Ensure all parties understand resolution to conflict and know the necessary future activities.</p>
        </td>
        <td class="chart8-td-right">
          <div class="chart8-div-red">4.00</div>
          <div class="chart8-div-blue">4.71</div>
        </td>
      </tr>
      <tr>
        <td class="chart8-td-left">
          <p class="chart8-blue">31 . Gives timely and appropriate performance feedback.</p>
        </td>
        <td class="chart8-td-right">
          <div class="chart8-div-red">4.00</div>
          <div class="chart8-div-blue">4.71</div>
        </td>
      </tr>
      <tr>
        <td class="chart8-td-left">
          <p class="chart8-blue">7. Diplomatically delivers difficult messages.</p>
        </td>
        <td class="chart8-td-right">
          <div class="chart8-div-red">4.00</div>
          <div class="chart8-div-blue">4.71</div>
        </td>
      </tr>
      <tr>
        <td class="chart8-td-left">
          <p class="chart8-blue">8. Effectively answer questions and comments from the audience.</p>
        </td>
        <td class="chart8-td-right">
          <div class="chart8-div-red">4.00</div>
          <div class="chart8-div-blue">4.71</div>
        </td>
      </tr>
      <tr>
        <td class="chart8-td-left">
          <p class="chart8-blue">9. Attentive to customer needs and desires, while avoiding unreasonable commitments.</p>
        </td>
        <td class="chart8-td-right">
          <div class="chart8-div-red">4.00</div>
          <div class="chart8-div-blue">4.71</div>
        </td>
      </tr>
      <tr>
        <td class="chart8-td-left">
          <p class="chart8-blue">4. Communicates reasons for change effectively.</p>
        </td>
        <td class="chart8-td-right">
          <div class="chart8-div-red">4.00</div>
          <div class="chart8-div-blue">4.71</div>
        </td>
      </tr> -->
    </table>
    <span class="chart8-n1">1</span>
    <span class="chart8-n2">2</span>
    <span class="chart8-n3">3</span>
    <span class="chart8-n4">4</span>
    <span class="chart8-n5">5</span>
    <div class="chart8-small-blue"></div>
    <span class="chart8-oa">OA: Overall Average</span>
    <div class="chart8-small-red"></div>
    <span class="chart8-self">Self</span>
    <p class="chart8-bottom">360-degree Assessment. Zrutam Inc</p>
  </div>
</body>

</html>
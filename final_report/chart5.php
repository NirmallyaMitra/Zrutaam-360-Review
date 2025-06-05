<!DOCTYPE html>
<html lang="en">
<?php
include "../version1/database/connection.php";

$sql = "WITH ranked_categories AS (
    SELECT 
        q.category, 
        ROUND(AVG(o.answer), 2) AS avg_score
    FROM 
        others_response o
    JOIN 
        questions q ON o.question_id = q.id
    WHERE 
        o.unique_code = ?
    GROUP BY 
        q.category
)
SELECT *
FROM ranked_categories
WHERE avg_score <= (
    SELECT MAX(score) FROM (
        SELECT DISTINCT ROUND(AVG(o.answer), 2) AS score
        FROM others_response o
        JOIN questions q ON o.question_id = q.id
        WHERE o.unique_code = ?
        GROUP BY q.category
        ORDER BY score ASC
        LIMIT 3
    ) AS bottom3
)
ORDER BY avg_score ASC;
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $id);
$stmt->execute();
$result = $stmt->get_result();

$topCategories = [];
while ($row = $result->fetch_assoc()) {
  $topCategories[] = $row['category'];
  $topScores[] = $row['avg_score'];
}

// Dynamic placeholders based on category count
$placeholders = implode(',', array_fill(0, count($topCategories), '?'));

// SQL for top questions with ties
$sql2 = "WITH ranked_questions AS (
    SELECT 
        q.id, q.question, q.category,
        ROUND(AVG(o.answer), 2) AS avg_score
    FROM 
        others_response o
    JOIN 
        questions q ON o.question_id = q.id
    WHERE 
        o.unique_code = ?
        AND q.category IN ($placeholders)
    GROUP BY 
        q.id
)
SELECT *
FROM ranked_questions
WHERE avg_score <= (
    SELECT MAX(score) FROM (
        SELECT DISTINCT ROUND(AVG(o.answer), 2) AS score
        FROM others_response o
        JOIN questions q ON o.question_id = q.id
        WHERE o.unique_code = ?
          AND q.category IN ($placeholders)
        GROUP BY q.id
        ORDER BY score ASC
        LIMIT 3
    ) AS bottom3
)
ORDER BY avg_score ASC;
";

// Combine bind params
$params = array_merge([$id], $topCategories, [$id], $topCategories);
$types = str_repeat('s', count($params));
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param($types, ...$params);
$stmt2->execute();
$result2 = $stmt2->get_result();

$topQuestions = [];
while ($row = $result2->fetch_assoc()) {
  $topQuestions[] = $row;
}
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CHART 5</title>
  <style>
    .chart5-body {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    .chart5-main-container {
      display: inline-block;
      position: relative;
      width: 21cm;
      height: 29.7cm;
      padding-left: 30px;
    }

    .chart5-bold {
      position: absolute;
      top: 100px;
      left: 0;
      font-weight: bold;
      text-align: center;
      font-size: 20px;
      width: 793px;
    }

    .chart5-red {
      position: absolute;
      color: red;
      font-size: 20px;
      font-weight: bold;
      width: 793px;
      top: 140px;
      text-align: center;
      left: 0;
    }

    .chart5-normal {
      color: black;
      font-size: 13px;
      text-align: center;
      font-size: 14px;
    }

    .chart5-black {
      position: absolute;
      top: 165px;
      left: 100px;
      width: 600px;
      border: 1px solid black;
    }

    .chart5-center-text {
      position: absolute;
      top: 180px;
      left: 100px;
      width: 620px;
    }

    .chart5-table {
      position: absolute;
      top: 270px;
      left: 100px;
      width: 620px;
      height: auto;
      border: 1px solid black;
    }

    .chart5-td-number {
      width: 100px;
    }

    .chart5-number-bold {
      font-weight: bold;
      text-align: right;
      padding-right: 10px;
      color: blue;
      font-size: 12px;
      font-weight: bold;
    }

    .chart5-td-left {
      width: 320px;
      padding: 3px 7px 3px 7px;
    }

    .chart5-td-right {
      width: 100px;
      text-align: right;
      padding: 3px 27px 3px 0px;
    }

    .chart5-p-blue {
      color: blue;
      font-size: 12px;
      font-weight: bold;
    }

    .chart5-p-black {
      font-size: 12px;
      font-weight: bold;
    }

    .chart5-following {
      position: absolute;
      top: 480px;
      left: 100px;
      width: 620px;
    }

    .chart5-table1 {
      position: absolute;
      top: 530px;
      left: 100px;
      width: 620px;
      height: auto;
      border: 1px solid black;
    }

    .chart5-td-number1 {
      width: 100px;
    }

    .chart5-number-bold1 {
      font-weight: bold;
      text-align: right;
      padding-right: 10px;
      color: blue;
      font-size: 12px;
      font-weight: bold;
    }

    .chart5-td-left1 {
      width: 420px;
      padding: 3px 7px 3px 7px;
    }

    .chart5-td-right1 {
      width: 100px;
      text-align: right;
      padding: 3px 27px 3px 0px;
    }

    .chart5-p-blue1 {
      color: blue;
      font-size: 12px;
      font-weight: bold;
    }

    .chart5-p-black1 {
      font-size: 12px;
      font-weight: bold;
    }

    .chart5-bottom {
      position: absolute;
      bottom: 20px;
      left: 20px;
      color: gray;
    }
  </style>
</head>

<body class="chart5-body">
  <div class="chart5-main-container">
    <p class="chart5-bold">Opportunities for Development</p>
    <p class="chart5-red">Prepared for: <span class="chart5-normal"><?php echo $var_name ?></span></p>
    <div class="chart5-black"></div>
    <p class="chart5-center-text">The following analysis identifies those Competencies in which you rated lowest based on the aver-age of your raters\' scores.</p>
    <table class="chart5-table">
      <tr>
        <th colspan="3">Lowest Rated Competencies</th>
      </tr>
      <?php $i = 0;
      foreach ($topCategories as $j) { ?>
        <tr>
          <td class="chart5-td-number">
            <p class="chart5-number-bold"><?php echo ++$i ?>.</p>
          </td>
          <td class="chart5-td-left">
            <p class="chart5-p-blue"><?php echo $j ?></p>
          </td>
          <td class="chart5-td-right">
            <p class="chart5-p-black"><?php echo $topScores[$i - 1] ?></p>
          </td>
        </tr>
      <?php } ?>
      <!-- <tr>
        <td class="chart5-td-number">
          <p class="chart5-number-bold">2.</p>
        </td>
        <td class="chart5-td-left">
          <p class="chart5-p-blue">INNOVATION </p>
        </td>
        <td class="chart5-td-right">
          <p class="chart5-p-black">4.00</p>
        </td>
      </tr>
      <tr>
        <td class="chart5-td-number">
          <p class="chart5-number-bold">3.</p>
        </td>
        <td class="chart5-td-left">
          <p class="chart5-p-blue">CUSTOMER FOCUS</p>
        </td>
        <td class="chart5-td-right">
          <p class="chart5-p-black">4.11</p>
        </td>
      </tr> -->
    </table>
    <p class="chart5-following">The following items are the three lowest rated behaviors within your lowest rated Competency.</p>
    <table class="chart5-table1">
      <?php foreach ($topQuestions as $question) { ?>
        <tr>
          <td class="chart5-td-number1">
            <p class="chart4-number-bold1"><?php echo $question['id'] ?>.</p>
          </td>
          <td class="chart5-td-left1">
            <p class="chart4-p-blue1"><?php echo $question['question'] ?></p>
          </td>
          <td class="chart5-td-right1">
            <p class="chart4-p-black1"><?php echo $question['avg_score'] ?></p>
          </td>
        </tr>
      <?php } ?>

      <!-- <tr>
        <td class="chart5-td-number1">
          <p class="chart5-number-bold1">35.</p>
        </td>
        <td class="chart5-td-left1">
          <p class="chart5-p-blue1">Identifies needed timelines to insure a successful project.</p>
        </td>
        <td class="chart5-td-right1">
          <p class="chart5-p-black1">3.57</p>
        </td>
      </tr>
      <tr>
        <td class="chart5-td-number1">
          <p class="chart5-number-bold1">33.</p>
        </td>
        <td class="chart5-td-left1">
          <p class="chart5-p-blue1">Allow enough time to manage subordinates and complete own work assignments.</p>
        </td>
        <td class="chart5-td-right1">
          <p class="chart5-p-black1">3.83</p>
        </td>
      </tr> -->
    </table>
    <p class="chart5-bottom">360-degree Assessment. Zrutam Inc</p>
  </div>
</body>

</html>
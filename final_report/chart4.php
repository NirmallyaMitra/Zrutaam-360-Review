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
WHERE avg_score >= (
    SELECT MIN(score) FROM (
        SELECT DISTINCT ROUND(AVG(o.answer), 2) AS score
        FROM others_response o
        JOIN questions q ON o.question_id = q.id
        WHERE o.unique_code = ?
        GROUP BY q.category
        ORDER BY score DESC
        LIMIT 3
    ) AS top3
)
ORDER BY avg_score DESC
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
WHERE avg_score >= (
    SELECT MIN(score) FROM (
        SELECT DISTINCT ROUND(AVG(o.answer), 2) AS score
        FROM others_response o
        JOIN questions q ON o.question_id = q.id
        WHERE o.unique_code = ?
          AND q.category IN ($placeholders)
        GROUP BY q.id
        ORDER BY score DESC
        LIMIT 3
    ) AS top3
)
ORDER BY avg_score DESC
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
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CHART 4</title>
  <style>
    .chart4-body {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    .chart4-main-container {
      display: inline-block;
      position: relative;
      width: 21cm;
      height: 29.7cm;
      padding-left: 30px;
    }

    .chart4-bold {
      position: absolute;
      top: 100px;
      left: 0;
      font-weight: bold;
      text-align: center;
      font-size: 20px;
      width: 793px;
    }

    .chart4-red {
      position: absolute;
      color: red;
      font-size: 20px;
      font-weight: bold;
      width: 793px;
      top: 140px;
      text-align: center;
      left: 0;
    }

    .chart4-normal {
      color: black;
      font-size: 13px;
      text-align: center;
      font-size: 14px;
    }

    .chart4-black {
      position: absolute;
      top: 165px;
      left: 100px;
      width: 600px;
      border: 1px solid black;
    }

    .chart4-center-text {
      position: absolute;
      top: 180px;
      left: 100px;
      width: 620px;
    }

    .chart4-table {
      position: absolute;
      top: 270px;
      left: 100px;
      width: 620px;
      height: auto;
      border: 1px solid black;
    }

    .chart4-td-number {
      width: 100px;
    }

    .chart4-number-bold {
      font-weight: bold;
      text-align: right;
      padding-right: 10px;
      color: blue;
      font-size: 12px;
      font-weight: bold;
    }

    .chart4-td-left {
      width: 320px;
      padding: 3px 7px 3px 7px;
    }

    .chart4-td-right {
      width: 100px;
      text-align: right;
      padding: 3px 27px 3px 0px;
    }

    .chart4-p-blue {
      color: blue;
      font-size: 12px;
      font-weight: bold;
    }

    .chart4-p-black {
      font-size: 12px;
      font-weight: bold;
    }

    .chart4-following {
      position: absolute;
      top: 480px;
      left: 100px;
      width: 620px;
    }

    .chart4-table1 {
      position: absolute;
      top: 530px;
      left: 100px;
      width: 620px;
      height: auto;
      border: 1px solid black;
    }

    .chart4-td-number1 {
      width: 100px;
    }

    .chart4-number-bold1 {
      font-weight: bold;
      text-align: right;
      padding-right: 10px;
      color: blue;
      font-size: 12px;
      font-weight: bold;
    }

    .chart4-td-left1 {
      width: 420px;
      padding: 3px 7px 3px 7px;
    }

    .chart4-td-right1 {
      width: 100px;
      text-align: right;
      padding: 3px 27px 3px 0px;
    }

    .chart4-p-blue1 {
      color: blue;
      font-size: 12px;
      font-weight: bold;
    }

    .chart4-p-black1 {
      font-size: 12px;
      font-weight: bold;
    }

    .chart4-bottom {
      position: absolute;
      bottom: 20px;
      left: 20px;
      color: gray;
    }
  </style>
</head>

<body class="chart4-body">
  <div class="chart4-main-container">
    <p class="chart4-bold">Strengths</p>
    <p class="chart4-red">Prepared for: <span class="chart4-normal"><?php echo $var_name ?></span></p>
    <div class="chart4-black"></div>
    <p class="chart4-center-text">The following analysis identifies those Competencies in which you rated highest based on the aver-age of your raters\' scores.</p>
    <table class="chart4-table">
      <tr>
        <th colspan="3">Highest Rated Competencies</th>
      </tr>
      <tr>
        <td class="chart4-td-number">
          <p class="chart4-number-bold">1.</p>
        </td>
        <td class="chart4-td-left">
          <p class="chart4-p-blue"><?php echo $topCategories[0] ?></p>
        </td>
        <td class="chart4-td-right">
          <p class="chart4-p-black"><?php echo $topScores[0] ?></p>
        </td>
      </tr>
      <tr>
        <td class="chart4-td-number">
          <p class="chart4-number-bold">2.</p>
        </td>
        <td class="chart4-td-left">
          <p class="chart4-p-blue"><?php echo $topCategories[1] ?></p>
        </td>
        <td class="chart4-td-right">
          <p class="chart4-p-black"><?php echo $topScores[1] ?></p>
        </td>
      </tr>
      <tr>
        <td class="chart4-td-number">
          <p class="chart4-number-bold">3.</p>
        </td>
        <td class="chart4-td-left">
          <p class="chart4-p-blue"><?php echo $topCategories[2] ?></p>
        </td>
        <td class="chart4-td-right">
          <p class="chart4-p-black"><?php echo $topScores[2] ?></p>
        </td>
      </tr>
    </table>
    <p class="chart4-following">The following items are the three highest rated behaviors within your highest rated Competency.</p>
    <table class="chart4-table1">
      <?php foreach ($topQuestions as $question) { ?>
        <tr>
          <td class="chart4-td-number1">
            <p class="chart4-number-bold1"><?php echo $question['id'] ?>.</p>
          </td>
          <td class="chart4-td-left1">
            <p class="chart4-p-blue1"><?php echo $question['question'] ?></p>
          </td>
          <td class="chart4-td-right1">
            <p class="chart4-p-black1"><?php echo $question['avg_score'] ?></p>
          </td>
        </tr>
      <?php } ?>
      <!-- <tr>
        <td class="chart4-td-number1">
          <p class="chart4-number-bold1">28.</p>
        </td>
        <td class="chart4-td-left1">
          <p class="chart4-p-blue1"><?php echo $topQuestions[0]['question'] ?></p>
        </td>
        <td class="chart4-td-right1">
          <p class="chart4-p-black1">4.57</p>
        </td>
      </tr>
      <tr>
        <td class="chart4-td-number1">
          <p class="chart4-number-bold1">25.</p>
        </td>
        <td class="chart4-td-left1">
          <p class="chart4-p-blue1">Consider all points of view when resolving conflict.</p>
        </td>
        <td class="chart4-td-right1">
          <p class="chart4-p-black1">4.43</p>
        </td>
      </tr>
      <tr>
        <td class="chart4-td-number1">
          <p class="chart4-number-bold1">26.</p>
        </td>
        <td class="chart4-td-left1">
          <p class="chart4-p-blue1">Takes positive action to resolve the conflict.</p>
        </td>
        <td class="chart4-td-right1">
          <p class="chart4-p-black1">4.43</p>
        </td>
      </tr> -->
    </table>
    <p class="chart4-bottom">360-degree Assessment. Zrutam Inc</p>
  </div>
</body>

</html>
<?php
include "../version1/database/connection.php";

function printCategories($reviewerName, $categories)
{
  foreach ($categories as $category) {
    echo "<p class='chart3-red'>" . $category . "</p>";
  }
}

function printCategoriesOverall($categories)
{
  foreach ($categories as $category) {
    echo "<p class='chart3-red'>" . $category . "</p>";
  }
}

$sql = "SELECT q.category, SUM(s.answer) AS total_some FROM candidate_response s JOIN questions q ON s.question_id = q.id WHERE s.unique_code = ? GROUP BY q.category ORDER BY SUM(s.answer) desc LIMIT 3";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
  $high_compitancy_self[] = $row['category'];
}

$sql1 = "SELECT q.category, SUM(s.answer) AS total_some FROM candidate_response s JOIN questions q ON s.question_id = q.id WHERE s.unique_code = ? GROUP BY q.category ORDER BY SUM(s.answer) asc LIMIT 3 ";

$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param("i", $id);
$stmt1->execute();
$result1 = $stmt1->get_result();

while ($row1 = $result1->fetch_assoc()) {
  $lowwest_compitancy_self[] = $row1['category'];
}

// $sql2 = "WITH category_avg AS (
//     SELECT 
//         od.RTL,
//         q.category,
//         ROUND(AVG(or1.answer), 2) AS avg_score
//     FROM 
//         others_response or1
//     JOIN 
//         questions q ON or1.question_id = q.id
//     JOIN 
//         others_info od ON or1.u_id = od.uc AND or1.unique_code = od.uni_code
//     WHERE 
//         or1.unique_code = 12
//     GROUP BY 
//         od.RTL, q.category
// ),
// ranked_categories AS (
//     SELECT *,
//         RANK() OVER (PARTITION BY RTL ORDER BY avg_score DESC) AS rank_top
//     FROM category_avg
// )
// SELECT 
//     RTL,
//     category,
//     avg_score
// FROM 
//     ranked_categories
// WHERE 
//     rank_top <= 3
// ORDER BY 
//     RTL desc, rank_top;
// ";

$sql2 = "WITH ranked_data AS ( 
      SELECT 
        oi.RTL, 
        q.category, 
        AVG(o.answer) AS avg_score, 
      RANK() OVER (PARTITION BY oi.RTL ORDER BY AVG(o.answer) DESC) AS rank_top 
      FROM 
        others_response o 
      INNER JOIN 
        questions q ON o.question_id = q.id 
      INNER JOIN 
        others_info oi ON oi.uc = o.u_id
      WHERE 
        o.unique_code = ?
      GROUP BY
        oi.RTL, q.category 
      ) 
      SELECT 
        RTL,
        category,
        avg_score 
      FROM 
        ranked_data 
      WHERE 
        rank_top <= 3 
      ORDER BY 
        avg_score DESC
";

$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("i", $id);
$stmt2->execute();
$result2 = $stmt2->get_result();

while ($row2 = $result2->fetch_assoc()) {
  $reviewer = $row2['RTL'];
  $category = $row2['category'];

  switch ($reviewer) {
    case 'PEER':
      $peer_highest[] = $category;
      break;
    case 'MANAGER':
      $supervisor_highest[] = $category;
      break;
    case 'DIRECT REPORTEE':
      $team_member_highest[] = $category;
      break;
  }
}

// $sql3 = "WITH category_avg AS (
//   SELECT 
//       od.RTL,
//       q.category,
//       ROUND(AVG(or1.answer), 2) AS avg_score
//   FROM 
//       others_response or1
//   JOIN 
//       questions q ON or1.question_id = q.id
//   JOIN 
//       others_info od ON or1.u_id = od.uc AND or1.unique_code = od.uni_code
//   WHERE 
//       or1.unique_code = 12
//   GROUP BY 
//       od.RTL, q.category
// ),
// ranked_categories AS (
//   SELECT *,
//       RANK() OVER (PARTITION BY RTL ORDER BY avg_score ASC) AS rank_top
//   FROM category_avg
// )
// SELECT 
//   RTL,
//   category,
//   avg_score
// FROM 
//   ranked_categories
// WHERE 
//   rank_top <= 3
// ORDER BY 
//   RTL desc, rank_top;
// ";

$sql3 = "WITH ranked_data AS ( 
      SELECT 
        oi.RTL, 
        q.category, 
        AVG(o.answer) AS avg_score, 
      RANK() OVER (PARTITION BY oi.RTL ORDER BY AVG(o.answer) ASC) AS rank_top 
      FROM 
        others_response o 
      INNER JOIN 
        questions q ON o.question_id = q.id 
      INNER JOIN 
        others_info oi ON oi.uc = o.u_id
      WHERE 
        o.unique_code = ?
      GROUP BY
        oi.RTL, q.category 
      ) 
      SELECT 
        RTL,
        category,
        avg_score 
      FROM 
        ranked_data 
      WHERE 
        rank_top <= 3 
      ORDER BY 
        avg_score ASC
";

$stmt3 = $conn->prepare($sql3);
$stmt3->bind_param("i", $id);
$stmt3->execute();
$result3 = $stmt3->get_result();

while ($row3 = $result3->fetch_assoc()) {
  $reviewer = $row3['RTL'];
  $category = $row3['category'];

  switch ($reviewer) {
    case 'PEER':
      $peer_lowest[] = $category;
      break;
    case 'MANAGER':
      $supervisor_lowest[] = $category;
      break;
    case 'DIRECT REPORTEE':
      $team_member_lowest[] = $category;
      break;
  }
}

// Highest Compitency Overall

// $sql4 = "SELECT q.category, avg(o.answer) from others_response o inner join questions q on o.question_id = q.id where o.unique_code = 12 group by q.category order by avg(o.answer) desc";

$sql4 = "SELECT *
FROM (
    SELECT 
        q.category,
        AVG(o.answer) AS avg_answer,
        RANK() OVER (ORDER BY AVG(o.answer) DESC) AS ranking
    FROM 
        others_response o
    INNER JOIN 
        questions q ON o.question_id = q.id
    WHERE 
        o.unique_code = ?
    GROUP BY 
        q.category
) ranked
WHERE ranking <= 3 order by ranking asc";

$stmt4 = $conn->prepare($sql4);
$stmt4->bind_param("i", $id);
$stmt4->execute();
$result4 = $stmt4->get_result();


while ($row4 = $result4->fetch_assoc()) {
  $high_compitancy_overall[] = $row4['category'];
}

$sql5 = "SELECT *
FROM (
    SELECT 
        q.category,
        AVG(o.answer) AS avg_answer,
        RANK() OVER (ORDER BY AVG(o.answer) ASC) AS ranking
    FROM 
        others_response o
    INNER JOIN 
        questions q ON o.question_id = q.id
    WHERE 
        o.unique_code = ?
    GROUP BY 
        q.category
) ranked
WHERE ranking <= 3 order by ranking asc";

$stmt5 = $conn->prepare($sql5);
$stmt5->bind_param("i", $id);
$stmt5->execute();
$result5 = $stmt5->get_result();

while ($row5 = $result5->fetch_assoc()) {
  $low_compitancy_overall[] = $row5['category'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    .chart3-main-container {
      display: inline-block;
      position: relative;
      width: 21cm;
      height: 29.7cm;
      padding-left: 30px;
    }

    .chart3-heading {
      position: absolute;
      left: 0;
      top: 100px;
      width: 793px;
      text-align: center;
    }

    .chart3-text {
      position: absolute;
      left: 20px;
      top: 170px;
    }

    .chart3-bigger-text {
      padding-bottom: 20px;
    }

    .chart3-normal-text {
      width: 640px;
    }

    .chart3-table {
      position: absolute;
      left: 20px;
      top: 390px;
      border-collapse: collapse;
      width: 700px;
    }

    .chart3-th,
    .chart3-td {
      padding: 10px;
    }

    .chart3-td p {
      font-size: 13px;
    }

    .chart3-red {
      color: red;
      padding-bottom: 3px;
      font-weight: bold;
      text-align: center;
    }

    .chart3-blue {
      color: blue;
      padding-bottom: 3px;
      text-align: center;
    }

    .chart3-td-center {
      text-align: center;
    }

    .chart3-bold {
      font-size: 17px;
    }

    .chart3-height {
      height: 110px;
    }

    .chart3-exclude {
      padding-top: 5px;
      font-size: 12px;
    }

    .chart3-bottom {
      position: absolute;
      bottom: 20px;
      left: 20px;
      color: gray;
    }
  </style>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./chart3.css">
  <title>CHART 3</title>
</head>

<body>
  <div class="border12"></div>
  <div class="chart3-main-container">
    <div class="heading">
      <strong class="heading1">[<?php echo $var_name ?>]</strong>
    </div>
    <div class="chart3-text">
      <p class="chart3-bigger-text">Contrasting Perceptions</p>
      <p class="chart3-normal-text">
        This table highlights major differences among perceptions of competencies at the rater group level...
      </p>
    </div>
    <table class="chart3-table" border="2">
      <tr>
        <th>Highest competencies</th>
        <th>Rater Group</th>
        <th>Lowest competencies</th>
      </tr>
      <tr>
        <td>
          <p class="chart3-red"><?php echo $high_compitancy_self[0]; ?></p>
          <p class="chart3-blue"><?php echo $high_compitancy_self[1]; ?></p>
          <p class="chart3-blue"><?php echo $high_compitancy_self[2]; ?></p>
        </td>
        <td class="chart3-td-center">
          <p class="chart3-bold"><b>Self</b></p>
        </td>
        <td>
          <p class="chart3-blue chart3-right"><?php echo $lowwest_compitancy_self[0]; ?></p>
          <p class="chart3-blue chart3-right"><?php echo $lowwest_compitancy_self[1]; ?></p>
          <p class="chart3-blue chart3-right"><?php echo $lowwest_compitancy_self[2]; ?></p>
        </td>
      </tr>
      <tr>
        <td>
          <?php printCategories('MANAGER', $supervisor_highest); ?>
        </td>
        <td class="chart3-td-center">
          <p class="chart3-bold"><b>MANAGER</b></p>
        </td>
        <td>
          <?php printCategories('MANAGER', $supervisor_lowest); ?>
        </td>
      </tr>
      <tr>
        <td>
          <?php printCategories('PEER', $peer_highest); ?>
        </td>
        <td class="chart3-td-center">
          <p class="chart3-bold"><b>Peer</b></p>
        </td>
        <td>
          <?php printCategories('PEER', $peer_lowest); ?>
        </td>
      </tr>
      <tr>
        <td>
          <?php printCategories('DIRECT REPORTEE', $team_member_highest); ?>
        </td>
        <td class="chart3-td-center">
          <p class="chart3-bold"><b>DIRECT REPORTEE</b></p>
        </td>
        <td>
          <?php printCategories('DIRECT REPORTEE', $team_member_lowest); ?>
        </td>
      </tr>

      <tr>
        <td>
          <?php printCategoriesOverall($high_compitancy_overall); ?>
        </td>
        <td class="chart3-td-center">
          <p class="chart3-bold"><b>Overall</b></p>
          <p class="chart3-exclude">(Excludes Self)</p>
        </td>
        <td>
          <?php printCategoriesOverall($low_compitancy_overall); ?>
        </td>
      </tr>
    </table>
    <p class="chart3-bottom">360-degree Assessment. Zrutam Inc</p>
  </div>
</body>

</html>
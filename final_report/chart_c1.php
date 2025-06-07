<?php
include '../version1/database/connection.php';

$sql = "select question from questions where category = 'ADAPTABILITY' order by id asc";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
  $question[] = $row['question'];
}

// Self Score
$sql1 = "select round(avg(answer),2) as av_my_score from candidate_response c INNER JOIN questions q on c.question_id = q.id where c.unique_code = ? AND q.category = 'ADAPTABILITY' group by q.id order by q.id;";

$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param("i", $id);
$stmt1->execute();
$result1 = $stmt1->get_result();

while ($row1 = $result1->fetch_assoc()) {
  $self_score[] = $row1['av_my_score'];
}


// Question wise and relation wise others score 
$sql2 = "select q.id, oi.RTL, q.category, count(o.answer), round(avg(o.answer),2) as avg_score from others_response o INNER JOIN questions q on o.question_id = q.id INNER JOIN others_info oi on o.u_id = oi.uc where o.unique_code = ? AND q.category = 'ADAPTABILITY' group by q.id, oi.RTL order by q.id, oi.RTL";

$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("i", $id);
$stmt2->execute();
$result2 = $stmt2->get_result();

while ($row2 = $result2->fetch_assoc()) {
  $score_others1[] = [
    'id' => $row2['id'],
    'RTL' => $row2['RTL'],
    'category' => $row2['category'],
    'count' => $row2['count(o.answer)'],
    'avg' => $row2['avg_score']
  ];
}

// Question wise overall others score 
$sql3 = "select count(o.answer), round(avg(o.answer), 2) as avg_score from others_response o INNER JOIN questions q on o.question_id = q.id INNER JOIN others_info oi on o.u_id = oi.uc where o.unique_code = ? AND q.category = 'ADAPTABILITY' group by q.id order by q.id, oi.RTL";

$stmt3 = $conn->prepare($sql3);
$stmt3->bind_param("i", $id);
$stmt3->execute();
$result3 = $stmt3->get_result();

while ($row3 = $result3->fetch_assoc()) {
  $score_others2[] = [
    'count' => $row3['count(o.answer)'],
    'avg' => $row3['avg_score']
  ];
}

// Question and relation wise others min score 
$sql4 = "select q.id, oi.RTL, min(o.answer) from others_response o INNER JOIN questions q on o.question_id = q.id INNER JOIN others_info oi on o.u_id = oi.uc where o.unique_code = ? AND q.category = 'ADAPTABILITY' group by q.id, oi.RTL order by q.id, oi.RTL";

$stmt4 = $conn->prepare($sql4);
$stmt4->bind_param("i", $id);
$stmt4->execute();
$result4 = $stmt4->get_result();

while ($row4 = $result4->fetch_assoc()) {
  $score_others3[] = [
    'score' => $row4['min(o.answer)']
  ];
}

// Question and relation wise others max score 
$sql5 = "select q.id, oi.RTL, max(o.answer) from others_response o INNER JOIN questions q on o.question_id = q.id INNER JOIN others_info oi on o.u_id = oi.uc where o.unique_code = ? AND q.category = 'ADAPTABILITY' group by q.id, oi.RTL order by q.id, oi.RTL";

$stmt5 = $conn->prepare($sql5);
$stmt5->bind_param("i", $id);
$stmt5->execute();
$result5 = $stmt5->get_result();

while ($row5 = $result5->fetch_assoc()) {
  $score_others4[] = [
    'score' => $row5['max(o.answer)']
  ];
}

$sql6 = "select q.id, oi.RTL, min(o.answer) from others_response o INNER JOIN questions q on o.question_id = q.id INNER JOIN others_info oi on o.u_id = oi.uc where o.unique_code = ? AND q.category = 'ADAPTABILITY' group by q.id order by q.id, oi.RTL";

$stmt6 = $conn->prepare($sql6);
$stmt6->bind_param("i", $id);
$stmt6->execute();
$result6 = $stmt6->get_result();

while ($row6 = $result6->fetch_assoc()) {
  $score_others5[] = [
    'score' => $row6['min(o.answer)']
  ];
}

$sql7 = "select q.id, oi.RTL, max(o.answer) from others_response o INNER JOIN questions q on o.question_id = q.id INNER JOIN others_info oi on o.u_id = oi.uc where o.unique_code = ? AND q.category = 'ADAPTABILITY' group by q.id order by q.id, oi.RTL";

$stmt7 = $conn->prepare($sql7);
$stmt7->bind_param("i", $id);
$stmt7->execute();
$result7 = $stmt7->get_result();

while ($row7 = $result7->fetch_assoc()) {
  $score_others6[] = [
    'score' => $row7['max(o.answer)']
  ];
}

$sql8 = "select round(avg(o.answer),2) as avg_score from others_response o INNER JOIN questions q on o.question_id = q.id where o.unique_code = ? AND q.category = 'ADAPTABILITY'";

$stmt8 = $conn->prepare($sql8);
$stmt8->bind_param("i", $id);
$stmt8->execute();
$result8 = $stmt8->get_result()->fetch_assoc();

$sql9 = "select round(avg(o.answer),2) as avg_score from others_response o INNER JOIN questions q on o.question_id = q.id INNER JOIN others_info oi on o.u_id = oi.uc where o.unique_code = ? AND q.category = 'ADAPTABILITY' group by oi.RTL order by oi.RTL";

$stmt9 = $conn->prepare($sql9);
$stmt9->bind_param("i", $id);
$stmt9->execute();
$result9 = $stmt9->get_result();

while ($row9 = $result9->fetch_assoc()) {
  $score_others7[] = [
    'avg_score' => $row9['avg_score']
  ];
}

$sql10 = "select round(avg(answer),2) as av_my_score from candidate_response c INNER JOIN questions q on c.question_id = q.id where c.unique_code = ? AND q.category = 'ADAPTABILITY'";

$stmt10 = $conn->prepare($sql10);
$stmt10->bind_param("i", $id);
$stmt10->execute();
$result10 = $stmt10->get_result()->fetch_assoc();

function calculate_difference($a, $b)
{
  return abs($a - $b);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Chart</title>
  <!-- ! ========================== CSS =============================================== -->
  <!-- <link rel="stylesheet" href="chart.css" /> -->
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

    * {
      padding: 0;
      margin: 0;
      box-sizing: border-box;
      font-family: "Montserrat", sans-serif;
      font-optical-sizing: auto;
      font-weight: 700;
      font-style: normal;
    }

    .main-container {
      display: inline-block;
      position: relative;
      width: 21cm;
      height: 29.7cm;
      padding-left: 30px;
    }

    .side-text {
      border-bottom: 1px solid black;
      height: 113px;
      width: 130px;
      position: absolute;
      top: 414px;
      left: 623px;
      font-size: 13px;
      font-weight: 600;
    }

    .side-text-new {

      display: block;
      position: absolute;
      width: 40px;
      font-size: 13px;
      top: 415px;
      left: 700px;
      font-weight: 900;
      z-index: 1;
    }

    .new {
      padding-left: 15px;
      font-family: "Montserrat", sans-serif !important;
      font-optical-sizing: auto !important;
      font-weight: 400 !important;
      font-style: normal !important;
    }

    .new-1 {
      margin-top: -1px;
    }

    .new-2 {
      margin-top: 3px;
    }

    .new-3 {
      margin-top: 4px;
    }

    .new-4 {
      margin-top: 6px;
    }

    .new-5 {
      margin-top: 10px;
    }

    .new-6 {
      margin-top: 8px;
    }

    .new-7 {
      margin-top: 6px;
    }

    .new-8 {
      margin-top: 6px;
    }

    .new-9 {
      margin-top: 6px;
    }

    .side-text-new-2 {
      display: block;
      position: absolute;
      font-size: 13px;
      font-weight: 900;
      top: 533px;
      left: 700px;
      z-index: 1;
    }

    .side-text-new-3 {
      display: block;
      position: absolute;
      font-size: 13px;
      font-weight: 900;
      top: 650px;
      left: 700px;
      z-index: 1;
    }

    .side-text-new-4 {
      display: block;
      position: absolute;
      font-size: 13px;
      font-weight: 900;
      top: 765px;
      left: 700px;
      z-index: 1;
    }

    .side-text-new-5 {
      display: block;
      position: absolute;
      font-size: 13px;
      font-weight: 900;
      top: 880px;
      left: 700px;
      z-index: 1;
    }

    .side-text-2 {
      position: absolute;
      height: 113px;
      left: 630px;
      border-bottom: 1px solid black;
      top: 528.4px;
    }

    .side-text-3 {
      position: absolute;
      height: 113px;
      border-bottom: 1px solid black;
      top: 642px;
    }

    .side-text-4 {
      position: absolute;
      height: 113px;
      border-bottom: 1px solid black;
      top: 756px;
    }

    .side-text-5 {
      position: absolute;
      height: 113px;
      border-bottom: 1px solid black;
      top: 870px;
    }

    .number-1 {
      padding-top: 20px;
      padding-left: 40px;
    }

    .number-2 {
      padding-left: 40px;
      padding-top: 2px;
    }

    .number-3 {
      padding-left: 40px;
      padding-top: 4px;
    }

    .number-4 {
      padding-left: 40px;
      padding-top: 13px;
    }

    .number-5 {
      text-align: top;
      margin-top: -200px;
      margin-left: 100px;
    }

    .number-6 {
      padding-top: 2px;
      margin-left: 100px;
    }

    .number-7 {
      padding-top: 4px;
      margin-left: 100px;
    }

    .number-8 {
      padding-top: 1px;
      margin-left: 100px;
    }

    .number-9 {
      padding-top: 13px;
      margin-left: 100px;
    }

    .heading {
      display: block;
      width: 100%;
      text-align: left;
      margin-top: 100px;
    }

    .text {
      margin-top: 100px;
      margin-bottom: 100px;
    }

    .bigger-text {
      padding-bottom: 20px;
    }

    .normal-text {
      width: 640px;
      font-family: "Montserrat", sans-serif;
      font-optical-sizing: auto;
      font-weight: 400;
      font-style: normal;
    }

    /* ! ================================= UPPER TEXT ====================================== */

    .upper-text {
      display: block;
      height: 100px;
      width: 638px;
      position: absolute;
      top: 298px;
    }

    .bold-n {
      padding-top: 73px;
      font-size: 20px;
      font-weight: 900;
      padding-left: 265px;
      font-family: "Montserrat", sans-serif !important;
      font-optical-sizing: auto !important;
      font-weight: 400 !important;
      font-style: normal !important;
    }

    .level {
      display: block;
      text-align: end;
      padding-left: 10px;
      width: 50px;
      font-size: 12px;
      font-family: "Montserrat", sans-serif;
      font-optical-sizing: auto;
      font-weight: 900;
      font-style: normal;
    }

    .level-1 {
      position: absolute;
      top: 85px;
      left: 325px;
    }

    .level-2 {
      position: absolute;
      top: 94px;
      left: 397px;
    }

    .level-3 {
      position: absolute;
      top: 95px;
      left: 457px;
    }

    .level-4 {
      position: absolute;
      top: 95px;
      left: 516px;
    }

    .level-5 {
      position: absolute;
      top: 85px;
      left: 567px;
    }

    .level-6 {
      position: absolute;
      top: 55px;
      left: 610px;
    }

    .level-7 {
      position: absolute;
      top: 55px;
      left: 670px;
    }

    .div-text {
      color: black;
      display: block;
      position: absolute;
      top: 410px;
      left: 242px;
      font-size: 11px;
      text-align: end;
    }

    .div-text-1 {
      top: 523px;
    }

    .div-text-2 {
      top: 637px;
    }

    .div-text-3 {
      top: 752px;
    }

    .div-text-4 {
      top: 865px;
    }

    .adaptibility {
      font-size: 14px;
      font-weight: 900;
      width: 180px;
      padding-left: 4px;
      font-family: "Montserrat", sans-serif;
      font-optical-sizing: auto;
      font-weight: 700;
      font-style: normal;
      color: #2351fc !important;
    }

    .modifies {
      padding-left: 4px;
      width: 190px;
    }

    .self {
      padding-top: 7px;
      font-family: "Montserrat", sans-serif !important;
      font-optical-sizing: auto !important;
      font-weight: 400 !important;
      font-style: normal !important;
    }

    .supr {
      padding-top: 4px;
      font-family: "Montserrat", sans-serif !important;
      font-optical-sizing: auto !important;
      font-weight: 400 !important;
      font-style: normal !important;
    }

    .peer {
      padding-top: 7px;
      font-family: "Montserrat", sans-serif !important;
      font-optical-sizing: auto !important;
      font-weight: 400 !important;
      font-style: normal !important;
    }

    .subord {
      padding-top: 7px;
      font-family: "Montserrat", sans-serif !important;
      font-optical-sizing: auto !important;
      font-weight: 400 !important;
      font-style: normal !important;
    }

    .OA {
      font-size: 10px;
      padding-top: 10px;
      font-family: "Montserrat", sans-serif !important;
      font-optical-sizing: auto !important;
      font-weight: 400 !important;
      font-style: normal !important;
    }

    .freq {
      padding-top: 3px;
      font-size: 10px;
    }

    .span {
      font-size: 14px;
    }

    .span-1 {
      padding-left: 48px;
    }

    .span-2 {
      padding-left: 48px;
    }

    .span-3 {
      padding-left: 48px;
    }

    .span-4 {
      padding-left: 48px;
    }

    .span-5 {
      padding-left: 48px;
    }

    .div-number {
      display: block;
      position: absolute;
      top: 412px;
      font-size: 13px;
      left: 312px;
    }

    .c-r {
      color: red;
    }

    .div-number-1 {
      top: 527px;
    }

    .div-number-2 {
      top: 642px;
    }

    .div-number-3 {
      top: 754px;
    }

    .div-number-4 {
      top: 868px;
    }

    .one {
      padding-top: 4px;
    }

    .one-1 {
      padding-top: 2px;
    }

    .three {
      padding-top: 4px;
    }

    .three-3 {
      padding-top: 2px;
    }

    .seven {
      padding-top: 12px;
    }

    /* ! ================================= END UPPER TEXT ====================================== */

    /* ! ================================= DASHED BORDER ====================================== */

    .dashed-border {
      display: block;
      position: absolute;
      height: 584px;
      width: 300px;
      top: 410px;
      left: 320px;
      z-index: 1;
    }

    .border-1 {
      border-right: 1px dashed black;
      position: absolute;
      height: 575px;
      left: 1px;
      width: 59.36px;
    }

    .border-2 {
      border-right: 1px dashed black;
      position: absolute;
      height: 575px;
      width: 59.36px;
      left: 60.16px;
    }

    .border-3 {
      border-right: 1px dashed black;
      position: absolute;
      height: 575px;
      width: 59.36px;
      left: 120.32px;
    }

    .border-4 {
      border-right: 1px dashed black;
      position: absolute;
      height: 575px;
      width: 59.36px;
      left: 179.68px;
    }

    /* .border-5 {
      border-right: 1px dashed black;
      position: absolute;
      height: 575px;
      width: 58.6px;
      left: 238.4px;
    } */

    /* ! ================================= DASHED BORDER END ====================================== */

    /* ! ================================= TABLE ====================================== */

    .i {
      font-size: 13px;
      color: blue;
      font-weight: 900;
      height: 110px;
      width: 250px;
    }

    .black-text {
      width: 180px;
      color: black;
      padding-top: 2px;
      padding-left: 4px;
      font-size: 12px;
    }

    .n {
      width: 40px;
    }

    .j {
      width: 300px;
    }

    .table1 {
      border: 1px solid black;
      border-collapse: collapse;
    }

    .outer-bar {
      top: 2px;
      margin-bottom: 5px;
      position: relative;
      height: 13px;
    }

    .outer-bar-5 {
      margin-top: 15px;
    }

    .outer-bar-6 {
      margin-top: -5px;
    }

    .span {
      font-size: 11px;
      font-weight: 600;
    }

    .inner-bar {
      font-size: 11px;
      font-weight: 900;
      height: 13px;
      background-color: rgb(166, 166, 244);
      /* border: 0.7px solid black; */
    }

    .red {
      /*background-color: rgb(251, 81, 81);*/
      background-color: #061132;
    }

    .green {
      /*background-color: rgb(59, 229, 59);*/
      background-color: #0a194c;
    }

    .gray {
      /*background-color: rgb(214, 212, 212);*/
      background-color: #163ab0;
    }

    .pink {
      /*background-color: rgb(247, 146, 163);*/
      background-color: #3664fc;
    }

    /* ! ================================= TABLE ENDING ====================================== */
    .overall {
      margin-top: 20px;
      font-size: 13px;
      font-family: "Montserrat", sans-serif !important;
      font-optical-sizing: auto !important;
      font-weight: 400 !important;
      font-style: normal !important;
    }

    .overall-bottom {
      font-size: 13px;
      font-family: "Montserrat", sans-serif !important;
      font-optical-sizing: auto !important;
      font-weight: 400 !important;
      font-style: normal !important;
    }

    .zrutam {
      font-size: 10px;
      margin-top: 50px;
      color: #6387fd;
    }

    .border12 {
      position: absolute;
      top: 15px;
      left: 15px;
      z-index: 999999;
      border: 1px solid black;
      width: 20cm;
      height: 29cm;
    }

    .text-color {
      color: white;
      font-family: "Montserrat", sans-serif !important;
      font-optical-sizing: auto !important;
      font-weight: 400 !important;
      font-style: normal !important;
    }

    .ov {
      background-color: #6387fd;
    }

    /* ! ================================= END CHART BOTTOM ====================================== */
  </style>
  <!-- ! ========================== END CSS =============================================== -->
</head>

<body>
  <div class="border12"></div>
  <div class="main-container">
    <div class="heading">
      <strong class="heading1">[<?php echo $var_name ?>]</strong>
    </div>
    <div class="text">
      <p class="bigger-text">EXECUTIVE SUMMARY</p>
      <p class="normal-text">
        This section provides a ranking order of your proficiency rating in
        all of the competencies, from your strongest area to the area needing
        the most development based on the average score of all respondents
        (does not include your self rating).
      </p>
    </div>
    <div class="side-text">
      <p class="number-1 number"><?php echo calculate_difference($result10['av_my_score'], $score_others7[1]['avg_score']) ?></p>
      <p class="number-2 number"><?php echo calculate_difference($result10['av_my_score'], $score_others7[0]['avg_score']) ?></p>
      <p class="number-3 number"><?php echo calculate_difference($result10['av_my_score'], $score_others7[2]['avg_score']) ?></p>
      <p class="number-4 number"><?php echo calculate_difference($result10['av_my_score'], $result8['avg_score']) ?></p>
    </div>
    <div class="side-text-new">
      <p class="new-1 new">3-4</p>
      <p class="new-2 new">4-4</p>
      <p class="new-3 new">3-5</p>
      <p class="new-4 new">4-5</p>
      <p class="new-5 new">3-5</p>
    </div>
    <div class="side-text side-text-2">
      <p class="number-1 number"><?php echo calculate_difference($self_score[0], $score_others1[1]['avg']) ?></p>
      <p class="number-2 number"><?php echo calculate_difference($self_score[0], $score_others1[0]['avg']) ?></p>
      <p class="number-3 number"><?php echo calculate_difference($self_score[0], $score_others1[2]['avg']) ?></p>
      <p class="number-4 number"><?php echo calculate_difference($self_score[0], $score_others2[0]['avg']) ?></p>
    </div>
    <div class="side-text-new-2">
      <p class="new-1 new"><?php echo round($self_score[0], 0) . "-" . round($self_score[0], 0) ?></p>
      <p class="new-2 new"><?php echo $score_others3[1]['score'] . "-" . $score_others4[1]['score'] ?></p>
      <p class="new-3 new"><?php echo $score_others3[0]['score'] . "-" . $score_others4[0]['score'] ?></p>
      <p class="new-4 new"><?php echo $score_others3[2]['score'] . "-" . $score_others4[2]['score'] ?></p>
      <p class="new-5 new"><?php echo $score_others5[0]['score'] . "-" . $score_others6[0]['score'] ?></p>
    </div>
    <div class="side-text side-text-3">
      <p class="number-1 number"><?php echo calculate_difference($self_score[1], $score_others1[4]['avg']) ?></p>
      <p class="number-2 number"><?php echo calculate_difference($self_score[1], $score_others1[3]['avg']) ?></p>
      <p class="number-3 number"><?php echo calculate_difference($self_score[1], $score_others1[5]['avg']) ?></p>
      <p class="number-4 number"><?php echo calculate_difference($self_score[1], $score_others2[1]['avg']) ?></p>
    </div>
    <div class="side-text-new-3">
      <p class="new-1 new"><?php echo round($self_score[1], 0) . "-" . round($self_score[1], 0) ?></p>
      <p class="new-2 new"><?php echo $score_others3[4]['score'] . "-" . $score_others4[4]['score'] ?></p>
      <p class="new-3 new"><?php echo $score_others3[3]['score'] . "-" . $score_others4[3]['score'] ?></p>
      <p class="new-4 new"><?php echo $score_others3[5]['score'] . "-" . $score_others4[5]['score'] ?></p>
      <p class="new-5 new"><?php echo $score_others5[1]['score'] . "-" . $score_others6[1]['score'] ?></p>
    </div>
    <div class="side-text side-text-4">
      <p class="number-1 number"><?php echo calculate_difference($self_score[2], $score_others1[7]['avg']) ?></p>
      <p class="number-2 number"><?php echo calculate_difference($self_score[2], $score_others1[6]['avg']) ?></p>
      <p class="number-3 number"><?php echo calculate_difference($self_score[2], $score_others1[8]['avg']) ?></p>
      <p class="number-4 number"><?php echo calculate_difference($self_score[2], $score_others2[2]['avg']) ?></p>
    </div>
    <div class="side-text-new-4">
      <p class="new-1 new"><?php echo round($self_score[2], 0) . "-" . round($self_score[2], 0) ?></p>
      <p class="new-2 new"><?php echo $score_others3[7]['score'] . "-" . $score_others4[7]['score'] ?></p>
      <p class="new-3 new"><?php echo $score_others3[6]['score'] . "-" . $score_others4[6]['score'] ?></p>
      <p class="new-4 new"><?php echo $score_others3[8]['score'] . "-" . $score_others4[8]['score'] ?></p>
      <p class="new-5 new"><?php echo $score_others5[2]['score'] . "-" . $score_others6[2]['score'] ?></p>
    </div>
    <div class="side-text side-text-5">
      <p class="number-1 number"><?php echo calculate_difference($self_score[3], $score_others1[10]['avg']) ?></p>
      <p class="number-2 number"><?php echo calculate_difference($self_score[3], $score_others1[9]['avg']) ?></p>
      <p class="number-3 number"><?php echo calculate_difference($self_score[3], $score_others1[11]['avg']) ?></p>
      <p class="number-4 number"><?php echo calculate_difference($self_score[3], $score_others2[3]['avg']) ?></p>
    </div>
    <div class="side-text-new-5">
      <p class="new-1 new"><?php echo round($self_score[3], 0) . "-" . round($self_score[3], 0) ?></p>
      <p class="new-2 new"><?php echo $score_others3[10]['score'] . "-" . $score_others4[10]['score'] ?></p>
      <p class="new-3 new"><?php echo $score_others3[9]['score'] . "-" . $score_others4[9]['score'] ?></p>
      <p class="new-4 new"><?php echo $score_others3[11]['score'] . "-" . $score_others4[11]['score'] ?></p>
      <p class="new-5 new"><?php echo $score_others5[3]['score'] . "-" . $score_others6[3]['score'] ?></p>
    </div>
    <div class="upper-text">
      <p class="bold-n">N</p>
      <div class="level level-1">Very Low 1</div>
      <div class="level level-2">2</div>
      <div class="level level-3">3</div>
      <div class="level level-4">4</div>
      <div class="level level-5">Very High 5</div>
      <div class="level level-6">Gap from Self</div>
      <div class="level level-7">Range of Scores</div>
    </div>
    <div class="dashed-border">
      <div class="border-1 border"></div>
      <div class="border-2 border"></div>
      <div class="border-3 border"></div>
      <div class="border-4 border"></div>
      <!-- <div class="border-5 border"></div> -->
    </div>
    <div class="chart">
      <table id="table" class="table1" border="black">
        <tr>
          <td class="i">
            <p class="adaptibility">ADAPTABILITY</p>
            <p class="black-text">(Overall Competency)</p>
            <div class="div-text">
              <p class="self">Self</p>
              <p class="supr">Supr.</p>
              <p class="peer">Peer</p>
              <p class="subord">Subord.</p>
              <p class="OA">OA</p>
              <p class="freq">% Freq</p>
            </div>
          </td>
          <td class="n"></td>
          <td class="j">
            <div class="outer-bar outer-bar-1">
              <div class="inner-bar red text-color" style="width: <?php echo $result10['av_my_score'] * 58.96 ?>px"><?php echo $result10['av_my_score'] ?></div>
            </div>
            <div class="outer-bar outer-bar-2">
              <div class="inner-bar green text-color" style="width: <?php echo $score_others7[1]['avg_score'] * 58.96 ?>px"><?php echo $score_others7[1]['avg_score'] ?></div>
            </div>
            <div class="outer-bar outer-bar-3">
              <div class="inner-bar gray text-color" style="width: <?php echo $score_others7[0]['avg_score'] * 58.96 ?>px"><?php echo $score_others7[0]['avg_score'] ?></div>
            </div>
            <div class="outer-bar outer-bar-4">
              <div class="inner-bar pink text-color" style="width: <?php echo $score_others7[2]['avg_score'] * 58.96 ?>px"><?php echo $score_others7[2]['avg_score'] ?></div>
            </div>
            <div class="outer-bar outer-bar-5">
              <div class="inner-bar ov text-color" style="width: <?php echo $result8['avg_score'] * 58.96 ?>px"><?php echo $result8['avg_score']  ?></div>
            </div>
            <div class="outer-bar outer-bar-6">
              <span class="span span-1">0</span>
              <span class="span span-2">0</span>
              <span class="span span-3">7</span>
              <span class="span span-4">57</span>
              <span class="span span-5">36</span>
            </div>
          </td>
        </tr>
        <tr>
          <td class="i">
            <p class="modifies">
              <!-- 1. Seeks all information to understand reasons for change. -->
              <?php echo '1. ' . $question[0] ?>
            </p>
            <div class="div-text div-text-1">
              <p class="self">Self</p>
              <p class="supr">Supr.</p>
              <p class="peer">Peer</p>
              <p class="subord">Subord.</p>
              <p class="OA">OA</p>
              <p class="freq">% Freq</p>
            </div>
          </td>
          <td class="n">
            <div class="div-number div-number-1">
              <p class="one">1</p>
              <p class="one-1"><?php echo $score_others1[1]['count'] ?></p>
              <p class="three"><?php echo $score_others1[0]['count'] ?></p>
              <p class="three-3"><?php echo $score_others1[2]['count'] ?></p>
              <p class="seven"><?php echo $score_others2[0]['count'] ?></p>
            </div>
          </td>
          <td class="j">
            <div class="outer-bar outer-bar-1">
              <div class="inner-bar red text-color" style="width: <?php echo ($self_score[0] * 58.96) ?>px"><?php echo $self_score[0] ?></div>
            </div>
            <div class="outer-bar outer-bar-2">
              <div class="inner-bar green" style="width: <?php echo ($score_others1[1]['avg'] * 58.96) ?>px"><?php echo $score_others1[1]['avg'] ?></div>
            </div>
            <div class="outer-bar outer-bar-3">
              <div class="inner-bar gray" style="width: <?php echo $score_others1[0]['avg'] * 58.96 ?>px"><?php echo $score_others1[0]['avg'] ?></div>
            </div>
            <div class="outer-bar outer-bar-4">
              <div class="inner-bar pink" style="width: <?php echo $score_others1[2]['avg'] * 58.96 ?>px"><?php echo $score_others1[2]['avg'] ?></div>
            </div>
            <div class="outer-bar outer-bar-5">
              <div class="inner-bar" style="width: <?php echo $score_others2[0]['avg'] * 58.96 ?>px"><?php echo $score_others2[0]['avg'] ?></div>
            </div>
            <div class="outer-bar outer-bar-6">
              <span class="span span-1">0</span>
              <span class="span span-2">0</span>
              <span class="span span-3">7</span>
              <span class="span span-4">57</span>
              <span class="span span-5">36</span>
            </div>
          </td>
        </tr>
        <tr>
          <td class="i">
            <p class="modifies">
              <!-- 2. Modifies own behavior, when necessary, to deal effectively
              with change. -->
              <?php echo '2. ' . $question[1] ?>
            </p>
            <div class="div-text div-text-2">
              <p class="self">Self</p>
              <p class="supr">Supr.</p>
              <p class="peer">Peer</p>
              <p class="subord">Subord.</p>
              <p class="OA">OA</p>
              <p class="freq">% Freq</p>
            </div>
          </td>
          <td class="n">
            <div class="div-number div-number-2">
              <p class="one">1</p>
              <p class="one-1"><?php echo $score_others1[4]['count'] ?></p>
              <p class="three"><?php echo $score_others1[3]['count'] ?></p>
              <p class="three-3"><?php echo $score_others1[5]['count'] ?></p>
              <p class="seven"><?php echo $score_others2[1]['count'] ?></p>
            </div>
          </td>
          <td class="j">
            <div class="outer-bar outer-bar-1">
              <div class="inner-bar red" style="width: <?php echo $self_score[1] * 58.96 ?>px"><?php echo $self_score[1] ?></div>
            </div>
            <div class="outer-bar outer-bar-2">
              <div class="inner-bar green" style="width: <?php echo $score_others1[4]['avg'] * 58.96 ?>px"><?php echo $score_others1[4]['avg'] ?></div>
            </div>
            <div class="outer-bar outer-bar-3">
              <div class="inner-bar gray" style="width: <?php echo $score_others1[3]['avg'] * 58.96 ?>px"><?php echo $score_others1[3]['avg'] ?></div>
            </div>
            <div class="outer-bar outer-bar-4">
              <div class="inner-bar pink" style="width: <?php echo $score_others1[5]['avg'] * 58.96 ?>px"><?php echo $score_others1[5]['avg'] ?></div>
            </div>
            <div class="outer-bar outer-bar-5">
              <div class="inner-bar" style="width: <?php echo $score_others2[1]['avg'] * 58.96 ?>px"><?php echo $score_others2[1]['avg'] ?></div>
            </div>
            <div class="outer-bar outer-bar-6">
              <span class="span span-1">0</span>
              <span class="span span-2">0</span>
              <span class="span span-3">7</span>
              <span class="span span-4">57</span>
              <span class="span span-5">36</span>
            </div>
          </td>
        </tr>
        <tr>
          <td class="i">
            <p class="modifies">
              <!-- 3. Treats change or new situations as opportunities for learning
              and growth. -->
              <?php echo '3. ' . $question[2] ?>
            </p>
            <div class="div-text div-text-3">
              <p class="self">Self</p>
              <p class="supr">Supr.</p>
              <p class="peer">Peer</p>
              <p class="subord">Subord.</p>
              <p class="OA">OA</p>
              <p class="freq">% Freq</p>
            </div>
          </td>
          <td class="n">
            <div class="div-number div-number-3">
              <p class="one">1</p>
              <p class="one-1"><?php echo $score_others1[7]['count'] ?></p>
              <p class="three"><?php echo $score_others1[6]['count'] ?></p>
              <p class="three-3"><?php echo $score_others1[8]['count'] ?></p>
              <p class="seven"><?php echo $score_others2[2]['count'] ?></p>
            </div>
          </td>
          <td class="j">
            <div class="outer-bar outer-bar-1">
              <div class="inner-bar red" style="width: <?php echo $self_score[2] * 58.96 ?>px"><?php echo $self_score[2] ?></div>
            </div>
            <div class="outer-bar outer-bar-2">
              <div class="inner-bar green" style="width: <?php echo $score_others1[7]['avg'] * 58.96 ?>px"><?php echo $score_others1[7]['avg'] ?></div>
            </div>
            <div class="outer-bar outer-bar-3">
              <div class="inner-bar gray" style="width: <?php echo $score_others1[6]['avg'] * 58.96 ?>px"><?php echo $score_others1[6]['avg'] ?></div>
            </div>
            <div class="outer-bar outer-bar-4">
              <div class="inner-bar pink" style="width: <?php echo $score_others1[8]['avg'] * 58.96 ?>px"><?php echo $score_others1[8]['avg'] ?></div>
            </div>
            <div class="outer-bar outer-bar-5">
              <div class="inner-bar" style="width: <?php echo $score_others2[2]['avg'] * 58.96 ?>px"><?php echo $score_others2[2]['avg'] ?></div>
            </div>
            <div class="outer-bar outer-bar-6">
              <span class="span span-1">0</span>
              <span class="span span-2">0</span>
              <span class="span span-3">7</span>
              <span class="span span-4">57</span>
              <span class="span span-5">36</span>
            </div>
          </td>
        </tr>
        <tr>
          <td class="i">
            <p class="modifies">
              <!-- 4. Communicates reasons for change effectively. -->
              <?php echo '4. ' . $question[3] ?>
            </p>
            <div class="div-text div-text-4">
              <p class="self">Self</p>
              <p class="supr">Supr.</p>
              <p class="peer">Peer</p>
              <p class="subord">Subord.</p>
              <p class="OA">OA</p>
              <p class="freq">% Freq</p>
            </div>
          </td>
          <td class="n">
            <div class="div-number div-number-4">
              <p class="one">1</p>
              <p class="one-1"><?php echo $score_others1[10]['count'] ?></p>
              <p class="three"><?php echo $score_others1[9]['count'] ?></p>
              <p class="three-3"><?php echo $score_others1[11]['count'] ?></p>
              <p class="seven"><?php echo $score_others2[3]['count'] ?></p>
            </div>
          </td>
          <td class="j">
            <div class="outer-bar outer-bar-1">
              <div id="r1" class="inner-bar red" style="width: <?php echo $self_score[3] * 58.96 ?>px"><?php echo $self_score[3] ?></div>
            </div>
            <div class="outer-bar outer-bar-2">
              <div class="inner-bar green" style="width: <?php echo $score_others1[10]['avg'] * 58.96 ?>px"><?php echo $score_others1[10]['avg'] ?></div>
            </div>
            <div id="r3" class="outer-bar outer-bar-3">
              <div class="inner-bar gray" style="width: <?php echo $score_others1[9]['avg'] * 58.96 ?>px"><?php echo $score_others1[9]['avg'] ?></div>
            </div>
            <div class="outer-bar outer-bar-4">
              <div class="inner-bar pink" style="width: <?php echo $score_others1[11]['avg'] * 58.96 ?>px"><?php echo $score_others1[11]['avg'] ?></div>
            </div>
            <div class="outer-bar outer-bar-5">
              <div class="inner-bar" style="width: <?php echo $score_others2[3]['avg'] * 58.96 ?>px"><?php echo $score_others2[3]['avg'] ?></div>
            </div>
            <div class="outer-bar outer-bar-6">
              <span class="span span-1">0</span>
              <span class="span span-2">0</span>
              <span class="span span-3">7</span>
              <span class="span span-4">57</span>
              <span class="span span-5">36</span>
            </div>
          </td>
        </tr>
      </table>
      <div class="overall">
        <span style="font-weight: 700;">OA</span>: Overall Average of all your raters (self excluded).
      </div>
      <div class="overall-bottom">
        <span style="font-weight: 700;">Freq</span>: % of people who gace you a score of 1, % who gave you a score of
        2.
      </div>
      <div class="zrutam">360-degree Assessment</div>
    </div>
  </div>
</body>

</html>
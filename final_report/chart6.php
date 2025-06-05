<?php
include '../version1/database/connection.php';

// $sql = "WITH self_avg AS (
//     SELECT q.category, ROUND(AVG(s.answer), 2) AS self_score
//     FROM candidate_response s
//     JOIN questions q ON s.question_id = q.id
//     WHERE s.unique_code = ?
//     GROUP BY q.category
// ),
// others_avg AS (
//     SELECT q.category, oi.RTL AS relation, ROUND(AVG(o.answer), 2) AS others_score
//     FROM others_response o
//     JOIN questions q ON o.question_id = q.id
//     JOIN others_info oi ON o.u_id = oi.uc AND o.unique_code = oi.uni_code
//     WHERE o.unique_code = ?
//     GROUP BY q.category, oi.RTL
// ),
// diff_table AS (
//     SELECT o.category, o.relation, o.others_score, s.self_score,
//            ROUND(ABS(o.others_score - s.self_score), 2) AS diff_score
//     FROM others_avg o
//     JOIN self_avg s ON o.category = s.category
// ),
// ranked_diff AS (
//     SELECT *, DENSE_RANK() OVER (PARTITION BY relation ORDER BY diff_score DESC) AS rnk
//     FROM diff_table
// )
// SELECT category, relation, self_score, others_score, diff_score
// FROM ranked_diff
// WHERE rnk <= 3
// ORDER BY relation, diff_score DESC;
// ";

$sql1 = "WITH my_avg AS ( 
    SELECT 
        q.category, 
        AVG(cr.answer) AS my_a 
    FROM 
        candidate_response cr 
    INNER JOIN 
        questions q ON cr.question_id = q.id 
    WHERE 
        cr.unique_code = ? 
    GROUP BY 
        q.category 
), 
managers_avg AS ( 
    SELECT 
        q.category, 
        AVG(o.answer) AS m_a 
    FROM 
        others_response o 
    INNER JOIN 
        questions q ON o.question_id = q.id
    INNER JOIN 
        others_info oi ON o.u_id = oi.uc 
    WHERE 
        oi.RTL = 'supervisor' AND o.unique_code = ? 
    GROUP BY 
        q.category 
),
diffs AS (
    SELECT 
        my_avg.category, 
        my_avg.my_a, 
        managers_avg.m_a, 
        ROUND(my_avg.my_a - managers_avg.m_a, 2) AS diff
    FROM 
        my_avg 
    JOIN 
        managers_avg ON my_avg.category = managers_avg.category 
),
ranked AS (
    SELECT *, 
        RANK() OVER (ORDER BY ABS(diff) DESC) AS rnk 
    FROM diffs
)
SELECT *
FROM ranked
WHERE rnk <= 3
ORDER BY rnk;";

$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param("ss", $id, $id);
$stmt1->execute();
$result1 = $stmt1->get_result();

$sql2 = "WITH my_avg AS ( 
    SELECT 
        q.category, 
        AVG(cr.answer) AS my_a 
    FROM 
        candidate_response cr 
    INNER JOIN 
        questions q ON cr.question_id = q.id 
    WHERE 
        cr.unique_code = ? 
    GROUP BY 
        q.category 
), 
managers_avg AS ( 
    SELECT 
        q.category, 
        AVG(o.answer) AS m_a 
    FROM 
        others_response o 
    INNER JOIN 
        questions q ON o.question_id = q.id
    INNER JOIN 
        others_info oi ON o.u_id = oi.uc 
    WHERE 
        oi.RTL = 'peer' AND o.unique_code = ? 
    GROUP BY 
        q.category 
),
diffs AS (
    SELECT 
        my_avg.category, 
        my_avg.my_a, 
        managers_avg.m_a, 
        ROUND(my_avg.my_a - managers_avg.m_a, 2) AS diff
    FROM 
        my_avg 
    JOIN 
        managers_avg ON my_avg.category = managers_avg.category 
),
ranked AS (
    SELECT *, 
        RANK() OVER (ORDER BY ABS(diff) DESC) AS rnk 
    FROM diffs
)
SELECT *
FROM ranked
WHERE rnk <= 3
ORDER BY rnk;";


$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("ss", $id, $id);
$stmt2->execute();
$result2 = $stmt2->get_result();

$sql3 = "WITH my_avg AS ( 
    SELECT 
        q.category, 
        AVG(cr.answer) AS my_a 
    FROM 
        candidate_response cr 
    INNER JOIN 
        questions q ON cr.question_id = q.id 
    WHERE 
        cr.unique_code = ? 
    GROUP BY 
        q.category 
), 
managers_avg AS ( 
    SELECT 
        q.category, 
        AVG(o.answer) AS m_a 
    FROM 
        others_response o 
    INNER JOIN 
        questions q ON o.question_id = q.id
    INNER JOIN 
        others_info oi ON o.u_id = oi.uc 
    WHERE 
        oi.RTL = 'team-member' AND o.unique_code = ? 
    GROUP BY 
        q.category 
),
diffs AS (
    SELECT 
        my_avg.category, 
        my_avg.my_a, 
        managers_avg.m_a, 
        ROUND(my_avg.my_a - managers_avg.m_a, 2) AS diff
    FROM 
        my_avg 
    JOIN 
        managers_avg ON my_avg.category = managers_avg.category 
),
ranked AS (
    SELECT *, 
        RANK() OVER (ORDER BY ABS(diff) DESC) AS rnk 
    FROM diffs
)
SELECT *
FROM ranked
WHERE rnk <= 3
ORDER BY rnk;";

$stmt3 = $conn->prepare($sql3);
$stmt3->bind_param("ss", $id, $id);
$stmt3->execute();
$result3 = $stmt3->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHART 6</title>
    <style>
        .chart6-body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .chart6-main-container {
            display: inline-block;
            position: relative;
            width: 21cm;
            height: 29.7cm;
            padding-left: 30px;
        }

        .chart6-bold {
            position: absolute;
            top: 100px;
            left: 0;
            font-weight: bold;
            text-align: center;
            font-size: 20px;
            width: 793px;
        }

        .chart6-red {
            position: absolute;
            color: red;
            font-size: 20px;
            font-weight: bold;
            width: 793px;
            top: 140px;
            text-align: center;
            left: 0;
        }

        .chart6-normal {
            color: black;
            font-size: 13px;
            text-align: center;
            font-size: 14px;
        }

        .chart6-black {
            position: absolute;
            top: 165px;
            left: 100px;
            width: 600px;
            border: 1px solid black;
        }

        .chart6-center-text {
            position: absolute;
            top: 180px;
            left: 100px;
            width: 620px;
        }

        .chart6-table {
            position: absolute;
            top: 340px;
            left: 100px;
            width: 620px;
            height: auto;
            border: 1px solid black;
        }

        .chart6-td-number {
            width: 100px;
        }

        .chart6-number-bold {
            font-weight: bold;
            text-align: right;
            padding-right: 10px;
            color: blue;
            font-size: 12px;
            font-weight: bold;
        }

        .chart6-td-left {
            width: 310px;
            padding: 3px 7px 3px 7px;
        }

        .chart6-td-right {
            width: 100px;
            text-align: right;
            padding: 3px 27px 3px 0px;
        }

        .chart6-p-blue {
            color: blue;
            font-size: 12px;
            font-weight: bold;
        }

        .chart6-p-black {
            font-size: 12px;
            font-weight: bold;
        }

        .chart6-p-red {
            color: red;
            font-size: 12px;
            font-weight: bold;
        }

        .chart6-bottom {
            position: absolute;
            bottom: 20px;
            left: 20px;
            color: gray;
        }

        .chart6-table1 {
            position: absolute;
            top: 450px;
            left: 100px;
            width: 620px;
            height: auto;
            border: 1px solid black;
        }

        .chart6-table2 {
            position: absolute;
            top: 560px;
            left: 100px;
            width: 620px;
            height: auto;
            border: 1px solid black;
        }
    </style>
</head>

<body class="chart6-body">
    <div class="chart6-main-container">
        <p class="chart6-bold">Opportunities to Reach Common Ground</p>
        <p class="chart6-red">Prepared for: <span class="chart6-normal"><?php echo $var_name ?></span></p>
        <div class="chart6-black"></div>
        <p class="chart6-center-text">The following comparisons show the gaps between your self ratings and the ratings of others on those three Competencies where the gaps are largest. These represent opportunities for exploration on how to reach common ground. Please note that a negative number indicates that your self rating was HIGHER than the average within the comparison category. A positive number indicates that you rated yourself LOWER than the average of the individuals within a category.</p>
        <table class="chart6-table">
            <tr>
                <th colspan="3">Self vs. Superiors</th>
            </tr>
            <?php $i = 1;
            while ($row1 = $result1->fetch_assoc()) { ?>
                <tr>
                    <td class="chart6-td-number">
                        <p class="chart6-number-bold"><?php echo $i ?>.</p>
                    </td>
                    <td class="chart6-td-left">
                        <p class="chart6-p-blue"><?php echo $row1['category'] ?></p>
                    </td>
                    <td class="chart6-td-right">
                        <p class="chart6-p-red"><?php echo $row1['diff'] ?></p>
                    </td>
                </tr>
            <?php $i++;
            } ?>
            <!-- <tr>
                <td class="chart6-td-number">
                    <p class="chart6-number-bold">2.</p>
                </td>
                <td class="chart6-td-left">
                    <p class="chart6-p-blue">MENTORING/DEVELOPING EMPLOYEES </p>
                </td>
                <td class="chart6-td-right">
                    <p class="chart6-p-red">-.50</p>
                </td>
            </tr>
            <tr>
                <td class="chart6-td-number">
                    <p class="chart6-number-bold">3.</p>
                </td>
                <td class="chart6-td-left">
                    <p class="chart6-p-blue">COMMUNICATION</p>
                </td>
                <td class="chart6-td-right">
                    <p class="chart6-p-red">-.25</p>
                </td>
            </tr> -->
        </table>
        <table class="chart6-table1">
            <tr>
                <th colspan="3">Self vs. Peers</th>
            </tr>
            <?php $i = 1;
            while ($row2 = $result2->fetch_assoc()) { ?>
                <tr>
                    <td class="chart6-td-number">
                        <p class="chart6-number-bold"><?php echo $i ?>.</p>
                    </td>
                    <td class="chart6-td-left">
                        <p class="chart6-p-blue"><?php echo $row2['category'] ?></p>
                    </td>
                    <td class="chart6-td-right">
                        <p class="chart6-p-black"><?php echo $row2['diff'] ?></p>
                    </td>
                </tr>
            <?php $i++;
            } ?>
            <!-- <tr>
                <td class="chart6-td-number">
                    <p class="chart6-number-bold">2.</p>
                </td>
                <td class="chart6-td-left">
                    <p class="chart6-p-blue">DECISION-MAKING </p>
                </td>
                <td class="chart6-td-right">
                    <p class="chart6-p-black">+.58</p>
                </td>
            </tr>
            <tr>
                <td class="chart6-td-number">
                    <p class="chart6-number-bold">3.</p>
                </td>
                <td class="chart6-td-left">
                    <p class="chart6-p-blue">ADAPTABILITY</p>
                </td>
                <td class="chart6-td-right">
                    <p class="chart6-p-black">+.42</p>
                </td>
            </tr> -->
        </table>
        <table class="chart6-table2">
            <tr>
                <th colspan="3">Self vs. Subordinates</th>
            </tr>
            <?php $i = 1;
            while ($row3 = $result3->fetch_assoc()) { ?>
                <tr>
                    <td class="chart6-td-number">
                        <p class="chart6-number-bold"><?php echo $i ?>.</p>
                    </td>
                    <td class="chart6-td-left">
                        <p class="chart6-p-blue"><?php echo $row3['category'] ?></p>
                    </td>
                    <td class="chart6-td-right">
                        <p class="chart6-p-black"><?php echo $row3['diff'] ?></p>
                    </td>
                </tr>
            <?php $i++;
            } ?>

            <!-- <tr>
                <td class="chart6-td-number">
                    <p class="chart6-number-bold">2.</p>
                </td>
                <td class="chart6-td-left">
                    <p class="chart6-p-blue">DECISION-MAKING </p>
                </td>
                <td class="chart6-td-right">
                    <p class="chart6-p-black">+1.00</p>
                </td>
            </tr>
            <tr>
                <td class="chart6-td-number">
                    <p class="chart6-number-bold">3.</p>
                </td>
                <td class="chart6-td-left">
                    <p class="chart6-p-blue">INNOVATION</p>
                </td>
                <td class="chart6-td-right">
                    <p class="chart6-p-black">+1.00</p>
                </td>
            </tr>
            <tr>
                <td class="chart6-td-number">
                    <p class="chart6-number-bold">4.</p>
                </td>
                <td class="chart6-td-left">
                    <p class="chart6-p-blue">MANAGING CONFLICT</p>
                </td>
                <td class="chart6-td-right">
                    <p class="chart6-p-black">+1.00</p>
                </td>
            </tr> -->
        </table>
        <p class="chart6-bottom">360-degree Assessment. Zrutam Inc</p>
    </div>
</body>

</html>
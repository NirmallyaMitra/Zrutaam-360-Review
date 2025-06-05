<?php
include '../version1/database/connection.php';

$sql = "WITH self_avg AS (
            SELECT q.id AS question_id, q.question, q.category, ROUND(AVG(s.answer), 2) AS self_score
            FROM candidate_response s
            JOIN questions q ON s.question_id = q.id
            WHERE s.unique_code = ?
            GROUP BY q.id, q.question, q.category
        ),
        others_avg AS (
            SELECT q.id AS question_id, q.question, q.category, oi.RTL AS relation, ROUND(AVG(o.answer), 2) AS others_score
            FROM others_response o
            JOIN questions q ON o.question_id = q.id
            JOIN others_info oi ON o.u_id = oi.uc AND o.unique_code = oi.uni_code
            WHERE o.unique_code = ?
            GROUP BY q.id, q.question, q.category, oi.RTL
        ),
        diff_table AS (
            SELECT o.question_id, o.question, o.category, o.relation, o.others_score, s.self_score,
                   ROUND(ABS(o.others_score - s.self_score), 2) AS diff_score
            FROM others_avg o
            JOIN self_avg s ON o.question_id = s.question_id
        ),
        ranked_diff AS (
            SELECT *, DENSE_RANK() OVER (PARTITION BY relation ORDER BY diff_score DESC) AS rnk
            FROM diff_table
        )
        SELECT relation, question, category, self_score, others_score, diff_score
        FROM ranked_diff
        WHERE rnk <= 3
        ORDER BY relation, diff_score DESC;";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $id, $id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHART 7</title>
    <style>
        .chart7-body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .chart7-main-container {
            display: inline-block;
            position: relative;
            width: 21cm;
            height: 29.7cm;
            padding-left: 30px;
        }

        .chart7-bold {
            position: absolute;
            top: 100px;
            left: 0;
            font-weight: bold;
            text-align: center;
            font-size: 20px;
            width: 793px;
        }

        .chart7-red {
            position: absolute;
            color: red;
            font-size: 20px;
            font-weight: bold;
            width: 793px;
            top: 140px;
            text-align: center;
            left: 0;
        }

        .chart7-normal {
            color: black;
            font-size: 13px;
            text-align: center;
            font-size: 14px;
        }

        .chart7-black {
            position: absolute;
            top: 165px;
            left: 100px;
            width: 600px;
            border: 1px solid black;
        }

        .chart7-center-text {
            position: absolute;
            top: 180px;
            left: 100px;
            width: 620px;
        }

        .chart7-table {
            position: absolute;
            top: 330px;
            left: 100px;
            width: 620px;
            height: auto;
            border: 1px solid black;
        }

        .chart7-td-number1 {
            width: 100px;
        }

        .chart7-number-bold1 {
            font-weight: bold;
            text-align: right;
            padding-right: 10px;
            color: blue;
            font-size: 12px;
            font-weight: bold;
        }

        .chart7-td-left1 {
            width: 420px;
            padding: 3px 7px 3px 7px;
        }

        .chart7-td-right1 {
            width: 100px;
            text-align: right;
            padding: 3px 27px 3px 0px;
        }

        .chart7-p-blue1 {
            color: blue;
            font-size: 12px;
            font-weight: bold;
        }

        .chart7-p-black1 {
            font-size: 12px;
            font-weight: bold;
        }

        .chart7-p-red1 {
            font-size: 12px;
            font-weight: bold;
            color: red;
        }

        .chart7-bottom {
            position: absolute;
            bottom: 20px;
            left: 20px;
            color: gray;
        }

        .chart7-table1 {
            position: absolute;
            top: 460px;
            left: 100px;
            width: 620px;
            height: auto;
            border: 1px solid black;
        }

        .chart7-table2 {
            position: absolute;
            top: 620px;
            left: 100px;
            width: 620px;
            height: auto;
            border: 1px solid black;
        }
    </style>
</head>

<body class="chart7-body">
    <div class="chart7-main-container">
        <p class="chart7-bold">Opportunities to Reach Common Ground</p>
        <p class="chart7-red">Prepared for: <span class="chart7-normal"><?php echo $var_name ?></span></p>
        <div class="chart7-black"></div>
        <p class="chart7-center-text">The following comparisons show at the item level how your self ratings compare with the average ratings of others based on items drawn from the first Competency in each of the comparisons on the previous page. A negative number indicates that you rated yourself HIGHER than the average of the individuals within a category. A positive number indicates that you rated yourself LOWER than the average of the individuals within a category.</p>
        <table class="chart7-table">
            <tr>
                <th colspan="3">Self vs. Superiors</th>
            </tr>
            <tr>
                <td class="chart7-td-number1">
                    <p class="chart7-number-bold1">11.</p>
                </td>
                <td class="chart7-td-left1">
                    <p class="chart7-p-blue1">Makes an extra effort, through alternative choices, to satisfy customer demands.</p>
                </td>
                <td class="chart7-td-right1">
                    <p class="chart7-p-red1">-2.00</p>
                </td>
            </tr>
            <tr>
                <td class="chart7-td-number1">
                    <p class="chart7-number-bold1">10.</p>
                </td>
                <td class="chart7-td-left1">
                    <p class="chart7-p-blue1">Effectively and quickly handles customer complaints.</p>
                </td>
                <td class="chart7-td-right1">
                    <p class="chart7-p-black1">+1.00</p>
                </td>
            </tr>
            <tr>
                <td class="chart7-td-number1">
                    <p class="chart7-number-bold1">12.</p>
                </td>
                <td class="chart7-td-left1">
                    <p class="chart7-p-blue1">Leads by example in serving customer.</p>
                </td>
                <td class="chart7-td-right1">
                    <p class="chart7-p-red1">-1.00</p>
                </td>
            </tr>
        </table>
        <table class="chart7-table1">
            <tr>
                <th colspan="3">Self vs. Peers</th>
            </tr>
            <tr>
                <td class="chart7-td-number1">
                    <p class="chart7-number-bold1">25.</p>
                </td>
                <td class="chart7-td-left1">
                    <p class="chart7-p-blue1">Considers all points of view when resolving conflict.</p>
                </td>
                <td class="chart7-td-right1">
                    <p class="chart7-p-black1">+1.33</p>
                </td>
            </tr>
            <tr>
                <td class="chart7-td-number1">
                    <p class="chart7-number-bold1">26.</p>
                </td>
                <td class="chart7-td-left1">
                    <p class="chart7-p-blue1">Takes positive action to resolve the conflict.</p>
                </td>
                <td class="chart7-td-right1">
                    <p class="chart7-p-black1">+.67</p>
                </td>
            </tr>
            <tr>
                <td class="chart7-td-number1">
                    <p class="chart7-number-bold1">27.</p>
                </td>
                <td class="chart7-td-left1">
                    <p class="chart7-p-blue1">Clearly explain reasons for decision when resolving conflict.</p>
                </td>
                <td class="chart7-td-right1">
                    <p class="chart7-p-black1">+.67</p>
                </td>
            </tr>
            <tr>
                <td class="chart7-td-number1">
                    <p class="chart7-number-bold1">28.</p>
                </td>
                <td class="chart7-td-left1">
                    <p class="chart7-p-blue1">Ensures all parties understand resolution to conflict and know the necessary future activities.</p>
                </td>
                <td class="chart7-td-right1">
                    <p class="chart7-p-black1">+.67</p>
                </td>
            </tr>
        </table>
        <table class="chart7-table2">
            <tr>
                <th colspan="3">Self vs. Subordinates</th>
            </tr>
            <tr>
                <td class="chart7-td-number1">
                    <p class="chart7-number-bold1">19.</p>
                </td>
                <td class="chart7-td-left1">
                    <p class="chart7-p-blue1">Gives freedom to choose approach while maintaining responsibility.</p>
                </td>
                <td class="chart7-td-right1">
                    <p class="chart7-p-black1">+2.00</p>
                </td>
            </tr>
            <tr>
                <td class="chart7-td-number1">
                    <p class="chart7-number-bold1">18.</p>
                </td>
                <td class="chart7-td-left1">
                    <p class="chart7-p-blue1">Provide resources and guidance needed for the task.</p>
                </td>
                <td class="chart7-td-right1">
                    <p class="chart7-p-black1">+1.00</p>
                </td>
            </tr>
            <tr>
                <td class="chart7-td-number1">
                    <p class="chart7-number-bold1">20.</p>
                </td>
                <td class="chart7-td-left1">
                    <p class="chart7-p-blue1">Knows when it is necessary to assist or intervene.</p>
                </td>
                <td class="chart7-td-right1">
                    <p class="chart7-p-black1">+.67</p>
                </td>
            </tr>
            <tr>
                <td class="chart7-td-number1">
                    <p class="chart7-number-bold1">17.</p>
                </td>
                <td class="chart7-td-left1">
                    <p class="chart7-p-blue1">Assign work to the appropriate person.</p>
                </td>
                <td class="chart7-td-right1">
                    <p class="chart7-p-black1">+.67</p>
                </td>
            </tr>
        </table>
        <p class="chart7-bottom">360-degree Assessment. Zrutam Inc</p>
    </div>
</body>

</html>
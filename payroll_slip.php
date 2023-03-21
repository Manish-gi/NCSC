<?php
$tableOne = '';
$tableTwo = '';
?>
<style>
    #head {
        width: 50%;

    }

    th {
        text-align: left;
    }

    h2 {
        margin-block: 10px;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .card-header {
        width: 100%;
    }

    .card {
        display: inline-flex;
        width: 49%;
    }

    table {
        width: 100%;
        border: 2px;


    }
</style>

<div>
    <h1 class="text-center">EMPLOYEE PAYSLIP</h1>
    <hr>
</div>
<table id="head">
    <thead>
        <!-- <tr>
            <th class="text-center">Employee ID</th>
            <th class="text-center">Employee Name</th>
            <th class="text-center">Fix-Pay</th>
            <th class="text-center">Attendance</th>
            <th class="text-center">Total Allowance</th>
            <th class="text-center">Total Deduction</th>
            <th class="text-center">Net Pay</th>
        </tr> -->
    </thead>
    <tbody>
            <?php include('db_connect.php') ?>
            <?php
            $result = $conn->query("SELECT sm.*,concat(e.first_name,' ',e.last_name) as ename,ec.acc_no,d.dept_name,e.pay_min,e.pay_max,p.pos_name from salary_main sm INNER JOIN employee e on sm.emp_id=e.emp_id INNER JOIN position p on e.pos_id=p.pos_id LEFT JOIN emp_acc ec on e.emp_id=ec.emp_id INNER JOIN department d on e.dept_id=d.dept_id where sm.emp_id='" . $_GET['emp_id'] . "' AND sm.date='" . $_GET['date'] . "'");
            while ($data = $result->fetch_array()) { ?>
        <tr>
            <th>
                Month
            </th>
            <th>
                <?php echo date("Y-M", strtotime($data['date'])) ?>
            </th>
        </tr>
        <tr>
            <td class="text-left">Employee ID</td>
            <td class="text-left"><?php echo $data['emp_id'] ?></td>
        </tr>
        <tr>
            <td class="text-left">Department</td>
            <td class="text-left"><?php echo $data['dept_name'] ?></td>
        </tr>
        <tr>
            <td class="text-left">Designation</td>
            <td class="text-left"><?php echo $data['pos_name'] ?></td>
        </tr>
        <tr>
            <td class="text-left">Employee Name</td>
            <td class="text-left"><?php echo $data['ename'] ?></td>
        </tr>
        <tr>
            <td class="text-left">Account Number</td>
            <td class="text-left"><?php echo $data['acc_no'] ?></td>
        </tr>
        <tr>
            <td class="text-left">Pay Band</td>
            <td class="text-left"><?php echo $data['pay_min'] ?> - <?php echo $data['pay_max'] ?></td>
        </tr>
        <tr>
            <td class="text-left">Present Day</td>
            <td class="text-left"><?php echo $data['attend'] ?></td>
        </tr>
    </tbody>
</table>

<?php
                $tot_alw = 0;
                $tot_dedu = 0;
                $net_pay = 0;
                $repo_col = $conn->query("SELECT COLUMN_NAME from information_schema.columns WHERE table_name = N'salary_main'");
                while ($repo_col_name = $repo_col->fetch_assoc()) {
                    // $i = 0;
                    $alw = $conn->query("SELECT * FROM allowance");
?>

<?php
                    while ($alwn = $alw->fetch_array()) {
                        if ($repo_col_name['COLUMN_NAME'] == $alwn['aloow_name']) {
                            $tableOne .= "<tr>";
                            $tableOne .= "<td >" . $alwn['description'] . "</td>";
                            $tableOne .= "<td>" . $data[$repo_col_name['COLUMN_NAME']] . "</td>";
                            echo "</tr>";
                            $tot_alw += $data[$repo_col_name['COLUMN_NAME']];
                        }
                    }


                    $alw = $conn->query("SELECT * FROM deduction");
                    while ($alwn = $alw->fetch_array()) {
                        if ($repo_col_name['COLUMN_NAME'] == $alwn['dedu_name']) {
                            $tableTwo .= "<tr>";
                            $tableTwo .= "<td>" . $alwn['dedu_desc'] . "</td>";
                            $tableTwo .= "<td>" . $data[$repo_col_name['COLUMN_NAME']] . "</td>";
                            echo "</tr>";
                            $tot_dedu += $data[$repo_col_name['COLUMN_NAME']];
                        }
                    }

                    if ($repo_col_name['COLUMN_NAME'] == "hra" || $repo_col_name['COLUMN_NAME'] == "da" || $repo_col_name['COLUMN_NAME'] == "ma") {
                        $tot_alw += $data[$repo_col_name['COLUMN_NAME']];
                    }
                    if ($repo_col_name['COLUMN_NAME'] == "ptax" || $repo_col_name['COLUMN_NAME'] == "epf") {
                        $tot_dedu += $data[$repo_col_name['COLUMN_NAME']];
                    }
                }

?>
<hr>
<div class="card">
    <div class="card-header">
        <h2 class="text-center">Earnings</h2>
        
        <?php
                echo "<table>";
        ?>
        <tr>
            <td>Fix Pay</td>
            <td class="text-left"><?php echo $data['fix_pay'] ?></td>
        </tr>
        <tr>
            <td>Grade Pay</td>
            <td class="text-left"><?php echo $data['grade_pay'] ?></td>
        </tr>
        <tr>
            <td>DA</td>
            <td class="text-left"><?php echo $data['da'] ?></td>
        </tr>
        <tr>
            <td>HRA</td>
            <td class="text-left"><?php echo $data['hra'] ?></td>
        </tr>
        <tr>
            <td>Medical Allowance</td>
            <td class="text-left"><?php echo $data['ma'] ?></td>
        </tr>
        <?php
                echo $tableOne;
        ?>


        <tr>
            <th>Total Allowance</th>
            <th class="text-left"><?php echo number_format($tot_alw) ?></th>
        </tr>
        <tr>
            <?php
                $gross=$tot_alw+$data['fix_pay']+$data['grade_pay'];      
            ?>
            <th>Gross Pay</th>
            <th class="text-left"><?php echo number_format($gross) ?></th>
        </tr>
        <?php
                echo "</table>";
        ?>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h2 class="text-center">Deduction</h2>
        <?php
                echo "<table>";
        ?>
        <tr>
            <td>P Tax</td>
            <td class="text-left"><?php echo $data['ptax'] ?></td>
        </tr>
        <tr>
            <td>EPF</td>
            <td class="text-left"><?php echo $data['epf'] ?></td>
        </tr>
        <?php
                echo $tableTwo;
        ?>

        <tr><b>
                <th>Total Deduction</th>
                <th><?php echo number_format($tot_dedu) ?></th>
            </b>
        </tr>
        <?php
                echo "</table>";
        ?>
    </div>
</div>

<hr>
<tr>
    <h1>
        <td class="text-center">Net Pay:</td>
        <?php 
        $net_pay = ($gross - $tot_dedu);
        ?>
        <td class="text-right"><?php echo number_format($net_pay) ?></td>
    </h1>
</tr>
<?php
            }
?>
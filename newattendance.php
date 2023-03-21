<?php include 'db_connect.php' ?>
<style>
    .form-group {
        display: inline-block;
    }

    table {
        border-collapse: collapse;
        border: 1px;
    }
</style>
<div class="container-fluid ">
    <div class="col-lg-12">
        <div class="card">

            <div class="card-header">
                <form method="POST">
                    <div class="form-group">
                        <input type="date" name="date" id="adate">
                    </div>
                    <div class="form-group">
                        <label>Employee Type</label>
                        <select class="custom-select browser-default select2" id="emp_typ" name="emp_typ">
                            <option value=""></option>
                            <option value="1">Parmanent</option>
                            <option value="2">Visiting</option>
                            <option value="3">Contractual</option>
                            <option value="4">Teaching Assistant</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button name="submit">Add Attendance</button>
                    </div>
                    <?php
                    if (isset($_POST['submit'])) {
                        $emp_type = $_POST['emp_typ'];
                        $date = $_POST['date'];

                        $_SESSION["emp_typ"]=$emp_type;
                        $_SESSION["date"]=$date;

                        $emp = $conn->query("SELECT * from employee where emp_type='" . $emp_type . "' AND ( d_o_r >='" . date("y-m-d") . "'|| d_o_r ='' )");
                        while ($data = $emp->fetch_array()) {

                    ?>
                </form>


            </div>
            <div class="card-body">
                <form method="POST" id="employee-attendance">
                    <table>

                        <tr>
                            <td><?php echo $data['emp_id'] ?></td>
                            <td><?php echo $data['first_name'] ?></td>
                            <td><?php echo $data['last_name'] ?></td>
                            <td><?php echo date("Y-M", strtotime($date)) ?></td>
                            <td><?php
                                $dat = strtotime($date);
                                echo cal_days_in_month(CAL_GREGORIAN, date("m", $dat), date("Y", $dat)) ?></td>
                            <td>
                            <td><input type="text" name="attend" id="attend" value="<?php echo cal_days_in_month(CAL_GREGORIAN, date("m", $dat), date("Y", $dat)) ?>"></td>
                        </tr>
                        <?php
                                }
                             }
                          ?>
                <tr>
                    <td>
                        <button name="save">Save Attendance</button>
                    </td>
                </tr>
                <?php
                if (isset($_POST['save'])) {
                    $inc_date = date('2011-08-10');

                    $emp_type=$_SESSION["emp_typ"];
                    $date=$_SESSION["date"];

                    echo $emp_type;
                    echo $date;

                    $emp = $conn->query("SELECT * from employee where emp_type='" . $emp_type . "' AND ( d_o_r >='" . date("y-m-d") . "'|| d_o_r ='' )");
                    while ($data = $emp->fetch_array()) {

                        

                        $attend = $_POST['attend'];
                        $pay = $conn->query("SELECT * FROM employee where emp_id =" . $data['emp_id'] )->fetch_array(); //importing employee details

                        $dt = strtotime($date);
                        $days_in_mounth = cal_days_in_month(CAL_GREGORIAN, date("m", $dt), date("Y", $dt)); //calulating total days in mounth
                        $tot_allow = 0;
                        echo $data['emp_id'];
                        if ($pay['emp_type'] == 2) {                                                    //calulating fix pay of employee
                            $fix_pay = $pay['fix_pay'] * $attend;
                            $tot_allow += $fix_pay;
                        } else {
                            $per_day_fix = $pay['fix_pay'] / $days_in_mounth;
                            $fix_pay = $per_day_fix * $attend;
                            $tot_allow += $fix_pay;
                        }

                        if ($pay['emp_type'] == 1) {                                                    //calculating grade pay of employee
                            $per_day_grade = $pay['grade_pay'] / $days_in_mounth;
                            $grade_pay = $per_day_grade * $attend;
                            $tot_allow += $grade_pay;
                            $data .= ", grade_pay ='" . $grade_pay . "' ";


                            $basic_pay = $fix_pay + $grade_pay;                                            //calculatung bassic pay of employee

                            $ent = $conn->query("SELECT * from entity where ent_name='DA'")->fetch_array(); //calculatung da of employee
                            $da = ($ent['ent_value'] / 100) * $basic_pay;
                            $tot_allow += $da;
                            $data .= ", da ='" . $da . "' ";

                            $ent = $conn->query("SELECT * from entity where ent_name='HRA'")->fetch_array(); //calculatung hra of employee
                            $hra = ($ent['ent_value'] / 100) * $basic_pay;
                            $tot_allow += $hra;
                            $data .= ", hra ='" . $hra . "' ";
                         

                            $ent = $conn->query("SELECT * from entity where ent_name='MA'")->fetch_array(); //calculatung ma of employee
                            $per_day_ma = $ent['ent_value'] / $days_in_mounth;
                            $ma = $per_day_ma * $attend;
                            $tot_allow += $ma;
                            $data .= ", ma ='" . $ma . "' ";
                        }
                        $all_emp_allow = $conn->query("SELECT * from emp_allow where emp_id=".$data['emp_id']) or die(mysqli_error($conn));       //importing employee all allowance
                        while ($row = $all_emp_allow->fetch_array()) {

                            $allowance = $conn->query("SELECT * from allowance where allow_id=" . $row['allow_id']);                            //imorting allowance details

                            if ($row['type'] == 2) {                                                                                                //checking the allowance in one time affective

                                date_default_timezone_set('Asia/Kolkata');
                                $efec_date = $row['effective_date'];
                                //$cur_date=date('Y-m-d');

                                if ($adate[$k] >= $efec_date) {                                                                                        ////calculatung alowance of employee
                                    while ($allow_name = $allowance->fetch_array()) {
                                        $allow_nm = $allow_name['aloow_name'];
                                    }

                                    $data = "," . $allow_nm . " ='" . $row['amount'] . "' ";
                                    $tot_allow += $row['amount'];
                                    $conn->query("DELETE FROM emp_allow where emp_allow_id=" . $row['emp_allow_id']);
                                }
                            } else {
                                while ($allow_name = $allowance->fetch_array()) {
                                    $allow_nm = $allow_name['aloow_name'];
                                }

                                $data .= "," . $allow_nm . " ='" . $row['amount'] . "' ";
                                $tot_allow += $row['amount'];
                            }
                        }

                        $all_emp_dedu = $conn->query("SELECT * from emp_dedu where emp_id=".$data['emp_id']) or die(mysqli_error($conn));       //importing employee all allowance
                        while ($row = $all_emp_dedu->fetch_array()) {

                            $deduction = $conn->query("SELECT * from deduction where dedu_id=" . $row['dedu_id']);                            //imorting allowance details

                            if ($row['type'] == 2) {                                                                                                //checking the allowance in one time affective

                                date_default_timezone_set('Asia/Kolkata');
                                $efec_date = $row['effective_date'];
                                //$cur_date=date('Y-m-d');

                                if ($date >= $efec_date) {                                                                                        ////calculatung alowance of employee
                                    while ($dedu_name = $deduction->fetch_array()) {
                                        $dedu_nm = $dedu_name['dedu_name'];
                                    }

                                    $data .= "," . $dedu_nm . " ='" . $row['amount'] . "' ";
                                    $tot_allow += $row['amount'];
                                    $conn->query("DELETE FROM emp_dedu where emp_dedu_id=" . $row['emp_dedu_id']);
                                }
                            } else {
                                while ($dedu_name = $deduction->fetch_array()) {
                                    $dedu_nm = $dedu_name['dedu_name'];
                                }

                                $data .= "," . $dedu_nm . " ='" . $row['amount'] . "' ";
                                $tot_allow += $row['amount'];
                            }
                        }
                        $lib = "Librarian";
                        $position = $conn->query("SELECT * from position where pos_name = '" . $lib . "'");
                        while ($pos = $position->fetch_array()) {
                            $pos_id = $pos['pos_id'];
                        }

                        if ($pay['emp_type'] == 1 && $pay['tech_non_tech'] == "non_teaching" && $pay['pos_id'] != $pos_id) {
                            $ent = $conn->query("SELECT * from entity where ent_name='EPF'")->fetch_array();
                            $epf = ($ent['ent_value'] / 100) * ($basic_pay + $da);
                            $data = ", epf ='" . $epf . "' ";
                        }

                        if ($tot_allow <= 5999) {
                            $ptax = 0;
                            $data .= ", ptax ='" . $ptax . "' ";
                        } else if ($tot_allow >= 6000 && $tot_allow <= 8999) {
                            $ptax = 80;
                            $data .= ", ptax ='" . $ptax . "' ";
                        } else if ($tot_allow >= 9000 && $tot_allow <= 11999) {
                            $ptax = 150;
                            $data .= ", ptax ='" . $ptax . "' ";
                        } else {
                            $ptax = 200;
                            $data .= ", ptax ='" . $ptax . "' ";
                        }
                        $data .= ", fix_pay ='" . $fix_pay . "' ";
                        $save = $conn->query("INSERT INTO salary_main  " . $data);
                    }
                }
                ?>
                    </table>
                </form>
            </div>

        </div>
    </div>
</div>
<style>
table{
    width:100%;
    border-collapse:collapse;
}
tr,td,th{
    border:1px solid black
}
.text-center{
    text-align:center;
}
.text-right{
    text-align:right;
}
</style>

<div>
<h2 class="text-center">Payslip</h2>
<hr>
</div>
<table>
    <thead>
        <tr>
            <th class="text-center">Employee ID</th>
            <th class="text-center">Employee Name</th>
            <th class="text-center">Date</th>
            <th class="text-center">Fix-Pay</th>
            <th class="text-center">Attendance</th>
            <th class="text-center">Total Allowance</th>
            <th class="text-center">Total Deduction</th>
            <th class="text-center">Net Pay</th>
            <th class="text-center">Print</th>
        </tr>
    </thead>
    <tbody>
    <tr>
    <?php include('db_connect.php') ?>
<?php
        $emp_id = $_SESSION["login_emp_id"];
        $result = $conn->query("SELECT sm.*,concat(e.first_name,' ',e.last_name) as ename,d.dept_name from salary_main sm INNER JOIN employee e on sm.emp_id=e.emp_id INNER JOIN department d on e.dept_id=d.dept_id where sm.emp_id=".$emp_id);
        while ($data = $result->fetch_array()) {
            $tot_alw = 0;
            $tot_dedu = 0;
            $net_pay = 0;
            $repo_col = $conn->query("SELECT COLUMN_NAME from information_schema.columns WHERE table_name = N'salary_main'");
            while ($repo_col_name = $repo_col->fetch_assoc()) {
                // $i = 0;
                $alw = $conn->query("SELECT * FROM allowance");
                while ($alwn = $alw->fetch_array()) {
                    if ($repo_col_name['COLUMN_NAME'] == $alwn['aloow_name']) {
                        $tot_alw += $data[$repo_col_name['COLUMN_NAME']];
                    }
                }
                $alw = $conn->query("SELECT * FROM deduction");
                while ($alwn = $alw->fetch_array()) {
                    if ($repo_col_name['COLUMN_NAME'] == $alwn['dedu_name']) {
                        $tot_dedu += $data[$repo_col_name['COLUMN_NAME']];
                    }
                }

                if ($repo_col_name['COLUMN_NAME'] == "hra" || $repo_col_name['COLUMN_NAME'] == "da" || $repo_col_name['COLUMN_NAME'] == "ma") {
                    $tot_alw += $data[$repo_col_name['COLUMN_NAME']];
                }
                if ($repo_col_name['COLUMN_NAME'] == "ptax") {
                    $tot_dedu += $data[$repo_col_name['COLUMN_NAME']];
                }
            }
            $net_pay = ($data['fix_pay'] + $tot_alw) - $tot_dedu;
        
?>
        <td><?php echo $data['emp_id'] ?></td>
        <td><?php echo $data['ename'] ?></td>
        <td><?php echo date("Y-M",strtotime($data['date'])) ?></td>
        <td class="text-right"><?php echo $data['fix_pay'] ?></td>
        <td class="text-right"><?php echo $data['attend'] ?></td>
        <td class="text-right"><?php echo number_format($tot_alw) ?></td>
        <td class="text-right"><?php echo number_format($tot_dedu) ?></td>
        <td class="text-right"><?php echo number_format($net_pay) ?></td>
        <td><button class="btn btn-sm btn-outline-primary print_btn" data-id="<?php echo $data['emp_id']?>" data-date="<?php echo $data['date'] ?>" type="button"><i class="fa fa-print"></i></button></td>
    </tr>
    <?php
        }
    ?>
    </tbody>
</table>
<script>
    		$('.print_btn').click(function(){
			var $emp_id=$(this).attr('data-id');
			var $date=$(this).attr('data-date');
				var nw = window.open("payroll_slip.php?emp_id="+$emp_id+"&date="+$date,"_blank","height=500,width=800")
				setTimeout(function(){
					nw.print()
					setTimeout(function(){
						nw.close()
						},500)
				},1000)
			})
</script>
<?php include('db_connect.php');
$result = $conn->query("SELECT sm.*,concat(e.first_name,' ',e.last_name) as ename,ec.acc_no,d.dept_name from salary_main sm INNER JOIN employee e on sm.emp_id=e.emp_id LEFT JOIN emp_acc ec on e.emp_id=ec.emp_id INNER JOIN department d on e.dept_id=d.dept_id;");


// $date_from=$_POST["date_from"];
?>
<div class="container-fluid ">
	<div class="col-lg-12">

		<br />
		<br />
		<div class="card">
			<div class="card-header">
				<span><b>Payroll List</b></span>
				<!-- <button class="btn btn-primary btn-sm btn-block col-md-3 float-right" type="button" id="filter"><span class="fa fa-plus"></span> Select Month</button> -->
			</div>
			<div class="card-body">
				<table id="table" class="table table-bordered table-striped">
					<thead>
						<tr>

							<th>emp_id</th>
							<th>Month</th>
							<th>Employee</th>
							<th>Department</th>
							<th>Fix <br />Pay</th>
							<th>Total<br /> Allowance</th>
							<th>Total <br />Deduction</th>
							<th>Net Pay</th>
							<th>Action</th>

						</tr>
					</thead>
					<tbody>
						<?php
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
								if ($repo_col_name['COLUMN_NAME'] == "ptax" || $repo_col_name['COLUMN_NAME'] == "epf"){
									$tot_dedu += $data[$repo_col_name['COLUMN_NAME']];
								}
							}
							$net_pay = ($data['fix_pay'] + $tot_alw) - $tot_dedu;
						?>
							<tr>
								<td><?php echo $data['emp_id'] ?></td>
								<!-- <td><?php //echo $data['tech_non_tech']
											?></td> -->
								<td><?php echo date("Y-M", strtotime($data['date'])) ?></td>
								<td><?php echo $data['ename'] ?></td>
								<td><?php echo $data['dept_name'] ?></td>
								<td><?php echo $data['fix_pay'] ?></td>
								<td><?php echo $tot_alw ?></td>
								<td><?php echo $tot_dedu ?></td>
								<td><?php echo $net_pay ?></td>
								<td><button class="btn btn-sm btn-outline-primary print_btn" data-id="<?php echo $data['emp_id']?>" data-date="<?php echo $data['date'] ?>" type="button"><i class="fa fa-print"></i></button></td>
							</tr>
						<?php
						}
						?>
			</div>
			<!-- <input type="text" value="$date"> -->

			</tbody>
			</table>
		</div>
	</div>
</div>
</div>



<script type="text/javascript">
	$(document).ready(function() {
		$('#table').DataTable();
		// $('#table2').DataTable({
		// 	dom: 'Bfrtip',
		// 	buttons: [
		// 		'csv', {
		// 			extend: 'pdfHtml5',
		// 			orientation: 'landscape',
		// 			title: 'NCSC Payroll Report',
		// 			pageSize: 'LEGAL'
		// 		}
		// 	]
		// });
		$('#table').on("click",".print_btn",function(){
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

	});
</script>
<!-- <script type="text/javascript">
	$(document).ready(function() {
		// $.datepicker.setDefaults({
		// 	dateFormat:'yy-mm-dd'
		// });
		// $(function(){
		// 	$("#date_from").datepicker();

		// });
		$('#filter').click(function() {
			var date_from = $('#date_from').val();
			if (date_from != '') {
				$.ajax({
					url: "manage_payroll.php",
					method: "POST",
					data: {
						date_from: date_from
					},
					success: function(data) {
						$('#order_table').html(data);
					}
				});
			}
		});


	})
</script> -->
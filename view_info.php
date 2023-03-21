<?php include 'db_connect.php' ?>

<?php
$emp = $conn->query("SELECT e.*,d.dept_name as dname,p.pos_name as pname FROM employee e inner join department d on e.dept_id = d.dept_id inner join position p on e.pos_id = p.pos_id where e.emp_id =" . $_GET['emp_id'])->fetch_array();
foreach ($emp as $k => $v) {
	$$k = $v;
}
?>

<div class="contriner-fluid">
	<div class="col-md-12">
		<h5><b><small>Employee ID :</small><?php echo $emp_id ?></b></h5>
		<h4><b><small>Name: </small><?php echo ucwords($last_name . "  " . $first_name) ?></b></h4>
		<p><b>Department : <?php echo ucwords($dname) ?></b></p>
		<p><b>Position : <?php echo ucwords($pname) ?></b></p>
		<?php if($emp_type=1){
				echo "Employee Type : Parmanent";
		} else if($emp_type=2){
			echo "Employee Type : Visitng";
		}else if($emp_type=3){
			echo "Employee Type : Contractual";
		}else{
			echo "Employee Type : Teaching Asst";
		}
		?>
		<hr class="divider">
		<div class="row">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<span><b>Account Details</b></span>
						<button class="btn btn-primary btn-sm float-right" style="padding: 3px 5px" type="button" id="new_info"><i class="fa fa-plus"></i></button>
					</div>
					<div class="card-body">
						<ul class="list-group">
							<?php
							$acc = $conn->query("SELECT * FROM emp_acc where emp_id=". $_GET['emp_id'] );
							while ($row = $acc->fetch_assoc()) :
							?>
								<li class="list-group-item d-flex justify-content-between align-items-center alist" data-id="<?php echo $row['emp_id'] ?>">
									<span>
										<p><small>Account Number:<?php echo $row['acc_no'] ?></small></p>
										<p><small>Type: <?php echo $row['acc_name'] ?></small></p>
										<p><small>IFSC code: <?php echo $row['acc_ifsc'] ?></small></p>
									</span>
									<button class="badge badge-danger badge-pill btn remove_allowance" type="button" data-id="<?php echo $row['acc_tb_id'] ?>"><i class="fa fa-trash"></i></button>
								</li>
							<?php endwhile; ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<span><b>Nominee Details</b></span>
						<button class="btn btn-primary btn-sm float-right" style="padding: 3px 5px" type="button" id="new_nominee"><i class="fa fa-plus"></i></button>
					</div>
					<div class="card-body">
						<ul class="list-group">
							<?php
							$nominee = $conn->query("SELECT * FROM emp_nominee where emp_id=". $_GET['emp_id'] );
							while ($row = $nominee->fetch_assoc()) :
							?>
								<li class="list-group-item d-flex justify-content-between align-items-center dlist" data-id="<?php echo $row['emp_id'] ?>">
									<span>
										<p><small>Nominee:<?php echo $row['nominee'] ?></small></p>
										<p><small>Relation: <?php echo $row['relation'] ?></small></p>
									</span>
									<button class="badge badge-danger badge-pill btn remove_deduction" type="button" data-id="<?php echo $row['nominee_id'] ?>"><i class="fa fa-trash"></i></button>
								</li>
							<?php endwhile; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<style type="text/css">
	.list-group-item>span>p {
		margin: unset;
	}

	.list-group-item>span>p>small {
		font-weight: 700
	}
</style>
<script>
	$('#new_info').click(function() {
		uni_modal("New Employee Account Details for <?php echo $emp_id . ' - ' . ucwords($last_name . ", " . $first_name) ?>", 'manage_employee_acc.php?emp_id=<?php echo $_GET['emp_id'] ?>', 'mid-large')
	})
	$('#new_nominee').click(function() {
		uni_modal("New Employee Nominee Details for <?php echo $emp_id . ' - ' . ucwords($last_name . ", " . $first_name) ?>", 'manage_employee_nominee.php?emp_id=<?php echo $_GET['emp_id'] ?>', 'mid-large')
	})
	$('.remove_allowance').click(function() {
		_conf("Are you sure to delete this Employee Info?", "remove_allowance", [$(this).attr('data-id')])
	})
	


	function remove_allowance(acc_tb_id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_employee_info',
			method: "POST",
			data: {
				acc_tb_id: acc_tb_id
			},
			error: err => console.log(err),
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Selected Account detail successfully deleted", "success");
					$('.alist[data-id="' + acc_tb_id + '"]').remove()
					$('#confirm_modal').modal('hide')
					end_load()
				}
			}
		})
	}

	$('.remove_deduction').click(function() {
		_conf("Are you sure to delete this deduction?", "remove_deduction", [$(this).attr('data-id')])
	})
	function remove_deduction(emp_dedu_id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_employee_deduction',
			method: "POST",
			data: {
				emp_dedu_id: emp_dedu_id
			},
			error: err => console.log(err),
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Selected deduction successfully deleted", "success");
					$('.dlist[data-id="'+emp_dedu_id+'"]').remove()
					$('#confirm_modal').modal('hide')
					end_load()
				}
			}
		})
	}
</script>
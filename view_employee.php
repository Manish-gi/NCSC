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
						<span><b>Allowances</b></span>
						<button class="btn btn-primary btn-sm float-right" style="padding: 3px 5px" type="button" id="new_allowance"><i class="fa fa-plus"></i></button>
					</div>
					<div class="card-body">
						<ul class="list-group">
							<?php
							$allowances = $conn->query("SELECT ea.*,a.aloow_name as aname FROM emp_allow ea inner join allowance a on a.allow_id = ea.allow_id where ea.emp_id=" . $_GET['emp_id'] . " order by ea.type asc,date(ea.effective_date) asc, a.aloow_name asc;");
							$t_arr = array(1 => "Monthly", 2 => "Once");
							while ($row = $allowances->fetch_assoc()) :
							?>
								<li class="list-group-item d-flex justify-content-between align-items-center alist" data-id="<?php echo $row['emp_allow_id'] ?>">
									<span>
										<p><small><?php echo $row['aname'] ?> Allowance</small></p>
										<p><small>Type: <?php echo $t_arr[$row['type']] ?></small></p>
										<?php if ($row['type'] == 2) : ?>
											<p><small>Effective: <?php echo date("M d,Y", strtotime($row['effective_date'])) ?></small></p>
										<?php endif; ?>
									</span>
									<button class="badge badge-danger badge-pill btn remove_allowance" type="button" data-id="<?php echo $row['emp_allow_id'] ?>"><i class="fa fa-trash"></i></button>
								</li>
							<?php endwhile; ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<span><b>Deductions</b></span>
						<button class="btn btn-primary btn-sm float-right" style="padding: 3px 5px" type="button" id="new_deduction"><i class="fa fa-plus"></i></button>
					</div>
					<div class="card-body">
						<ul class="list-group">
							<?php
							$deductions = $conn->query("SELECT ea.*,d.dedu_name as dname FROM emp_dedu ea inner join deduction d on d.dedu_id = ea.dedu_id where ea.emp_id=" . $_GET['emp_id'] . " order by ea.type asc,date(ea.effective_date) asc, d.dedu_name asc;");
							$t_arr = array(1 => "Monthly", 2 => "Once");
							while ($row = $deductions->fetch_assoc()) :
							?>
								<li class="list-group-item d-flex justify-content-between align-items-center dlist" data-id="<?php echo $row['emp_dedu_id'] ?>">
									<span>
										<p><small><?php echo $row['dname'] ?>Deductions</small></p>
										<p><small>Type: <?php echo $t_arr[$row['type']] ?></small></p>
										<?php if ($row['type'] == 2) : ?>
											<p><small>Effective: <?php echo date("M d,Y", strtotime($row['effective_date'])) ?></small></p>
										<?php endif; ?>
									</span>
									<button class="badge badge-danger badge-pill btn remove_deduction" type="button" data-id="<?php echo $row['emp_dedu_id'] ?>"><i class="fa fa-trash"></i></button>
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
	$('#new_allowance').click(function() {
		uni_modal("New Allowance for <?php echo $emp_id . ' - ' . ucwords($last_name . ", " . $first_name) ?>", 'manage_employee_allowances.php?emp_id=<?php echo $_GET['emp_id'] ?>', 'mid-large')
	})
	$('#new_deduction').click(function() {
		uni_modal("New Deduction for <?php echo $emp_id . ' - ' . ucwords($last_name . ", " . $first_name) ?>", 'manage_employee_deductions.php?emp_id=<?php echo $_GET['emp_id'] ?>', 'mid-large')
	})
	$('.remove_allowance').click(function() {
		_conf("Are you sure to delete this allowance?", "remove_allowance", [$(this).attr('data-id')])
	})
	


	function remove_allowance(emp_allow_id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_employee_allowance',
			method: "POST",
			data: {
				emp_allow_id: emp_allow_id
			},
			error: err => console.log(err),
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Selected allowance successfully deleted", "success");
					$('.alist[data-id="' + emp_allow_id + '"]').remove()
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
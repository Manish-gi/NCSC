<?php include('db_connect.php'); 
$opt=$_SESSION["login_emp_id"];?>
<div class="container-fluid ">
	<div class="col-lg-12">
		<br />
		<br />
		<div class="card">
			<div class="card-header">
				<span><b>Employee List</b></span>
				<button class="btn btn-primary btn-sm btn-block col-md-3 float-right" type="button" id="new_emp_btn"><span class="fa fa-plus"></span> Add Employee</button>
			</div>
			<div class="card-body">
				<table id="table" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Employee No</th>
							<th>Firstname</th>
							<th>Lastname</th>
							<th>E-mail</th>
							<th>Employee Type</th>
							<th>Department</th>
							<th>Designation</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$d_arr[0] = "Unset";
						$p_arr[0] = "Unset";
						$dept = $conn->query("SELECT * from department order by dept_name asc");
						while ($row = $dept->fetch_assoc()) :
							$d_arr[$row['dept_id']] = $row['dept_name'];
						endwhile;
						$pos = $conn->query("SELECT * from position order by  pos_name asc");
						while ($row = $pos->fetch_assoc()) :
							$p_arr[$row['pos_id']] = $row['pos_name'];
						endwhile;
						$employee_qry = $conn->query("SELECT * FROM employee") or die(mysqli_error($conn, $sql));
						while ($row = $employee_qry->fetch_array()) {
						?>
							<tr>
								<td><?php echo $row['emp_id'] ?></td>
								<td><?php echo $row['first_name'] ?></td>
								<td><?php echo $row['last_name'] ?></td>
								<td><?php echo $row['email'] ?></td>
								<td><?php
									switch ($row['emp_type']) {
										case 1:
											echo "Parmanent";
											break;
										case 2:
											echo "Visiting";
											break;
										case 3:
											echo "Contractual";
											break;
										case 4:
											echo "Teaching_Asst";
											break;
									}
									?>
								</td>
								<td><?php echo $d_arr[$row['dept_id']] ?></td>
								<td><?php echo $p_arr[$row['pos_id']] ?></td>
								<td>
									<center>
										<?php
										$res = $conn->query("SELECT * FROM employee where emp_id=" . $opt);
										while ($access = $res->fetch_array()) {
										?>
											<button class="btn btn-sm btn-outline-primary view_employee" data-id="<?php echo $row['emp_id'] ?>" type="button"><i class="fa fa-eye"></i></button>
											<?php
											if ($access['access'] == 1) { ?>
												<button class="btn btn-sm btn-outline-primary edit_employee" data-id="<?php echo $row['emp_id'] ?>" type="button"><i class="fa fa-edit"></i></button>
												<!-- <button class="btn btn-sm btn-outline-danger remove_employee" data-id="<?php //echo $row['emp_id'] 
																															?>" type="button"><i class="fa fa-trash"></i></button> -->
										<?php
											}
										} ?>
									</center>
								</td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>



<script type="text/javascript">
	$(document).ready(function() {
		$('#table').DataTable();

		$("#table tbody").on("click", ".edit_employee", function() {
			var $emp_id = $(this).attr('data-id');
			uni_modal("Edit Employee", "manage_employee.php?emp_id=" + $emp_id)
		});

		// $('.edit_employee').click(function() {
		// 	var $emp_id = $(this).attr('data-id');
		// 	uni_modal("Edit Employee", "manage_employee.php?emp_id=" + $emp_id)

		// });

		$("#table tbody").on("click", ".view_employee", function() {
			var $emp_id = $(this).attr('data-id');
			uni_modal("Employee Details", "view_employee.php?emp_id=" + $emp_id, "mid-large")

		});

		$('#new_emp_btn').click(function() {
			uni_modal("New Employee", "manage_employee.php")
		});
		$("#table tbody").on("click", ".remove_employee", function() {
			_conf("Are you sure to delete this employee?", "remove_employee", [$(this).attr('data-id')])
		});
	});

	function remove_employee(emp_id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_employee',
			method: "POST",
			data: {
				emp_id: emp_id
			},
			error: err => console.log(err),
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Employee's data successfully deleted", "success");
					setTimeout(function() {
						location.reload();

					}, 1000)
				}
			}
		})
	}
</script>
<?php include 'db_connect.php' ?>
<div class="container-fluid">
	<form id="report">
		<div class="col-lg-12 card-header">
			<center>
				<h2>REPORT</h2>
			</center>
			<hr>
			<div class="form-group">
				<label>Employee</label>
				<select class="custom-select browser-default" id="emp_id">
					<!--  onchange="sel_dept()" -->
					<option value="0">All</option>
					<?php
					$emp = $conn->query("SELECT emp_id,concat(last_name,', ',first_name) AS ename from  employee ");
					while ($row = $emp->fetch_assoc()) :
					?>
						<option value="<?php echo $row['emp_id'] ?>"><?php echo $row['ename'] ?></option>

					<?php
					endwhile; ?>
				</select>
			</div>

			<div class="form-group">
				<label>Department</label>
				<select class="custom-select browser-default" id="dept_id">
					<!--  onchange="sel_dept()" -->
					<option value="all">All</option>
					<?php
					$dept = $conn->query("SELECT * from department order by dept_name asc");
					while ($row = $dept->fetch_assoc()) :
					?>
						<option value="<?php echo $row['dept_name'] ?>"><?php echo $row['dept_name'] ?></option>

					<?php
					endwhile; ?>
				</select>
			</div>

			<div class="form-group">
				<label>Position</label>
				<select class="custom-select browser-default select2" id="pos_id" name="pos_id">
					<option value="all">All</option>
					<?php
					$pos = $conn->query("SELECT * from position order by pos_name asc");
					while ($row = $pos->fetch_assoc()) :
					?>
						<option value="<?php echo $row['pos_name'] ?>"><?php echo $row['pos_name'] ?></option>

					<?php
					endwhile; ?>
				</select>
			</div>

			<div class="form-group">
				<label>Employee Type</label>
				<select class="custom-select browser-default select2" id="emp_typ" name="emp_typ">
				<option value="all">All</option>
					<option value="1">Permanent</option>
					<option value="2">Visiting</option>
					<option value="3">Contractual</option>
					<option value="4">Teaching Assistant</option>

				</select>
			</div>

			<div class="form-group">
				<label>Teaching/Non-Teaching:</label>
				<select id="typ_tech" name="typ_tech"class="custom-select browser-default select2">
				<option value="all">All</option>
					<option value="teaching">Teaching</option>
					<option value="non_teaching">Non-Teaching</option>
				</select>
			</div>
			<div class="form-group">
				<label>From</label>
				<input type="date" id="from" class="form-control " autocomplete="off" step="any" />
				<!--required="required"-->
			</div>
			<div class="form-group">
				<label>To</label>
				<input type="date" id="to" class="form-control" autocomplete="off" step="any" />
			</div>
			<br>
		</div>
	</form>
</div>

<script>
	// $(document).ready(function() {
	// 	uni_modal("New Time Record/s", "manage_report.php", 'mid-large')
	// });
	$(document).ready(function() {

		$("#report").submit(function(e) {
			e.preventDefault()
			start_load();
			var dept_id = $('#dept_id').val();
			var pos_id = $('#pos_id').val();
			var typ_tech = $('#typ_tech').val();
			var emp_typ = $('#emp_typ').val();
			var from = $('#from').val();
			var to = $('#to').val();
			var emp_id=$('#emp_id').val();
			$.ajax({
				url: 'ajax.php?action=gene_report',
				method: "POST",
				// data:$(this).serialize(),
				data: {
					dept_id: dept_id,
					pos_id: pos_id,
					typ_tech: typ_tech,
					emp_typ: emp_typ,
					from: from,
					to: to,
					emp_id:emp_id

				},
				error: err => console.log(err),
				success:function(resp){
					if (resp == 1) {
						alert_toast("Report data successfull", "success");
						setTimeout(function() {
							location.reload();

						}, 1000)
					}
				}
				
			})
		})
	})
</script>
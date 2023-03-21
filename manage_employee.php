<?php
include 'db_connect.php';
if (isset($_GET['emp_id'])) {
	$qry = $conn->query("SELECT * FROM employee where emp_id = " . $_GET['emp_id'])->fetch_array();
	foreach ($qry as $k => $v) {
		$$k = $v;
	}
}
?>

<div class="container-fluid">

	<form id='employee_frm'>

		<div class="form-group">
			<label>Department</label>
			<select class="custom-select browser-default select2" name="dept_id">
				<?php
				$dept = $conn->query("SELECT * from department order by dept_name asc");
				while ($row = $dept->fetch_assoc()) :
				?>
					<option value="<?php echo $row['dept_id'] ?>" <?php echo isset($dept_id) && $dept_id == $row['dept_id'] ? "selected" : '' ?>><?php echo $row['dept_name'] ?></option>

				<?php
				endwhile; ?>
			</select>
		</div>

		<div class="form-group">
			<label>Employee Type:</label>
			<select class="custom-select browser-default select2" id="emp_typ" name="emp_type">
				<option value=""></option>
				<option value="1" <?php echo isset($emp_type) && $emp_type == 1 ? 'selected' : '' ?>>Parmanent</option>
				<option value="2" <?php echo isset($emp_type) && $emp_type == 2 ? 'selected' : '' ?>>Visiting</option>
				<option value="3" <?php echo isset($emp_type) && $emp_type == 3 ? 'selected' : '' ?>>Contractual</option>
				<option value="4" <?php echo isset($emp_type) && $emp_type == 4 ? 'selected' : '' ?>>Teaching_asst</option>
			</select>
		</div>

		<div class="form-group">
			<label>Teaching/Non-Teaching</label>
			<select class="custom-select browser-default select2" name="tech_non_tech">
				<option value="teaching" <?php echo isset($tech_non_tech) && $tech_non_tech == 'teaching' ? "selected" : "" ?>>Teaching</option>
				<option value="non_teaching" <?php echo isset($tech_non_tech) && $tech_non_tech == 'non_teaching' ? "selected" : "" ?>>Non-Teaching</option>
			</select>
		</div>

		<div class="form-group">
			<label>Position</label>
			<select class="custom-select browser-default select2" name="pos_id">
				<option value=""></option>
				<?php
				$pos = $conn->query("SELECT * from position order by pos_name asc");
				while ($row = $pos->fetch_assoc()) :
				?>
					<option value="<?php echo $row['pos_id'] ?>" <?php echo isset($pos_id) && $pos_id == $row['pos_id'] ? "selected" : "" ?>><?php echo $row['pos_name'] ?></option>
				<?php endwhile; ?>
			</select>
		</div>

		<div class="form-group">
			<label>Username</label>
			<input type="hidden" name="emp_id" value="<?php echo isset($emp_id) ? $emp_id : "" ?>" />
			<input type="text" name="emp_un" required="required" class="form-control" value="<?php echo isset($emp_un) ? $emp_un : "" ?>" />
		</div>

		<div class="form-group">
			<label>Password</label>
			<input type="password" name="emp_pw" required="required" class="form-control" value="<?php echo isset($emp_pw) ? $emp_pw : "" ?>" />
		</div>

		<div class="form-group">
			<label>Firstname</label>
			<input type="text" name="first_name" required="required" class="form-control" value="<?php echo isset($first_name) ? $first_name : "" ?>" />
		</div>

		<div class="form-group">
			<label>Lastname:</label>
			<input type="text" name="last_name" required="required" class="form-control" value="<?php echo isset($last_name) ? $last_name : "" ?>" />
		</div>
		<div class="form-group" style="display: none" id="pay_min_field">
			<label>Pay Minimum</label>
			<input type="text" name="pay_min" placeholder="(optional)" class="form-control" value="<?php echo isset($pay_min) ? $pay_min : "" ?>" />
		</div>

		<div class="form-group" style="display: none" id="pay_max_field">
			<label>Pay Maximum</label>
			<input type="text" name="pay_max" placeholder="(optional)" class="form-control" value="<?php echo isset($pay_max) ? $pay_max : "" ?>" />
		</div>
		<div class="form-group">
			<label>Fix-Pay</label>
			<input type="number" name="fix_pay" required="required" class="form-control text-right" step="any" value="<?php echo isset($fix_pay) ? $fix_pay : "" ?>" />
		</div>

		<div class="form-group" style="display: none" id="gpay_field">
			<label>Grade-Pay</label>
			<input type="number" name="grade_pay" required="required" class="form-control text-right" step="any" value="<?php echo isset($grade_pay) ? $grade_pay : "" ?>" />
		</div>

		<div class="form-group">
			<label>E-mail</label>
			<input type="text" name="email" required="required" class="form-control text-right" step="any" value="<?php echo isset($email) ? $email : "" ?>" />
		</div>

		<div class="form-group">
			<label>Mobile No:</label>
			<input type="text" name="mobile" required="required" class="form-control" value="<?php echo isset($mobile) ? $mobile : "" ?>" />
		</div>

		<div class="form-group">
			<label>Date of Joining</label>
			<input type="date" name="d_o_j" required="required" class="form-control datepicker" autocomplete="off" value="<?php echo isset($d_o_j) ? $d_o_j : ""  ?>">
		</div>

		<div class="form-group">
			<label>Date of Resign</label>
			<input type="date" name="d_o_r" required="required" class="form-control datepicker" autocomplete="off" step="any" value="<?php echo isset($d_o_r) ? $d_o_r : "" ?>">
		</div>

		<div class="form-group">
			<label>Address:</label>
			<input type="text" name="address" required="required" class="form-control" value="<?php echo isset($address) ? $address : "" ?>" />
		</div>

		<div><label>Gender:</label>
			<select class="custom-select browser-default select2" name="gender">
				<option value="Male" <?php echo isset($gender) && $gender == 'Male' ? "selected" : "" ?>>Male</option>
				<option value="Female" <?php echo isset($gender) && $gender == 'Female' ? "selected" : "" ?>>Female</option>
				<option value="Others" <?php echo isset($gender) && $gender == 'Others' ? "selected" : "" ?>>Others</option>
			</select>
		</div>

		<div class="form-group">
			<label>Marital Status</label>
			<select class="custom-select browser-default select2" name="m_s">
				<option value="Married" <?php echo isset($m_s) && $m_s == 'Married' ? "selected" : "" ?>>Married</option>
				<option value="Single" <?php echo isset($m_s) && $m_s == 'Single' ? "selected" : "" ?>>Single</option>
			</select>
		</div>

		<div class="form-group">
			<label>Date of Birth</label>
			<input type="date" name="d_o_b" required="required" class="form-control datepicker" autocomplete="off" step="any" value="<?php echo isset($d_o_b) ? $d_o_b : "" ?>">
		</div>

		<div><label>Access:</label>
			<select class="custom-select browser-default " name="access">
				<option value="1" <?php echo isset($access) && $access == 1 ? "selected" : "" ?>>Admin</option>
				<option value="2" <?php echo isset($access) && $access == 2 ? "selected" : "" ?>>clerck</option>
				<option value="3" <?php echo isset($access) && $access == 3 ? "selected" : "" ?>>Employee</option>
			</select>
		</div>

	</form>
</div>
<script>
	// $('[name="department_id"]').change(function() {
	// 	var did = $(this).val()
	// 	$('[name="position_id"] .opt').each(function() {
	// 		if ($(this).attr('data-did') == did) {
	// 			$(this).attr('disabled', false)
	// 		} else {
	// 			$(this).attr('disabled', true)
	// 		}
	// 	})
	// })
	$('#emp_typ').change(function() {
		if ($(this).val() == 1) {
			$('#pay_min_field').show()
			$('#pay_max_field').show()
			$('#gpay_field').show()
		} else {
			$('#pay_min_field').hide()
			$('#pay_max_field').hide()
			$('#gpay_field').hide()
		}
	})
	// $('#emp_typ').select(function(){
	//  $.ajax({
	// 	 url:'ajax.php?action=emp_typ_vali'
	//  })
	// });
	$(document).ready(function() {
		$('.select2').select2({
			placeholder: "Please Select Here",
			width: "100%"
		})
		$('#employee_frm').submit(function(e) {
			e.preventDefault()
			start_load();
				$.ajax({
					url: 'ajax.php?action=save_employee',
					method: "POST",
					data: $(this).serialize(),
					error: err => console.log(),
					success: function(resp) {
						if (resp == 1) {
							alert_toast("Employee's data successfully saved", "success");
							setTimeout(function() {
								location.reload();

							}, 1000)
						}
					}
				})
		})
	})
</script>
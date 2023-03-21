<?php include 'db_connect.php' ?>

<?php ?>

<div class="container-fluid">
	<div class="col-lg-12">
	<form action="" id="employee-attendance">
		<div class="row form-group">
			<div class="col-md-4">
				<label for="" class="control-label">Employee</label>
				<select id="emp_id" class="borwser-default select2">
					<option value=""></option>
					<?php 
					$employee = $conn->query("SELECT *,concat(last_name,', ',first_name) as ename FROM employee WHERE d_o_r >='". date("Y-m-d") ."'|| d_o_r =''order by concat(last_name,', ',first_name) asc");
					while($row = $employee->fetch_assoc()):
					?>
						<option value="<?php echo $row['emp_id'] ?>"><?php echo $row['ename'] . ' | '. $row['emp_id'] ?></option>
					<?php endwhile; ?>
				</select>
			</div>
			<div class="col-md-3">
				<label for="" class="control-label">Date</label>
				<input type="date" id="adate" class="form-control" autocomplete="off">
			</div>
			<div>
			<label for="" class="control-label">Attendance</label>
				<input type="number" id="attend" class="form-control" required="required">
			</div>
			<div class="col-md-2">
				<label for="" class="control-label">&nbsp</label>
				<button class="btn btn-primary btn-block btn-sm" type="button" id="add_list"> Add to List</button>
			</div>	
		</div>		
		<hr>
		<div class="row">
			<table class="table table-bordered" id="attendance-list">
				<thead>
					<tr>
						<th class="text-center">
							Employee
						</th>
						<th class="text-center">
							Attendance
						</th>
						<th class="text-center">
							Date
						</th>
						<th class="text-center">
							
						</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</form>
	</div>
</div>
<div id="tr_clone" style="display: none">
	<table>
		<tr>
			<td>
				<input type="hidden" name="emp_id[]">
				<p class="emp_id"></p>
			</td>
			<td>
				<input type="hidden" name="attend[]">
				<p class="attend"></p>
			</td>
			
			<td>
				<input type="hidden" name="adate[]">
				<p class="adate"></p>
			</td>
			<td class="text-center">
				<button class="btn-sm btn-danger" type="button" onclick="$(this).closest('tr').remove()"><i class="fa fa-trash"></i></button>
			</td>
		</tr>
	</table>
</div>

<script>

	$('.select2').select2({
		placeholder:"Select here",
		width:"100%"
	})
	$('.datetimepicker').datetimepicker({
		format:"y-m-d H:i "
	})
	
	$('#add_list').click(function(){
		var emp_id = $('#emp_id').val(),
			attend = $('#attend').val(),
			adate = $('#adate').val();
			console
		var tr = $('#tr_clone tr').clone()
		tr.find('[name="emp_id[]"]').val(emp_id)
		tr.find('[name="attend[]"]').val(attend)
		tr.find('[name="adate[]"]').val(adate)
		tr.find('.emp_id').html($('#emp_id option[value="'+emp_id+'"]').html())
		tr.find('.attend').html(attend)
		tr.find('.adate').html(adate)
		$('#attendance-list tbody').append(tr)
		$('#emp_id').val('').select2({
			placeholder:"Select here",
			width:"100%"
		})
		$('#attend').val('')
		$('#adate').val('')

	})
	$(document).ready(function(){
		$('#employee-attendance').submit(function(e){
				e.preventDefault()
				start_load();
			$.ajax({
				url:'ajax.php?action=save_employee_attendance',
				method:"POST",
				data:$(this).serialize(),
				error:err=>console.log(),
				success:function(resp){
						if(resp == 1){
							alert_toast("Attendance data successfully saved","success");
							setTimeout(function(){
								location.reload()
							},1000)
						}
				}
			})
		})
	})
</script>
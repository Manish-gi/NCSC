<?php include 'db_connect.php' ?>

<?php ?>

<div class="container-fluid">
	<form action="" id="employee-allowance">
		<input type="hidden" name="emp_id" value="<?php echo $_GET['emp_id'] ?>">
		<div class="row form-group">
			<div class="col-md-5">
				<label for="" class="control-label">Allowance</label>
				<select id="allow_id" class="borwser-default select2">
					<option value=""></option>
					<?php 
					$allowance = $conn->query("SELECT * FROM allowance order by aloow_name asc");
					while($row = $allowance->fetch_assoc()):
					?>
						<option value="<?php echo $row['allow_id'] ?>"><?php echo $row['aloow_name'] ?></option>
					<?php endwhile; ?>
				</select>
			</div>
			<div class="col-md-3">
				<label for="" class="control-label">Type</label>
				<select id="type" class="borwser-default custom-select">
					<option value="1">Monthly</option>
					<option value="2">Once</option>
				</select>
			</div>
			<div class="col-md-3" style="display: none" id="dfield">
				<label for="" class="control-label">Effective Date</label>
				<input type="date" id="edate" class="form-control">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-5">
				<label for="" class="control-label">Amount</label>
				<input type="number" id="amount" class="form-control text-right" step="any" >
			</div>	
			<div class="col-md-2 offset-md-2">
				<label for="" class="control-label">&nbsp</label>
				<button class="btn btn-primary btn-block btn-sm" type="button" id="add_list"> Add to List</button>
			</div>	
		</div>
		<hr>
		<div class="row">
			<table class="table table-bordered" id="allowance-list">
				<thead>
					<tr>
						<th class="text-center">
							Allowance
						</th>
						<th class="text-center">
							Type
						</th>
						<th class="text-center">
							Amount
						</th>
						<th class="text-center">
							Date
						</th>
						<th class="text-center">
							
						</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</form>
</div>
<div id="tr_clone" style="display:none">
	<table>
		<tr>
			<td>
				<input type="hidden" name="allow_id[]">
				<p class="allow_id"></p>
			</td>
			<td>
				<input type="hidden" name="type[]">
				<p class="type"></p>
			</td>
			<td>
				<input type="hidden" name="amount[]">
				<p class="amount"></p>
			</td>
			<td>
				<input type="hidden" name="effective_date[]">
				<p class="edate"></p>
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
	$('#type').change(function(){
		if($(this).val() == 2){
			$('#dfield').show()
		}else{
			$('#dfield').hide()
		}
	})
	$('#add_list').click(function(){
		var allow_id = $('#allow_id').val(),
			type = $('#type').val(),
			amount = $('#amount').val(),
			edate = $('#edate').val();
			console
		var tr = $('#tr_clone tr').clone()
		tr.find('[name="allow_id[]"]').val(allow_id)
		tr.find('[name="type[]"]').val(type)
		tr.find('[name="effective_date[]"]').val(edate)
		tr.find('[name="amount[]"]').val(amount)
		tr.find('.allow_id').html($('#allow_id option[value="'+allow_id+'"]').html())
		tr.find('.type').html($('#type option[value="'+type+'"]').html())
		tr.find('.amount').html(amount)
		tr.find('.edate').html(edate)
		$('#allowance-list tbody').append(tr)
		$('#allow_id').val('').select2({
			placeholder:"Select here",
			width:"100%"
		})
		$('#type').val('')
		$('#amount').val('')
		$('#edate').val('')

	})
	$(document).ready(function(){
		$('#employee-allowance').submit(function(e){
				e.preventDefault()
				start_load();
			$.ajax({
				url:'ajax.php?action=save_employee_allowance',
				method:"POST",
				data:$(this).serialize(),
				error:err=>console.log(),
				success:function(resp){
						if(resp == 1){
							alert_toast("Employee's data successfully saved","success");
							end_load()
							uni_modal("Employee Details",'view_employee.php?emp_id=<?php echo $_GET['emp_id'] ?>','mid-large')
						}
				}
			})
		})
	})
</script>
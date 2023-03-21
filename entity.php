<?php include('db_connect.php'); ?>

<div class="container-fluid">

	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
				<form action="" id="manage-entity">
					<div class="card">
						<div class="card-header">
							Entity Form
						</div>
						<div class="card-body">
							<input type="hidden" name="ent_id">
							<div class="form-group">
								<label class="control-label">Entity</label>
								<textarea name="ent_name" id="" cols="30" rows="2" class="form-control" required></textarea>
							</div>
							<div class="form-group">
								<label class="control-label">Description</label>
								<textarea name="ent_desc" id="" cols="30" rows="2" class="form-control" required></textarea>
							</div>
							<div class="form-group">
								<label class="control-label">Value</label>
								<input type="text" name="ent_value" id="" cols="30" rows="2" class="form-control" required>
							</div>

						</div>

						<div class="card-footer">
							<div class="row">
								<div class="col-md-12">
									<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
									<button class="btn btn-sm btn-default col-sm-3" type="button" onclick="_reset()"> Cancel</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Entity Information</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								$entity = $conn->query("SELECT * FROM entity order by ent_id asc");
								while ($row = $entity->fetch_assoc()) :
								?>
									<tr>
										<td class="text-center"><?php echo $i++ ?></td>

										<td class="">
											<p>Name: <b><?php echo $row['ent_name'] ?></b></p>
											<p class="truncate"><small>Description: <b><?php echo $row['ent_desc'] ?></b></small></p>
											<p> Value: <b><?php echo $row['ent_value'] ?></b></p>
										</td>
										<td class="text-center">
											<button class="btn btn-sm btn-primary edit_entity" type="button" data-id="<?php echo $row['ent_id'] ?>" data-entity="<?php echo $row['ent_name'] ?>" data-description="<?php echo $row['ent_desc'] ?>" data-value="<?php echo $row['ent_value'] ?>">Edit</button>
											<!-- <button class="btn btn-sm btn-danger delete_entity" type="button" data-id="<?php echo $row['ent_id'] ?>">Delete</button> -->
										</td>
									</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
						<div>
							<?php
							$date;
							$inc = $conn->query("SELECT * from inc ");
							while ($inc_date = $inc->fetch_array()) {
								$date = $inc_date['inc_date'];
							}
							?>
							<p>Date:<b><?php echo "$date" ?></b></p>
							<button class="btn btn-sm btn-primary" id="inc" type="button">Increment</button>
						</div>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>

</div>
<style>
	td {
		vertical-align: middle !important;
	}

	td p {
		margin: unset
	}

	img {
		max-width: 100px;
		max-height: 150px;
	}
</style>
<script>
	function _reset() {
		$('[name="id"]').val('');
		$('#manage-entity').get(0).reset();
	}

	$('#manage-entity').submit(function(e) {
		e.preventDefault()
		start_load()
		$.ajax({
			url: 'ajax.php?action=save_entity',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data successfully added", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				} else if (resp == 2) {
					alert_toast("Data successfully updated", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	})
	// $('#inc').click(function() {
	// 	<?php
	// 	$ent_value = 0;
	// 	$ent = $conn->query("SELECT * from entity where ent_name=inc");
	// 	while ($ent_hn = $ent->fetch_array()) {
	// 		$ent_value = $ent_hn['ent_value'];
	// 	}
	// 	$row = $conn->query("SELECT * FROM employee WHERE emp_type= 1 and (d_o_r >='" . date("Y-m-d") . "'|| d_o_r ='')");
	// 	while ($emp_details = $row->fetch_array()) {
	// 		$fix_pay = $emp_details['fix_pay'];
	// 		$fix_pay = $fix_pay + (($ent_value / 100) * $fix_pay);
	// 		$conn->query("UPDATE employee SET fix_pay ='" . $fix_pay . "' WHERE emp_id =" . $emp_details['emp_id']);
	// 	}
	// 	$conn->query("INSERT INTO inc(inc_date,value) VALUES ('" . date("Y-m-d") . "','" . $ent_value . "')");
	// 	?>
	// 	alert_toast("Data successfully added", 'success')
	// 	setTimeout(function() {
	// 		location.reload()
	// 	}, 1500)

	// })
	$('#inc').click(function() {

		$.ajax({
			url:'ajax.php?action=increment',
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data successfully added", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)
				}
			}
		})
	})
	$('.edit_entity').click(function() {
		start_load()
		var cat = $('#manage-entity')
		cat.get(0).reset()
		cat.find("[name='ent_id']").val($(this).attr('data-id'))
		cat.find("[name='ent_name']").val($(this).attr('data-entity'))
		cat.find("[name='ent_desc']").val($(this).attr('data-description'))
		cat.find("[name='ent_value']").val($(this).attr('data-value'))
		end_load()
	})
	// $('.delete_entity').click(function(){
	// 	_conf("Are you sure to delete this Entity?","delete_entity",[$(this).attr('data-id')])
	// })
	function displayImg(input, _this) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#cimg').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}
	// function delete_entity($ent_id){
	// 	start_load()
	// 	$.ajax({
	// 		url:'ajax.php?action=delete_entity',
	// 		method:'POST',
	// 		data:{ent_id:$ent_id},
	// 		success:function(resp){
	// 			if(resp==1){
	// 				alert_toast("Data successfully deleted",'success')
	// 				setTimeout(function(){
	// 					location.reload()
	// 				},1500)

	// 			}
	// 		}
	// 	})
	// }
</script>
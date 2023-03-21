<?php include('db_connect.php') ?>
		<div class="container-fluid " >
			<div class="col-lg-12">
				
				<br />
				<br />
				<div class="card">
					<div class="card-header">
						<span><b>Attendance List</b></span>
						<button class="btn btn-primary btn-sm btn-block col-md-3 float-right" type="button" id="new_attendance_btn"><span class="fa fa-plus"></span> Add Attendance</button>
					</div>
					<div class="card-body">
						<table id="table" class="table table-bordered table-striped">
							<colgroup>
								<col width="10%">
								<col width="20%">
								<col width="30%">
								<col width="30%">
								<col width="10%">
							</colgroup>
							<thead>
								<tr>
									<th>Date</th>
									<th>Employee No</th>
									<th>Name</th>
									<th>Total days</th>
									<th>Attendended Days</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$att=$conn->query("SELECT s.*,e.emp_un, concat(e.last_name,', ',e.first_name) as ename, EXTRACT( MONTH FROM 's.date') as mounth, EXTRACT( YEAR FROM 's.date') as year FROM salary_main s inner join employee e on s.emp_id = e.emp_id order by s.date asc") or die(mysqli_error($conn));
									// $lt_arr = array(1 => " Time-in AM",2=>"Time-out AM",3 => " Time-in PM",4=>"Time-out PM");
									while($row=$att->fetch_array()){

									// 	$date = date("Y-m-d",strtotime($row['datetime_log']));
									// 	$attendance[$row['employee_id']."_".$date]['details'] = array("eid"=>$row['employee_id'],"name"=>$row['ename'],"eno"=>$row['employee_no'],"date"=>$date);
									// 	if($row['log_type'] == 1 || $row['log_type'] == 3){
									// 		if(!isset($attendance[$row['employee_id']."_".$date]['log'][$row['log_type']]))
									// 		$attendance[$row['employee_id']."_".$date]['log'][$row['log_type']] = array('id'=>$row['id'],"date" =>  $row['datetime_log']);
									// 	}else{
									// 		$attendance[$row['employee_id']."_".$date]['log'][$row['log_type']] =array('id'=>$row['id'],"date" =>  $row['datetime_log']);
									// 	}
									?>
								<tr>
									<td><?php echo date("Y-M",strtotime($row['date']))?> </td>
									<td><?php echo $row['emp_id'] ?></td>
									<td><?php echo $row['ename'] ?></td>
									<td><?php
									$date=strtotime($row['date']);
									echo cal_days_in_month(CAL_GREGORIAN,date("m",$date),date("Y",$date))?></td>
									<td>
										<?php echo $row['attend'];?>
									</td>
									<td>
										<center>
										<button class="btn btn-sm btn-outline-danger remove_attendance" data-id="<?php echo $row['emp_salary_id'] ?>" type="button"><i class="fa fa-trash"></i></button>
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
		<style>
			td p{
				margin: unset;
			}
			.rem_att{
				cursor: pointer;
			}
		</style>
			
		
		
	<script type="text/javascript">
		$(document).ready(function(){
			$('#table').DataTable();
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){

			

			
			$('.edit_attendance').click(function(){
				var $id=$(this).attr('data-id');
				uni_modal("Edit Employee","manage_attendance.php?id="+$id)
				
			});
			$('.view_attendance').click(function(){
				var $id=$(this).attr('data-id');
				uni_modal("Employee Details","view_attendance.php?id="+$id,"mid-large")
				
			});
			$('#new_attendance_btn').click(function(){
				uni_modal("New Time Record/s","manage_attendance.php",'mid-large')
			});
			$('#table tbody').on("click",".remove_attendance", function(){
				var $id=$(this).attr('data-id');
				_conf("Are you sure to delete this employee's time log record?","remove_attendance",[$id])
			});
			// $('.rem_att').click(function(){
			// 	var $id=$(this).attr('data-id');
			// 	// var $date=$(this).attr('data-date');
			// 	_conf("Are you sure to delete this time log?","rem_att",[$id])
			// });
		});
		function remove_attendance(id){
				// console.log(id)
				// return false;
			start_load()
			$.ajax({
				url:'ajax.php?action=delete_employee_attendance',
				method:"POST",
				data:{id:id},
				error:err=>console.log(err),
				success:function(resp){
						if(resp == 1){
							alert_toast("Selected employee's time log data successfully deleted","success");
								setTimeout(function(){
								location.reload();

							},1000)
						}
					}
			})
		}
		// function rem_att(id){
				
		// 	start_load()
		// 	$.ajax({
		// 		url:'ajax.php?action=delete_employee_attendance',
		// 		method:"POST",
		// 		data:{id:id},
		// 		error:err=>console.log(err),
		// 		success:function(resp){
		// 				if(resp == 1){
		// 					alert_toast("Selected employee's attendanse successfully deleted","success");
		// 						setTimeout(function(){
		// 						location.reload();

		// 					},1000)
		// 				}
		// 			}
		// 	})
		// }

	</script>
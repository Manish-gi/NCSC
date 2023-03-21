<?php include 'db_connect.php' ?>

<?php ?>

<div class="container-fluid">
        <form action="" id="employee_nominee">
            <div class="card">
                <div class="card-header">
                    Nominee Details
                </div>
                <div class="card-body">
                    <input type="hidden" name="emp_id" value="<?php echo $_GET['emp_id'] ?>">
                    <div class="form-group">
                        <label for="" class="control-label">Nominee</label>
                        <textarea name="nominee" id="nominee" cols="30" rows="2" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Relation</label>
                        <textarea name="relation" id="relation" cols="30" rows="2" class="form-control" required></textarea>
                    </div>
                    <!-- <div class="form-group">
                        <label for="" class="control-label">IFSC Code</label>
                        <textarea name="acc_ifsc" id="acc_ifsc" cols="30" rows="2" class="form-control" required></textarea>
                    </div> -->
                 </div>
            </div>
        </form>
</div>


<script>
    $('.select2').select2({
        placeholder: "Select here",
        width: "100%"
    });
    // $('#add_list').click(function(){
    // 	var allow_id = $('#acc_no').val(),
    // 		type = $('#acc_name').val(),
    // 		amount = $('#ifsc').val();
    // 		console
    // 	var tr = $('#tr_clone tr').clone()
    // 	tr.find('[name="acc_no[]"]').val(acc_no)
    // 	tr.find('[name="acc_name[]"]').val(acc_name)
    // 	tr.find('[name="ifsc[]"]').val(ifsc)
    // 	tr.find('.acc_no').html(acc_no)
    // 	tr.find('.acc_name').html(acc_name)
    // 	tr.find('.ifsc').html(ifsc)
    // 	$('#allowance-list tbody').append(tr)
    // 	$('#acc_no').val('').select2({
    // 		placeholder:"Select here",
    // 		width:"100%"
    // 	})
    // 	$('#acc_name').val('')
    // 	$('#ifsc').val('')
    // });
    $(document).ready(function() {
        $('#employee_nominee').submit(function(e) {
            e.preventDefault()
            start_load();
            $.ajax({
                url: 'ajax.php?action=save_employee_nominee',
                method: "POST",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                error: err => console.log(),
                success: function(resp) {
                    if (resp == 1) {
                        alert_toast("Employee's Nominee successfully saved", "success");
                        end_load()
                        uni_modal("Employee Details", 'view_info.php?emp_id=<?php echo $_GET['emp_id'] ?>', 'mid-large')
                    } else($mysqli_error)
                }
            })
        });
    })
</script>
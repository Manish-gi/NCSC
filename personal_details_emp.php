<?php 
    include('db_connect.php') ?>    
        <div class="card col-lg-12">
        <div class="container-fluid">
            <h1>Personal Details</h1>
            <table class="table-striped table-bordered col-md-12">
				<thead>
				</thead>
                <tbody>
				<?php
                     $emp_id = $_SESSION["login_emp_id"];
                        $sql = "SELECT * from employee e inner join department d ON e.dept_id=d.dept_id inner join position p ON e.pos_id=p.pos_id where emp_id=$emp_id";
                    $result = mysqli_query($conn, $sql) or die("Query Failed");

                 $row = mysqli_fetch_assoc($result);

                    // print_r($row);
                    // $result = mysqli_query($conn,$emp) or die("Query Failed");
                    //  while($row=>mysqli_fetch_assoc($result)){
                    //   echo $row['Emp_UN'] ;
                    //  }
                 ?>
					<tr>
                    <td>
                        <label>Employee Id</label>
                    </td>
                    <td>
                        <?php echo $row['emp_id']?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>User Name</label>
                    </td>
                    <td><?php echo $row['emp_un']?></td>
                </tr>
                <tr>
                    <td>
                        <label>Password</label>
                    </td>
                    <td><?php echo $row['emp_pw']?></td>
                </tr>
                <tr>
                    <td>
                        <label>Department</label>
                    </td>
                    <td><?php echo $row['dept_name']?></td>
                </tr>
                <tr>
                    <td>
                        <label>Designation</label>
                    </td>
                    <td><?php echo $row['pos_name']?></td>
                </tr>
                <tr>
                    <td>
                        <label>Grade Pay</label>
                    </td>
                    <td><?php echo $row['grade_pay']?></td>
                </tr>
                <tr>
                    <td>
                        <label>Fix Pay</label>
                    </td>
                    <td><?php echo $row['fix_pay']?></td>
                </tr>
                <tr>
                    <td>
                        <label>Date Of Joning</label>
                    </td>
                    <td><?php echo $row['d_o_j']?></td>
                </tr>
                <tr>
                    <td>
                        <label>Date Of Resign</label>
                    </td>
                    <td><?php echo $row['d_o_r']?></td>
                </tr>
                <tr>
                    <td>
                        <label>First Name</label>
                    </td>
                    <td><?php echo $row['first_name']?></td>
                </tr>
                <tr>
                    <td>
                        <label>Last Name</label>
                    </td>
                    <td><?php echo $row['last_name']?></td>
                </tr>
                <tr>
                    <td>
                        <label>Gender</label>
                    </td>
                    <td><?php echo $row['gender']?></td>
                </tr>
                <tr>
                    <td>
                        <label>Marital Status</label>
                    </td>
                    <td><?php echo $row['m_s']?></td>
                </tr>
                <tr>
                    <td>
                        <label>Address</label>
                    </td>
                    <td><?php echo $row['address']?></td>
                </tr>
                <tr>
                    <td>
                        <label>E-mail</label>
                    </td>
                    <td><?php echo $row['email']?></td>
                </tr>
                <tr>
                    <td>
                        <label>Mobile No</label>
                    </td>
                    <td><?php echo $row['mobile']?></td>
                </tr>
                <tr>
                    <td>
                        <label>Birth Date</label>
                    </td>
                    <td><?php echo $row['d_o_b']?></td>
                </tr>
                <tr>
                    <td>
                        <label>Employee Type</label>
                    </td>
                    <td><?php if($row['emp_type']==1){
                    echo "Parmanent";
                }elseif($row['emp_type']==2){
                    echo "Visting";
                }elseif($row['emp_type']==3){
                    echo "Contractual";
                }
                else{
                    echo "Teaching Asst";
                }
                        ?></td>
                </tr>
				</tbody>
            </table>
        </div>
</div>
<script>
	
</script>
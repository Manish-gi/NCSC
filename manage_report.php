 <?php include('db_connect.php');
    $gross_pay = [] ?>
 <div class="container-fluid">
     <div class="col-lg-12">
         <br />
         <br />
         <div class="card">
             <div class="card-header">
                 <b>Report</b>
                 <button class="btn btn-primary btn-sm btn-block col-md-3 float-right" type="button" id="new_repo_btn"><span class="fa fa-plus"></span>New Report</button>
             </div>
             <div class="card-body">
             <center> <button type="button" class="btn btn-primary  col-md-3 ">Allowance</button></center>
                 <!-- <input class="btn btn-success btn-sm btn-block col-md-3 float-right" type="button" id="table1_print_btn" class="fa fa-print" value="Print" onclick="createPDF()" /> -->
                 <table id="table" class="table table-bordered table-striped">
                     <thead>
                         <tr>
                             <th>Employee</th>
                             <!-- <th>Teaching/Non Teaching</th> -->
                             <th>Designation</th>
                             <th>DOJ</th>
                             <th>Department</th>
                             <th>Pay Scale</th>
                             <th>Date</th>
                             <th>Total Days</th>
                             <th>Present Days</th>
                             <th>Fix<br />Pay</th>
                             <th>Grade<br />Pay</th>
                             <th>basic<br />pay</th>
                             <?php
                                // SELECT ename,tech_non_tech,pos_name,d_o_j,dept_name,pay_scale from report
                                $repo_col = $conn->query("SELECT COLUMN_NAME from information_schema.columns WHERE table_name = N'report'");
                                while ($repo_col_name = $repo_col->fetch_assoc()) {
                                    $alw = $conn->query("SELECT * FROM allowance");
                                    while ($alwn = $alw->fetch_array()) {
                                        if ($repo_col_name['COLUMN_NAME'] == $alwn['aloow_name']) {

                                ?>
                                         <th><?php echo $repo_col_name['COLUMN_NAME'] ?></th>
                                     <?php
                                        }
                                    }

                                    if ($repo_col_name['COLUMN_NAME'] == "hra" || $repo_col_name['COLUMN_NAME'] == "da" || $repo_col_name['COLUMN_NAME'] == "ma") {
                                        ?>
                                     <th><?php echo $repo_col_name['COLUMN_NAME'] ?></th>
                             <?php
                                    }
                                }
                                ?>
                             <th>Total</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php
                            $row_sum = 0;
                            $i = 0;
                            $full_repo = $conn->query("SELECT * from report");
                            while ($data = $full_repo->fetch_array()) {
                            ?>
                             <tr>
                                 <td><?php echo $data['ename'] ?></td>
                                 <!-- <td><?php //echo $data['tech_non_tech']
                                            ?></td> -->
                                 <td><?php echo $data['pos_name'] ?></td>
                                 <td><?php echo $data['d_o_j'] ?></td>
                                 <td><?php echo $data['dept_name'] ?></td>
                                 <td><?php echo $data['pay_scale'] ?></td>
                                 <td><?php echo date("Y-M", strtotime($data['date'])) ?></td>
                                 <td><?php $date = strtotime($data['date']);
                                        echo cal_days_in_month(CAL_GREGORIAN, date("m", $date), date("Y", $date)) ?></td>
                                 <td><?php echo $data['attend'] ?></td>
                                 <td><?php echo $data['fix_pay'] ?></td>
                                 <td><?php echo $data['grade_pay'] ?></td>
                                 <td><?php echo ($data['fix_pay'] + $data['grade_pay']) ?></td>

                                 <?php
                                    $row_sum = ($data['fix_pay'] + $data['grade_pay']);
                                    $repo_col = $conn->query("SELECT COLUMN_NAME from information_schema.columns WHERE table_name = N'report'");
                                    while ($repo_col_name = $repo_col->fetch_assoc()) {
                                        // $i = 0;
                                        $alw = $conn->query("SELECT * FROM allowance");
                                        while ($alwn = $alw->fetch_array()) {
                                            if ($repo_col_name['COLUMN_NAME'] == $alwn['aloow_name']) {
                                                $row_sum += $data[$repo_col_name['COLUMN_NAME']];
                                    ?>
                                             <td><?php echo $data[$repo_col_name['COLUMN_NAME']] ?></td>
                                         <?php
                                            }
                                        }

                                        if ($repo_col_name['COLUMN_NAME'] == "hra" || $repo_col_name['COLUMN_NAME'] == "da" || $repo_col_name['COLUMN_NAME'] == "ma") {
                                            $row_sum += $data[$repo_col_name['COLUMN_NAME']];
                                            ?>
                                         <td><?php echo  $data[$repo_col_name['COLUMN_NAME']] ?></td>
                                 <?php
                                        }
                                    }
                                    ?>
                                 <td><?php $i++;
                                        $gross_pay[$i] = $row_sum;
                                        echo $row_sum; ?></td>
                             </tr>
                         <?php
                            }
                            ?>
                     </tbody>
                 </table>
             </div>
             <div class="card-body">
                 <center> <button type="button" class="btn btn-primary  col-md-3 ">Deduction</button></center>
            
                 <table id="table2" class="table table-bordered table-striped">
                     <thead>
                         <tr>
                             <th>Employee</th>
                             <!-- <th>Teaching/Non Teaching</th> -->
                             <th>Designation</th>
                             <th>DOJ</th>
                             <th>Department</th>
                             <th>Pay Scale</th>
                             <th>Date</th>
                             <th>Total Days</th>
                             <th>Present Days</th>
                             <th>Gross<br />Pay</th>
                             <?php
                                // SELECT ename,tech_non_tech,pos_name,d_o_j,dept_name,pay_scale from report
                                $repo_col = $conn->query("SELECT COLUMN_NAME from information_schema.columns WHERE table_name = N'report'");
                                while ($repo_col_name = $repo_col->fetch_assoc()) {
                                    // $i = 0;
                                    $dedu = $conn->query("SELECT * FROM deduction");
                                    while ($ded = $dedu->fetch_array()) {
                                        if ($repo_col_name['COLUMN_NAME'] == $ded['dedu_name']) {
                                ?>
                                         <th><?php echo $repo_col_name['COLUMN_NAME'] ?></th>
                                     <?php
                                        }
                                    }

                                    if ($repo_col_name['COLUMN_NAME'] == "ptax" || $repo_col_name['COLUMN_NAME'] == "epf") {
                                        ?>
                                     <th><?php echo $repo_col_name['COLUMN_NAME'] ?></th>
                             <?php
                                    }
                                }
                                ?>
                             <th>Total<br />Deductions</th>
                             <th>Net <br /> Pay</th>

                         </tr>
                     </thead>
                     <tbody>
                         <?php
                            $i = 1;
                            $full_repo = $conn->query("SELECT * from report");
                            while ($data = $full_repo->fetch_array()) {
                                $row_sum = 0;
                            ?>

                             <tr>
                                 <td><?php echo $data['ename'] ?></td>
                                 <!-- <td><?php //echo $data['tech_non_tech']
                                            ?></td> -->
                                 <td><?php echo $data['pos_name'] ?></td>
                                 <td><?php echo $data['d_o_j'] ?></td>
                                 <td><?php echo $data['dept_name'] ?></td>
                                 <td><?php echo $data['pay_scale'] ?></td>
                                 <td><?php echo date("Y-M", strtotime($data['date'])) ?></td>
                                 <td><?php $date = strtotime($data['date']);
                                        echo cal_days_in_month(CAL_GREGORIAN, date("m", $date), date("Y", $date)) ?></td>
                                 <td><?php echo $data['attend'] ?></td>
                                 <td><?php echo $gross_pay[$i] ?></td>
                                 <?php
                                    $repo_col = $conn->query("SELECT COLUMN_NAME from information_schema.columns WHERE table_name = N'report'");
                                    while ($repo_col_name = $repo_col->fetch_assoc()) {
                                        // $i = 0;
                                        $ded = $conn->query("SELECT * FROM deduction");
                                        while ($dedu = $ded->fetch_array()) {
                                            if ($repo_col_name['COLUMN_NAME'] == $dedu['dedu_name']) {
                                                $row_sum += $data[$repo_col_name['COLUMN_NAME']];
                                    ?>
                                             <td><?php echo $data[$repo_col_name['COLUMN_NAME']] ?></td>
                                         <?php
                                            }
                                        }

                                        if ($repo_col_name['COLUMN_NAME'] == "ptax" || $repo_col_name['COLUMN_NAME'] == "epf") {
                                            $row_sum += $data[$repo_col_name['COLUMN_NAME']];
                                            ?>
                                         <td><?php echo  $data[$repo_col_name['COLUMN_NAME']] ?></td>
                                 <?php
                                        }
                                    }
                                    ?>
                                 <td><?php echo $row_sum ?></td>
                                 <td><?php echo $gross_pay[$i] - $row_sum;
                                        $i++; ?> </td>
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
     //  $(document).ready(function() {
     //      $('#table').DataTable();
     //  });
     $(document).ready(function() {
         $('#table').DataTable({
             dom: 'Bfrtip',
             buttons: [
                 'csv', {
                 extend: 'pdfHtml5',
                 orientation: 'landscape',
                 title:'NCSC Payroll Report',
                 pageSize: 'LEGAL'
             }]
         });
     });
     $(document).ready(function() {
         $('#table2').DataTable({
             dom: 'Bfrtip',
             buttons: [
                 'csv', {
                 extend: 'pdfHtml5',
                 orientation: 'landscape',
                 title:'NCSC Payroll Report',
                 pageSize: 'LEGAL'
             }]
         });
     });
 </script>
 <script type="text/javascript">
     $(document).ready(function() {
         $('#new_repo_btn').click(function() {
             uni_modal("New Report", "report.php")
         })
     });
 </script>
 <!-- <script>
    function createPDF() {
        var sTable = document.getElementById('table').innerHTML;

        // var style = "<style>";
        // style = style + "table {width: 100%;font: 17px Calibri;}";
        // style = style + "table, th, td {border: solid 1px #DDD; border-collapse: collapse;";
        // style = style + "padding: 2px 3px;text-align: center;}";
        // style = style + "</style>";

        // CREATE A WINDOW OBJECT.
        var win = window.open('', '', 'height=900,width=900');

        win.document.write('<html><head>');
        win.document.write('<title>Profile</title>');   // <title> FOR PDF HEADER.
        win.document.write();          // ADD STYLE INSIDE THE HEAD TAG.
        win.document.write('</head>');
        win.document.write('<body>');
        win.document.write();         // THE TABLE CONTENTS INSIDE THE BODY TAG.
        win.document.write('</body></html>');

        win.document.close(); 	// CLOSE THE CURRENT WINDOW.

        win.print();    // PRINT THE CONTENTS.
    }
</script> -->
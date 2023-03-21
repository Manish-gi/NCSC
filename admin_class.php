<?php
session_start();
ini_set('display_errors', 1);
class Action
{
	private $db;

	public function __construct()
	{
		ob_start();
		include 'db_connect.php';

		$this->db = $conn;
	}
	function __destruct()
	{
		$this->db->close();
		ob_end_flush();
	}

	function login()
	{
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM employee where emp_un = '" . $username . "' and emp_pw = '" . $password . "' ");
		if ($qry->num_rows > 0) {
			foreach ($qry->fetch_array() as $key => $value) {
				if ($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_' . $key] = $value;
			}
			return 1;
		} else {
			return 3;
		}
	}

	function gene_report()
	{

		extract($_POST);
		$data = " ";
		if (strcmp("$dept_id", "all")) {
			$data .= " AND dept_name ='" . $dept_id . "'";
		}
		if ($emp_id != 0) {
			$data .= " AND e.emp_id ='" . $emp_id . "'";
		}
		if (strcmp("$pos_id", "all")) {
			$data .= " AND pos_name ='" . $pos_id . "'";
		}
		if (strcmp("$typ_tech", "all")) {
			$data .= " AND tech_non_tech ='" . $typ_tech . "'";
		}
		if (strcmp("$emp_typ", "all")) {
			$data .= " AND emp_type ='" . $emp_typ . "'";
		}
		if (isset($data)) {
			$this->db->query("DROP TABLE IF EXISTS report");
			$qry = $this->db->query("CREATE TABLE report AS (SELECT concat(e.last_name,', ',e.first_name) as ename,e.tech_non_tech,p.pos_name,e.d_o_j,e.emp_type,d.dept_name,concat(e.pay_min,'-',e.pay_max,' GP=',e.grade_pay) as pay_scale,sm.* from  salary_main sm right join  employee e on e.emp_id=sm.emp_id INNER JOIN position p ON e.pos_id=p.pos_id INNER JOIN department d ON e.dept_id=d.dept_id where date between '" . $from . "' AND '" . $to . "'" . $data . ")");
		} else {
			$this->db->query("DROP TABLE IF EXISTS report");
			$qry = $this->db->query("CREATE TABLE report AS (SELECT concat(e.last_name,', ',e.first_name) as ename,e.tech_non_tech,p.pos_name,e.d_o_j,e.emp_type,d.dept_name,concat(e.pay_min,'-',e.pay_max,' GP=',e.grade_pay) as pay_scale,sm.* from  salary_main sm right join  employee e on e.emp_id=sm.emp_id INNER JOIN position p ON e.pos_id=p.pos_id INNER JOIN department d ON e.dept_id=d.dept_id where date between '" . $from . "' AND '" . $to . "')");
		}
		if ($qry) {
			return 1;
		}
	}

	function increment()
	{
		$ent_value = 0;
		$ent = $this->db->query("SELECT * from entity where ent_name= 'inc'");
		while ($ent_hn = $ent->fetch_array()) {
			$ent_value = $ent_hn['ent_value'];
		}
		$row = $this->db->query("SELECT * FROM employee WHERE emp_type= 1 and (d_o_r >='" . date("Y-m-d") . "'|| d_o_r ='')");
		while ($emp_details = $row->fetch_array()) {
			$fix_pay=0;
			$fix_pay = $emp_details['fix_pay'];
			$new_fix_pay = $fix_pay + (($ent_value / 100) * $fix_pay);
			$this->db->query("UPDATE employee SET fix_pay ='" . $new_fix_pay . "' WHERE emp_id =" . $emp_details['emp_id']);
		}
		$save = $this->db->query("INSERT INTO inc(inc_date,value) VALUES ('" . date("Y-m-d") . "','" . $ent_value . "')");
		if (isset($save))
			return 1;
	}

	function save_employee_nominee()
	{
		extract($_POST);

		$data = " emp_id='$emp_id' ";
		$data .= ", nominee = '$nominee' ";
		$data .= ", relation = '$relation' ";
		$save = $this->db->query("INSERT INTO emp_nominee set " . $data);


		if (isset($save))
			return 1;
	}
	function delete_employee_nominee()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM emp_nominee where nominee_id = " . $nominee_id);
		if ($delete)
			return 1;
	}
	function save_employee_info()
	{
		extract($_POST);

		$data = " emp_id='$emp_id' ";
		$data .= ", acc_no = '$acc_no' ";
		$data .= ", acc_name = '$acc_name' ";
		$data .= ", acc_ifsc = '$acc_ifsc' ";
		$save = $this->db->query("INSERT INTO emp_acc set " . $data);


		if (isset($save))
			return 1;
	}
	function delete_employee_info()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM emp_acc where emp_id = " . $emp_id);
		if ($delete)
			return 1;
	}
	function login2()
	{
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where username = '" . $email . "' and password = '" . md5($password) . "' ");
		if ($qry->num_rows > 0) {
			foreach ($qry->fetch_array() as $key => $value) {
				if ($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_' . $key] = $value;
			}
			return 1;
		} else {
			return 3;
		}
	}
	function logout()
	{
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function logout2()
	{
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	function save_user()
	{
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		$data .= ", password = '$password' ";
		$data .= ", type = '$type' ";
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO users set " . $data);
		} else {
			$save = $this->db->query("UPDATE users set " . $data . " where id = " . $id);
		}
		if ($save) {
			return 1;
		}
	}
	function signup()
	{
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", contact = '$contact' ";
		$data .= ", address = '$address' ";
		$data .= ", username = '$email' ";
		$data .= ", password = '" . md5($password) . "' ";
		$data .= ", type = 3";
		$chk = $this->db->query("SELECT * FROM users where username = '$email' ")->num_rows;
		if ($chk > 0) {
			return 2;
			exit;
		}
		$save = $this->db->query("INSERT INTO users set " . $data);
		if ($save) {
			$qry = $this->db->query("SELECT * FROM users where username = '" . $email . "' and password = '" . md5($password) . "' ");
			if ($qry->num_rows > 0) {
				foreach ($qry->fetch_array() as $key => $value) {
					if ($key != 'passwors' && !is_numeric($key))
						$_SESSION['login_' . $key] = $value;
				}
			}
			return 1;
		}
	}

	function save_settings()
	{
		extract($_POST);
		$data = " name = '" . str_replace("'", "&#x2019;", $name) . "' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '" . htmlentities(str_replace("'", "&#x2019;", $about)) . "' ";
		if ($_FILES['img']['tmp_name'] != '') {
			$fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], 'assets/img/' . $fname);
			$data .= ", cover_img = '$fname' ";
		}

		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if ($chk->num_rows > 0) {
			$save = $this->db->query("UPDATE system_settings set " . $data);
		} else {
			$save = $this->db->query("INSERT INTO system_settings set " . $data);
		}
		if ($save) {
			$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
			foreach ($query as $key => $value) {
				if (!is_numeric($key))
					$_SESSION['setting_' . $key] = $value;
			}

			return 1;
		}
	}
	function employee()
	{
		extract($_POST);
		$data =$emp_typ="emp_typ";
		$data .=$adate=",adate";

		if($emp_typ){
			$emp=$this->db->query("SELECT *,concat(last_name,', ',first_name) as ename from employee where emp_type='".$emp_typ."' AND ( d_o_r >='". date("y-m-d") ."'|| d_o_r ='' )");      
                        while($data=$emp->fetch_array()){
							$dat=$data;
						}
		}
		if($data){
			return($dat);
		}
	}

	function save_employee()
	{
		extract($_POST);
		$data = " dept_id='$dept_id' ";
		$data .= ", emp_type='$emp_type' ";
		$data .= ", tech_non_tech='$tech_non_tech' ";
		$data .= ", emp_un='$emp_un' ";
		$data .= ", emp_pw='$emp_pw' ";
		$data .= ", pos_id='$pos_id' ";
		$data .= ", first_name='$first_name' ";
		$data .= ", last_name='$last_name' ";
		$data .= ", pay_min='$pay_min' ";
		$data .= ", pay_max='$pay_max' ";
		$data .= ", fix_pay='$fix_pay' ";
		$data .= ", grade_pay='$grade_pay' ";
		$data .= ", email='$email' ";
		$data .= ", mobile='$mobile' ";
		$data .= ", `d_o_j`= '$d_o_j' ";
		$data .= ", `d_o_r`='$d_o_r' ";
		$data .= ", address='$address' ";
		$data .= ", gender='$gender' ";
		$data .= ", m_s='$m_s' ";
		$data .= ", `d_o_b`='$d_o_b' ";
		$data .= ", access='$access'";


		if (empty($emp_id)) {
			$save = $this->db->query("INSERT INTO employee set " . $data);
		} else {
			$save = $this->db->query("UPDATE employee set " . $data . " where emp_id = " . $emp_id);
		}
		if ($save)
			return 1;
	}

	function delete_employee()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM employee where emp_id = " . $emp_id);
		if ($delete)
			return 1;
	}

	function save_department()
	{
		extract($_POST);
		$data = " dept_name='$dept_name' ";


		if (empty($dept_id)) {
			$save = $this->db->query("INSERT INTO department set " . $data);
		} else {
			$save = $this->db->query("UPDATE department set " . $data . " where dept_id=" . $dept_id);
		}
		if ($save)
			return 1;
	}
	function delete_department()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM department where dept_id = " . $dept_id);
		if ($delete)
			return 1;
	}
	function save_position()
	{
		extract($_POST);
		$data = " pos_name='$pos_name' ";
		// $data .=", dept_id = '$dept_id' ";


		if (empty($pos_id)) {
			$save = $this->db->query("INSERT INTO position set " . $data);
		} else {
			$save = $this->db->query("UPDATE position set " . $data . " where pos_name=" . $pos_name);
		}
		if ($save)
			return 1;
	}
	function delete_position()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM position where pos_id = " . $pos_id);
		if ($delete)
			return 1;
	}
	function save_allowances()
	{
		extract($_POST);
		$data = " aloow_name='$aloow_name' ";
		$data .= ", description = '$description' ";
		$allo = $this->db->query("SELECT * FROM allowance where allow_id='" . $allow_id . "'");
		while ($allow = $allo->fetch_array()) {
			$pre_allow_name = $allow['aloow_name'];
		}

		if (empty($allow_id)) {
			$save = $this->db->query("INSERT INTO allowance set " . $data);
			$this->db->query("ALTER TABLE salary_main ADD " . $aloow_name . " bigint;");
		} else {
			$save = $this->db->query("UPDATE allowance set " . $data . " where allow_id=" . $allow_id);
			$this->db->query("ALTER TABLE salary_main CHANGE " . $pre_allow_name . " " . $aloow_name . " BIGINT");
		}
		if ($save)
			return 1;
	}
	function delete_allowances()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM allowance where allow_id = " . $allow_id);
		if ($delete)
			return 1;
	}
	function save_employee_allowance()
	{
		extract($_POST);

		foreach ($allow_id as $k => $v) {
			$data = " emp_id='$emp_id' ";
			$data .= ", allow_id = '$allow_id[$k]' ";
			$data .= ", type = '$type[$k]' ";
			$data .= ", amount = '$amount[$k]' ";
			$data .= ", effective_date = '$effective_date[$k]' ";
			$save[] = $this->db->query("INSERT INTO emp_allow set " . $data);
		}

		if (isset($save))
			return 1;
	}
	function delete_employee_allowance()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM emp_allow where emp_allow_id = " . $emp_allow_id);
		if ($delete)
			return 1;
	}
	function save_deductions()
	{
		extract($_POST);
		$data = " dedu_name='$dedu_name' ";
		$data .= ", dedu_desc = '$dedu_desc' ";
		$dedu = $this->db->query("SELECT * FROM deduction where dedu_id='" . $dedu_id . "'");
		while ($deduction = $dedu->fetch_array()) {
			$pre_dedu_name = $deduction['dedu_name'];
		}


		if (empty($dedu_id)) {
			$save = $this->db->query("INSERT INTO deduction set " . $data);
			$this->db->query("ALTER TABLE salary_main ADD " . $dedu_name . " bigint;");
		} else {
			$save = $this->db->query("UPDATE deduction set " . $data . " where dedu_id=" . $dedu_id);
			$this->db->query("ALTER TABLE salary_main CHANGE " . $pre_dedu_name . " " . $dedu_name . " BIGINT");
		}
		if ($save)
			return 1;
	}
	function delete_deductions()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM deduction where dedu_id = " . $dedu_id);
		if ($delete)
			return 1;
	}
	function save_entity()
	{
		extract($_POST);
		// $data = " ent_name ='$ent_name' ";
		$data = "ent_desc = '$ent_desc' ";
		$data .= ", ent_value = '$ent_value' ";


		if (empty($ent_id)) {
			$save = $this->db->query("INSERT INTO entity set " . $data);
		} else {
			$save = $this->db->query("UPDATE entity set " . $data . " where ent_id=" . $ent_id);
		}
		if ($save)
			return 1;
	}
	function delete_entity()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM entity where ent_id = " . $ent_id);
		if ($delete)
			return 1;
	}
	function save_employee_deduction()
	{
		extract($_POST);

		foreach ($dedu_id as $k => $v) {
			$data = " emp_id='$emp_id' ";
			$data .= ", dedu_id = '$dedu_id[$k]' ";
			$data .= ", type = '$type[$k]' ";
			$data .= ", amount = '$amount[$k]' ";
			$data .= ", effective_date = '$effective_date[$k]' ";
			$save[] = $this->db->query("INSERT INTO emp_dedu set " . $data);
		}

		if (isset($save))
			return 1;
	}
	function delete_employee_deduction()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM emp_dedu where emp_dedu_id = " . $emp_dedu_id);
		if ($delete)
			return 1;
	}
	function save_employee_attendance()
	{
		extract($_POST);
		$inc_date = date('2011-08-10');
		foreach ($emp_id as $k => $v) {

			$data = "emp_id='$emp_id[$k]'";
			$pay = $this->db->query("SELECT * FROM employee where emp_id = '$emp_id[$k]'")->fetch_array(); //importing employee details
			$data .= ", attend = '$attend[$k]' ";
			$data .= ", date = '$adate[$k]' ";

			$dt = strtotime($adate[$k]);
			$days_in_mounth = cal_days_in_month(CAL_GREGORIAN, date("m", $dt), date("Y", $dt)); //calulating total days in mounth
			$tot_allow = 0;

			if ($pay['emp_type'] == 2) {													//calulating fix pay of employee
				$fix_pay = $pay['fix_pay'] * $attend[$k];
				$tot_allow += $fix_pay;
			} else {
				$per_day_fix = $pay['fix_pay'] / $days_in_mounth;
				$fix_pay = $per_day_fix * $attend[$k];
				$tot_allow += $fix_pay;
			}

			if ($pay['emp_type'] == 1) {													//calculating grade pay of employee
				$per_day_grade = $pay['grade_pay'] / $days_in_mounth;
				$grade_pay = $per_day_grade * $attend[$k];
				$tot_allow += $grade_pay;
				$data .= ", grade_pay ='" . $grade_pay . "' ";


				$basic_pay = $fix_pay + $grade_pay;											//calculatung bassic pay of employee

				$ent = $this->db->query("SELECT * from entity where ent_name='DA'")->fetch_array(); //calculatung da of employee
				$da = ($ent['ent_value'] / 100) * $basic_pay;
				$tot_allow += $da;
				$data .= ", da ='" . $da . "' ";

				$ent = $this->db->query("SELECT * from entity where ent_name='HRA'")->fetch_array(); //calculatung hra of employee
				$hra = ($ent['ent_value'] / 100) * $basic_pay;
				$tot_allow += $hra;
				$data .= ", hra ='" . $hra . "' ";

				$ent = $this->db->query("SELECT * from entity where ent_name='MA'")->fetch_array(); //calculatung ma of employee
				$per_day_ma = $ent['ent_value'] / $days_in_mounth;
				$ma = $per_day_ma * $attend[$k];
				$tot_allow += $ma;
				$data .= ", ma ='" . $ma . "' ";
			}
			$all_emp_allow = $this->db->query("SELECT * from emp_allow where emp_id='$emp_id[$k]'") or die(mysqli_error($conn));       //importing employee all allowance
			while ($row = $all_emp_allow->fetch_array()) {

				$allowance = $this->db->query("SELECT * from allowance where allow_id=" . $row['allow_id']);							//imorting allowance details

				if ($row['type'] == 2) {																								//checking the allowance in one time affective

					date_default_timezone_set('Asia/Kolkata');
					$efec_date = $row['effective_date'];
					//$cur_date=date('Y-m-d');

					if ($adate[$k] >= $efec_date) {																						////calculatung alowance of employee
						while ($allow_name = $allowance->fetch_array()) {
							$allow_nm = $allow_name['aloow_name'];
						}

						$data .= "," . $allow_nm . " ='" . $row['amount'] . "' ";
						$tot_allow += $row['amount'];
						$this->db->query("DELETE FROM emp_allow where emp_allow_id=" . $row['emp_allow_id']);
					}
				} else {
					while ($allow_name = $allowance->fetch_array()) {
						$allow_nm = $allow_name['aloow_name'];
					}

					$data .= "," . $allow_nm . " ='" . $row['amount'] . "' ";
					$tot_allow += $row['amount'];
				}
			}

			$all_emp_dedu = $this->db->query("SELECT * from emp_dedu where emp_id='$emp_id[$k]'") or die(mysqli_error($conn));       //importing employee all allowance
			while ($row = $all_emp_dedu->fetch_array()) {

				$deduction = $this->db->query("SELECT * from deduction where dedu_id=" . $row['dedu_id']);							//imorting allowance details

				if ($row['type'] == 2) {																								//checking the allowance in one time affective

					date_default_timezone_set('Asia/Kolkata');
					$efec_date = $row['effective_date'];
					//$cur_date=date('Y-m-d');

					if ($adate[$k] >= $efec_date) {																						////calculatung alowance of employee
						while ($dedu_name = $deduction->fetch_array()) {
							$dedu_nm = $dedu_name['dedu_name'];
						}

						$data .= "," . $dedu_nm . " ='" . $row['amount'] . "' ";
						$tot_allow += $row['amount'];
						$this->db->query("DELETE FROM emp_dedu where emp_dedu_id=" . $row['emp_dedu_id']);
					}
				} else {
					while ($dedu_name = $deduction->fetch_array()) {
						$dedu_nm = $dedu_name['dedu_name'];
					}

					$data .= "," . $dedu_nm . " ='" . $row['amount'] . "' ";
					$tot_allow += $row['amount'];
				}
			}
			$lib = "Librarian";
			$position = $this->db->query("SELECT * from position where pos_name = '" . $lib . "'");
			while ($pos = $position->fetch_array()) {
				$pos_id = $pos['pos_id'];
			}

			if ($pay['emp_type'] == 1 && $pay['tech_non_tech'] == "non_teaching" && $pay['pos_id'] != $pos_id) {
				$ent = $this->db->query("SELECT * from entity where ent_name='EPF'")->fetch_array();
				$epf = ($ent['ent_value'] / 100) * ($basic_pay + $da);
				$data .= ", epf ='" . $epf . "' ";
			}

			if ($tot_allow <= 5999) {
				$ptax = 0;
				$data .= ", ptax ='" . $ptax . "' ";
			} else if ($tot_allow >= 6000 && $tot_allow <= 8999) {
				$ptax = 80;
				$data .= ", ptax ='" . $ptax . "' ";
			} else if ($tot_allow >= 9000 && $tot_allow <= 11999) {
				$ptax = 150;
				$data .= ", ptax ='" . $ptax . "' ";
			} else {
				$ptax = 200;
				$data .= ", ptax ='" . $ptax . "' ";
			}
			$data .= ", fix_pay ='" . $fix_pay . "' ";
			$save[] = $this->db->query("INSERT INTO salary_main set " . $data);
		}
		if (isset($save))
			return 1;
	}
	function delete_employee_attendance()
	{
		extract($_POST);
		$data = "emp_salary_id='".$id."' ";
		// $data .= " date ='$date'";

		//$dt = date("Y-m-d",strtotime($date[1]));
		$delete = $this->db->query("DELETE FROM salary_main where " . $data);
		//$delete = $this->db->query("DELETE FROM salary_main where emp_id = '".$emp_id."' and date ='$dt' ");
		if ($delete)
			return 1;
	}
	// function delete_employee_attendance_single(){
	// 	extract($_POST);
	// 	$dt = date("Y-m-d",strtotime($date));

	// 	$delete = $this->db->query("DELETE FROM salary_main where emp_id ='" .$emp_id."' and date ='$dt'");
	// 	if($delete)
	// 		return 1;
	// }
	function save_payroll()
	{
		extract($_POST);
		$data = " date_from='$date_from' ";
		$data .= ", date_to = '$date_to' ";
		$data .= ", type = '$type' ";


		if (empty($id)) {
			$i = 1;
			while ($i == 1) {
				$ref_no = date('Y') . '-' . mt_rand(1, 9999);
				$chk  = $this->db->query("SELECT * FROM payroll where ref_no = '$ref_no' ")->num_rows;
				if ($chk <= 0) {
					$i = 0;
				}
			}
			$data .= ", ref_no='$ref_no' ";
			$save = $this->db->query("INSERT INTO payroll set " . $data);
		} else {
			$save = $this->db->query("UPDATE payroll set " . $data . " where id=" . $id);
		}
		if ($save)
			return 1;
	}
	function delete_payroll()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM payroll where id = " . $id);
		if ($delete)
			return 1;
	}
	function calculate_payroll()
	{
		extract($_POST);
		$am_in = "08:00";
		$am_out = "12:00";
		$pm_in = "13:00";
		$pm_out = "17:00";
		$this->db->query("DELETE FROM payroll_items where payroll_id=" . $id);
		$pay = $this->db->query("SELECT * FROM payroll where id = " . $id)->fetch_array();
		$employee = $this->db->query("SELECT * FROM employee");
		if ($pay['type'] == 1)
			$dm = 22;
		else
			$dm = 11;
		$calc_days = abs(strtotime($pay['date_to'] . " 23:59:59")) - strtotime($pay['date_from'] . " 00:00:00 -1 day");
		$calc_days = floor($calc_days / (60 * 60 * 24));
		$att = $this->db->query("SELECT * FROM attendance where date(datetime_log) between '" . $pay['date_from'] . "' and '" . $pay['date_from'] . "' order by UNIX_TIMESTAMP(datetime_log) asc  ") or die(mysqli_error($conn));
		while ($row = $att->fetch_array()) {
			$date = date("Y-m-d", strtotime($row['datetime_log']));
			if ($row['log_type'] == 1 || $row['log_type'] == 3) {
				if (!isset($attendance[$row['employee_id'] . "_" . $date]['log'][$row['log_type']]))
					$attendance[$row['employee_id'] . "_" . $date]['log'][$row['log_type']] = $row['datetime_log'];
			} else {
				$attendance[$row['employee_id'] . "_" . $date]['log'][$row['log_type']] = $row['datetime_log'];
			}
		}
		$deductions = $this->db->query("SELECT * FROM employee_deductions where (`type` = '" . $pay['type'] . "' or (date(effective_date) between '" . $pay['date_from'] . "' and '" . $pay['date_from'] . "' ) ) ");
		$allowances = $this->db->query("SELECT * FROM employee_allowances where (`type` = '" . $pay['type'] . "' or (date(effective_date) between '" . $pay['date_from'] . "' and '" . $pay['date_from'] . "' ) ) ");
		while ($row = $deductions->fetch_assoc()) {
			$ded[$row['employee_id']][] = array('did' => $row['deduction_id'], "amount" => $row['amount']);
		}
		while ($row = $allowances->fetch_assoc()) {
			$allow[$row['employee_id']][] = array('aid' => $row['allowance_id'], "amount" => $row['amount']);
		}
		while ($row = $employee->fetch_assoc()) {
			$salary = $row['salary'];
			$daily = $salary / 22;
			$min = (($salary / 22) / 8) / 60;
			$absent = 0;
			$late = 0;
			$dp = 22 / $pay['type'];
			$present = 0;
			$net = 0;
			$allow_amount = 0;
			$ded_amount = 0;


			for ($i = 0; $i < $calc_days; $i++) {
				$dd = date("Y-m-d", strtotime($pay['date_from'] . " +" . $i . " days"));
				$count = 0;
				$p = 0;
				if (isset($attendance[$row['id'] . "_" . $dd]['log']))
					$count = count($attendance[$row['id'] . "_" . $dd]['log']);

				if (isset($attendance[$row['id'] . "_" . $dd]['log'][1]) && isset($attendance[$row['id'] . "_" . $dd]['log'][2])) {
					$att_mn = abs(strtotime($attendance[$row['id'] . "_" . $dd]['log'][2])) - strtotime($attendance[$row['id'] . "_" . $dd]['log'][1]);
					$att_mn = floor($att_mn  / 60);
					$net += ($att_mn * $min);
					$late += (240 - $att_mn);
					$present += .5;
				}
				if (isset($attendance[$row['id'] . "_" . $dd]['log'][3]) && isset($attendance[$row['id'] . "_" . $dd]['log'][4])) {
					$att_mn = abs(strtotime($attendance[$row['id'] . "_" . $dd]['log'][4])) - strtotime($attendance[$row['id'] . "_" . $dd]['log'][3]);
					$att_mn = floor($att_mn  / 60);
					$net += ($att_mn * $min);
					$late += (240 - $att_mn);
					$present += .5;
				}
			}
			$ded_arr = array();
			$all_arr = array();
			if (isset($allow[$row['id']])) {
				foreach ($allow[$row['id']] as $arow) {
					$all_arr[] = $arow;
					$net += $arow['amount'];
					$allow_amount += $arow['amount'];
				}
			}
			if (isset($ded[$row['id']])) {
				foreach ($ded[$row['id']] as $drow) {
					$ded_arr[] = $drow;
					$net -= $drow['amount'];
					$ded_amount += $drow['amount'];
				}
			}
			$absent = $dp - $present;
			$data = " payroll_id = '" . $pay['id'] . "' ";
			$data .= ", employee_id = '" . $row['id'] . "' ";
			$data .= ", absent = '$absent' ";
			$data .= ", present = '$present' ";
			$data .= ", late = '$late' ";
			$data .= ", salary = '$salary' ";
			$data .= ", allowance_amount = '$allow_amount' ";
			$data .= ", deduction_amount = '$ded_amount' ";
			$data .= ", allowances = '" . json_encode($all_arr) . "' ";
			$data .= ", deductions = '" . json_encode($ded_arr) . "' ";
			$data .= ", net = '$net' ";
			$save[] = $this->db->query("INSERT INTO payroll_items set " . $data);
		}
		if (isset($save)) {
			$this->db->query("UPDATE payroll set status = 1 where id = " . $pay['id']);
			return 1;
		}
	}
}

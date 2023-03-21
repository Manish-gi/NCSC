
<style>
</style>
<nav id="sidebar" class='mx-lt-5 bg-dark' >
		
		<div class="sidebar-list">

				<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Home</a>
			 <?php if($_SESSION['login_access'] == 1): ?>
				
				<a href="index.php?page=attendance" class="nav-item nav-attendance"><span class='icon-field'><i class="fa fa-toggle-on"></i></span> Attendance</a>
				<a href="index.php?page=payroll" class="nav-item nav-payroll"><span class='icon-field'><i class="fa fa-tv"></i></span> Payroll List</a>
				<a href="index.php?page=employee" class="nav-item nav-employee"><span class='icon-field'><i class="fa fa-user-tie"></i></span> Employee List</a>
				
				<a href="index.php?page=department" class="nav-item nav-department"><span class='icon-field'><i class="fa fa-building"></i></span> Depatment List</a>
				<a href="index.php?page=position" class="nav-item nav-position"><span class='icon-field'><i class="fa fa-user-times"></i></span> Position List</a>
				<a href="index.php?page=allowances" class="nav-item nav-allowances"><span class='icon-field'><i class="fa fa-tasks"></i></span> Allowance List</a>
				<a href="index.php?page=deductions" class="nav-item nav-deductions"><span class='icon-field'><i class="fa fa-money-bill-wave"></i></span> Deduction List</a>		
				<a href="index.php?page=entity" class="nav-item nav-entity"><span class='icon-field'><i class="fa fa-calendar-alt"></i></span> Entity List</a>
				
				<a href="index.php?page=manage_report" class="nav-item nav-manage_report"><span class='icon-field'><i class="fa fa-clipboard"></i></span> Reports</a>
				<a href="index.php?page=Info" class="nav-item nav-Info"><span class='icon-field'><i class="fa fa-users"></i></span> Info</a>

			<?php endif; ?>
			<?php if($_SESSION['login_access'] == 2): ?>
				<a href="index.php?page=attendance" class="nav-item nav-attendance"><span class='icon-field'><i class="fa fa-toggle-on"></i></span> Attendance</a>
				<a href="index.php?page=payroll" class="nav-item nav-payroll"><span class='icon-field'><i class="fa fa-tv"></i></span> Payroll List</a>
				<a href="index.php?page=employee" class="nav-item nav-employee"><span class='icon-field'><i class="fa fa-user-tie"></i></span> Employee List</a>
				
				<a href="index.php?page=allowances" class="nav-item nav-allowances"><span class='icon-field'><i class="fa fa-tasks"></i></span> Allowance List</a>
				<a href="index.php?page=deductions" class="nav-item nav-deductions"><span class='icon-field'><i class="fa fa-money-bill-wave"></i></span> Deduction List</a>		
				
				<a href="index.php?page=manage_report" class="nav-item nav-manage_report"><span class='icon-field'><i class="fa fa-clipboard"></i></span> Reports</a>
				<a href="index.php?page=Info" class="nav-item nav-Info"><span class='icon-field'><i class="fa fa-users"></i></span> Info</a>

			<?php endif; ?>
			<?php if($_SESSION['login_access'] == 3): ?>
				<a href="index.php?page=personal_details_emp" class="nav-item nav-personal_details_emp"><span class='icon-field'><i class="fa fa-user-tie"></i></span> Personal Details</a>
				<a href="index.php?page=account_emp" class="nav-item nav-account_emp"><span class='icon-field'><i class="fa fa-tv"></i></span> Account & Nonimee Details</a>
				<a href="index.php?page=payslip_emp" class="nav-item nav-payslip_emp"><span class='icon-field'><i class="fa fa-tv"></i></span> Employee Pay Slip</a>
				
				<?php endif; ?>
		</div>

</nav>
<script>
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>

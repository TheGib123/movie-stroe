<!DOCTYPE html> 
<html>
<body>
<?php
include("../../functions.php");
$empID = $_POST['empID'];
if ($empID == ""){
	$empID = $employeeID;
}

function Update_Employee($employeeID, $fName, $lName, $phoneNumber, $email){
	$query = "update EMPLOYEES set firstName = '" . $fName . "', lastName = '" . $lName . "', phoneNumber = " . $phoneNumber . ", email = '" . $email . "' where employeeID = " . $employeeID . ";";
	Query($query);
}

function Check_Employee($phone, $current_phone){
	if ($phone == $current_phone){
		return "good";
	}
	$query = "select phoneNumber from EMPLOYEES where phoneNumber = " . $phone . ";";
	$result = ReturnQuery($query);
	$realNumb = mysqli_fetch_row($result);
	
	if ($realNumb[0] == ""){
		return "good";
	}
}

function Show_Info($empID){
	$query = "select * from EMPLOYEES where employeeID = " . $empID . ";";
	$result = ReturnQuery($query);
	$row = mysqli_fetch_row($result);

	print("<form action='' method='post'>");
		print("First Name<input type='text' name='fName' value='" . $row[1] . "'><br>");
		print("Last Name<input type='text' name='lName' value='" . $row[2] . "'><br>");
		print("Phone Number<input type='number' min='0' step='1' name='phone' value='" . $row[3] . "'><br>");
		print("Email<input type='text' name='email' value='" . $row[4] . "'><br>");
		print("<input type='hidden' name='empID' value='$row[0]'>");
		print("<input type='hidden' name='current_phone' value='$row[3]'>");
		print("<input type='submit' name='update_employee' value='Update Employee'/>");
		print("<a href='ManagerSelectEmployee.php'><button type='button'><-</button></a>");
		print("<br><br>");
	print("</form>");
}

if(isset($_POST['update_employee'])){ 
	$fName = $_POST['fName'];
	$lName = $_POST['lName'];
	$phoneNumber = $_POST['phone'];
	$current_phone = $_POST['current_phone'];
	$email = $_POST['email'];
	$employeeID = $_POST['empID'];
	$check = Check_Employee($phoneNumber, $current_phone);
	if ($check == "good"){
		Update_Employee($employeeID, $fName, $lName, $phoneNumber, $email);
		Show_Info($empID);
		print("Employee updated");
	}
	else {
		Show_Info($empID);
		print("Phone number is already linked to a Employee. Could not update");
	}
	
}
else {
	Show_Info($empID);
}



?>
</body>
</html>
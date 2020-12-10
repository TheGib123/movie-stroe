<!DOCTYPE html> 
<html>
<body>
<?php
include("../../functions.php");
$custID = $_POST['custID'];
if ($custID == ""){
	$custID = $customerID;
}

function Update_Customer($customerID, $fName, $lName, $phoneNumber, $email){
	$query = "update CUSTOMERS set firstName = '" . $fName . "', lastName = '" . $lName . "', phoneNumber = " . $phoneNumber . ", email = '" . $email . "' where customerID = " . $customerID . ";";
	Query($query);
}

function Check_Customer($phone, $current_phone){
	if ($phone == $current_phone){
		return "good";
	}
	$query = "select phoneNumber from CUSTOMERS where phoneNumber = " . $phone . ";";
	$result = ReturnQuery($query);
	$realNumb = mysqli_fetch_row($result);
	
	if ($realNumb[0] == ""){
		return "good";
	}
}

function Show_Info($custID){
	$query = "select * from CUSTOMERS where customerID = " . $custID . ";";
	$result = ReturnQuery($query);
	$row = mysqli_fetch_row($result);

	print("<form action='' method='post'>");
		print("First Name<input type='text' name='fName' value='" . $row[1] . "'><br>");
		print("Last Name<input type='text' name='lName' value='" . $row[2] . "'><br>");
		print("Phone Number<input type='number' min='0' step='1' name='phone' value='" . $row[3] . "'><br>");
		print("Email<input type='text' name='email' value='" . $row[4] . "'><br>");
		print("<input type='hidden' name='custID' value='$row[0]'>");
		print("<input type='hidden' name='current_phone' value='$row[3]'>");
		print("<input type='submit' name='update_customer' value='Update Customer'/>");
		print("<a href='EmployeeSelectCustomer.php'><button type='button'><-</button></a>");
		print("<br><br>");
	print("</form>");
}

if(isset($_POST['update_customer'])){ 
	$fName = $_POST['fName'];
	$lName = $_POST['lName'];
	$phoneNumber = $_POST['phone'];
	$current_phone = $_POST['current_phone'];
	$email = $_POST['email'];
	$customerID = $_POST['custID'];
	$check = Check_Customer($phoneNumber, $current_phone);
	if ($check == "good"){
		Update_Customer($customerID, $fName, $lName, $phoneNumber, $email);
		Show_Info($custID);
		print("Customer updated");
	}
	else {
		Show_Info($custID);
		print("Phone number is already linked to a Customer. Could not update");
	}
	
}
else {
	Show_Info($custID);
}



?>
</body>
</html>
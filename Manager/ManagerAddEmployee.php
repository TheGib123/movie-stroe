<!DOCTYPE html> 
<html>
<body>
<?php
include("../functions.php");

function Insert_Employee($fName, $lName, $phoneNumber, $email, $pass){
	$query = "insert into EMPLOYEES(firstName, lastName, phoneNumber, email, pass) values('" . $fName . "', '" . $lName . "', " . $phoneNumber . ", '" . $email . "', '" . $pass . "');";
	Query($query);
	print("Employee Added");
}

function Check_Employee($phone){
	$query = "select phoneNumber from EMPLOYEES where phoneNumber = " . $phone . ";";
	$result = ReturnQuery($query);
	$realNumb = mysqli_fetch_row($result);
	
	if ($realNumb[0] == ""){
		return "good";
	}
	else {
		print("Phone number is already linked to a Employee");
	}
}


print("<form action='' method='post'>");
	print("First Name<input type='text' name='f_name'><br>");
	print("Last Name<input type='text' name='l_name'><br>");
	print("Phone Number<input type='number' min='0' step='1' name='phone_number'><br>");
	print("Email<input type='text' name='email'><br>");	
    print("Password<input type='text' name='pass'><br>");
	print("<input type='submit' name='add' value='Add Employee'/>");
    print("<a href='ManagerMenu.php'><button type='button'><-</button></a>");
	print("<br><br>");
print("</form>");

if(isset($_POST['add'])){ 
	$fName = $_POST['f_name'];
	$lName = $_POST['l_name'];
	$phoneNumber = $_POST['phone_number'];
	$email = $_POST['email'];
    $pass = $_POST['pass'];
	$check = Check_Employee($phoneNumber);
	if ($check == "good"){
		Insert_Employee($fName, $lName, $phoneNumber, $email, $pass);
	}	
}



?>
</body>
</html>

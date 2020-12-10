<!DOCTYPE html> 
<html>
<body>
<?php
include("../functions.php");

function Insert_Customer($fName, $lName, $phoneNumber, $email){
	$query = "insert into CUSTOMERS(firstName, lastName, phoneNumber, email, lateFees) values('" . $fName . "', '" . $lName . "', " . $phoneNumber . ", '" . $email . "', 0);";
	Query($query);
	print("Customer Added");
}

function Check_Customer($phone){
	$query = "select phoneNumber from CUSTOMERS where phoneNumber = " . $phone . ";";
	$result = ReturnQuery($query);
	$realNumb = mysqli_fetch_row($result);
	
	if ($realNumb[0] == ""){
		return "good";
	}
	else {
		print("Phone number is already linked to a Customer");
	}
}


print("<form action='' method='post'>");
	print("First Name<input type='text' name='f_name'><br>");
	print("Last Name<input type='text' name='l_name'><br>");
	print("Phone Number<input type='number' min='0' step='1' name='phone_number'><br>");
	print("Email<input type='text' name='email'><br>");	
	print("<input type='submit' name='add' value='Add Customer'/>");
    print("<a href='EmployeeMenu.php'><button type='button'><-</button></a>");
	print("<br><br>");
print("</form>");

if(isset($_POST['add'])){ 
	$fName = $_POST['f_name'];
	$lName = $_POST['l_name'];
	$phoneNumber = $_POST['phone_number'];
	$email = $_POST['email'];
	$check = Check_Customer($phoneNumber);
	if ($check == "good"){
		Insert_Customer($fName, $lName, $phoneNumber, $email);
	}	
}



?>
</body>
</html>

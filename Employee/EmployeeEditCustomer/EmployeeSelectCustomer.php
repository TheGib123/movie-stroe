<!DOCTYPE html> 
<html>
<body>
<?php
include("../../functions.php");

function Show_Customers($fName, $lName, $phone, $email){
	$query = "select firstName, lastName, phoneNumber, email from CUSTOMERS where firstName like '%" . $fName . "%' and lastName like '%" . $lName . "%' and phoneNumber like '%" . $phone . "%' and email like '%" . $email . "%';";
	$result = ReturnQuery($query);
	print("<div style='height:200px;overflow:auto;'>");
	print("<table>");
	print("<th>First Name</th>");
	print("<th>Last Name</th>");
	while ($row = mysqli_fetch_row($result)){
		print("<tr>");
			print("<td style='border: 1px solid black;'>");
				print("$row[0]");
			print("</td>");
			print("<td style='border: 1px solid black;'>");
				print("$row[1]");
			print("</td>");
			print("<td style='border: 1px solid black;'>");
				print("$row[2]");
			print("</td>");
			print("<td style='border: 1px solid black;'>");
				print("$row[3]");
			print("</td>");
		print("</tr>");
	}
	print("</table>"); 
	print("</div>");
}

print("<form action='' method='post'>");
	print("Search First Name<input type='text' name='s_fName'><br>");
	print("Search Last Name<input type='text' name='s_lName'><br>");
	print("Search Phone Number<input type='number' min='0' step='1' name='s_phone'><br>");
	print("Search Email<input type='text' name='s_email'><br>");
	print("<input type='submit' name='search_customer' value='Search Customer'/>");
    print("<a href='../EmployeeMenu.php'><button type='button'><-</button></a>");
	print("<br><br>");
print("</form>");

$query = "select firstName, lastName, phoneNumber, email, customerID from CUSTOMERS;";

if(isset($_POST['search_customer'])){ 
	$fName = $_POST['s_fName'];
	$lName = $_POST['s_lName'];
	$phone = $_POST['s_phone'];
	$email = $_POST['s_email'];
	$query = "select firstName, lastName, phoneNumber, email, customerID from CUSTOMERS where firstName like '%" . $fName . "%' and lastName like '%" . $lName . "%' and phoneNumber like '%" . $phone . "%' and email like '%" . $email . "%';";
}


$result = ReturnQuery($query);
print("<div style='height:200px;overflow:auto;'>");
	print("<table>");
	print("<th>First Name</th>");
	print("<th>Last Name</th>");
	print("<th>Phone Number</th>");
	print("<th>Email</th>");
	while ($row = mysqli_fetch_row($result)){
		print("<tr>");
			print("<td style='border: 1px solid black;'>");
				print("$row[0]");
			print("</td>");
			print("<td style='border: 1px solid black;'>");
				print("$row[1]");
			print("</td>");
			print("<td style='border: 1px solid black;'>");
				print("$row[2]");
			print("</td>");
			print("<td style='border: 1px solid black;'>");
				print("$row[3]");
			print("</td>");
			
			print("<form action='EmployeeEditCustomer.php' method='post'>");
			print("<input type='hidden' name='custID' value='$row[4]'>");
			print("<td><input type='submit' name='viewCust' value='Select'/></td>");
			print("</form>");
			
		print("</tr>");
	}
	print("</table>"); 
	print("</div>");


?>
</body>
</html>
<!DOCTYPE html> 
<html>
<body>
<?php
include("../functions.php");

if(isset($_POST['logOut'])){ 
	session_destroy();
	header('Location: ../');
}

print("Employee Menu<br>");
print("<a href='EmployeeAddCustomer.php'>");
	print("<button type='button'>Add Customer</button>");
print("</a>");

print("<a href='EmployeeEditCustomer/EmployeeSelectCustomer.php'>");
	print("<button type='button'>Edit Customer</button>");
print("</a>");

print("<a href='EmployeeTransaction/EmployeeTransactionSelectCustomer.php'>");
	print("<button type='button'>Transaction</button>");
print("</a>");

print("<a href='EmployeeReturns.php'>");
	print("<button type='button'>Return Movies</button>");
print("</a>");

print("<form action='' method='post'>");
	print("<input type='submit' name='logOut' value='Log Out'>");
print("</form>");


?>
</body>
</html>
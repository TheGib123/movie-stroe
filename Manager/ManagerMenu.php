<!DOCTYPE html> 
<html>
<body>
<?php
include("../functions.php");

if(isset($_POST['logOut'])){ 
	session_destroy();
	header('Location: ../');
}
print("Manager Menu");
print("<br>");

//done
print("<a href='ManagerAddCustomer.php'>");
	print("<button type='button'>Add Customer</button>");
print("</a>");

//done
print("<a href='ManagerEditCustomer/ManagerSelectCustomer.php'>");
	print("<button type='button'>Edit Customer</button>");
print("</a>");

//done
print("<a href='ManagerDeleteCustomer.php'>");
	print("<button type='button'>Delete Customer</button>");
print("</a>");

//done
print("<a href='ManagerAddEmployee.php'>");
	print("<button type='button'>Add Employee</button>");
print("</a>");

//done
print("<a href='ManagerEditEmployee/ManagerSelectEmployee.php'>");
	print("<button type='button'>Edit Employee</button>");
print("</a>");

//done
print("<a href='ManagerDeleteEmployee.php'>");
	print("<button type='button'>Delete Employee</button>");
print("</a>");

print("<a href='ManagerReports.php'>");
	print("<button type='button'>Reports</button>");
print("</a>");

//done
print("<a href='ManagerMovie/ManagerAddMovie.php'>");
	print("<button type='button'>Add Movie</button>");
print("</a>");

//done
print("<a href='ManagerMovie/ManagerDeleteMovie.php'>");
	print("<button type='button'>Delete Movie</button>");
print("</a>");


print("<a href='ManagerActor/ManagerAddActor.php'>");
	print("<button type='button'>Add Actor</button>");
print("</a>");

print("<a href='ManagerActor/ManagerDeleteActor.php'>");
	print("<button type='button'>Delete Actor</button>");
print("</a>");

//almost done
print("<a href='ManagerTransaction/ManagerTransactionSelectCustomer.php'>");
	print("<button type='button'>Transaction</button>");
print("</a>");

//done
print("<a href='MangerReturns.php'>");
	print("<button type='button'>Return Movies</button>");
print("</a>");

print("<form action='' method='post'>");
	print("<input type='submit' name='logOut' value='Log Out'>");
print("</form>");


?>
</body>
</html>
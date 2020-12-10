<!DOCTYPE html> 
<html>
<body>
<?php
include("../functions.php");

function LOGIN($id, $pass, $workerType){
	$querey = "";
	if ($workerType == "employee"){
		$querey = "select pass from EMPLOYEES where employeeID = " . $id . ";";
	}
	else {
		$querey = "select pass from MANAGERS where managerID = " . $id . ";";
	}
	
	$result = ReturnQuery($querey);
	$actualPass = mysqli_fetch_row($result);
	$realPass = $actualPass[0];

	if ($pass == $realPass){
		print("logIN");
		session_start();
		$_SESSION['id'] = $id;
		$_SESSION['workerType'] = $workerType;
		if ($workerType == "employee"){
			header('Location: ../Employee/EmployeeMenu.php');
		}
		else {
			header('Location: ../Manager/ManagerMenu.php');
		}
	}
}

if(isset($_POST['login'])){ 
	$id = $_POST['id'];
	$pass = $_POST['pass'];
	$workerType = $_POST['worker'];
	if ($id != ""){
		LOGIN($id, $pass, $workerType);
	}
}

print("<form action='' method='post'>");
  print("<input type='radio' name='worker' value='employee' checked>Employee<br>");
  print("<input type='radio' name='worker' value='manager'>Manager<br>");
  print("ID:<br>");
  print("<input type='number' min='0' step='1' name='id'><br>");
  print("Password:<br>");
  print("<input type='password' name='pass'><br>");
  print("<input type='submit' name='login' value='Log In'>");
print("</form>");


?>
</body>
</html>
<!DOCTYPE html> 
<html>
<body>
<?php
include("../functions.php");

function Delete_Employee($phoneNumber){
    $query = "delete from EMPLOYEES where phoneNumber = '" . $phoneNumber . "';";
    Query($query);
    print("Employee Deleted");
}

function Delete_Constraints($empID){
    $query = "update TRANSACTIONS set employeeID = NULL where employeeID = " . $empID . ";";
    Query($query);
}

/*
function Check_Employee($phone){
	$query = "select * from RENTALMOVIE natural join TRANSACTIONS natural join CUSTOMERS where returned = 'no' and phoneNumber = '" . $phone . "';";
	$result = ReturnQuery($query);
	$realNumb = mysqli_fetch_row($result);
	
	if ($realNumb[0] == ""){
		return "good";
	}
	else {
		print("Can not delete employee still has movies out");
	}
}
*/

function Info($phoneNumber){
    $query = "select * from EMPLOYEES where phoneNumber = '" . $phoneNumber . "';";
    $result = ReturnQuery($query);
    $row = mysqli_fetch_row($result);
    print("First Name: $row[1]<br>");
    print("Last Name: $row[2]<br>");
    print("Phone Number: $row[3]<br>");
    print("Email: $row[4]<br>");
    print("Late Fees: $row[5]<br>");
    return $row[0];
}

print("Delete Employee");
print("<form action='' method='post'>");
	print("Phone Number<input type='number' min='0' step='1' name='phone_number'><br>");
	print("<input type='submit' name='delete' value='Search'/>");
    print("<a href='ManagerMenu.php'><button type='button'><-</button></a>");
	print("<br><br>");
print("</form>");

if(isset($_POST['delete'])){ 
	$phoneNumber = $_POST['phone_number'];
    $empID = Info($phoneNumber);
	//$check = Check_Employee($phoneNumber);
	//if ($check == "good"){
        //print("no movies out");
        print("<form action='' method='post'>");
            print("<input type='hidden' name='empID' value='$empID'/>");
            print("<input type='hidden' name='phone' value='$phoneNumber'/>");
	        print("<input type='submit' name='delete_emp' value='Delete Employee'/>");
            print("<a href='ManagerMenu.php'><button type='button'><-</button></a>");
	        print("<br><br>");
        print("</form>");
	//}	
    
}

if(isset($_POST['delete_emp'])){ 
    $empID = $_POST['empID'];
    $phoneNumber = $_POST['phone'];
    //echo $phoneNumber;
    Delete_Constraints($empID);
    Delete_Employee($phoneNumber);
    print("<a href='ManagerMenu.php'><button type='button'><-</button></a>");
}



?>
</body>
</html>
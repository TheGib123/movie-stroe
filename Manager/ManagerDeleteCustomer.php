<!DOCTYPE html> 
<html>
<body>
<?php
include("../functions.php");

function Delete_Customer($phoneNumber){
    $query = "delete from CUSTOMERS where phoneNumber = '" . $phoneNumber . "';";
    Query($query);
    print("Customer Deleted");
}

function Delete_Constraints($custID){
    $query = "update TRANSACTIONS set customerID = NULL where customerID = " . $custID . ";";
    Query($query);
}

function Check_Customer($phone){
	$query = "select * from RENTALMOVIE natural join TRANSACTIONS natural join CUSTOMERS where returned = 'no' and phoneNumber = '" . $phone . "';";
	$result = ReturnQuery($query);
	$realNumb = mysqli_fetch_row($result);
	
	if ($realNumb[0] == ""){
		return "good";
	}
	else {
		print("Can not delete customer still has movies out");
	}
}

function Info($phoneNumber){
    $query = "select * from CUSTOMERS where phoneNumber = '" . $phoneNumber . "';";
    $result = ReturnQuery($query);
    $row = mysqli_fetch_row($result);
    print("First Name: $row[1]<br>");
    print("Last Name: $row[2]<br>");
    print("Phone Number: $row[3]<br>");
    print("Email: $row[4]<br>");
    print("Late Fees: $row[5]<br>");
    return $row[0];
}

print("Delete Customer");
print("<form action='' method='post'>");
	print("Phone Number<input type='number' min='0' step='1' name='phone_number'><br>");
	print("<input type='submit' name='delete' value='Search'/>");
    print("<a href='ManagerMenu.php'><button type='button'><-</button></a>");
	print("<br><br>");
print("</form>");

if(isset($_POST['delete'])){ 
	$phoneNumber = $_POST['phone_number'];
    $custID = Info($phoneNumber);
	$check = Check_Customer($phoneNumber);
	if ($check == "good"){
        print("no movies out");
        print("<form action='' method='post'>");
            print("<input type='hidden' name='custID' value='$custID'/>");
            print("<input type='hidden' name='phone' value='$phoneNumber'/>");
	        print("<input type='submit' name='delete_cust' value='Delete Customer'/>");
            print("<a href='ManagerMenu.php'><button type='button'><-</button></a>");
	        print("<br><br>");
        print("</form>");
	}	
    
}

if(isset($_POST['delete_cust'])){ 
    $custID = $_POST['custID'];
    $phoneNumber = $_POST['phone'];
    //echo $phoneNumber;
    Delete_Constraints($custID);
    Delete_Customer($phoneNumber);
    print("<a href='ManagerMenu.php'><button type='button'><-</button></a>");
}



?>
</body>
</html>
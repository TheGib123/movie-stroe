<!DOCTYPE html> 
<html>
<body>
<?php
include("../functions.php");

function Check_Movie_Out($movieID){
	$query = "select returned from RENTALMOVIE where returned = 'no' and movieID = " . $movieID . ";";
	$result = ReturnQuery($query);
	$row = mysqli_fetch_row($result);
	
	$check = "";
	if ($row[0] == "no"){
		$check = "good";
	}
	else {
		$check = "bad";
	}
	
	return $check;
}

function Get_CustomerID($movieID){
	$query = "select customerID from RENTALMOVIE natural join TRANSACTIONS where returned = 'no' and movieID = " . $movieID . ";";
	$result = ReturnQuery($query);
	$row = mysqli_fetch_row($result);
	return $row[0];
}

function Get_Currented_Latefees($customerID){
	$query = "select lateFees from CUSTOMERS where customerID = " . $customerID . ";";
	$result = ReturnQuery($query);
	$row = mysqli_fetch_row($result);
	return $row[0];
}

function Insert_LateFees($customerID, $movieID){
	$query = "select returnDate from RENTALMOVIE natural join TRANSACTIONS where returned = 'no' and movieID = " . $movieID . ";";
	$result = ReturnQuery($query);
	$row = mysqli_fetch_row($result);
	$returnDate = $row[0];
	$todaysDate = date("Y/m/d");
	$daysLate = 0;
	
	echo $returnDate;
	echo $todaysDate;
	
	if ($returnDate > $todaysDate){
		$daysLate = round(abs(strtotime($todaysDate) - strtotime($returnDate))/86400);
		
		print("<br>");
		print("Movie is $daysLate days late");
	
		$latefees = $daysLate * .5;
		$currentfees = Get_Currented_Latefees($customerID);
		$latefees = $latefees + $currentfees;
	
		print("<br>");
		print("Late fees are $latefees");
	
		$query = "update CUSTOMERS set lateFees = " . $latefees . " where customerID = " . $customerID . ";";
		Query($query);
	}
	
	$rental_query = "update RENTALMOVIE set returned = 'yes' where movieID = " . $movieID . ";";
	$movie_query = "update MOVIES set rented = 'no' where movieID = " . $movieID . ";";
	Query($rental_query);
	Query($movie_query);
	
	print("<br>");
	print("Movie Returned");

	

	
	
	//$interval = $todaysDate->diff($returnDate);
	//echo $interval->days;
}

print("<form action='' method='post'>");
	print("Enter Movie ID<input type='number' min='0' step='1' name='movieID'>");
	print("<input type='submit' name='MovieReturn' value='Return Movie'/><br><br>");
print("</form>");
print("<a href='ManagerMenu.php'><button type='button'><-</button></a>");


if(isset($_POST['MovieReturn'])){
	print("<br>");
	$movieID = $_POST['movieID'];
	//echo $movieID;
	if ($movieID != ""){
		$check_state = Check_Movie_Out($movieID);
		if ($check_state == "good"){
			$customerID = Get_CustomerID($movieID);
			Insert_LateFees($customerID, $movieID);
		}
		else {
			print("Movie is in store already");
		}
	}
	else {
		print("Need a movie ID");
	}
}

?>
</body>
</html>
<!DOCTYPE html> 
<html>
<body>
<?php
include("../../functions.php");


function Insert_In_TRANSACTIONS($customerID, $employeeID, $date, $returnDate, $workerType){
	$query = "";
	if ($workerType == "employee"){
		$query = "insert into TRANSACTIONS(customerID, employeeID, date, returnDate) values(" . $customerID . "," . $employeeID . ",'" . $date . "', '" . date("Y-m-d",$returnDate) . "');";
	}                                                                                     
	else if ($workerType == "manager") {
		// MAKE SURE MANAGER GOES IN TRANSACTION NOT TESTED
		$query = "insert into TRANSACTIONS(customerID, date, returnDate, managerID) values(" . $customerID . ",'" . $date . "', '" . date("Y-m-d",$returnDate) . "', " . $employeeID . ");";
	}
	else {
		print("Transaction failed please log out and back in");
	}
	
	$transactionID = ReturnIdQuery($query);	
	return $transactionID;
}

function Insert_In_MOVIE($movies){	
	foreach ($movies as $movie){
		$query = "update MOVIES set rented = 'yes' where movieID = " . $movie . ";";
		Query($query);
	}
}

function Insert_In_RENTALMOVIE($transactionID, $movies) {
	foreach ($movies as $movie){
		$query = "select movieID, cost from MOVIES where movieID = " . $movie . ";" ;
		$result = ReturnQuery($query);
		while ($row = mysqli_fetch_row($result)){
			$movID = $row[0];
			$movCost = $row[1];
			$q = "insert into RENTALMOVIE (transactionID, movieID, movieCost, returned) values(" . $transactionID . "," . $movID . "," . $movCost. ", 'no');";
			Query($q);
		}
	}
}

/*
function Insert_In_CUSTOMER($customerID, $movies){
	$movCount = 0;
	foreach ($movies as $movie){
		$movCount = $movCount + 1;
	}
	
	$query = "update CUSTOMERS set moviesOut = " . $movCount . " where customerID = " . $customerID . ";";
	Query($query);
}*/

function Get_Late_Fees($customerID){
    $query = "select lateFees from CUSTOMERS where customerID = " . $customerID . ";";
    $result = ReturnQuery($query);
    $row = mysqli_fetch_row($result);
    return $row[0];
}


function Get_Movie_Total($movies){
    $total = 0;
    foreach ($movies as $movie){
        $query = "select title, cost from MOVIES where movieID = " . $movie . ";" ;
        $result = ReturnQuery($query);
		$row = mysqli_fetch_row($result);
		print("$row[0] $l $row[1]<br>");
        $total = $total + $row[1];
        
    }
    return $total;
}

function Get_Sales_Tax($money){
    return ($money * 7.932) / 100;
}

session_start();
$customerID = $_POST['custID'];
$employeeID = $_SESSION['id'];
$movies = $_SESSION['m'];
$workerType = $_SESSION['workerType'];



if(isset($_POST['finish'])){
    $lateFees = $_POST['lateFees'];
    $tax = $_POST['tax'];
    $movieTotal = $_POST['total'];
    $customerID = $_POST['custID'];
    $date = date("Y-m-d");
    $returnDate = strtotime($date."+ 2 days");
	
    print("The Movie Store<br>");
    print("Date of Transaction $date<br>");
    print("Retrun Date  ");
    print(date("Y-m-d",$returnDate));
    print("<br><br>");

    $lateFees = Get_Late_Fees($customerID);
    $movieTotal = Get_Movie_Total($movies);
    $tax = Get_Sales_Tax(($movieTotal + $lateFees));
    $total = $lateFees + $movieTotal + $tax;
	
	$transactionID = Insert_In_TRANSACTIONS($customerID, $employeeID, $date, $returnDate, $workerType);
	Insert_In_RENTALMOVIE($transactionID, $movies);
	Insert_In_MOVIE($movies);
	//Insert_In_CUSTOMER($customerID, $movies);
	

    print("<br><br>");
    print("Late Fees:$lateFees<br>");
    print("Total: $movieTotal<br>");
    print("Tax: $tax<br><br>");
    print("Total: $total");
    print("<br><br>");

    print("<a href='../EmployeeMenu.php'><button type='button'><-</button></a>");
}
else {
    $lateFees = Get_Late_Fees($customerID);
    $movieTotal = Get_Movie_Total($movies);
    $tax = Get_Sales_Tax(($movieTotal + $lateFees));
    $total = $lateFees + $movieTotal + $tax;
	
	if ($lateFees == 0 and count($movies) == 0){
		print "No late fees and no movies to check out<br>";
		print("<a href='../EmployeeMenu.php'><button type='button'><-</button></a>");
	}
	else {
		print("<br><br>");
		print("Late Fees:$lateFees<br>");
		print("Total: $movieTotal<br>");
		print("Tax: $tax<br><br>");
		print("Total: $total");
		print("<br><br>");

		print("<form action='' method='post'>");
			print("<input type='hidden' name='lateFees' value='$lateFees'>");
			print("<input type='hidden' name='tax' value='$tax'>");
			print("<input type='hidden' name='total' value='$total'>");
			print("<input type='hidden' name='custID' value='$customerID'>");
			print("<input type='submit' name='finish' value='Pay'/>");
			print("<a href='../EmployeeMenu.php'><button type='button'><-</button></a>");
		print("</form>");
	}

}

?>
</body>
</html>
<!DOCTYPE html> 
<html>
<body>
<?php
include("../../functions.php");

function Show_Info($custID){
	$query = "select * from CUSTOMERS where customerID = " . $custID . ";";
	$result = ReturnQuery($query);
	$row = mysqli_fetch_row($result);

	print("First Name: $row[1]");
	print("<br>");
	print("Last Name: $row[2]");
	print("<br>");
	print("Phone Number: $row[3]");
	print("<br>");
	print("Email: $row[4]");
	print("<br>");
	print("Late Fees: "); 
    print(money_format('$%i', $row[5])); 
	print("<br>");
	print("<a href='../ManagerMenu.php'><button type='button'><-</button></a>");
}

function Get_Movies_Out($custID){
	$query = "select rentalMovieID from RENTALMOVIE natural join TRANSACTIONS where returned = 'no' and customerID = " . $custID . ";";
	$result = ReturnQuery($query);
	$movOut = 0;
	while ($row = mysqli_fetch_row($result)){
		$movOut = $movOut + 1;
	}
	return $movOut;
}

function Movies_Out($custID){
	print("<div style='height:200px;overflow:auto;'>");
	print("<table>");
	print("<th>Movie Title</th>");
	print("<th>Return Date</th>");
	
	$query = "select title, returnDate from RENTALMOVIE natural join TRANSACTIONS natural join MOVIES where returned = 'no' and customerID = " . $custID . ";";
	$result = ReturnQuery($query);
	while ($row = mysqli_fetch_row($result)){
		print("<tr>");
			print("<td style='border: 1px solid black;'>");
			print("$row[0]");
			print("</td>");
			print("<td style='border: 1px solid black;'>");
			print("$row[1]");
			print("</td>");
		print("</tr>");
	}
	print("</table>"); 
	print("</div>");
	
	print("Customer currently has movies out and will not be able to rent again until they are returned");
}

function Add_Movie_Form($custID){
	print("<form action='' method='post'>");
	print("Enter Movie ID<input type='number' min='0' step='1' name='movieID'>");
	print("<input type='hidden' name='custID' value='$custID'>");
	print("<td><input type='submit' name='Movie' value='Add Movie'/></td><br><br>");
	print("</form>");
	
	print("<form action='ManagerTransactionPay.php' method='post'>");
	print("<input type='hidden' name='custID' value='$custID'>");
	print("<td><input type='submit' name='CeckOut' value='Check Out'/></td>");
	print("</form>");
}

function Check_Movie($currentMovie){
	$query = "select rented from MOVIES where movieID = " . $currentMovie . ";";
	$result = ReturnQuery($query);
	$row = mysqli_fetch_row($result);
	$check = "bad";
	if ($row[0] == "no"){
		return "good";
	}
}

function Check_List($currentMovie, $currentList){
	$check = "good";
    if ($currentMovie == ""){
        $check = "bad";
    }
	foreach ($currentList as $i){
		if ($currentMovie == $i){
			$check = "bad";
		}
	}
	return $check;
}

function Print_Selected_Movies($rentalMovies, $custID){
	print("<div style='height:200px;overflow:auto;'>");
	print("<table>");
	print("<th>Movie ID</th>");
	print("<th>Movie Title</th>");
	print("<th>Movie Cost</th>");
	foreach ($rentalMovies as $movie){
		$query = "select movieID, title, cost from MOVIES where movieID = " . $movie . ";" ;
		$result = ReturnQuery($query);
		while ($row = mysqli_fetch_row($result)){
			print("<tr>");

                print("<form action='' method='post'>");
				print("<td style='border: 1px solid black;'>");
					print("$row[0]");
				print("</td>");
				print("<td style='border: 1px solid black;'>");
					print("$row[1]");
				print("</td>");
				print("<td style='border: 1px solid black;'>");
					//print("$row[2]");
                    print(money_format('$%i', $row[2]));
				print("</td>");
				
				//print("<form action='' method='post'>");
				print("<input type='hidden' name='movID' value='$movie'>");
				print("<input type='hidden' name='custID' value='$custID'>");
				print("<td><input type='submit' name='DelMov' value='Delete'/></td>");
				print("</form>");
				
			print("</tr>");
		}
	}
	print("</table>"); 
	print("</div>");
}

if(isset($_POST['viewCust'])){ 
	$custID = $_POST['custID'];
	session_start();
	$rm = array();
	$_SESSION["m"] = $rm;
}

session_start();
if ($_SESSION["m"] == NULL){
	$rm = array();
}
else {
	$rm = $_SESSION["m"];
}


if(isset($_POST['DelMov'])){
	$custID = $_POST['custID'];
	$mov = $_POST['movID'];
	if (($key = array_search($mov, $rm)) !== false) {
		unset($rm[$key]);
	}
	session_start();
	$_SESSION["m"] = $rm;	
	
}



if(isset($_POST['Movie'])){ 
	$custID = $_POST['custID'];
	Show_Info($custID);
	$currentMovie = $_POST['movieID'];
    $check = "";
    $checkList = "";

    if ($currentMovie != ""){
        $check = Check_Movie($currentMovie);
	    $checkList = Check_List($currentMovie, $rm);
    }

	if ($check == "good" and $checkList == "good"){
		array_push($rm, $currentMovie);
		session_start();
		$_SESSION["m"] = $rm;
		Print_Selected_Movies($rm, $custID);
		Add_Movie_Form($custID);
	}
	else {
		session_start();
		$_SESSION["m"] = $rm;
		Print_Selected_Movies($rm, $custID);
		Add_Movie_Form($custID);
		print("Movie is checked out, in list, or invalid input");
	}
}
else {
	Show_Info($custID);
	$amount_movies_out = Get_Movies_Out($custID);
	if ($amount_movies_out == 0){
		Print_Selected_Movies($rm, $custID);
		Add_Movie_Form($custID);
	}
	else {
		Movies_Out($custID);
	}
}

?>
</body>
</html>
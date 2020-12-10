<!DOCTYPE html> 
<html>
<body>
<?php
include("../functions.php");


if(isset($_POST['MoviesOut'])){
    $query = "SELECT movieID, title, firstName, lastName, phoneNumber, email FROM RENTALMOVIE natural join MOVIES naural join CUSTOMERS WHERE returned = 'no'";
    $result = ReturnQuery($query);

    print("<div style='height:200px;overflow:auto;'>");
	print("<table>");
	print("<th>MovieID</th>");
	print("<th>Title</th>");
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
            print("<td style='border: 1px solid black;'>");
				print("$row[4]");
			print("</td>");
            print("<td style='border: 1px solid black;'>");
				print("$row[5]");
			print("</td>");
		print("</tr>");
	}
	print("</table>"); 
	print("</div>");
}

else {
    print("<form action='' method='post'>");
	print("<input type='submit' name='MoviesOut' value='All Movies Out'/><br><br>");
    print("</form>");
    print("<a href='ManagerMenu.php'><button type='button'><-</button></a>");
}

?>
</body>
</html>
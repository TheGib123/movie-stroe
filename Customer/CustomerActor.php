<!DOCTYPE html> 
<html>
<body>
<?php
include("../functions.php");



function ShowActors($actorID){
	$q_actorName = "select firstName, lastName from ACTORS where actorID = $actorID;";
	$r_actorName = ReturnQuery($q_actorName);
	$name = mysqli_fetch_row($r_actorName);
	print("<h1>Movies $name[0], $name[1] star in</h1>");
	
    $q1 = "select title, catagory, releaseDate, cost, sum(rented='no') from MOVACT natural join MOVIES where actorID = " . $actorID . " group by title, catagory, releaseDate, cost;";
    $r = ReturnQuery($q1);
	
	print("<div style='height:200px;overflow:auto;'>");
	print("<table>");
	print("<th>Movie Title</th>");
	print("<th>Catagory</th>");
	print("<th>Release Year</th>");
	print("<th>Rental Cost</th>");
	print("<th>Copies In Store</th>");
    while ($row = mysqli_fetch_row($r)){
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
			print(money_format('$%i', $row[3])); 
		print("</td>");
		print("<td style='border: 1px solid black;'>");
			print("$row[4]");
		print("</td>");
		print("</tr>");
    }
	print("</table>"); 
	print("</div>");
}

print("<form action='' method='post'>");
	print("Search Actor First Name<input type='text' name='s_fn'><br>");
	print("Search Actor Last Name<input type='text' name='s_ln'><br>");
	print("<input type='submit' name='Search' value='Search'/>");
    print("<a href='CustomerMenu.html'><button type='button'><-</button></a>");
	print("<br><br>");
print("</form>");

//select title, catagory, releaseDate, cost, COUNT(*) from  MOVIES where rented = "no" and title like '%oe%'group by title, catagory, releaseDate, cost having count(*) > 1;


//$query = "select title, catagory, releaseDate, cost, COUNT(*) from  MOVIES where rented = 'no' and    title like '%" . $search_string . "%' group by title, catagory, releaseDate, cost having count(*);";
//$query = "select title, catagory, releaseDate, cost, sum(rented = 'no') from MOVIES where title like '%" . $search_string . "%' group by title, catagory, releaseDate, cost;";
$query = "select * from ACTORS where firstName like '%%' and lastName like '%%';";



if(isset($_POST['Search'])){ 
	$search_firstName = "";
	$search_lastName = "";
	$search_firstName = $_POST['s_fn'];
	$search_lastName = $_POST['s_ln'];
	$query = "select * from ACTORS where firstName like '%" . $search_firstName . "%' and lastName like '%" . $search_lastName . "%';";
}
$result = ReturnQuery($query);


print("<div style='height:200px;overflow:auto;'>");
print("<table>");
print("<th>First Name</th>");
print("<th>Last Name</th>");
while ($row = mysqli_fetch_row($result)){
	print("<tr>");
		print("<td style='border: 1px solid black;'>");
			print("$row[1]");
		print("</td>");
		print("<td style='border: 1px solid black;'>");
			print("$row[2]");
		print("</td>");


        print("<form action='' method='post'>");
        print("<input type='hidden' name='actorID' value='$row[0]'>");
        print("<td><input type='submit' name='ViewActors' value='Movies'/></td>");
        print("</form>");

	print("</tr>");
}
print("</table>"); 
print("</div>");


if(isset($_POST['ViewActors'])){ 
    $actorID = $_POST['actorID'];
    ShowActors($actorID);
}

?>
</body>
</html>
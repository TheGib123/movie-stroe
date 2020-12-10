<!DOCTYPE html> 
<html>
<body>
<?php
include("../functions.php");



function ShowActors($mov_title){
    print("<h1>$mov_title Actors</h1>");
    $q1 = "select firstName, lastName from MOVACT NATURAL JOIN ACTORS NATURAL JOIN MOVIES where title = '" . $mov_title . "' group by firstName, lastName;";
    $r = ReturnQuery($q1);
    print("<div style='height:200px;overflow:auto;'>");
	print("<table>");
	print("<th>First Name</th>");
	print("<th>Last Name</th>");
	while ($row = mysqli_fetch_row($r)){
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
}

print("<form action='' method='post'>");
	print("Search Title<input type='text' name='s_title'><br>");
	print("Search Catagory<input type='text' name='s_cat'><br>");
	print("Search Year<input type='text' name='s_year'><br>");
	print("<input type='submit' name='Search' value='Search'/>");
    print("<a href='CustomerMenu.html'><button type='button'><-</button></a>");
	print("<br><br>");
print("</form>");

//select title, catagory, releaseDate, cost, COUNT(*) from  MOVIES where rented = "no" and title like '%oe%'group by title, catagory, releaseDate, cost having count(*) > 1;


//$query = "select title, catagory, releaseDate, cost, COUNT(*) from  MOVIES where rented = 'no' and    title like '%" . $search_string . "%' group by title, catagory, releaseDate, cost having count(*);";
//$query = "select title, catagory, releaseDate, cost, sum(rented = 'no') from MOVIES where title like '%" . $search_string . "%' group by title, catagory, releaseDate, cost;";
$query = "select title, catagory, releaseDate, cost, sum(rented = 'no') from MOVIES where title like '%%' group by title, catagory, releaseDate, cost;";



if(isset($_POST['Search'])){ 
	$search_title = "";
	$search_cat = "";
	$search_year = "";
	$search_title = $_POST['s_title'];
	$search_cat = $_POST['s_cat'];
	$search_year = $_POST['s_year'];
	$query = "select title, catagory, releaseDate, cost, sum(rented = 'no') from MOVIES where title like '%" . $search_title . "%' and catagory like '%" . $search_cat . "%' and releaseDate like '%" . $search_year . "%' group by title, catagory, releaseDate, cost;";
}
$result = ReturnQuery($query);


print("<div style='height:200px;overflow:auto;'>");
print("<table>");
print("<th>Movie Title</th>");
print("<th>Catagory</th>");
print("<th>Release Year</th>");
print("<th>Rental Cost</th>");
print("<th>Copies In Store</th>");
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
            print(money_format('$%i', $row[3])); 
		print("</td>");
		print("<td style='border: 1px solid black;'>");
			print("$row[4]");
		print("</td>");

        print("<form action='' method='post'>");
        print("<input type='hidden' name='MovieTitle' value='$row[0]'>");
        print("<td><input type='submit' name='ViewMovies' value='Actors'/></td>");
        print("</form>");

	print("</tr>");
}
print("</table>"); 
print("</div>");


if(isset($_POST['ViewMovies'])){ 
    $mov_title = $_POST['MovieTitle'];
    ShowActors($mov_title);
}

?>
</body>
</html>

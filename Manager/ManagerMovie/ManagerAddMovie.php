<!DOCTYPE html> 
<html>
<body>
<?php
include("../../functions.php");


function Link_Actors($actAr, $movieID) {
    foreach ($actAr as $actor){
        $query = "insert into MOVACT (movieID, actorID) values($movieID,$actor);";
        Query($query);
    }
}

function Insert_Movie($title, $catagory, $year, $cost){
    $query = "insert into MOVIES (title, releaseDate, cost, catagory, rented) values('$title', $year, $cost, '$catagory', 'no');";

    $movieID = ReturnIdQuery($query);	
    return $movieID;
}

function Print_Actors(){
    $query = "select * from ACTORS";
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
            print("<td><input type='submit' name='actors' value='Add Actor'/></td>");
            print("</form>");

        print("</tr>");
    }
    print("</table>"); 
    print("</div>");

    print("<form action='' method='post'>");
        print("<td><input type='submit' name='finish' value='Finish Adding Movie'/></td>");
    print("</form>");
}

function Check($x){
    $check = "bad";
    if ($x != ""){
        $check = "good";
    }
    return $check;
}



if(isset($_POST['add'])){
    $title = $_POST['title'];
    $catagory = $_POST['catagory'];
    $year = $_POST['year'];
    $cost = $_POST['cost'];
    $copies = $_POST['copies'];

    $check_title = Check($title);
    $check_catagory = Check($catagory);
    $check_year = Check($year);
    $check_cost = Check($cost);
    $check_copies = Check($copies);

    if ($check_title == "good" && $check_catagory == "good" && $check_year == "good" && $check_cost == "good" && $check_copies == "good"){
        session_start();
	    $actorsARRY = array();
        $_SESSION["actAR"] = $actorsARRY;
        $_SESSION["AddMovTitle"] = $title;
        $_SESSION["AddMovCatagory"] = $catagory;
        $_SESSION["AddMovYear"] = $year;
        $_SESSION["AddMovCost"] = $cost;
        $_SESSION["AddMovCopies"] = $copies;
        Print_Actors();
    }
    else {
        print("All fields must be filled out");
    }

} 
elseif(isset($_POST['actors'])){
    $actID = $_POST['actorID'];
    session_start();
    array_push($_SESSION["actAR"], $actID); 
    Print_Actors();

}
elseif(isset($_POST['finish'])){
    session_start();
    $_SESSION["actAR"] = array_unique($_SESSION["actAR"], SORT_REGULAR);
    
    for ($i = 0; $i < $_SESSION["AddMovCopies"]; $i++){
        $newMovieID = Insert_Movie($_SESSION["AddMovTitle"], $_SESSION["AddMovCatagory"], $_SESSION["AddMovYear"], $_SESSION["AddMovCost"]);
        Link_Actors($_SESSION["actAR"], $newMovieID);
        print("Movie Added with ID $newMovieID<br>");
    }
    
    print("<a href='../ManagerMenu.php'><button type='button'><-</button></a>");


    $_SESSION["AddMovTitle"] = "";
    $_SESSION["AddMovCatagory"] = "";
    $_SESSION["AddMovYear"] = "";
    $_SESSION["AddMovCost"] = "";
    $_SESSION["actAR"] = "";
    $_SESSION["AddMovCopies"] = "";
}
else {
    print("<form action='' method='post'>");
	print("Title<input type='text' name='title'><br>");
	print("Catagory<input type='text' name='catagory'><br>");
	print("Release Year<input type='number' min='0' step='1' name='year'><br>");
	print("Rental Cost<input type='number' min='0' step='0.01'  name='cost'><br>");
    print("Copies<input type='number' min='0' step='1' name='copies'><br>");	
	print("<input type='submit' name='add' value='Add Movies'/>");
    print("<a href='../ManagerMenu.php'><button type='button'><-</button></a>");
	print("<br><br>");
    print("</form>");
}





?>
</body>
</html>

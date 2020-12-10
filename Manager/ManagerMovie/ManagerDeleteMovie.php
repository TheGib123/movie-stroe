<!DOCTYPE html> 
<html>
<body>
<?php
include("../../functions.php");

function Delete_Constraints($movieID){
    $query = "delete from MOVACT where movieID = $movieID;";
    Query($query);
}

function Delete_Movie($movieID){
    $query = "delete from MOVIES where movieID = $movieID;";
    Query($query);
}

function Print_Movie($movieID){
    $query = "select * from MOVIES where movieID = $movieID;";
    $result = ReturnQuery($query);
    $row = mysqli_fetch_row($result);
    print("$row[0], $row[1]<br>");
}

function Check_Movie($movieID) {
    $query = "select * from MOVIES where movieID = $movieID;";
    $result = ReturnQuery($query);
    $row = mysqli_fetch_row($result);
    $input = "bad";
    if ($row[0] == $movieID){
        $input = "good";
    }
    return $input;
}

print("Delete Movie");
print("<form action='' method='post'>");
    print("Movie ID<input type='number' min='0' step='1' name='movID'><br>");	
	print("<input type='submit' name='delete' value='Delete Movie'/>");
    print("<a href='../ManagerMenu.php'><button type='button'><-</button></a>");
	print("<br><br>");
print("</form>");



if(isset($_POST['delete'])){
    $movieID = $_POST['movID'];
    if ($movieID != ""){
        $check = Check_Movie($movieID);
        if ($check == "good"){
            Print_Movie($movieID);
            Delete_Constraints($movieID);
            Delete_Movie($movieID);
            print("Movie Deleted");
        }
    }
    else{
        print("You must type in the Movie ID you want to delete<br>");
    }
}





?>
</body>
</html>
<!DOCTYPE html> 
<html>
<body>
<?php
include("../../functions.php");

function Delete_Actor($fname, $lname){
    $query = "delete from ACTORS where firstName = '$fname' and lastName = '$lname';";
    Query($query);
}

function Delete_Constraint($fname, $lname){
    $query = "select * from ACTORS where firstName = '$fname' and lastName = '$lname';";
    $result = ReturnQuery($query);
    $row = mysqli_fetch_row($result);
    $actorID = $row[0];
    $query = "update MOVACT set actorID = NULL where actorID = $actorID;";
    Query($query);
}

function Check_Actor($fname, $lname){
    $query = "select * from ACTORS where firstName = '$fname' and lastName = '$lname';";
    $result = ReturnQuery($query);
    $row = mysqli_fetch_row($result);
    $input = "bad";
    if ($row[0] != ""){
        $input = "good";
    }

    return $input;

}


print("Delete Actor");
print("<form action='' method='post'>");
    print("First Name<input type='text' name='fname'><br>");
	print("Last Name<input type='text' name='lname'><br>");	
	print("<input type='submit' name='delete' value='Delete Actor'/>");
    print("<a href='../ManagerMenu.php'><button type='button'><-</button></a>");
	print("<br><br>");
print("</form>");


if(isset($_POST['delete'])){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    print("$fname, $lname");
    $check = Check_Actor($fname, $lname);
    if ($check == "good"){
        Delete_Constraint($fname, $lname);
        Delete_Actor($fname, $lname);
        print("Actor Deleted");
    }
    else {
        print("Actor was not found");
    }
}



?>
</body>
</html>
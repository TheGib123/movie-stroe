<!DOCTYPE html> 
<html>
<body>
<?php
include("../../functions.php");


function Add_Actor($fname, $lname){
    $query = "insert into ACTORS (firstName, lastName) values('$fname','$lname');";
    Query($query);
}

function Check_Actor($fname, $lname) {
    $query = "select * from ACTORS where firstName = '$fname' and lastName = '$lname';";
    $result = ReturnQuery($query);
    $row = mysqli_fetch_row($result);
    $input = "bad";
    if ($row[0] == ""){
        $input = "good";
    }
    return $input;
}


print("<form action='' method='post'>");
    print("Add Actor<br>");
	print("First Name<input type='text' name='fName'><br>");
	print("Last Name<input type='text' name='lName'><br>");
    print("<input type='submit' name='add' value='Add Actors'/>");
    print("<a href='../ManagerMenu.php'><button type='button'><-</button></a><br>");
print("</form>");


if(isset($_POST['add'])){
    $fname = $_POST['fName'];
    $lname = $_POST['lName'];

    if ($fname != "" && $lname != ""){
        $check = Check_Actor($fname, $lname);
        if ($check == "good"){
            Add_Actor($fname, $lname);
            print("Actor Added");
        }
        else {
            print("Actor is alread added");
        }
    }
    else {
        print("Type in actor first name and last name");
    }
}










?>
</body>
</html>
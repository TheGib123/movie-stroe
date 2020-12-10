<?php
function ConnectDB() {
	// connects to database 
	if ($database=mysqli_connect("HOST", "USERNAME", "PASSWORD", "DATABASE NAME")){
    	return $database;
	}
	else {
		echo "<h1>Could Not Connect to Database</h1>";
	}
}

function Query($query){
	$database = ConnectDB();

	if ( !( $result = mysqli_query( $database,$query ) ) )
	{
		print( "Could not execute query! <br />" );
		die( mysqli_error() );
	}
	
	mysqli_close($database);
}

function ReturnQuery($query){
	$database = ConnectDB();
	if ( !( $result = mysqli_query( $database, $query) ) )
        {
            print( "Could not execute query! <br />" );
            die( mysqli_error() );
        }
	return $result;
}

function ReturnIdQuery($query){
	$database = ConnectDB();

	if ( !( $result = mysqli_query( $database,$query ) ) )
	{
		print( "Could not execute query! <br />" );
		die( mysqli_error() );
	}
	else {
		$last_id = mysqli_insert_id($database);
		return $last_id;
	}
	
	mysqli_close($database);
}

?>

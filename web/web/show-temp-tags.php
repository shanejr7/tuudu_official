
<?php include('server.php'); // * server.php gives each new user a special id for oraganzing data through set up process ?>
<?php 

if (isset($_session['ID'])) {
// connect to database
	
$tagID = $_session["ID"];

// ---------------------------------joins iTags with temporarytags table
// 1. gets iTagType from temporarytags user selected and compare to iTags to query iTagName that are subsets of user selection
// 2. gets iTagName related to iTagType from iTags table
// 3. from user with id = ###

// gets server information

// Create connection
//$conn = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
$conn = pg_connect(getenv("DATABASE_URL"));
 //$conn = pg_connect("host=ec2-54-83-23-121.compute-1.amazonaws.com dbname=d191igjs7stcrv user=taqionqfyxisao password=
//f411fd2208dece2d0f6ac32df889fb2b9d1f1e616ade43b8ae73acd30ac7ff32");
// Check connection

if ($res1 = pg_get_result($conn)) {
    die("Connection failed: " .  pg_result_error($res1) );
}

// array to hold items for each row 
$tempArray = array();

// query
$sql = "SELECT DISTINCT temporarytags.itagtype, itags.itagname, temporarytags.tempid FROM temporarytags, itags WHERE temporarytags.itagtype = itags.itagtype AND temporarytags.tempid =$tagID";
$result = pg_query($conn,$sql);
// loops through rows until there is 0 rows
if (pg_num_rows($result) > 0) {
    // output data of each row
    while($row = pg_fetch_assoc($result)) {
      
    	$tempArray[] = array("temporarytags.iTagType" => $row["itagtype"], "itags.iTagName" => $row["itagname"], "temporarytags.tempid"=> $row["tempid"]);



    }
    // if no rows 
} else {
 // echo "0 results";
}


if(!pg_close($conn)){
//failed to connect
}else{
//connected
}


}






?>
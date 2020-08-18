
<?php 

include('server.php');


if (isset($_SESSSION['id'])) {

	
		$tagID = $_SESSSION["id"];


		$conn = pg_connect(getenv("DATABASE_URL"));
 
		// Check connection

		if ($res1 = pg_get_result($conn)) {
    		
    		die("Connection failed: " .  pg_result_error($res1) );
		}

		// holds items for each row
		
		$tempArray = array();

		// query
		
		$sql = "SELECT DISTINCT word_tag.event_type, word_tag.itag FROM word_tag, feedstate WHERE word_tag.event_type = feedstate.word_tag AND feedstate.userid =$tagID";
		
		$result = pg_query($conn,$sql);
		
		// loops through rows until there is 0 rows
		
		if (pg_num_rows($result) > 0) {
    		
    		// output data of each row
    		
    		while($row = pg_fetch_assoc($result)) {
      
    			$tempArray[] = array("event_type" => $row["event_type"], "itag" => $row["itag"]);

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
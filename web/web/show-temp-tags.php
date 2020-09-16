
<?php 
/* DOCS

  * 
  * [word_tag] <selected user tags and related topic tags to be selected from>
  *	show-temp-tags.php --> set-up.php <show users selected tag>
  *
  
*/

include('server.php');

$tempArray = array();

if (isset($_SESSION['id'])) {

	
		$tagID = $_SESSION["id"];


		$conn = pg_connect(getenv("DATABASE_URL"));
 
		// Check connection

		if ($res1 = pg_get_result($conn)) {
    		
    		die("Connection failed: " .  pg_result_error($res1) );
		}


		// query
		
		$sql = "SELECT DISTINCT word_tag.event_type, word_tag.itag FROM word_tag, feedstate WHERE word_tag.event_type = feedstate.word_tag AND feedstate.userid =$tagID LIMIT 20";
		
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
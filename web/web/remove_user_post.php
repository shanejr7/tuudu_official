<?php




if (isset($_POST['id']) && isset($_POST['publickey']) && isset($_POST['time'])) {



		
 		$publickey = "";
 		$userid="";
 		$time = "";
   	    $db ="";
 	
 



 		try{
 	
 			$db = pg_connect(getenv("DATABASE_URL"));
	
			}catch(Execption $e){
 	
 				 header('location:oops.php');
			}

 		$userid = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
 		$publickey = filter_var($_POST['publickey'], FILTER_SANITIZE_STRING);
 		$time = filter_var($_POST['time'], FILTER_SANITIZE_STRING);
 

 				 	pg_query($db, "DELETE FROM messagestate
	WHERE user_id = $userid AND publickey = '$publickey' AND timestamp_message = '$time'");


 		
 		}







?>
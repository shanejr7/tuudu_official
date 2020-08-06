<?php 

include("server.php");

	if (isset($_POST['id']) && isset($_POST['publickey'])) {

    
		$user_id = 0;
		$publickey = "";
		$user_post = "";
		$result ="";
    	$sid= "";






			$db="";


			try{
 	
 			$db = pg_connect(getenv("DATABASE_URL"));
	
			}catch(Execption $e){
 	
 				 header('location:oops.php');
			}


		$publickey = pg_escape_string($db, $_POST['publickey']);
		$publickey = trim($publickey);
		$user_id = pg_escape_string($db, $_POST['id']);


		  if (isset($_SESSION['id'])) {
        
        		$sid = $_SESSION['id']; 
    
    		}
  
      
      pg_query($db, "INSERT INTO public.user_follow_user(user_id, user_following_id) 
        VALUES ($sid, $user_id)");


  

    pg_close($db);

}


    ?>
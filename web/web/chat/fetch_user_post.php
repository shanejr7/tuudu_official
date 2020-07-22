<?php 

// USER POST CHAT DATA

	if (isset($_POST['userID']) && isset($_POST['publickey'])) {

		$publickey = pg_escape_string($db, $_POST['publickey']);
		$user_id = pg_escape_string($db, $_POST['userID']);
		
			$db="";

			try{
 	
 			$db = pg_connect(getenv("DATABASE_URL"));
	
			}catch(Execption $e){
 	
 				 header('location:oops.php');
			}



				$result = pg_query($db, "SELECT C.id as post_id, C.publickey as post_publickey ,C.email as post_email, C.description as post_description, C.date_submitted as post_submitted,Z.id as user_id, Z.email as user_email, Z.publickey as user_publickey,Z.username as user_username FROM organization C ,users Z  WHERE C.id = $user_id  AND C.publickey ='$publickey'  LIMIT 1");
  				
  				$user_post = pg_fetch_assoc($result);
  
  				

  				$data = '<h4 class="card-title">'.$user_post['user_username'].'</h4>
                  <p class="description">'.$user_post['description'].'</p>';



 				pg_close($db);




	}

 

?>
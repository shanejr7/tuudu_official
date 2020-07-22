<?php 

// USER POST CHAT DATA

	if (isset($_POST['id']) && isset($_POST['publickey'])) {

		$user_id = 0;
		$publickey = "";

		$publickey = pg_escape_string($db, $_POST['publickey']);
		$publickey = trim($publickey);
		$user_id = pg_escape_string($db, $_POST['id']);

		echo 'user_id '.$user_id;
		echo "publickey ". $publickey;
		
			$db="";


			try{
 	
 			$db = pg_connect(getenv("DATABASE_URL"));
	
			}catch(Execption $e){
 	
 				 header('location:oops.php');
			}



				$result = pg_query($db, "SELECT C.id as post_id, C.publickey as post_publickey ,C.email as post_email, C.description as post_description, C.date_submitted as post_submitted,Z.id as user_id, Z.email as user_email, Z.publickey as user_publickey,Z.username as user_username FROM organization C ,users Z WHERE C.id = $user_id  AND Z.id =$user_id AND C.publickey ='$publickey'");

  				
  				$user_post = pg_fetch_assoc($result);
  
  				echo "string ".$user_post['user_username'];

  				$data = '<h4 class="card-title">'.$user_post['user_username'].'</h4>
                  <p class="description">'.$user_post['post_description'].'</p>';

                  echo $data;



 				pg_close($db);




	}

 

?>
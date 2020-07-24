<?php 
include("server.php");



	if (isset($_POST['id']) && isset($_POST['publickey'])) {

 
 

		
		$user_id = 0;
		$publickey = "";
		$username = "";

			
		 
		$publickey= filter_var($_POST['publickey'] FILTER_SANITIZE_STRING);
		$publickey = trim($publickey);
		
		if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
				$user_id = $_SESSION['id'];
				$username = $_SESSION['username'];
		}
	 


      echo "string in";
 
				$data.='<a href="#" class="post_comment btn btn-primary btn-round btn-wd float-right"
                  data-userid="'.$user_id.'" data-username="'.$username.'" data-publickey="'.$publickey.'" data-replyid="">Post Comment</a>'

                  echo $data;



 				pg_close($db);




	}

 

?>
 
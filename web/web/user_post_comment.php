<?php




if (isset($_POST['id']) && isset($_POST['publickey']) && isset($_POST['post']) && isset($_POST['username'])) {



		$post = "";
 		$publickey = "";
 		$data =" ";
 		$userid="";
   	    $db ="";
 		$replyid = 0;
 		$username = "";
 		$boolEdit = false;

 		if (isset($_SESSION['id']) && isset($_POST['time'])) {
 			$boolEdit = true;
 		}



 		try{
 	
 			$db = pg_connect(getenv("DATABASE_URL"));
	
			}catch(Execption $e){
 	
 				 header('location:oops.php');
			}



			if ($boolEdit) {
				


 		$userid = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
 		$publickey = filter_var($_POST['publickey'], FILTER_SANITIZE_STRING);
 		$post = filter_var($_POST['post'], FILTER_SANITIZE_STRING);
 		$post = trim($post);
 		$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
 		$username = trim($username);

 		if ($post=== "" || $post=== " ") {

 		}else{

 				 	pg_query($db, "INSERT INTO public.messagestate(
	user_id, message, publickey, reply_to_id, timestamp_message, favorite, username)
	VALUES ($userid, '$post', '$publickey', $replyid, now(), 0, '$username')");
 		

 		}
 		 

 	 

 		$data.='<textarea class="form-control" rows="5" value="" id="postText"></textarea>';


 		echo $data;


			}else{






 		$userid = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
 		$publickey = filter_var($_POST['publickey'], FILTER_SANITIZE_STRING);
 		$post = filter_var($_POST['post'], FILTER_SANITIZE_STRING);
 		$post = trim($post);
 		$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
 		$username = trim($username);
 		$time = filter_var($_POST['time'], FILTER_SANITIZE_STRING);
 		$replyid = filter_var($_POST['replyid'], FILTER_SANITIZE_STRING);

 		if ($post=== "" || $post=== " ") {

 		}else{

 				 	pg_query($db, "UPDATE messagestate
	SET user_id=$userid, message='$post', publickey='$publickey', reply_to_id=$replyid, timestamp_message=now(), favorite=0, username='$username'
	WHERE publickey = '$publickey' AND user_id = $userid AND timestamp_message = '$time' AND reply_to_id = $replyid");
 		

 		}
 		 

 		$data.='<textarea class="form-control" rows="5" value="" id="postText"></textarea>';


 		echo $data;
			}


 
 		}
















?>
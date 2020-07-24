<?php




if (isset($_POST['id']) && isset($_POST['publickey']) && isset($_POST['post']) && isset($_POST['username'])) {



		$post = "";
 		$publickey = "";
 		$data =" ";
 		$userid="";
   	    $db ="";
 		$replyid = 0;
 		$username = "";
 	

 		echo "id ".$_POST['id'];
 		echo "publickey ".$_POST['publickey'];
 		echo "post ".$_POST['post'];
 		echo "username ".$_POST['username'];



 		try{
 	
 			$db = pg_connect(getenv("DATABASE_URL"));
	
			}catch(Execption $e){
 	
 				 header('location:oops.php');
			}

 		$userid = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
 		$publickey = filter_var($_POST['publickey'], FILTER_SANITIZE_STRING);
 		$post = filter_var($_POST['post'], FILTER_SANITIZE_STRING);
 		$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
 		$username = trim($username);

 		pg_query($db, "INSERT INTO public.messagestate(
	user_id, message, publickey, reply_to_id, timestamp_message, favorite, username)
	VALUES ($user_id, '$post', '$publickey', $replyid, now(), 0, '$username')");



 		echo $data;
}















?>
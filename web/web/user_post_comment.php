<?php

include("server.php");


if (isset($_POST['id']) && isset($_POST['publickey']) && isset($_POST['post']) && isset($_POST['username'])) {



		$post = "";
 		$publickey = "";
 		$data =" ";
 		$userid="";
   	    $db ="";
 		$replyid = 0;
 		$username = "";
 		$img_src = "";
 		$img_bool_null = true;
 		$boolEdit = false;

 		if (isset($_POST['time'])) {
 			$boolEdit = true;
 		}

 		if (isset($_SESSION['img_src']) && strlen(trim($_SESSION['img_src'])) >30) {
 			$img_src = trim($_SESSION['img_src']);
 			$img_bool_null = false;
 		}else{
 			$img_bool_null = true;
 		}

 		 


 		try{
 	
 			$db = pg_connect(getenv("DATABASE_URL"));
	
			}catch(Execption $e){
 	
 				 header('location:oops.php');
			}



			if ($boolEdit == false) {
				


 		$userid = pg_escape_string($db, $_POST['id']);
 		$publickey = pg_escape_string($db, $_POST['publickey']);
 		$post = pg_escape_string($db, $_POST['post']);
 		$post = trim($post);
 		$username = pg_escape_string($db, $_POST['username']);
 		$username = trim($username);

 		if (isset($_POST['replyid'])) {
 			$replyid = pg_escape_string($db, $_POST['replyid']);
 		}


 		if ($post=== "" || $post=== " ") {

 		}else{

 			if ($img_bool_null) {
 				pg_query($db, "INSERT INTO public.messagestate(
	user_id, message, publickey, reply_to_id, timestamp_message, favorite, username,src)
	VALUES ($userid, '$post', '$publickey', $replyid, now(), 0, '$username',NULL)")
 				 
 			}else{
pg_query($db, "INSERT INTO public.messagestate(
	user_id, message, publickey, reply_to_id, timestamp_message, favorite, username,src)
	VALUES ($userid, '$post', '$publickey', $replyid, now(), 0, '$username','$img_src')");
 			}

 				 
 		

 		}
 		 

 	 

 		$data.='<textarea class="form-control" rows="5" value="" id="postText"></textarea>';


 		echo $data;


			}else{





		$userid = pg_escape_string($db, $_POST['id']);
 		$publickey = pg_escape_string($db, $_POST['publickey']);
 		$post = pg_escape_string($db, $_POST['post']);
 		$post = trim($post);
 		$username = pg_escape_string($db, $_POST['username']);
 		$username = trim($username);
 		$time = pg_escape_string($db, $_POST['time']);
 		$replyid = pg_escape_string($db, $_POST['replyid']);

 		if ($post=== "" || $post=== " ") {

 		}else if($boolEdit == true){

 				 	pg_query($db, "UPDATE messagestate
	SET user_id=$userid, message='$post', publickey='$publickey', reply_to_id=$replyid, favorite=0, username='$username', src = '$img_src'
	WHERE publickey = '$publickey' AND user_id = $userid AND timestamp_message = '$time' AND reply_to_id = $replyid");
 		

 		}
 		 

 		$data.='<textarea class="form-control" rows="5" value="" id="postText"></textarea>';


 		echo $data;
			}


 
 		}
















?>
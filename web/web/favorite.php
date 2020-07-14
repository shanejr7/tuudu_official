<?php


if (isset($_SESSION['id']) && $_GET['publickey']) {
	  
	  $user_id = "";
	  $user_id = $_SESSION['id'];


	  $db = pg_connect(getenv("DATABASE_URL"));

     // Check connection
     if (!$db) {
        die("Connection failed: " . pg_connect_error());
        header('location:oops.php');
      }

	 $publickey = pg_escape_string($db,trim($_GET['publickey']));



	 // check if user already favorite post
	  $result = pg_query($db, "SELECT * FROM postsate WHERE publickey = '$publickey' AND user_id = $user_id LIMIT 1");

 	  $postsate = pg_fetch_assoc($result);



 	  
 if (!$result) {
 	
 		pg_query($db, "INSERT INTO postsate (user_id, publickey,favorite)
  VALUES($user_id,'$publickey',1)");
  
  

 }elseif($postsate['favorite']==1){

 	 pg_query($db, "UPDATE public.organization
    SET favorite = 0 WHERE publickey = '$publickey' AND user_id= $user_id");

 }else{

 	 pg_query($db, "UPDATE public.organization
    SET favorite = 1 WHERE publickey = '$publickey' AND user_id= $user_id");
   
 }

	 pg_close($db);
}










?>
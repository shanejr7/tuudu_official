<?php
echo "hello<br><br>";

if (isset($_SESSION['id']) && isset($_GET['publickey'])) {
	echo "in";
	  
	  $user_id = "";
	  $user_id = $_SESSION['id'];


	  $db = pg_connect(getenv("DATABASE_URL"));

     // Check connection
     if (!$db) {
        die("Connection failed: " . pg_connect_error());
        header('location:oops.php');
      }

     $publickey = "";
	 $publickey = pg_escape_string($db,$_GET['publickey']);
	 $publickey = trim($publickey);
	 echo "<br>publickey ". $publickey;



	 // check if user already favorite post
	  $result = pg_query($db, "SELECT favorite FROM poststate WHERE publickey = '$publickey' AND user_id = $user_id LIMIT 1");

 	  $poststate = pg_fetch_assoc($result);


 if (pg_num_rows($result) > 0) {

 }		
 	  
 if ($poststate['favorite']==1) {

 	 pg_query($db, "UPDATE poststate
    SET favorite = 0 WHERE publickey = '$publickey' AND user_id= $user_id");
 	
  
  

 }elseif($poststate['favorite']==0){

 		 pg_query($db, "UPDATE poststate
    SET favorite = 1 WHERE publickey = '$publickey' AND user_id= $user_id");
 	

 }elseif($poststate['favorite']==null || !$poststate){

 	pg_query($db, "INSERT INTO poststate (user_id, publickey,favorite)
  VALUES($user_id,'$publickey',1)");


   
 }


	 pg_close($db);
}










?>
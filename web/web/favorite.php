<?php
/* DOCS

  * 
  *
  
*/

// issue may appear getting negative value when unfavoriting 


if (isset($_GET['publickey']) && isset($_SESSION['id'])) {
	  
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



	 // check if user already favorite post
	  $result = pg_query($db, "SELECT favorite FROM poststate WHERE publickey = '$publickey' AND user_id = $user_id LIMIT 1");

 	  $poststate = pg_fetch_assoc($result);


 if (pg_num_rows($result) <= 0) {

 	pg_query($db, "INSERT INTO poststate (user_id, publickey,favorite)
  VALUES($user_id,'$publickey',1)");


  pg_query($db, "UPDATE public.organization
    SET favorites = favorites + 1 
    WHERE publickey = '$publickey'");

 }elseif ($poststate['favorite']==1) {

 	 pg_query($db, "UPDATE poststate
    SET favorite = 0 WHERE publickey = '$publickey' AND user_id= $user_id");
 	
  pg_query($db, "UPDATE public.organization
    SET favorites = favorites - 1 
    WHERE publickey = '$publickey'");
  
  

 }elseif($poststate['favorite']==0){

 		 pg_query($db, "UPDATE poststate
    SET favorite = 1 WHERE publickey = '$publickey' AND user_id= $user_id");

     pg_query($db, "UPDATE public.organization
    SET favorites = favorites + 1 
    WHERE publickey = '$publickey'");
 	

 }elseif($poststate['favorite']==null ){

 	pg_query($db, "INSERT INTO poststate (user_id, publickey,favorite)
  VALUES($user_id,'$publickey',1)");

  pg_query($db, "UPDATE public.organization
    SET favorites = favorites + 1 
    WHERE publickey = '$publickey'");


 }


	 pg_close($db);

   $_SERVER['REQUEST_URI'] = strtok($_SERVER['REQUEST_URI', '?');

   

}












?>
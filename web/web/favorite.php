<?php


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


}


if (isset($_SESSION['id']) && isset($_POST['id']) && isset($_POST['publickey']) && isset($_POST['time']) && isset($_POST['username'])) {


 $db = pg_connect(getenv("DATABASE_URL"));

     // Check connection
     if (!$db) {
        die("Connection failed: " . pg_connect_error());
        header('location:oops.php');
      }

      $publickey = "";
      $user_id = "";
      $time = "";
      $username = "";


      $publickey = pg_escape_string($db,$_POST['publickey']);
      $publickey = trim($publickey);
      $user_id = "";
      $user_id = pg_escape_string($db,$_POST['id']);
      $username = pg_escape_string($db,$_POST['username']);
      $username = trim($username);
      $time = pg_escape_string($db,$_POST['time']);
    






// install user unfavorite later


      pg_query($db, "UPDATE messagestate
    SET favorite = favorite + 1 
    WHERE publickey = '$publickey' AND user_id = $user_id AND timestamp_message = $time ");


   pg_close($db);




}










?>
<?php


include("server.php");

if (isset($_POST['id'])) {




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
      $id= "";


      $publickey = pg_escape_string($db,$_POST['publickey']);
      $publickey = trim($publickey);
      $user_id = "";
      $user_id =$_SESSION['id'];  
      $username = pg_escape_string($db,$_POST['username']);
      $username = trim($username);
      $time = pg_escape_string($db,$_POST['time']);
      $id_post= pg_escape_string($db,$_POST['id']);
      $messagestate = "";
    




   // check if user already favorite message
    $result = pg_query($db, "SELECT * FROM fav_message WHERE publickey = '$publickey' AND user_id = $user_id AND id_post_message = $id_post AND timestamp_message = '$time' LIMIT 1");

    $messagestate= pg_fetch_assoc($result);


 if (pg_num_rows($result) <= 0) {

  pg_query($db, "INSERT INTO fav_message (user_id, timestamp_message, favorite, publickey, id_post_message)
  VALUES ($user_id, '$time', 1, '$publickey', $id_post)");


  pg_query($db, "UPDATE messagestate
    SET favorite = favorite + 1 
   WHERE publickey = '$publickey' AND user_id= $user_id AND timestamp_message = '$time'");

 }elseif ($messagestate['favorite']==1) {

   pg_query($db, "UPDATE fav_message
    SET favorite = 0 WHERE publickey = '$publickey' AND id_post_message=$id_post AND user_id= $user_id AND timestamp_message = '$time'");
  
  pg_query($db, "UPDATE messagestate
    SET favorite = favorite - 1 
    WHERE publickey = '$publickey' AND user_id = $user_id AND  timestamp_message= '$time' ");
  
  

 }elseif($messagestate['favorite']==0){

     pg_query($db, "UPDATE fav_message
    SET favorite = 1 WHERE publickey = '$publickey' AND id_post_message=$id_post AND user_id= $user_id AND timestamp_message = '$time'");

    pg_query($db, "UPDATE messagestate
    SET favorite = favorite + 1 
    WHERE publickey = '$publickey' AND user_id = $user_id AND  timestamp_message= '$time' ");
  

 }elseif($messagestate['favorite']==null ){

  pg_query($db, "INSERT INTO fav_message (user_id, timestamp_message, favorite, publickey, id_post_message)
  VALUES ($user_id, '$time', 1, '$publickey', $id_post)");

  pg_query($db, "UPDATE messagestate
    SET favorite = favorite + 1 
    WHERE publickey = '$publickey' AND user_id = $user_id AND  timestamp_message= '$time' ");


 }



   pg_close($db);




}

?>

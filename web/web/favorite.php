<?php
/* DOCS

  * 
  *
  
*/
include("server.php");


// require('../aws/aws-autoloader.php');
require('../aws/Aws/S3/S3Client.php'); 
require('../aws/Aws/S3/ObjectUploader.php'); 

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\ObjectUploader;

$s3=" ";
$s3 = new Aws\S3\S3Client([
    'version'  => 'latest',
     'region'   => 'us-east-2',
]);

$bucket = getenv('S3_BUCKET')?: header('location:oops.php');
$bucket_name = 'tuudu-official-file-storage';



if (isset($_POST['id']) && isset($_POST['cid']) && isset($_POST['toggle']) && isset($_POST['publickey']) && isset($_SESSION['id'])) {
	  
	  $user_id = "";
	  $user_id = $_SESSION['id'];
    $data="";
    $pid ="";
    $home_list = array();
    $product_list = array();
    $posts_list = array();
    $publickey = "";
    $toggle = "";


	  $db = pg_connect(getenv("DATABASE_URL"));

     // Check connection
     if (!$db) {
        die("Connection failed: " . pg_connect_error());
        header('location:oops.php');
      }

   $pid = pg_escape_string($db,$_POST['id']);
   $css_id = pg_escape_string($db,$_POST['cid']);
   $toggle = pg_escape_string($db,$_POST['toggle']);
	 $publickey = pg_escape_string($db,$_POST['publickey']);
   $css_id = trim($css_id);
	 $publickey = trim($publickey);

// delete user from poststate that unlike posts but did not make that post
   // ajax on profile view when click follow/unfollow
   //click profile view if user page


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


if ($toggle==0) {
  // home profile tab


    $result = pg_query($db, "SELECT DISTINCT favorite FROM poststate WHERE user_id =$user_id AND publickey = '$publickey' LIMIT 1");

   $user = pg_fetch_assoc($result);


                   $data.= '<a href="#postLike'.$css_id.'" class="fav_chat" data-key="'.$publickey.'" data-id="'.$pid.'" data-cid="'.$css_id.'" data-toggle="0">';

                        if ($user['favorite']==1) {
                         $data.= '<i class="material-icons" style="color:red;font-size:18pt;">favorite</i></a>';

                        }else{

                         $data.= '<i class="material-icons" style="font-size:18pt;">favorite</i></a>';
                        }
  
}elseif ($toggle==1) {
  // product profile tab


$result = pg_query($db, "SELECT DISTINCT favorite FROM poststate WHERE user_id =$user_id AND publickey = '$publickey' LIMIT 1");

   $user = pg_fetch_assoc($result);


                   $data.= '<a href="#productLike'.$css_id.'" class="fav_chat" data-key="'.$publickey.'" data-id="'.$pid.'" data-cid="'.$css_id.'" data-toggle="1">';

                        if ($user['favorite']==1) {
                         $data.= '<i class="material-icons" style="color:red;font-size:18pt;">favorite</i></a>';

                        }else{

                         $data.= '<i class="material-icons" style="font-size:18pt;">favorite</i></a>';
                        }

     
  
}else if($toggle ==2){
  // dashboard post tab


   $result = pg_query($db, "SELECT DISTINCT favorite FROM poststate WHERE user_id =$user_id AND publickey = '$publickey' LIMIT 1");

   $user = pg_fetch_assoc($result);


                   $data.= '<a href="#like'.$css_id.'" class="fav_chat" data-key="'.$publickey.'" data-id="'.$pid.'" data-cid="'.$css_id.'" data-toggle="2">';

                        if ($user['favorite']==1) {
                         $data.= '<i class="material-icons" style="color:red;font-size:18pt;">favorite</i></a>';

                        }else{

                         $data.= '<i class="material-icons" style="font-size:18pt;">favorite</i></a>';
                        }

}

     

   echo $data;
	 pg_close($db);


   


}





 /* converts integer month to string*/
function toString(string $month_arr){

if ("01" == trim($month_arr[5].''.$month_arr[6])) {
  return "Jan".' '.$month_arr[8].''.$month_arr[9];
}
if ("02" == trim($month_arr[5].''.$month_arr[6])) {
  return "Feb".' '.$month_arr[8].''.$month_arr[9];
}
if ("03" == trim($month_arr[5].''.$month_arr[6])) {
  return "Mar".' '.$month_arr[8].''.$month_arr[9];
}
if ("04" == trim($month_arr[5].''.$month_arr[6])) {
  return "Apr".' '.$month_arr[8].''.$month_arr[9];
}
if ("05" == trim($month_arr[5].''.$month_arr[6])) {
  return "May".' '.$month_arr[8].''.$month_arr[9];
}
if ("06" == trim($month_arr[5].''.$month_arr[6])) {
  return "Jun".' '.$month_arr[8].''.$month_arr[9];
}
if ("07" == trim($month_arr[5].''.$month_arr[6])) {
  return "Jul".' '.$month_arr[8].''.$month_arr[9];
}
if ("08" == trim($month_arr[5].''.$month_arr[6])) {
  return "Aug".' '.$month_arr[8].''.$month_arr[9];
}
if ("09" == trim($month_arr[5].''.$month_arr[6])) {
  return "Sep".' '.$month_arr[8].''.$month_arr[9];
}
if ("10" == trim($month_arr[5].''.$month_arr[6])) {
  return "Oct".' '.$month_arr[8].''.$month_arr[9];
}
if ("11" == trim($month_arr[5].''.$month_arr[6])) {
  return "Nov".' '.$month_arr[8].''.$month_arr[9];
}
if ("12" == trim($month_arr[5].''.$month_arr[6])) {
  return "Dec".' '.$month_arr[8].''.$month_arr[9];
}
}







?>
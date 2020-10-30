<?php

include("server.php");
include('favorite.php');

 /* DOCS

  * 
  * 
  * <controls view for user profile body >
  *
  
*/

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





if (isset($_POST['id']) && isset($_POST['publickey'])) {

		

		$user_id = 0;
		$publickey = "";
		$user_post = "";
		$result ="";
    	$sid= "";
    	$data="";
    	$user_post_view = array();



    	$db="";


			try{
 	
 			$db = pg_connect(getenv("DATABASE_URL"));
	
			}catch(Execption $e){
 	
 				 header('location:oops.php');
			}


			$publickey = pg_escape_string($db, $_POST['publickey']);
			$publickey = trim($publickey);
			$user_id = pg_escape_string($db, $_POST['id']);

			if (isset($_SESSION['id'])) {
        
        		$sid = $_SESSION['id']; 
    
    		}

    		$data.='hello';




			pg_close($db);


    		  echo $data;


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
<?php 
include("server.php");
// USER POST CHAT DATA  

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
		$username = "";

			$db="";


			try{
 	
 			$db = pg_connect(getenv("DATABASE_URL"));
	
			}catch(Execption $e){
 	
 				 header('location:oops.php');
			}

		$publickey = pg_escape_string($db, $_POST['publickey']);
		$publickey = trim($publickey);
		$user_id = $_SESSION['id'];
		$username = $_SESSION['username'];


          // echo "string id". $user_post['user_id'];
 
				$data.='<a href="#" class="post_comment btn btn-primary btn-round btn-wd float-right"
                  data-userid="'.$user_id.'" data-username="'.$username.'" data-publickey="'.$publickey.'" data-replyid="">Post Comment</a>'

                  echo $data;



 				pg_close($db);




	}

 

?>
 
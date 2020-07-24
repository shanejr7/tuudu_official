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
		$user_post = "";
		$result ="";

			$db="";


			try{
 	
 			$db = pg_connect(getenv("DATABASE_URL"));
	
			}catch(Execption $e){
 	
 				 header('location:oops.php');
			}

		$publickey = pg_escape_string($db, $_POST['publickey']);
		$publickey = trim($publickey);
		$user_id = pg_escape_string($db, $_POST['id']);




				$result = pg_query($db, "SELECT C.id as post_id, C.publickey as post_publickey ,C.email as post_email, C.description as post_description,C.date_submitted as post_submitted,Z.id as user_id, Z.email as user_email, Z.public_key as user_publickey,Z.username as user_username,  Z.profile_pic_src as user_img FROM organization C ,users Z WHERE C.id = $user_id AND Z.id =$user_id AND C.publickey ='$publickey'");

  				
  				$user_post = pg_fetch_assoc($result);

          echo "string id". $user_post['user_id'];
 

  				 $data .= '
                <div class="col-md-2">
                  <div class="card-avatar">
                    <a href="#" class="post_account" data-id="'.$user_post['user_id'].'">';
                    	
                    if (isset($user_post['user_img'])) {
                 		
                 		$user_img = trim($user_post['user_img']);

                         $cmd = $s3->getCommand('GetObject', [
                            'Bucket' => ''.$bucket_name.'',
                            'Key'    => ''.$user_img.'',
                          ]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();

              	$data.='<img class="media-object"  src="'.$presignedUrl.'">';

              }else{

              	$data.='<img class="media-object" src="../../assets/img/image_placeholder.jpg">';
              }
                    
                    $data.='</a>
                    <div class="ripple-container"></div>
                  </div>
                </div>
                <div class="col-md-8">
                  <h4 class="card-title">'.trim($user_post['user_username']).'</h4>
                  <p class="description">'.trim($user_post['post_description']).'</p>
                </div>
                <div class="col-md-2">
                  <button type="button" data-id="'.$user_post['user_id'].'" class="post_follow_user btn btn-default pull-right btn-round">Follow</button>
                </div>';


                  echo $data;



 				pg_close($db);




	}

 

?>
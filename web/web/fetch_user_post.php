<?php 
include("server.php");

/* DOCS

  * 
  * profile.php --> fetch_user_post.php <USER POST CHAT DATA>
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

 
 

		
		$post_id = 0;
		$publickey = "";
		$user_post = "";
		$result ="";
    $sid="";



			$db="";


			try{
 	
 			$db = pg_connect(getenv("DATABASE_URL"));
	
			}catch(Execption $e){
 	
 				 header('location:oops.php');
			}

		$publickey = pg_escape_string($db, $_POST['publickey']);
		$publickey = trim($publickey);
		$post_id = pg_escape_string($db, $_POST['id']);

     if (isset($_SESSION['id'])) {

            $sid = $_SESSION['id'];
      
      }



				$result = pg_query($db, "SELECT C.id as post_id,C.post_type as post_type, C.title as post_title, C.img as post_img, C.publickey as post_publickey ,C.email as post_email, C.description as post_description,C.date_submitted as post_submitted,Z.id as post_id, Z.email as user_email, Z.public_key as user_publickey,Z.username as user_username,  Z.profile_pic_src as user_img FROM organization C ,users Z WHERE C.id = $post_id AND Z.id =$post_id AND C.publickey ='$publickey'");

  				
  				$user_post = pg_fetch_assoc($result);


          // instead select subscription
          $result = pg_query($db, "SELECT * FROM user_follow_organization WHERE userid = $sid AND publickey ='$publickey'");

          $user_subscribe = pg_fetch_assoc($result);
          
          // <div class="media media-post">
          //     <a class="author float-left" href="#pablo">
          //       <div class="avatar">
// <a href="#" class="post_account" data-id="'.$user_post['post_id'].'">
  				 $data .= '
                
                  <div class="media media-post">
              <a class=" float-left" href="#pablo">
                <div class="avatar">';
                    	

                $splitFileString = strtok(trim($user_post["post_img"]), '.' );
                $fileChecker = strtok('');
                $fileChecker = strtoupper($fileChecker);

 

                    if (isset($user_post['post_img']) && ($fileChecker=='JPG' || $fileChecker=='JPEG' || $fileChecker=='PNG')) {
                 		
                 		$user_img = trim($user_post['post_img']);

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
                    
                    $data.='
                    <div class="ripple-container"></div>
                  </div></a>
                </div>
                
                <div class="col-md-8">
                  <h4 class="card-title">'.trim($user_post['post_title']).'</h4>
                  <p class="description">'.trim($user_post['post_description']).'</p>
                  <div class="row">
                  <div class="col-md-1"></div>
                  <div class="col-md-8">';
                  $data.='heyyyyy='.$user_post['post_type'];

                if ($post_id == $sid || ( isset($user_post['post_type']) && strcmp(trim($user_post['post_type']), 'user_post')) ) {

                 

                }elseif($user_subscribe && isset($_SESSION['id'])){

                  $data.='<button type="button" data-pid="'.$post_id.'" data-id="'.$sid.'" data-publickey="'.$publickey.'" class="post_unsubscribe btn btn-danger pull-right btn-round">Subscribed</button>';

                }elseif(!$user_subscribe && isset($_SESSION['id'])){

                  $data.='<button type="button" data-pid="'.$post_id.'" data-id="'.$sid.'" data-publickey="'.$publickey.'" class="post_subscribe btn btn-default pull-right btn-round">Subscribe</button>';

                }


                  $data.='</div>

                  </div>
                </div>';



                // <div class="col-md-2">';
                // if ($post_id == $sid) {

                 

                // }elseif($user_subscribe && isset($_SESSION['id'])){

                //   $data.='<button type="button" data-pid="'.$post_id.'" data-id="'.$sid.'" data-publickey="'.$publickey.'" class="post_unsubscribe btn btn-danger pull-right btn-round">Subscribed</button>';

                // }elseif(!$user_subscribe && isset($_SESSION['id'])){

                //   $data.='<button type="button" data-pid="'.$post_id.'" data-id="'.$sid.'" data-publickey="'.$publickey.'" class="post_subscribe btn btn-default pull-right btn-round">Subscribe</button>';

                // }



                  
                
                // $data.='</div>';


                  echo $data;



 				pg_close($db);




	}

 

?>
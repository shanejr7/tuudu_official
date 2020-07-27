<?php 
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

	if (isset($_POST['id']) && isset($_POST['publickey'])) {

 		$data = "";
 		$publickey = "";
    $editBool = false;
 		$username = "";
 		$userid="";
    $tempid="";
    $db ="";
 		$user_post_id = "";
 		$replyid = 0;
 		$publickey = filter_var($_POST['publickey'], FILTER_SANITIZE_STRING);
 		$publickey = trim($publickey);
    $message = "";
    $time ="";


 			try{
 	
 			$db = pg_connect(getenv("DATABASE_URL"));
	
			}catch(Execption $e){
 	
 				 header('location:oops.php');
			}



      if (isset($_POST['message'])) {

      $tempid = $_SESSION['id'];
      $userid = pg_escape_string($db, $_POST['id']);
      $message = pg_escape_string($db, $_POST['message']);
      $time = pg_escape_string($db, $_POST['time']);
      $username = pg_escape_string($db, $_POST['username']);

      if ($tempid === $userid) {
         $editBool = true;
      }
      
    }

				$user_post_id = pg_escape_string($db, $_POST['id']);


				$result = pg_query($db, "SELECT username FROM users WHERE id = $user_post_id");

  				
  				$user_post = pg_fetch_assoc($result);



 		if (isset($_SESSION['username'])) {
 			$username = $_SESSION['username'];
 		}
 		


 		      if (isset($_SESSION['id']) && $editBool == false) { 

 		      	$userid = $_SESSION['id'];



                $data.=' 
            <div class="media media-post">
              <a class="author float-left" href="#pablo">
                <div class="avatar">';

                    if (isset($_SESSION['img_src'])) {

                  $user_img = trim($_SESSION['img_src']);

                         $cmd = $s3->getCommand('GetObject', [
                            'Bucket' => ''.$bucket_name.'',
                            'Key'    => ''.$user_img.'',
                          ]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();

                   $data.='<img class="media-object" src="'.$presignedUrl.'">';
                  
                }else{
                  $data.='<img class="media-object" src="../assets/img/image_placeholder.jpg">';
                }
                   

                $data.='</div>
              </a>
              <div class="media-body">
                <div class="form-group label-floating bmd-form-group">
                  <label class="form-control-label bmd-label-floating" for="exampleBlogPost"> Comment to '.$user_post['username'].'\'s post..</label>
                  <div id="cleanPost">
                  <textarea class="form-control" rows="5" value="" id="postText"></textarea>
                  </div>
                </div>
                <div class="media-footer">
                  <button type="button" href="#" name="post_comment" class="post_comment btn btn-primary btn-round btn-wd float-right"
                  data-userid="'.$userid.'" data-username="'.$username.'" data-key="'.$publickey.'" data-replyid="'.$replyid.'">Post Comment</button>
                </div>
              </div>
            </div>';
            }else if(isset($_SESSION) && $editBool == true){


                $userid = $_SESSION['id'];



                $data.=' 
            <div class="media media-post">
              <a class="author float-left" href="#pablo">
                <div class="avatar">';

                    if (isset($_SESSION['img_src'])) {

                  $user_img = trim($_SESSION['img_src']);

                         $cmd = $s3->getCommand('GetObject', [
                            'Bucket' => ''.$bucket_name.'',
                            'Key'    => ''.$user_img.'',
                          ]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();

                   $data.='<img class="media-object" src="'.$presignedUrl.'">';
                  
                }else{
                  $data.='<img class="media-object" src="../assets/img/image_placeholder.jpg">';
                }
                   

                $data.='</div>
              </a>
              <div class="media-body">
                <div class="form-group label-floating bmd-form-group">
                  <label class="form-control-label bmd-label-floating" for="exampleBlogPost"> Comment to '.$user_post['username'].'\'s post..</label>
                  <div id="cleanPost">
                  <textarea class="form-control" rows="5"  value="" id="postText">'.trim($message).'</textarea>
                  </div>
                </div>
                <div class="media-footer">
                  <button type="button"   name="edit_comment" class="edit_comment btn btn-primary btn-round btn-wd float-right"
                  data-userid="'.$userid.'" data-username="'.$username.'" data-key="'.$publickey.'" data-replyid="'.$replyid.'" data-time="'.$time.'">Post Comment</button>
                   <button type="button" name="remove_comment" class="remove_comment btn btn-danger btn-round btn-wd float-right"
                  data-userid="'.$userid.'" data-key="'.$publickey.'" data-time="'.$time.'">remove</button>
                  <button type="button" name="back" class="back_post btn btn-warning btn-round btn-wd float-right"
                  data-id="'.$userid.'" data-key="'.$publickey.'">back</button>

                </div>
              </div>
            </div>';


            }
 

		


            	echo $data;


            			pg_close($db);


	}

 

?>
 
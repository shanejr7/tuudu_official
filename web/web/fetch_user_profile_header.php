<?php 

include("server.php");



/* DOCS

  * 
  * 
  * <controls view for user profile header >
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
    	$followingArr = array();


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



				$result = pg_query($db, "SELECT * FROM public.users WHERE id=$user_id LIMIT 1");
  				
  				$user_profile = pg_fetch_assoc($result);

  				$result = pg_query($db, "SELECT COUNT(*) FROM public.users WHERE id IN(SELECT user_following_id FROM user_follow_user WHERE user_id =$sid)");

  				$user_profile_following = pg_fetch_assoc($result);

  				$result = pg_query($db, "SELECT COUNT(*) FROM public.users WHERE id IN(SELECT user_id FROM user_follow_user WHERE user_following_id =$sid)");

  				$user_profile_followers = pg_fetch_assoc($result);


  				if ($user_profile && $user_profile_following && $user_profile_followers) {


  					$img = $user_profile['profile_pic_src'];

  					 $cmd = $s3->getCommand('GetObject', [
                                        'Bucket' => ''.$bucket_name.'',
                                        'Key'    => ''.trim($img).'',
                            ]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();



                $data.= '<div style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
              <div class="avatar" style="width: 120px;">
                <img src="'.$presignedUrl.'" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">'.$user_profil['username'].'</h6> <h16 style="font-size: 12px;"><a href="#" class="unfollow_user_follow_btn" data-userid='.$user_profil['id'].' data-key="dummyString""><span class="material-icons">remove_circle_outline</span></a></h16>
                </div>
            </div>';

  					
  				}
    		
    		  pg_close($db);


    		  echo $data;


}






?>
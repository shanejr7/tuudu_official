<?php

/* DOCS

  * 
  * profile.php --> fetch_user_followers.php <user friend connections>
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


  if (isset($_POST['id']) && isset($_POST['publickey'])) {

    
    $user_id = 0;
    $publickey = "";
    $user_post = "";
    $result ="";
    $sid= "";
    $data= "";

   $followerArr = array();


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


        $result = pg_query($db, "SELECT id as user_id, username, email, profile_pic_src
  FROM users WHERE id IN(SELECT user_id FROM user_follow_user WHERE user_following_id =$sid)");



 if (pg_num_rows($result) > 0) {
                  // output data of each row
                    while($row = pg_fetch_assoc($result)) { 
      
                      $followerArr[] = array("user_id" => $row["user_id"], "username" => $row["username"], "email"=> $row["email"], "img" => $row["profile_pic_src"]);
                  
                  }

}else{

}

              
            if (isset($followerArr)) {
              
              foreach($followerArr as $item) {

                $splitFileString = strtok(trim($item["img"]), '.' );
                $fileChecker = strtok('');
                $fileChecker = strtoupper($fileChecker);

 

          if(strlen(trim($item["img"]))>10 && ($fileChecker=='JPG' || $fileChecker=='JPEG' || $fileChecker=='PNG')){
                 $user_img = trim($item['img']);

                         $cmd = $s3->getCommand('GetObject', [
                            'Bucket' => ''.$bucket_name.'',
                            'Key'    => ''.$user_img.'',
                          ]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();


                $data.= '<div class="profileFollowers media media-post" style="margin-left:15px;margin-top:15px;display: inline-block;  margin-right: 15px;">
              <div class="avatar" >
                <img src="'.$presignedUrl.'" alt="Circle Image" class="media-object">
              </div>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">'.$item['username'].'</h6> <h16 style="font-size: 12px;"><a href="#" class="unfollow_user_follow_btn" data-userid='.$item['user_id'].' data-key="dummyString""><span class="material-icons">remove_circle_outline</span></a></h16>
                </div>
            </div>';
                }else{

                  $data.= '<div class="profileFollowers media media-post" style="margin-left:15px;margin-top:15px;display: inline-block;  margin-right: 15px;">
              <div class="avatar" >
                <img src="../assets/img/image_placeholder.jpg" alt="Circle Image" class="media-object">
              </div>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">'.$item['username'].'</h6> <h16 style="font-size: 12px;">
              <a href="#" class="unfollow_user_follow_btn" data-userid='.$item['user_id'].' data-key="dummyString"><span class="material-icons">remove_circle_outline</span></a></form></h16>
                </div>
            </div>';
                }

                 

            }



            }

            echo $data;
            
             pg_close($db);

          }

?>
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




 		      if (isset($_SESSION['id'])) { 





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
                  <label class="form-control-label bmd-label-floating" for="exampleBlogPost"> Comment to mani_alshars post..</label>
                  <textarea class="form-control" rows="5" id="exampleBlogPost"></textarea>
                </div>
                <div class="media-footer" id="comment_post">
                  <a href="#" class="post_comment btn btn-primary btn-round btn-wd float-right"
                  data-userid="" data-username="" data-publickey="" data-replyid="">Post Comment</a>
                </div>
              </div>
            </div>';
            }
 

		


            	echo $data;


	}

 

?>
 
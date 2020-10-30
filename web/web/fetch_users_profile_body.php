<?php

include("server.php");

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


 // show users posts 
 // copy from dashbaord sql statement
 // 2x2 or 3x3 view of posts



 //  <div class="tab-content tab-space cd-section">

        //  <div class="tab-pane text-center gallery section section-sections">
         //  <div class="row">




 //</div>
 //</div>
 //</div>

 ?>
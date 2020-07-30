<?php 
include 'server.php';
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
  
  $data="";
  $db ="";



try{
 $db = pg_connect(getenv("DATABASE_URL"));
}catch(Execption $e){
  header('location:oops.php');
}
 

 

                if (isset($_SESSION['id'])) {

                  $data = $_SESSION['id'];
                  $result = pg_query($db, "SELECT * FROM users id =$data LIMIT 1");
                  $user = pg_fetch_assoc($result);

                  $user_img = trim($user['profile_pic_src']);



                         $cmd = $s3->getCommand('GetObject', [
                            'Bucket' => ''.$bucket_name.'',
                            'Key'    => ''.$user_img.'',
                          ]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();
                  $data.= '<img src="'.$presignedUrl.'" title="edit" alt="Circle Image" class="img-raised rounded-circle img-fluid">';
                  
                }else{
                  $data.= '<img src="../assets/img/image_placeholder.jpg" title="edit"  alt="Circle Image" class="img-raised rounded-circle img-fluid">';
                }


          
   
              echo $data;

pg_close($db);

?>


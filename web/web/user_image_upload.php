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
 

 if (isset($_SESSION['id']) {
  

$userid = $_SESSION['id'];
$randomString = " ";


//stores file to aws S3
if(isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['file']['tmp_name'])) {

    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
   
    $n = 15;
  
    for ($i = 0; $i < $n; $i++) { 
        $index = rand(0, strlen($characters) - 1); 
        $randomString .= $characters[$index]; 
    } 
 
$source = fopen($_FILES['file']['tmp_name'], 'rb');
$key =  "user_profile_img/".$randomString.''. $_FILES['file']['name']; 

$destination = $key;

    $uploader = new ObjectUploader(
    $s3,
    $bucket_name,
    $key,
    $source 
);
    try
{
    // echo 'Attempting to delete ' . $keyname . '...' . PHP_EOL;


$keyname = "";
if (isset($_SESSION['img_src'])) {
  $keyname = trim($_SESSION['img_src']);
}

$result = pg_query($db, "UPDATE public.users SET profile_pic_src=null WHERE id = $userid");

    $result = $s3->deleteObject([
        'Bucket' => $bucket_name,
        'Key'    => $keyname
    ]);

    if ($result['DeleteMarker'])
    {
        // echo $keyname . ' was deleted or does not exist.' . PHP_EOL;
    } else {
        // exit('Error: ' . $keyname . ' was not deleted.' . PHP_EOL);
    }
}
catch (S3Exception $e) {
    // exit('Error: ' . $e->getAwsErrorMessage() . PHP_EOL);
}

// 2. Check to see if the object was deleted.
// try
// {
//     // echo 'Checking to see if ' . $keyname . ' still exists...' . PHP_EOL;

//     // $result = $s3->getObject([
//     //     'Bucket' => $bucket,
//     //     'Key'    => $keyname
//     // ]);

//     // echo 'Error: ' . $keyname . ' still exists.';
// }
// catch (S3Exception $e) {
//     exit($e->getAwsErrorMessage());
// } 
   
    try {
       
        $upload = $uploader->upload($bucket, $destination, fopen($_FILES['file']['tmp_name'], 'rb'), 'public-read');

          $image_src = $destination;

          unset($_SESSION['img_src']);

          $_SESSION['img_src'] = $destination;



            // update user image
            pg_query($db,"UPDATE users SET profile_pic_src ='$image_src' WHERE id= $userid ");
 



          


            } catch(Exception $e){
               header('location:oops.php');
          }

}else{
 
}

}

                if (isset($_POST['data'])) {

                  $data = $_SESSION['id'];
                  $result = pg_query($db, "SELECT * FROM users WHERE id =$data LIMIT 1");
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


<?php 

include("server.php");

/* DOCS

  * 
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


if (!isset($_SESSION['username'])) {
 
   header('location: login-page.php');
  }


if (isset($_POST['imagePost']) && isset($_SESSION['id'])) {
  

$userid = $_SESSION['id'];
$randomString = " ";
$user_name ="";


if (isset($_SESSION['username'])) {
  $user_name = trim($_SESSION['username']);
}


//stores file to aws S3
if(isset($_FILES['file1']) && $_FILES['file1']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['file1']['tmp_name'])) {

	     try{

 		$db = pg_connect(getenv("DATABASE_URL"));
			}catch(Execption $e){
 		 header('location:oops.php');
			}

	$file_temp = pg_escape_string($db, $_FILES['file1']['tmp_name']);
	$file_name = pg_escape_string($db, $_FILES['file1']['name']);
  $title = trim(pg_escape_string($db, $_POST['title']));

    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
   
    $n = 15;
  
    for ($i = 0; $i < $n; $i++) { 
        $index = rand(0, strlen($characters) - 1); 
        $randomString .= $characters[$index]; 
    } 

    $randomString = trim($randomString);
 
$source = fopen($file_temp, 'rb');
$key =  "user_profile_post/".$randomString.''. $file_name; 

$destination = $key;

    $uploader = new ObjectUploader(
    $s3,
    $bucket_name,
    $key,
    $source 
);


    // delete post
//     try
// {
//     // echo 'Attempting to delete ' . $keyname . '...' . PHP_EOL;

// $keyname = "";
// if (isset($_SESSION['img_src'])) {
//   $keyname = trim($_SESSION['img_src']);
// }

// $result = pg_query($db, "UPDATE public.users SET profile_pic_src=null WHERE id = $userid");
// $result = pg_query($db, "UPDATE public.messagestate SET src=null WHERE user_id = $userid");

//     $result = $s3->deleteObject([
//         'Bucket' => $bucket_name,
//         'Key'    => $keyname
//     ]);

//     if ($result['DeleteMarker'])
//     {
//         // echo $keyname . ' was deleted or does not exist.' . PHP_EOL;
//     } else {
//         // exit('Error: ' . $keyname . ' was not deleted.' . PHP_EOL);
//     }
// }
// catch (S3Exception $e) {
//     // exit('Error: ' . $e->getAwsErrorMessage() . PHP_EOL);
// }

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
       
        $upload = $uploader->upload($bucket, $destination, fopen($file_temp, 'rb'), 'public-read');

          $image_src = $destination;

            // update user image

            pg_query($db,"INSERT INTO public.poststate(user_id, publickey, favorite, message,type)VALUES ($userid, '$randomString', 0, '$title','user_post')");


            pg_query($db,"INSERT INTO public.organization(word_tag, id, title, organization_name, phonenumber, email, address, date, url, img, description, content, publickey, privatekey, fiatvalue, views, date_submitted, payment_type, favorites, post_type, story_key, amount, size) VALUES (NULL, $userid, '$user_name', NULL, NULL, NULL, NULL, NULL, NULL, '$destination', '$title', NULL, '$randomString', NULL, NULL, 0, NOW(), NULL, 0, 'user_post', NULL, NULL, NULL)");



            } catch(Exception $e){
               header('location:oops.php');
          }

}else{
 
}

pg_close($db);

header('location:profile.php');

}

?>
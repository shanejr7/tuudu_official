<?php
/* DOCS

  * removes users posts
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



if (isset($_SESSION['id']) && isset($_GET['publickey'])) {
	

	  $user_id = "";
	  $user_id = $_SESSION['id'];


	  $db = pg_connect(getenv("DATABASE_URL"));

     // Check connection
     if (!$db) {
        die("Connection failed: " . pg_connect_error());
        header('location:oops.php');
      }

   	 $publickey = "";
	 $publickey = pg_escape_string($db,$_GET['publickey']);
	 $publickey = trim($publickey);


	 // select image location for posts
	  $result = pg_query($db, "SELECT img FROM organization WHERE publickey='$publickey' AND id=$user_id LIMIT 1");
  	  $user = pg_fetch_assoc($result);



// removing user post

	     try
{
    // echo 'Attempting to delete ' . $keyname . '...' . PHP_EOL;

$keyname = "";

if ($user) {

	$keyname = trim($user['img']);
}




// check any where else that stores data for posts


// remove post image from aws s3


    $result = $s3->deleteObject([
        'Bucket' => $bucket_name,
        'Key'    => $keyname
    ]);

    if ($result['DeleteMarker'])
    {
        // echo $keyname . ' was deleted or does not exist.' . PHP_EOL;

        // remove post assocications in db

$result = pg_query($db, "DELETE FROM public.organization WHERE id = $user_id AND publickey = '$publickey'");
$result = pg_query($db, "DELETE FROM public.poststate WHERE publickey = '$publickey'");
$result = pg_query($db, "DELETE FROM public.favorite WHERE publickey = '$publickey'");
$result = pg_query($db, "DELETE FROM public.messagestate WHERE publickey = '$publickey'");

    } else {
        // exit('Error: ' . $keyname . ' was not deleted.' . PHP_EOL);
    }
}
catch (S3Exception $e) {
    // exit('Error: ' . $e->getAwsErrorMessage() . PHP_EOL);
}



	  pg_close($db);


	  header('location:profile.php');



}


?>
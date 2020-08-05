<?php 

include("server.php");

if (!isset($_SESSION['username'])) {
 
   header('location: login-page.php');
  }


if (isset($_POST['image']) && isset($_SESSION['id'])) {
  

$userid = $_SESSION['id'];
$randomString = " ";


//stores file to aws S3
if(isset($_FILES['file1']) && $_FILES['file1']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['file1']['tmp_name'])) {

	     try{

 		$db = pg_connect(getenv("DATABASE_URL"));
			}catch(Execption $e){
 		 header('location:oops.php');
			}

	$file_temp = pg_escape_string($db, $_FILES['file1']['tmp_name']);
	$file_name = pg_escape_string($db, $_FILES['file1']['name']);

    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
   
    $n = 15;
  
    for ($i = 0; $i < $n; $i++) { 
        $index = rand(0, strlen($characters) - 1); 
        $randomString .= $characters[$index]; 
    } 

 
$source = fopen($file_temp, 'rb');
$key =  "user_profile_img/".$randomString.''. $file_name; 

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
       
        $upload = $uploader->upload($bucket, $destination, fopen($file_temp, 'rb'), 'public-read');

          $image_src = $destination;

          unset($_SESSION['img_src']);

          $_SESSION['img_src'] = $destination;

 
            $db = pg_connect(getenv("DATABASE_URL"));
            // Check connection
            if (!$db) {
              die("Connection failed: " . pg_connect_error());
              header('location:oops.php');
            }

            // update user image
            pg_query($db,"UPDATE users SET profile_pic_src ='$image_src' WHERE id= $userid ");

          


            } catch(Exception $e){
               header('location:oops.php');
          }

}else{
 
}

pg_close($db);

header('location:profile.php');

}

?>
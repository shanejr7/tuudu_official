<?php 
 
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

$bucket = getenv('S3_BUCKET')?: die('No "S3_BUCKET" config var in found in env!');
$bucket_name = 'tuudu-official-file-storage';
$key = ' ';
 
	if (isset($_POST["add_cart"])) {

     // Create connection
 //  $db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
 
     $db = pg_connect(getenv("DATABASE_URL"));

     $timezone = pg_escape_string($db, $_POST['timezone']);
 
     $timezone = explode(" ", $timezone);
     $timezone_str =  date('Y-m-d',strtotime($timezone[1].' '.$timezone[2].' '.$timezone[3]));
     $timezone_str = $timezone_str .' '.$timezone[4];

     $zone = substr($timezone[6],1,1).''.substr($timezone[7],0,1).''.substr($timezone[8],0,1);

     date_default_timezone_set($zone);

     $O = explode("-", $timezone[5]);
 

     $timezone_str = $timezone_str.''.date("O", strtotime($O[1]));

   $id = pg_escape_string($db, $_SESSION['id']);
   $organization_publickey = trim(pg_escape_string($db, $_POST['publickey']));
   $org_id = pg_escape_string($db, $_POST['org_id']);
   $ticket_amt = pg_escape_string($db, $_POST['ticket_amount']);
   $title = trim(pg_escape_string($db, $_POST['eventTitle']));
   $price = doubleval(pg_escape_string($db, $_POST['price']));
   $price = $price * doubleval($ticket_amt);

   $tax = doubleval(pg_escape_string($db,0.06));
   $total =0;
   if ($price>=1) {
    $tax = $tax * $price;
   }else{
    $tax = 0;
   }
    
    $total = $price + $tax;

    $total = number_format($total,2);

 
  


 
 
   // Check connection
    if ($res1 = pg_get_result($db)) {
    die("Connection failed: " .  pg_result_error($res1) );
    }
 // removes duplicate from refreshing page 
 $query = "DELETE FROM cart WHERE user_id = $id AND publickey = '$organization_publickey'";
 pg_query($db, $query);

// insert selected value


 $query = "INSERT INTO cart (user_id,org_id,publickey,ticket_amount,price,product_title,date_submitted) 
          VALUES($id,$org_id,'$organization_publickey',$ticket_amt,$total,'$title','$timezone_str')";

   pg_query($db, $query);


 

pg_close($db);
}

if (isset($_GET["purchased"])) {

      // Create connection
   $db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");


   $id = pg_escape_string($db, $_GET['purchased']);

   $query = "SELECT * FROM cart WHERE user_id = $id  ";
   $result = pg_query($db, $query);   
   $user_cart = pg_fetch_assoc($result);
 


  
   $organization_publickey = trim(pg_escape_string($db,$user_cart["publickey"]));
   $org_id = pg_escape_string($db,$user_cart["org_id"]);
   $ticket_amt = intval(pg_escape_string($db,$user_cart["ticket_amount"]));
   $title = trim(pg_escape_string($db,$user_cart["product_title"]));
   $price = doubleval(pg_escape_string($db,$user_cart["price"]));
 
   $price = number_format($price,2);


 
   $query = "INSERT INTO temporary_tag_schedule (user_id, org_id,publickey,ticket_amount,price,product_title) 
          VALUES($id,$org_id,'$organization_publickey',$ticket_amt,$price,'$title')";

   pg_query($db, $query);






   $organization_id = $user_cart['org_id'];

   // insert unique ID 
   $query = "SELECT email,payment_type FROM organization WHERE id = $organization_id  ";
   $result = pg_query($db, $query);   
   $organization_info = pg_fetch_assoc($result);

  $email = trim(pg_escape_string($db,$organization_info["email"]));
  $total = $price - ($price *5%);
  $currency = 'USD';
  $message = 'payment received'
  $payment_type = trim(pg_escape_string($db,$organization_info["payment_type"]));
  date_default_timezone_set('UTC');
  $time = date('c');

      $query = "INSERT INTO csv_web_payouts (email,total,currency,ID,message,payment_type,date_submitted) 
          VALUES('$email','$total','$currency',$organization_id,'$message','$payment_type','$time')";
 

   pg_query($db, $query);



$list = array (
  array($email, $total ,$currency, $organization_id,$message,$payment_type,$time)
);

$file = fopen("csv_web_payouts.csv","w");

foreach ($list as $line) {
  fputcsv($file, $line);
}

fclose($file);



$source = fopen($file, 'rb');
$key =  "web-payments/". $file; 

$destination = $key;

    $uploader = new ObjectUploader(
    $s3,
    $bucket_name,
    $key,
    $source 
);

try{
   $upload = $uploader->upload($bucket, $destination, fopen($file, 'public-read');
}catch(Execption $e){

}






   $query = "DELETE FROM cart WHERE user_id = $id";
   pg_query($db, $query);


   pg_close($db);


  header("location:profile.php");

}


?>
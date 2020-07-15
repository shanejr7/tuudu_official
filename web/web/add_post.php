<?php 
 
 if (!isset($_SESSION['username'])) {
 
   header('location: login-page.php');
  }


if (isset($_POST['push'])) {
  
 $publickey = $_SESSION['publicKey'];
 $userid = $_SESSION['id'];

 //$db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
// insert into 
$db = pg_connect(getenv("DATABASE_URL")); 

// Check connection
if (!$db) {
     die("Connection failed: " . pg_connect_error());
     header('location:oops.php');
}

$privateKey =filter_var('AbJeJTEuJru1mwZbO5mokcBkwwjWEKX_9O-k5mgXSAC8u81zjPk26Rqo9eEkixQTbZAqq11VhvjmtczB', FILTER_SANITIZE_STRING); // secret key payment for block
$paymentType =filter_var($_POST['paymentType'], FILTER_SANITIZE_STRING); // value of block
 
$fiatValue =doubleval(filter_var($_POST['fiatValue'], FILTER_SANITIZE_STRING)); // value of block
 
    $timezone = pg_escape_string($db, $_POST['timezone']);
  


  
    $timezone = explode(" ", $timezone);
    $timezone_str =  date('Y-m-d',strtotime($timezone[1].' '.$timezone[2].' '.$timezone[3]));
    $timezone_str = $timezone_str .' '.$timezone[4];

    $zone = substr($timezone[6],1,1).''.substr($timezone[7],0,1).''.substr($timezone[8],0,1);

    date_default_timezone_set($zone);

    $O = explode("-", $timezone[5]);
 

    $timezone_str = $timezone_str.''.date("O", strtotime($O[1]));

    $timestamp = $timezone_str;
 
    $paymentType = strtoupper(trim($paymentType));

    $fiatValue = number_format($fiatValue,2);

    if (strcmp($paymentType,'PAYPAL')) {
        
    }else if(strcmp($paymentType,'VENMO')){

    }else{
        $paymentType = 'PAYPAL';
    }
 

 
 
    pg_query($db, "UPDATE public.organization SET privatekey='$privateKey', fiatvalue='$fiatValue', views= 0, date_submitted ='$timestamp', payment_type = '$paymentType' WHERE publickey = '$publickey' AND id =$userid");
 


 // have a prompt confirming submission of event
    // when string start with it
    				// use ="e.$val" to get pop up for submission if wanted
                  // $val = random_str(12, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
 header('location: dashboard.php');
 
}elseif (isset($_POST['push_no_payment'])) {

$publickey = $_SESSION['publicKey'];
$userid = $_SESSION['id'];

//$db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
// insert into 
$db = pg_connect(getenv("DATABASE_URL"));

// Check connection
if (!$db) {
     die("Connection failed: " . pg_connect_error());
     header('location:oops.php');
}

$privateKey =filter_var('null', FILTER_SANITIZE_STRING); // secret key payment for block
$privateKey = ltrim($privateKey," ");
$fiatValue =filter_var('0.00', FILTER_SANITIZE_STRING); // value of block

	$timezone = pg_escape_string($db, $_POST['timezone']);
  


  
    $timezone = explode(" ", $timezone);
    $timezone_str =  date('Y-m-d',strtotime($timezone[1].' '.$timezone[2].' '.$timezone[3]));
    $timezone_str = $timezone_str .' '.$timezone[4];

    $zone = substr($timezone[6],1,1).''.substr($timezone[7],0,1).''.substr($timezone[8],0,1);

    date_default_timezone_set($zone);

    $O = explode("-", $timezone[5]);
 

    $timezone_str = $timezone_str.''.date("O", strtotime($O[1]));

    $timestamp = $timezone_str;
  

    pg_query($db, "UPDATE public.organization SET privatekey='$privateKey', fiatvalue='$fiatValue', views= 0, date_submitted ='$timestamp', payment_type = 'n/a' WHERE publickey = '$publickey' AND id =$userid");

 				// use val "=e.val."  to get pop up for submission if wanted
               // $val = random_str(12, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
               
 header('location: dashboard.php');

 
}

?>



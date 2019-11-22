<?php 
 
 if (!isset($_SESSION['username'])) {
 
   header('location: login-page.php');
  }


if (isset($_POST['push'])) {
  
 $publickey = $_SESSION['publicKey'];
 $userid = $_SESSION['id'];

$privateKey =filter_var($_POST['privatekey'], FILTER_SANITIZE_STRING); // secret key payment for block
 
$fiatValue =filter_var($_POST['fiatValue'], FILTER_SANITIZE_STRING); // value of block
 
$timestamp = date('c');
 
 

// $db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
// insert into 
$db = pg_connect(getenv("DATABASE_URL"));
    pg_query($db, "UPDATE public.organization SET privatekey='$privateKey', fiatvalue='$fiatValue', views= 0, date_submitted ='$timestamp' WHERE publickey = '$publickey' AND id =$userid");
 


 // have a prompt confirming submission of event
    // when string start with it
    				// use ="e.$val" to get pop up for submission if wanted
                  $val = random_str(12, '0123456789abcdfghijklmnopqrstuvwxyz');
 header('location: profile.php?dashboard='.$val.'');
 
}elseif (isset($_POST['push_no_payment'])) {

$publickey = $_SESSION['publicKey'];
$userid = $_SESSION['id'];

$privateKey =filter_var('null', FILTER_SANITIZE_STRING); // secret key payment for block
$privateKey = ltrim($privateKey," ");
$fiatValue =filter_var('0.00', FILTER_SANITIZE_STRING); // value of block
$timestamp = date('c');

 


// $db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
// insert into 
$db = pg_connect(getenv("DATABASE_URL"));

    pg_query($db, "UPDATE public.organization SET privatekey='$privateKey', fiatvalue='$fiatValue', views= 0, date_submitted ='$timestamp' WHERE publickey = '$publickey' AND id =$userid");

 				// use val "=e.val."  to get pop up for submission if wanted
               $val = random_str(12, '0123456789abcdfghijklmnopqrstuvwxyz');
               
 header('location: profile.php?dashboard='.$val.'');

 
}

?>



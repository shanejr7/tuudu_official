<?php 
 
 // if any post are removed then remove from poststate 

 if (!isset($_SESSION['username'])) {
 
   header('location: login-page.php');
  }


if (isset($_POST['push'])) {
  
 $publickey = $_SESSION['publicKey'];
 $userid = $_SESSION['id'];

 
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
 
    $eventType = pg_escape_string($db, $_POST['e_type']);
  
 
    $paymentType = strtoupper(trim($paymentType));

    $fiatValue = number_format($fiatValue,2);

    if (strcmp($paymentType,'PAYPAL')) {
        
    }else if(strcmp($paymentType,'VENMO')){

    }else{
        $paymentType = 'PAYPAL';
    }
 

 
 
    pg_query($db, "UPDATE public.organization SET privatekey='$privateKey', fiatvalue='$fiatValue', views= 0, date_submitted =NOW(), payment_type = '$paymentType', favorites = 0 WHERE publickey = '$publickey' AND id =$userid");

      pg_query($db, "INSERT INTO poststate (user_id, publickey,favorite,message)
  VALUES($userid,'$publickey',0,NULL)");

      pg_query($db, "UPDATE public.word_tag SET post_amt =post_amt + 1 WHERE event_type = 'eventType' ");
 



 header('location: dashboard.php');
 
}elseif (isset($_POST['push_no_payment'])) {

$publickey = $_SESSION['publicKey'];
$userid = $_SESSION['id'];


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
$eventType = pg_escape_string($db, $_POST['e_type']);
  

  

    pg_query($db, "UPDATE public.organization SET privatekey='$privateKey', fiatvalue='$fiatValue', views= 0, date_submitted =NOW(), payment_type = 'n/a', favorites =0 WHERE publickey = '$publickey' AND id =$userid");

    pg_query($db, "INSERT INTO poststate (user_id, publickey,favorite,message)
  VALUES($userid,'$publickey',0,NULL)");

     pg_query($db, "UPDATE public.word_tag SET post_amt =post_amt + 1 WHERE event_type = 'eventType'");

               
 header('location: dashboard.php');

 
}

?>



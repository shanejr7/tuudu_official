<?php 
 
/* DOCS

  * 
  * [organization] <inserts and updates new post>
  * [postate] <adds postate for messenger and favorite count>
  * [word_tag] <analysis count on event type posted>
  * post.php --> add_post.php <adds new post data>
  * <if any post are removed then remove from poststate and subtract event post_amt -1> 
  *
  *
  
*/

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

// $privateKey =filter_var('AbJeJTEuJru1mwZbO5mokcBkwwjWEKX_9O-k5mgXSAC8u81zjPk26Rqo9eEkixQTbZAqq11VhvjmtczB', FILTER_SANITIZE_STRING); // secret key payment for blockpaymentEmail
$privateKey =filter_var($_POST['paymentID'], FILTER_SANITIZE_STRING); // value of block// secret key payment for block
$paymentType =filter_var($_POST['paymentType'], FILTER_SANITIZE_STRING); // value of block
 
$fiatValue =doubleval(filter_var($_POST['fiatValue'], FILTER_SANITIZE_STRING)); // value of block

$post_amt =filter_var($_POST['amount'], FILTER_SANITIZE_STRING);
 
    $eventType = trim(pg_escape_string($db, $_POST['e_type']));
    $eventTags = pg_escape_string($db, $_POST['e_tags']);
  
 
    $paymentType = strtoupper(trim($paymentType));

    $fiatValue = number_format($fiatValue,2);

    if (strcmp($paymentType,'PAYPAL')) {
        
    }else if(strcmp($paymentType,'VENMO')){

    }else{
        $paymentType = 'PAYPAL';
    }
 

 
 
    pg_query($db, "UPDATE public.organization SET privatekey='$privateKey', fiatvalue='$fiatValue', views= 0, date_submitted =NOW(), payment_type = '$paymentType', favorites = 0, amount = '$post_amt' WHERE publickey = '$publickey' AND id =$userid");

      pg_query($db, "INSERT INTO poststate (user_id, publickey,favorite,message)
  VALUES($userid,'$publickey',0,NULL)");

      pg_query($db, "UPDATE public.word_tag SET post_amt =post_amt + 1 WHERE event_type = '$eventType' ");

       for ($i=0; $i <sizeof($tags) ; $i++) { 
        
          
            $result = pg_query($db, "SELECT * FROM itag_rank WHERE itag=trim('$tags[$i]') LIMIT 1");
              
              $itag_rank = pg_fetch_assoc($result);

              if (pg_num_rows($result)>0) {
                
                   pg_query($db, "UPDATE public.itag_rank SET post_amt = post_amt + 1 
                    WHERE itag = trim('$tags[$i]')");

              }
            }
 



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

$privateKey =filter_var('null', FILTER_SANITIZE_STRING); // secret key payment for post
$privateKey = ltrim($privateKey," ");
$fiatValue =filter_var('0.00', FILTER_SANITIZE_STRING); // value of post
$eventType = trim(pg_escape_string($db, $_POST['e_type']));
$eventTags = pg_escape_string($db, $_POST['e_tags']);
$post_amt ='unlimited';
  

  

    pg_query($db, "UPDATE public.organization SET privatekey='$privateKey', fiatvalue='$fiatValue', views= 0, date_submitted =NOW(), payment_type = 'n/a', favorites =0, amount = '$post_amt' WHERE publickey = '$publickey' AND id =$userid");

    pg_query($db, "INSERT INTO poststate (user_id, publickey,favorite,message)
  VALUES($userid,'$publickey',0,NULL)");

     pg_query($db, "UPDATE public.word_tag SET post_amt =post_amt + 1 WHERE event_type = '$eventType'");

       for ($i=0; $i <sizeof($tags) ; $i++) { 
        
          
            $result = pg_query($db, "SELECT * FROM itag_rank WHERE itag=trim('$tags[$i]') LIMIT 1");
              
              $itag_rank = pg_fetch_assoc($result);

              if (pg_num_rows($result)>0) {
                
                   pg_query($db, "UPDATE public.itag_rank SET post_amt = post_amt + 1 
                    WHERE itag = trim('$tags[$i]')");

              }
            }

               
 header('location: dashboard.php');

 
}

?>



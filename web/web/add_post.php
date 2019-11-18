<?php 
 
// organization portal make secure sumbmission
// use id as hash for unique iElement tracking
// give org special id string login
// send confirmation email to org if trying to sign on 

//org can use existing itag or create/search a new one for the specific event
if (isset($_POST['push'])) {
	

 
// $event_type =filter_var($_POST['event_type'], FILTER_SANITIZE_STRING); 
// $word_tag =filter_var($_POST['word_tags'], FILTER_SANITIZE_STRING); 
// $id =filter_var($_POST['id'], FILTER_SANITIZE_STRING); 
// $name =filter_var($_POST['name'], FILTER_SANITIZE_STRING); 
// $title =filter_var($_POST['title'], FILTER_SANITIZE_STRING); 
// $phoneNumber =filter_var($_POST['phoneNumber'], FILTER_SANITIZE_STRING);
// $email =filter_var($_POST['email'], FILTER_SANITIZE_STRING);  
// $address =filter_var($_POST['address'], FILTER_SANITIZE_STRING); 
// $date  =filter_var($_POST['date'], FILTER_SANITIZE_STRING);  
// $time =filter_var($_POST['time'], FILTER_SANITIZE_STRING);  
// $url =filter_var($_POST['url'], FILTER_SANITIZE_STRING);  
 
// $description =filter_var($_POST['description'], FILTER_SANITIZE_STRING);  
// $content =filter_var($_POST['content'], FILTER_SANITIZE_STRING); 
 
 
// generate random string..this key will be used for voting analysis and displayed on each block
// if removed the user is still linked to the itag of the host for future post but this specific block is removed 
 $publickey = $_SESSION['publicKey'];
 $userid = $_SESSION['id'];

$privateKey =filter_var($_POST['privatekey'], FILTER_SANITIZE_STRING); // secret key payment for block
// $privateKey = ltrim($privateKey," ");
$fiatValue =filter_var($_POST['fiatValue'], FILTER_SANITIZE_STRING); // value of block
// $word_tag = $event_type.'_'.str_replace(" ","/",$word_tag);
// $publickey =filter_var($_POST['publicKey'], FILTER_SANITIZE_STRING); // value of block
// $userid =filter_var($_POST['id'], FILTER_SANITIZE_STRING); // value of block
$timestamp = date('c');
 
echo $timestamp;

$db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
// insert into 

    pg_query($db, "UPDATE public.organization SET privatekey='$privateKey', fiatvalue='$fiatValue', views= 0, date_submitted ='$timestamp' WHERE publickey = '$publickey' AND id =$userid");
 

 
 
  // unset($_SESSION["event_type"]);
  //   unset($_SESSION["word_tags"]);
  //   unset($_SESSION["eventTitle"]);
  //   unset($_SESSION["phoneNumber"]);
  //   unset($_SESSION["publicKey"]);
  //   unset($_SESSION["privateKey"]);
  //   unset($_SESSION["img_src"]);
  //   unset($_SESSION["address"]);
  //   unset($_SESSION["date"]);
  //   unset($_SESSION["startTime"]);
  //   unset($_SESSION["endTime"]);
  //   unset($_SESSION["url"]);
  //   unset($_SESSION["email_temp"]);
  //   unset($_SESSION["content"]);
  //   unset($_SESSION["description"]);
  //   unset($_SESSION["name"]);
 
                  $val = random_str(12, '0123456789abcdefghijklmnopqrstuvwxyz');
 header('location: profile.php?dashbaord='.$val.'');

}elseif (isset($_POST['push_no_payment'])) {



// $event_type =filter_var($_POST['itype'], FILTER_SANITIZE_STRING); 
// $word_tag =filter_var($_POST['word_tags'], FILTER_SANITIZE_STRING); 
// $id =filter_var($_POST['id'], FILTER_SANITIZE_STRING); 
// $name =filter_var($_POST['name'], FILTER_SANITIZE_STRING); 
// $title =filter_var($_POST['title'], FILTER_SANITIZE_STRING); 
// $phoneNumber =filter_var($_POST['phoneNumber'], FILTER_SANITIZE_STRING);
// $email =filter_var($_POST['email'], FILTER_SANITIZE_STRING);  
// $address =filter_var($_POST['address'], FILTER_SANITIZE_STRING); 
// $date  =filter_var($_POST['date'], FILTER_SANITIZE_STRING);  
// $time =filter_var($_POST['time'], FILTER_SANITIZE_STRING);  
// $url =filter_var($_POST['url'], FILTER_SANITIZE_STRING);   
// $description =filter_var($_POST['description'], FILTER_SANITIZE_STRING);  
// $content =filter_var($_POST['content'], FILTER_SANITIZE_STRING); 



// $date = ltrim($date," ");
// $date = explode(" ",$date);
// $date[0] = ltrim($date[0]," ");
// $date[1] = ltrim($date[1]," ");
// $date[2] = ltrim($date[2]," ");
// $date[3] = ltrim($date[3]," ");
// echo $date[0]." ".$date[1]." ".$date[2]." ".$date[3];
// $type = $itype .'_'.$iname;
 
// generate random string..this key will be used for voting analysis and displayed on each block
// if removed the user is still linked to the itag of the host for future post but this specific block is removed 
// function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
// {
//     $pieces = [];
//     $max = mb_strlen($keyspace, '8bit') - 1;
//     for ($i = 0; $i < $length; ++$i) {
//         $pieces []= $keyspace[random_int(0, $max)];
//     }
//     return implode('', $pieces);
// }
// // for user voting block and state tracking
// $publicKey = random_str(9, '0123456789abcdefghijklmnopqrstuvwxyz');
// $publicKey = filter_var($publicKey, FILTER_SANITIZE_STRING); 
// $publicKey = ltrim($publicKey," ");

$privateKey =filter_var('null', FILTER_SANITIZE_STRING); // secret key payment for block
$privateKey = ltrim($privateKey," ");
$fiatValue =filter_var('0.00', FILTER_SANITIZE_STRING); // value of block


$word_tag = $event_type.'_/'.$str_replace(" ","/",$word_tag);


$db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
// insert into 

    pg_query($db, "UPDATE public.organization
        SET privatekey='$privateKey', fiatvalue='$fiatValue', views= 0
    WHERE publickey = '$publickey' AND id =$userid");


//remove stored push data

 
    // unset($_SESSION['event_type']);
    // unset($_SESSION['word_tags']);
    // unset($_SESSION['eventTitle']);
    // unset($_SESSION['phoneNumber]']);
    // unset($_SESSION['publicKey']);
    // unset($_SESSION['privateKey']);
    // unset($_SESSION['img_src']);
    // unset($_SESSION['address']);
    // unset($_SESSION['date']);
    // unset($_SESSION['startTime']);
    // unset($_SESSION['endTime']);
    // unset($_SESSION['url']);
    // unset($_SESSION['email_temp']);
    // unset($_SESSION['content']);
    // unset($_SESSION['description']);
    // unset($_SESSION['name']);


  header('location: profile.php');
}

?>



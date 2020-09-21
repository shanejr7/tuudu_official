<?php 
include('server.php');
include('add_post.php');
include("proper_nouns.php");

 
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
$key = ' ';
 
//$conn = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
 $conn = pg_connect(getenv("DATABASE_URL"));

 if (!$conn) {
     die("Connection failed: " . pg_connect_error());
     header('location:oops.php');
}
 
$event_push_arr = array();

//array for the word_tags with itag related
$event_related = array();
// query
 $sql = pg_query($conn, "SELECT DISTINCT event_type FROM word_tag");
 

// loops through rows until there is 0 rows
if (pg_num_rows($sql) > 0) {
    // output data of each row
    while($row = pg_fetch_assoc($sql)) {
      
      $event_push_arr[] = array("event_type" => $row["event_type"]);



    }
    // if no rows 
} else {
 //  echo "0 results";
}

 

pg_close($conn);

if (!isset($_SESSION['username'])) {
   
   header('location: login-page.php');
  }

 

   ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
   
 <link rel="icon" 
      type="image/jpg" 
      href="../assets/img/logo_size.jpg"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Post
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="../assets/css/material-kit.css?v=2.2.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />
  <link href="../assets/demo/vertical-nav.css" rel="stylesheet" />
  


</head>

<body class="profile-page sidebar-collapse">

<nav class="navbar navbar-expand-lg bg-primary">
    <div class="container">
        <div class="navbar-translate col-lg-4">

           
            <a class="navbar-brand" href="post.php">  <img src="../assets/img/logo.png" style="width: 30%; "></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse col-lg-8">
            <ul class="navbar-nav">
                  <li class="nav-item">
                    <a href="dashboard.php" class="nav-link">DASHBOARD</a>
                </li>
                 <li class="nav-item">
                    <a href="profile.php" class="nav-link">PROFILE</a>
                </li>
                 <li class="nav-item active">
                    <a href="login-page.php?logout='1'" onclick="revokeAllScopes()" class="nav-link">LOGOFF</a>
                    <script type="text/javascript">
                      var revokeAllScopes = function() {
                         auth2.disconnect();
                      }
                     </script>
                </li>
        
   </ul>          
                
       <?php 
                  
                     echo '</div></div>
                     </nav>'; 
      

 
function card(){
 
 $userid = $_SESSION['id'];
 if (isset($_SESSION['publicKey'])) {
   $publickey = trim($_SESSION['publicKey']); 
}
 
// Create connection
//$db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
$db = pg_connect(getenv("DATABASE_URL"));
// Check connection
if (!$db) {
     die("Connection failed: " . pg_connect_error());
     header('location:oops.php');
}

// update user image
 $data = pg_query($db,"SELECT DISTINCT img, title, organization_name as name, description, content
  FROM public.organization WHERE id = $userid AND publickey= '$publickey' LIMIT 1");

 $event_card = pg_fetch_assoc($data);

 if ($event_card['img']) {
   // $_SESSION['img_src_post'] = $event_card['img'];
    $_SESSION['img_src_post'] = '../assets/img/image_placeholder.jpg';
 }else{
    $_SESSION['img_src_post'] = '../assets/img/image_placeholder.jpg';
 }
  if ($event_card['name']) {
   $_SESSION['name'] = $event_card['name'];
   
 }
  if ($event_card['title']) {
   $_SESSION['eventTitle'] = $event_card['title'];
 }
  if ($event_card['description']) {
   $_SESSION['description'] = $event_card['description'];
 }
  if ($event_card['content']) {
   $_SESSION['content'] = $event_card['content'];
 }



pg_close($db);
 }
 

 
?>

    <div class="container" style="margin-top: 3em;">
        <div class="row">
          <div class="col-lg-5">
              <div class="col-md-12 mr-auto">
              <div class="card card-background" style="<?php if (isset($_SESSION['img_src_post'])){
                echo 'background-image:url('.$_SESSION['img_src_post'].')';
              }else{echo "background-image:url('../assets/img/image_placeholder.jpg')";} ?> ">
                <a href="#pablo"></a>
                <div class="card-body">
                  <span class="badge badge-rose"><?php if (isset($_SESSION['name'])) {
                    echo $_SESSION['name'];
                  }else{echo "name";} ?></span>
                  <a href="#pablo">
                    <h2 class="card-title"><?php if (isset($_SESSION['eventTitle'])) {
                    echo $_SESSION['eventTitle'];
                  }else{echo "title";} ?></h2>
                  </a>
                  <p class="card-description">
                   <?php if (isset($_SESSION['description'])) {
                    echo $_SESSION['description'];
                  }else{echo "description";} ?></p>

                    
                </div>
                  <div class="card-footer">
                
                  <p class="card-description">
                   <?php if (isset($_SESSION['content'])) {
                    echo $_SESSION['content'];
                  }else{echo "content";} ?></p>

                    
                </div>
               
              </div>
 
            </div>
            
          </div>
       

            <div class="col-lg-7 mr-auto" style="height: 650px;">
         <div class="card card-login">
          
      <div class="col-lg-10">
                     <!-- <h1 class="title">event submission</h1>
 -->                <div class="main object-non-visible" data-animation-effect="fadeInUpSmall" data-effect-delay="100">
                <div class="form-block p-30" style="margin-top: 5em; margin-left: 2em;" >
         
 
                    <?php 


 

 $page =1;
 $counter = 0;

 
if (isset($_POST['page']) && $_POST['page'] >1) {
  $page = filter_var($_POST['page'], FILTER_SANITIZE_STRING);
  if ($page==2) {

  $event_type = "";
  $radioOptions = "";
  $story_key = "";

  if (isset($_POST['event_type'])) {
    $event_type =  filter_var($_POST['event_type'], FILTER_SANITIZE_STRING);
    $radioOptions =  filter_var($_POST['radioOptions'], FILTER_SANITIZE_STRING);
    $_SESSION['event_type'] = $event_type;
  }

  if (isset($_POST['story_key'])) {
    $story_key = filter_var($_POST['story_key'], FILTER_SANITIZE_STRING);
    $story_key = trim($story_key);
  }

if (isset($_POST['event_type'])) {
 
 $publickey = $_SESSION['publicKey'];
      

    
 $userid = $_SESSION['id'];

  
 
// Create connection
$db = pg_connect(getenv("DATABASE_URL"));
// Check connection
if (!$db) {
     die("Connection failed: " . pg_connect_error());
     header('location:oops.php');
}

 // removes duplicate from refreshing page 
 $query = "DELETE FROM public.organization WHERE id = $userid AND publickey = '$publickey'";

 pg_query($db, $query);

// update user image
 pg_query($db,"INSERT INTO public.organization(id,publickey,post_type,story_key)
    VALUES ($userid,'$publickey','$radioOptions','$story_key')");
pg_close($db);
 card();
}else{
  
}
 
echo '<h3 class="title">Add Event Tags</h3>
              <form role="form" method="post" action="post.php">
 
                <div class="form-group">
                  <label for="exampleSelect2">used to find your event</label>
                  ';

                      
                  echo '<div id="textareaTags">
          <div class="row">
  

            <div class="col-md-6">
              <div class="title">
               <!-- <h3>Tags</h3> -->
              </div>
              <input type="text" name="word_tags" value="" placeholder="enter here" class="tagsinput form-control" data-role="tagsinput" data-color="rose">
              <!-- You can change data-color="rose" with one of our colors primary | warning | info | danger | success -->
            </div>
          </div>
        </div>';

                     
                  echo'</select><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="1" style="margin-right:2em;">back</button><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="3" style="display:inline-block">next</button></div></div></form>';


  

}else if($page ==3){

 
 

 $userid = $_SESSION['id'];
 $publickey = $_SESSION['publicKey'];
 $event_type = $_SESSION['event_type'];
 $_SESSION['tags'] = "";

if(isset($_POST['word_tags'])) {

 $event_type = $_SESSION['event_type'];
 $word_tags = "";
 $word_tags =  filter_var($_POST['word_tags'], FILTER_SANITIZE_STRING);  
 $word_tags = preg_replace('/[^A-Za-z0-9\-]/', ' ', $word_tags);
 $word_tags = str_replace(" ","/",trim($word_tags));
 $word_tags = '/'. $word_tags;
 $word_tags = strtolower($word_tags);
 $word_tag = $event_type.'_'.$word_tags;
 $_SESSION['tags'] .= $word_tags; 
 $tvar = explode('/', trim($_SESSION['tags']));


 // Create connection
$db = pg_connect(getenv("DATABASE_URL"));
// Check connection
if (!$db) {
     die("Connection failed: " . pg_connect_error());
     header('location:oops.php');
}


          for ($i=0; $i <sizeof($tvar) ; $i++) { 
        
          
            $result = pg_query($db, "SELECT * FROM itag_rank WHERE itag=trim('$tvar[$i]') LIMIT 1");
              
              $itag_rank = pg_fetch_assoc($result);

              if (pg_num_rows($result) <= 0) {
                
                   pg_query($db, "INSERT INTO public.itag_rank (itag,views) 
                    VALUES(trim('$tvar[$i]'),0)");

              }
            } 
 

          // create instance dont split sentences only words//
          $pn = new proper_nouns(); 

          //get array with proper nouns 
          $arr = $pn->get($word_tags);

          $word_tags = "";

          for ($i=0; $i < sizeof($arr) ; $i++) { 

            $word_tags.= '/'.$arr[$i];

          }

          $word_tags = strtolower($word_tags);
          $word_tags = str_replace(" ","/",trim($word_tags));
    
 
 

// update user image
 pg_query($db,"UPDATE public.organization SET word_tag ='$word_tag' WHERE id= $userid AND publickey = '$publickey'");
 
// update word_tag itag data
pg_query($db,"UPDATE public.word_tag SET itag =CONCAT(trim(itag),trim('$word_tags')) WHERE event_type = '$event_type'"); 

pg_close($db);

 
  card();
}else{
   
}

 
 

 // echo $word_tags;
  echo '<h2 class="title">Event | <span style="color:orange">content</span> (<strong>1/5</strong>)</h2>';

  // echo "<h3><strong>1/5</strong><h3>";
  echo '   <form enctype="multipart/form-data" method="post" action="'.$_SERVER['PHP_SELF'].'">
  <label>add content to your event..</label>
                 <div class="row">

                 <div class="col-md-6">
                  <div class="form-group row col-sm-10">
                    <input type="text" name="eventTitle" class="form-control" id="inputEvent" placeholder="title"  required>
                  </div>

                

                     <div class="form-group row col-sm-10">
                    <input type="text" name="description" class="form-control" id="inputDescription" placeholder="description" required>
                  </div>
                
                 
    
                
                  </div>
                  <div class="col-md-4">
                     <div class="form-group  ">
                    <input type="text" name="content" class="form-control" id="inputContent" placeholder="content info"  required>
                  </div>
                    
                   
                          <div class="form-group form-file-upload form-file-simple">
    <input type="text" class="form-control inputFileVisible" placeholder="upload image..." required>
    <input type="file" name="file1" class="inputFileHidden">
  </div>
                    </div></div>

                </div><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="2" style="margin-right:2em;">back</button><button type="submit" class="btn radius-50   btn-default-transparent btn-bg " name="page" value="4" style="display:inline-block">next</button></form>';
 
 
}else if ($page ==4) {
 $randomString = ''; 
 $destination = '';

 
 $userid = $_SESSION['id'];
 $publickey = $_SESSION['publicKey'];

//stores file to aws S3
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file1']) && $_FILES['file1']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['file1']['tmp_name'])) {


            $db = pg_connect(getenv("DATABASE_URL"));
            // Check connection
            if (!$db) {
              die("Connection failed: " . pg_connect_error());
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
$key =  "organization_event_img/".$randomString.''. $file_name; 
// save destination into postgresql
$destination = $key;

    $uploader = new ObjectUploader(
    $s3,
    $bucket_name,
    $key,
    $source 
);
 
    // FIXME: add more validation, e.g. using ext/fileinfo
   
    try {
       
        $upload = $uploader->upload($bucket, $destination, fopen($file_temp, 'rb'), 'public-read');

          $image_src = $destination;
          $eventTitle= filter_var($_POST['eventTitle'], FILTER_SANITIZE_STRING);
          $eventTitle = preg_replace('/[^A-Za-z0-9\-]!/', '',$eventTitle);
          $description= filter_var($_POST['description'], FILTER_SANITIZE_STRING);
          $description = preg_replace('/[^A-Za-z0-9\-]!/', '', $description);
          $content= filter_var($_POST['content'], FILTER_SANITIZE_STRING);   
          $content = preg_replace('/[^A-Za-z0-9\-]!/', '', $content);

          $event_type = $_SESSION['event_type'];
          $word_tags.= trim($event_title).'/';
          $word_tags.= trim($description).'/';
          $word_tags.= trim($content).'/';
          $word_tags = strtolower($word_tags);
          $_SESSION['tags'] .= $word_tags;
          $tvar = explode('/', trim($_SESSION['tags']));


          for ($i=0; $i <sizeof($tvar) ; $i++) { 
        
          
            $result = pg_query($db, "SELECT * FROM itag_rank WHERE itag=trim('$tvar[$i]') LIMIT 1");
              
              $itag_rank = pg_fetch_assoc($result);

              if (pg_num_rows($result) <= 0) {
                
                   pg_query($db, "INSERT INTO public.itag_rank (itag,views) 
                    VALUES(trim('$tvar[$i]'),0)");

              }
            }

          // proper noun class to select special nouns used for tags

          $pn = new proper_nouns(); 

          // get array with proper nouns from text used for tags

          $arr = $pn->get($word_tags);

          $word_tags = "";


          for ($i=0; $i <sizeof($arr) ; $i++) { 
            
              $word_tags.='/'.$arr[$i];

          
          }



          $word_tags = strtolower($word_tags);
          $word_tags = str_replace(" ","/",trim($word_tags));

 

            // update user image
            pg_query($db,"UPDATE public.organization SET title ='$eventTitle', description = '$description', content = '$content', img='$image_src' WHERE id= $userid AND publickey = '$publickey'");

            // update word_tag itag data
            pg_query($db,"UPDATE public.word_tag SET itag =CONCAT(trim(itag),trim('$word_tags')) WHERE event_type = '$event_type'"); 
 

            pg_close($db);

            card();


            } catch(Exception $e){
               // echo $e;
          }

}else{
 
}

    include 'errors.php';
 echo '<h2 class="title">Event | <span style="color:orange">contact</span> (<strong>2/5</strong>)</h2>'; 
   

 echo '   <form method="post" action="post.php">
             
               
                   <div class="form-group row">
    
                  <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" id="inputName" placeholder="name"  required>
            </div>
            </div>


                     <div class="form-group row">
    
                  <div class="col-sm-10">
                    <input type="phone number" name="phoneNumber" class="form-control" id="inputNumber" placeholder="phone number"  required>
                  </div>
                </div>
                 <div class="form-group row">
                  <div class="col-sm-10">
                    <input type="email" name="email" class="form-control" id="inputEmail" placeholder="email"  required>
                  </div>

<input type="hidden" value="1" name="counter">



                </div><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="3" style="margin-right:2em;">back</button><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="5" style="display:inline-block">next</button></form>';
 


}elseif ($page ==5 || $_POST["page"]==5) {


  
 
 $userid = $_SESSION['id'];
 $publickey = $_SESSION['publicKey'];

 if (isset($_POST['phoneNumber'])) {
   # code...
  
$phoneNumber= filter_var($_POST['phoneNumber'],FILTER_SANITIZE_STRING);
$phoneNumber = preg_replace('/[^A-Za-z0-9\-]-/', '', $phoneNumber);
$email= filter_var($_POST['email'], FILTER_SANITIZE_STRING);
$email = preg_replace('/[^A-Za-z0-9\-].@/', '', $email);
if (!filter_var($email,FILTER_VALIDATE_EMAIL)) { array_push($errors, "Email is invalid"); }
$name= filter_var($_POST['name'], FILTER_SANITIZE_STRING);   
$name = preg_replace('/[^A-Za-z0-9\-]/', ' ', $name);
$_SESSION['name'] = $name;
 

 if (count($errors)==0) {
  // Create connection

$db = pg_connect(getenv("DATABASE_URL"));
// Check connection
if (!$db) {
     die("Connection failed: " . pg_connect_error());
     header('location:oops.php');
}

// update user image
 pg_query($db,"UPDATE public.organization SET phonenumber ='$phoneNumber', email = '$email', organization_name = '$name' WHERE id= $userid AND publickey = '$publickey'");
 

pg_close($db);

}
}
   if(isset($_POST['page']) || isset($page)) {

 // add none expiring post element

 echo '<h2 class="title">Event | <span style="color:orange">time</span> (<strong>3/5</strong>)</h2>'; 
  

 echo ' <script src="../assets/js/local.js"></script>   <form method="post" action="post.php">
   <input type="hidden" name="timezone" value="" id="timezone">
                 
                <div class="form-group row">
                  <div class="col-sm-10">
                    <input type="time" name="startTime" class="form-control" id="inputTime" placeholder="1:30pm" required>
                  </div>
                </div> 
                 <div class="form-group row">
                  <div class="col-sm-10">
                    <input type="time" name="endTime" class="form-control" id="inputTime" placeholder="5:30pm" required>
                  </div>
                </div> 

                 <div class="form-group row">
    
                  <div class="col-sm-10">
                    <input type="date" name="date" class="form-control" id="inputDate" placeholder="05/21/2020" required>
                  </div>
                </div>


                <button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="4" style="margin-right:2em;">back</button><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="6" style="display:inline-block">next</button></form>';
 
  card();
}else{
    
 echo '<h2 class="title">Event | <span style="color:orange">contact</span> (<strong>2/5</strong>)</h2>'; 
   include 'errors.php';

 echo '    
   <form method="post" action="post.php">
              
               
                   <div class="form-group row">
    
                  <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" id="inputName" placeholder="name"  required>
            </div>
            </div>


                     <div class="form-group row">
    
                  <div class="col-sm-10">
                    <input type="phone number" name="phoneNumber" class="form-control" id="inputNumber" placeholder="phone number"  required>
                  </div>
                </div>
                 <div class="form-group row">
                  <div class="col-sm-10">
                    <input type="email" name="email" class="form-control" id="inputEmail" placeholder="email"  required>
                  </div>

<input type="hidden" value="1" name="counter">



                </div><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="3" style="margin-right:2em;">back</button><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="5" style="display:inline-block">next</button></form>';
}
 

 


 
  
 
 
 
 
}elseif ($page==6) {
 
 
 
   $userid = $_SESSION['id'];
   $publickey = $_SESSION['publicKey'];

   if(isset($_POST['page'])) {

 
 if (isset($_POST['startTime'])) {
    // Create connection

$db = pg_connect(getenv("DATABASE_URL"));
// Check connection
if (!$db) {
     die("Connection failed: " . pg_connect_error());
     header('location:oops.php');
}
 
$startTime = filter_var($_POST['startTime'], FILTER_SANITIZE_STRING);
$endTime = filter_var($_POST['endTime'], FILTER_SANITIZE_STRING);
$date = filter_var($_POST['date'], FILTER_SANITIZE_STRING); 
$timezone = pg_escape_string($db, $_POST['timezone']);
 
$time = $startTime.'-'.$endTime;

$timezone = explode(" ", $timezone);
$zone = substr($timezone[6],1,1).''.substr($timezone[7],0,1).''.substr($timezone[8],0,1);

date_default_timezone_set($zone);

$O = explode("-", $timezone[5]);

$startTime = date("H:i:s", strtotime($startTime)).''.date("O", strtotime($O[1])); 
  

$tagDate = date_format($date,"M d");;
$date = date("Y-m-d", strtotime($date)).' '.$startTime;

 

// update user image
 pg_query($db,"UPDATE public.organization SET date ='$date', time = '$time' WHERE id= $userid AND publickey = '$publickey'");

  // itag season generator analysis

    
    $today = new DateTime();
    $season = "";
    $seasonTag ="";



function getSeason($today){


    // get the season dates + shift dates to weather

    $spring = new DateTime('March 20');
    $summer = new DateTime('June 20');
    $fall = new DateTime('September 22');
    $winter = new DateTime('December 21');

switch(true) {
    case ($today <= $spring || $today >= $spring) && $today < $summer && $today < $fall && $today < $winter:
        return $season = "spring";
        break;

    case ($today <= $summer || $today >= $summer) && $today > $spring &&  $today < $fall && $today < $winter:
        return $season = "summer";
        break;

    case ($today <= $fall || $today >= $fall) && $today > $spring && $today > $summer && $today < $winter:
        return $season = "fall";
        break;

    default:
        return $season = "winter";
}

}


$season = getSeason($today);
$seasonTag = getSeason($tagDate);

 // set seasons for selected tags

     $tvar = explode('/', $_SESSION['tags']);


          for ($i=0; $i <sizeof($tvar) ; $i++) { 
        
          
            $result = pg_query($db, "SELECT * FROM itag_rank WHERE itag=trim('$tvar[$i]') LIMIT 1");
              
              $itag_rank = pg_fetch_assoc($result);

              if (pg_num_rows($result)>0) {
                
                   pg_query($db, "UPDATE public.itag_rank SET itag_season =trim('$seasonTag'), season = trim('$season') 
                    WHERE itag = trim('$tvar[$i]')");

              }
            }

 

pg_close($db);

  card();
 
}else{
  
}
 }

 echo '<h2 class="title">Event | <span style="color:orange">address</span> (<strong>4/5</strong>)</h2>'; 
  

 echo '   <form method="post" action="post.php">
                <div class="form-group row">
                  <div class="col-sm-10">
                  <label for="eventUrl">post url</label>
                    <input type="url" name="url" class="form-control" id="eventUrl" placeholder="https://www.tuudu.org/web/order_page.php?order='.trim($publickey).'" value="https://www.tuudu.org/web/order_page.php?order='.trim($publickey).'">
                  </div>
                </div> 
                 <div class="form-group row">
    
                  <div class="col-sm-10">
                    <input type="address" name="address" class="form-control" id="inputLocation" placeholder="address"  required>
                  </div>


                </div><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="5" style="margin-right:2em;">back</button><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="7" style="display:inline-block">next</button></form>';
}elseif ($page ==7) {
   
 
$userid = $_SESSION['id'];
$publickey = $_SESSION['publicKey'];
$event_type = trim($_SESSION['event_type']);
if(isset($_POST['page'])) {

if (isset($_POST['url'])) {

$url = filter_var($_POST['url'], FILTER_SANITIZE_STRING);
if (!filter_var($url, FILTER_VALIDATE_URL)){ array_push($errors, "url is not valid");} 
$address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
$adress = preg_replace('/[^A-Za-z0-9\-]/', '', $address);
 
 
 

 if (count($errors) == 0){
// Create connection
$db = pg_connect(getenv("DATABASE_URL"));
// Check connection
if (!$db) {
     die("Connection failed: " . pg_connect_error());
     header('location:oops.php');
}

// update user image
 pg_query($db,"UPDATE public.organization SET url ='$url', address = '$address' WHERE id= $userid AND publickey = '$publickey'");
 

pg_close($db);
echo '<h2 class="title">Event | <span style="color:orange">payment</span>  </h2>'; 
   echo "<h3><strong>payment method</strong><h3>";

 echo ' <script src="../assets/js/local.js"></script>

                    <form method="post" action="post.php"  style="display:inline-block">

                     <input type="hidden" name="e_type" value="'.$event_type.'">


                      <div class="form-group row">
    
                  <div class="col-sm-10">
                    <input type="text" name="paymentType" class="form-control" id="value1" placeholder="venmo or PayPal" required>
                  </div>
                  </div>
                   <div class="form-group row">
    
                  <div class="col-sm-10">
                    <input type="text" name="paymentID" class="form-control" id="value2" placeholder="venmo or Paypal CLIENT ID" required>
                  </div>
                  </div>

                 <div class="form-group row">
    
                  <div class="col-sm-10">
                    <input type="text" name="fiatValue" class="form-control" id="value3" placeholder="0.00 " required>
                  </div>
                </div>
               
                 
        
                <button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="6" style="margin-right:2em;">back</button><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="push" value="7" style="display:inline-block;margin-right:2em;">push</button>

   
                </form><p class="title" style="display:inline-block">or </p>
                <form method="post" action="post.php" style="display:inline-block" >

              <button   type="submit" class="btn radius-50   btn-default-transparent btn-sm" name="push_no_payment" value="7" style="display:inline-block;">free</button>

   
                </form>

             ';
 
  card();
}else{
   echo '<h2 class="title">Event | <span style="color:orange">address</span> (<strong>4/5</strong>)</h2>'; 
  include 'errors.php';

 echo '   <form method="post" action="post.php">
                <div class="form-group row">
                  <div class="col-sm-10">
                    <input type="url" name="url" class="form-control" id="eventUrl" placeholder="url"  >
                  </div>
                </div> 
                 <div class="form-group row">
    
                  <div class="col-sm-10">
                    <input type="address" name="address" class="form-control" id="inputLocation" placeholder="address"  required>
                  </div>


                </div><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="5" style="margin-right:2em;">back</button><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="7" style="display:inline-block">next</button></form>';
}
 }
  
 
 
   
}

 
}

}else if($page ==1 || $_POST['page']==1){

unset($_SESSION['img_src_post']);
unset($_SESSION['name']);
unset($_SESSION['eventTitle']);
unset($_SESSION['content']);
unset($_SESSION['description']);
unset($_SESSION['publicKey']);
unset($_SESSION['event_type']);
unset($_SESSION['name']);
unset($_SESSION['tags']);

 $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
 $randomString = ''; 
  
    for ($i = 0; $i < 15; $i++) { 
        $index = rand(0, strlen($characters) - 1); 
        $randomString .= $characters[$index]; 
    } 

$publickey = $randomString;

$_SESSION['publicKey'] = $publickey;

// use key through process 
  echo '<h3 class="title">Welcome..</h3><h4 class="title">Select your event</h2>
              <form  method="post" action="post.php">
                <div class="form-group">
                  <label for="exampleSelect1">event type</label>
                  <select class="form-control" name="event_type" id="exampleSelect1">
                  <option value="music">music</option>';
                  for($i=0; $i<sizeof($event_push_arr);$i++){
  if (trim($event_push_arr[$i]['event_type'])!="") {
echo '<option>'.$event_push_arr[$i]['event_type'].'</option>';

  } 
}

echo '<option value="other">other</option></select>';

echo '<div class="form-check form-check-radio  form-check-inline">
  <label class="form-check-label">
    <input class="form-check-input" type="radio" name="radioOptions" id="inlineRadio1" value="dated"><i class="material-icons">date_range</i>dated post
    <span class="circle">
        <span class="check"></span>
    </span>
  </label>
</div>
<div class="form-check form-check-radio form-check-inline">
  <label class="form-check-label">
    <input class="form-check-input" type="radio" name="radioOptions" id="inlineRadio2" value="publish"><i class="material-icons">event</i>publish post
    <span class="circle">
        <span class="check"></span>
    </span>
  </label>
</div>
<div class="form-check form-check-radio form-check-inline">
  <label class="form-check-label">
    <input data-toggle="modal" data-target="#storyPost" class="form-check-input" type="radio" name="radioOptions" id="inlineRadio3" value="story"><i class="material-icons">view_carousel</i>story post
    <span class="circle">
        <span class="check"></span>
    </span>
  </label>
</div>
<div class="form-check form-check-radio form-check-inline">
  <label class="form-check-label">
    <input class="form-check-input" type="radio" name="radioOptions" id="inlineRadio4" value="shipment"><i class="material-icons">local_shipping</i>shippment
    <span class="circle">
        <span class="check"></span>
    </span>
  </label>
</div>';
                  
    echo '<input type="hidden" name="story_key" value="" id="storyRKey">';




    echo '<button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="2">next</button></div></form>';

 
 


card();
}
                                          
 ?>
  </div>
              </div>
    
         
                </div>

          </div>
            </div>
          </div>
          <div class="row">
          </br>
        </br>
      </br>
      </br>        
          </div>
    </div>

         <div class="modal fade" id="storyPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Story Post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <?php 

        $db= "";
        $event_story_arr = array();
        $ssid = "";
        $randomString = "";

        if (isset($_SESSION['id'])) {
          $ssid = $_SESSION['id'];
        }

        try{
 $db = pg_connect(getenv("DATABASE_URL"));
}catch(Execption $e){
  header('location:oops.php');
}
      $result = pg_query($db, "SELECT DISTINCT organization.date, organization.time, organization.fiatvalue,organization.img, organization.id as org_key, organization.title, organization.views,organization.description,organization.publickey, organization.address,organization.views, organization.story_key
                  FROM organization
                    WHERE id =$ssid AND post_type ='story' AND date_submitted is not NULL AND date is not NULL AND date::timestamp >= NOW() ORDER BY organization.date");

 
                  if (pg_num_rows($result) > 0) {
                  // output data of each row
                    while($row = pg_fetch_assoc($result)) {

      
      
                      $event_story_arr[] = array("date" => $row["date"], "time" => $row["time"],"title" => $row["title"], "price"=> $row["fiatvalue"], "img" => $row["img"],"org_id" => $row["org_key"],"description" => $row["description"],"views" => $row["views"], "publickey" => trim($row['publickey']), "address" => $row["address"],"story_key" => $row["story_key"]);



                    }
                  
                  }else { }

            pg_close($db);

 echo'<div class="form-group">
                  <label for="exampleSelect1"></label>

                  <select class="form-control" name="story_type" id="storySelect">';
                 
                  for($i=0; $i<sizeof($event_story_arr);$i++){
  if (trim($event_story_arr[$i]['story_key'])!="") {
echo '<option value="'.trim($event_story_arr[$i]['story_key']).'">'.$event_story_arr[$i]['title'].'</option>';

  } 
}
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
   
    $n = 15;
  
    for ($i = 0; $i < $n; $i++) { 
        $index = rand(0, strlen($characters) - 1); 
        $randomString .= $characters[$index]; 
    } 

echo '<option value="'.$randomString.'">new story</option>';


echo '</select></div>';
?>

      </div>
      <div class="modal-footer">
        <button onclick="select()" type="button" class="btn btn-secondary" data-dismiss="modal">Submit</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
  <script>

function select() {
  var x = document.getElementById("storySelect").value;
 
  document.getElementById("storyRKey").value = x;


}
</script>
</div>

     <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Terms & Agreement</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label>payments are received after purchases are made and items are validated with a deduction of 0.2% paypal fee. Invalid items may be subject to return funds.</label>
 by accepting this agreement and terms with using our services. you agree that all transactions and events are affiliated to independent third-party organizations in which our services only provide data without any association or having liability with third party organizations. accepting these terms our services is allowed to use data of your liking to provide events and or activities you do not agree with our terms and policy then do not register, download, or use our services.
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button> -->
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
  <footer class="footer footer-default">
    <div class="container">
      <nav class="float-left">
    <ul>
          <li>
            <a href="https://www.Aeravi.io">
              Aeravi
            </a>
          </li>
          <li>
            <a href="https://www.Aeravi.io">
              About Us
            </a>
          </li>
          <li>
            <a href="https://www.Aeravi.io">
              Licenses
            </a>
          </li>
          <li>
           <a href="#" data-toggle="modal" data-target="#exampleModal">
            Terms
            </a>
          </li>
        </ul>
      </nav>
      <div class="copyright float-right">
        &copy;
        <script>
          document.write(new Date().getFullYear())
        </script> created by 
        <a href="https://www.aeravi.io">Aeravi</a>.
      </div>
    </div>
  </footer>
  </div>
<!--    <script type="text/javascript">
    document.getElementByClass("update").onclick = function () {
        location.href = "dashboard.php";
    };
</script> -->
  <script src="../assets/js/core/jquery.min.js" type="text/javascript"></script>
  <script src="../assets/js/core/popper.min.js" type="text/javascript"></script>
  <script src="../assets/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
  <script src="../assets/js/plugins/moment.min.js"></script>
  <!--  Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker -->
  <script src="../assets/js/plugins/bootstrap-datetimepicker.js" type="text/javascript"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="../assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
  <!--  Google Maps Plugin    -->
  <!-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> -->
  <!--  Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
  <script src="../assets/js/plugins/bootstrap-tagsinput.js"></script>
  <!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
  <script src="../assets/js/plugins/bootstrap-selectpicker.js" type="text/javascript"></script>
  <!--  Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
  <script src="../assets/js/plugins/jasny-bootstrap.min.js" type="text/javascript"></script>
  <!--  Plugin for Small Gallery in Product Page -->
  <script src="../assets/js/plugins/jquery.flexisel.js" type="text/javascript"></script>
  <!-- Plugins for presentation and navigation  -->
  <script src="../assets/demo/modernizr.js" type="text/javascript"></script>
  <script src="../assets/demo/vertical-nav.js" type="text/javascript"></script>
  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Js With initialisations For Demo Purpose, Don't Include it in Your Project -->
  <script src="../assets/demo/demo.js" type="text/javascript"></script>
  <!-- Control Center for Material Kit: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-kit.js?v=2.1.1" type="text/javascript"></script>
</body>

</html>

 
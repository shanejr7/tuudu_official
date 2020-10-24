<?php  
/* DOCS

  * 
  * dashboard.php --> feed_state.php <generates data for user feed>
  * dashboard.php --> favorite.php <favoriting data stored for post>
  *
  
*/

// RECONSTRUCT
                       //add users to post images and commenting post
                          //cooking recipes/videos..etc
                          //yoga workouts/lists
                          //music/playlists/video/movie/shows lists
                          //activity/products(fashion/tickets/tech/...)/events/reading articles

// in dashboard tab
  // create additional tabs for each topic
    // differentiate interest from products/rental
    // to show on store and other topics to show on dashboard

include('feed_state.php'); // retrieves organizations for users
include('favorite.php');
   
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
 
   if (isset($_GET['dashboard'])) {
        unset($_SESSION['event_type']);
    unset($_SESSION['word_tags']);
    unset($_SESSION['eventTitle']);
    unset($_SESSION['phoneNumber]']);
    unset($_SESSION['publicKey']);
    unset($_SESSION['privateKey']);
    unset($_SESSION['img_src_post']);
    unset($_SESSION['address']);
    unset($_SESSION['date']);
    unset($_SESSION['startTime']);
    unset($_SESSION['endTime']);
    unset($_SESSION['url']);
    unset($_SESSION['email_temp']);
    unset($_SESSION['content']);
    unset($_SESSION['description']);
    unset($_SESSION['name']);
    
   }
 

  if (!isset($_SESSION['username'])) {
   $_SESSION['msg'] = "You must log in first";
   header('location: login-page.php');
  }

  if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    unset($_SESSION['id']);
    unset($_SESSION['email']);
    header("location: login-page.php");
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
   <title>
    Dashboard
  </title>
  
  <link rel="icon" 
      type="image/jpg" 
      href="../assets/img/logo_size.jpg"/>
      
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <link href='https://fonts.googleapis.com/css?family=Anaheim' rel='stylesheet'>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
   <link href="../assets/css/material-kit.css?v=2.2.0" rel="stylesheet" />
 
  <link href="../assets/demo/demo.css" rel="stylesheet" />
  <link href="../assets/demo/vertical-nav.css" rel="stylesheet" />
  <!-- custom css -->
  <link href="../assets/css/core.css" rel="stylesheet" />

   <script src="../assets/js/local.js"></script>
     <?php 

     $temp = " ";

if (isset($_SESSION['temp_pw'])) {
  $temp = $_SESSION['temp_pw'];
}



if (isset($temp) && $temp == 1) {

echo '<script>
 
  document.getElementById("main").style.visibility = "hidden";
 
     </script>';
}else{

echo '<script>
 
  document.getElementById("main").style.visibility = "show";
 
     </script>';
}


  ?>

  
  
 
 
</head>
 
<body class="profile-page  sidebar-collapse">
 
 
<nav class="navbar navbar-expand-lg bg-primary cd-section" id="nav">
    <div class="container nav-tabs-navigation">
 <div class="navbar-translate">
      <ul class="nav  navbar-nav nav-tabs" id="tabTrack"  role="tabs">
        <li class="nav-item ">
                   <a href="home.php" class="nav-link"><i class="material-icons">home</i></a>
                </li>
                <li class="nav-item ">
                  <a onclick='clear()' style="font-weight: normal;" id="dash" class="nav-link active" href="#dashboard" role="tab" data-toggle="tab"  >
                    <i class="material-icons">dashboard</i> dashboard
                  </a>
                </li>
                <li class="nav-item">
                  <a onclick='clear()' style="font-weight: normal;" id="sched" class="nav-link" href="#schedule"  role="tab" data-toggle="tab" >
                    <i class="material-icons">schedule</i> schedule <span class="badge badge-default"><?php
                    if (isset($schedule_list)) {
                      echo sizeof($schedule_list);
                    }else{
                      echo "0";
                    }
                     
                      ?></span>
                  </a>
                </li>
                   <li class="nav-item">
                  <a class="nav-link" style="font-weight: normal;" href="post.php">
                    <i class="material-icons">post_add</i> post
                  </a>
                </li>
                <li class="nav-item">
                  <a onclick='clear()' style="font-weight: normal;" id="lis" class="nav-link" href="#list" role="tab" data-toggle="tab">
                    <i class="material-icons">list</i> subscriptions
                  </a>
                </li>
                  <li class="nav-item">
                  <a class="nav-link" style="font-weight: normal;" href="profile.php" onclick='clear()' >
                    <i class="material-icons">perm_identity</i> profile
                  </a>
                </li>
              </ul>

 </div>

        <div class="collapse navbar-collapse" id="sectionsNav" style="margin-left: 4px;">
            <ul class="navbar-nav">
                <li class="nav-item">
                     <a href="dashboard.php?logout='1'" onclick="revokeAllScopes()" class="nav-link">logoff</a> 
                     <script type="text/javascript">
                      var revokeAllScopes = function() {
                         auth2.disconnect();
                      }
                     </script>
                </li>
                <li class="nav-item">
                    
                </li>
            </ul>

            <form class="form-inline ml-auto" method="GET" action="dashboard.php">
                <div class="form-group no-border">
                  <input type="text" class="form-control" name="search" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-white btn-just-icon btn-round">
                    <i class="material-icons">search</i>
                </button>
            </form>

        </div>
           
    </div>
     <div class="collapse navbar-collapse">
                  <ul class="navbar-nav ml-auto">
                   <!--  <li class="nav-item">
                      <a href="#pablo" class="nav-link"><i class="material-icons">email</i></a>
                    </li> -->

                    <?php 


  if (isset($_SESSION['id'])) {

    $uid = $_SESSION['id'];
                        
                                      
          $db = pg_connect(getenv("DATABASE_URL"));

          // Check connection
          if (!$db) {
              die("Connection failed: " . pg_connect_error());
              header('location:oops.php');
          }


           // Check if user feedstate exists
          $resulted = pg_query($db, "SELECT DISTINCT * FROM feedstate WHERE userid = $uid");

           

          if (pg_num_rows($resulted) <= 0) {
           


          echo '<li class="nav-item">
                      <a href="interest.php" class="nav-link">
                        <i class="material-icons">settings</i>interest
                        <b class="caret"></b>
                      </a>
                      </li>';



          }else{

                        $settings_check_mark = pg_fetch_assoc($resulted);


                 echo ' <li class="dropdown nav-item">
                      <a href="#pablo" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <i class="material-icons">settings</i>interest
                        <b class="caret"></b>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right">
                        <h6 class="dropdown-header">Select interest</h6>
    
                        <a href="feed_state.php?word_tag=music" class="dropdown-item">Music';
                          if (isset($settings_check_mark) && $settings_check_mark['state'] == 1 && trim($settings_check_mark['word_tag']) =='music') {
                          echo '<i class="material-icons" style="font-size: 12pt">check</i>';
                        }else{

                        }
                      echo'</a>
                          <div class="dropdown-divider"></div>
                        <a href="feed_state.php?word_tag=fashion" class="dropdown-item">Fashion';
                          if (isset($settings_check_mark) && $settings_check_mark['state'] == 1 && trim($settings_check_mark['word_tag']) =='fashion') {
                          echo '<i class="material-icons" style="font-size: 12pt">check</i>';
                        }else{

                        }  
                        echo'</a>
                          <div class="dropdown-divider"></div>
                        <a href="feed_state.php?word_tag=art" class="dropdown-item">Art';
                          if (isset($settings_check_mark) && $settings_check_mark['state'] == 1 && trim($settings_check_mark['word_tag']) =='art') {
                          echo '<i class="material-icons" style="font-size: 12pt">check</i>';
                        }else{
                        }
                          
                        echo'</a>
                          <div class="dropdown-divider"></div>
                        <a href="feed_state.php?word_tag=sports" class="dropdown-item">Sports';          if (isset($settings_check_mark) && $settings_check_mark['state'] == 1 && trim($settings_check_mark['word_tag']) =='sports') {
                          echo '<i class="material-icons" style="font-size: 12pt">check</i>';
                        }else{

                        }
                        echo'</a>
                          <div class="dropdown-divider"></div>
                        <a href="feed_state.php?word_tag=festivals" class="dropdown-item">Festivals';
                            if (isset($settings_check_mark) && $settings_check_mark['state'] == 1 && trim($settings_check_mark['word_tag']) =='festivals') {
                          echo '<i class="material-icons" style="font-size: 12pt">check</i>';
                        }else{

                        }
                        echo '</a>
                        <div class="dropdown-divider"></div>
                        <a href="feed_state.php?word_tag=food" class="dropdown-item">Food';
                          if (isset($settings_check_mark) && $settings_check_mark['state'] == 1 && trim($settings_check_mark['word_tag']) =='food') {
                          echo '<i class="material-icons" style="font-size: 12pt">check</i>';
                        }else{

                        }
                        echo'</a>
                        <div class="dropdown-divider"></div>
                        <a href="feed_state.php?word_tag=outdoor" class="dropdown-item">Outdoors';
                          if (isset($settings_check_mark) && $settings_check_mark['state'] == 1 && trim($settings_check_mark['word_tag']) =='outdoor') {
                          echo '<i class="material-icons" style="font-size: 12pt">check</i>';
                        }else{

                        }
                        echo'</a>
                      </div>
                    </li>';

          }

      

           pg_close($db);


}
 


                    ?>
                    
                  </ul>
                </div>
</nav>
<?php 
$temp = " ";

if (isset($_SESSION['temp_pw'])) {
$temp = $_SESSION['temp_pw'];
}
 

if (isset($temp) && $temp ==1) {
 
   
 echo ' <div class=" bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
     <form class="form" method="post" action="dashboard.php">
                 <input type="hidden" name="timezone" value="" id="timezone">
                 
             <div class="card-header card-header-primary text-center" style="background-color:orange;">
                <h4 class="card-title">new password</h4>
                
              </div>
          
              <div class="card-body">
                 <br/>
               <div style="margin-left: 10%;">';   
 
              if (count($new_password_error)>0) {
                echo '<p>'.$new_password_error[0].'<span class="text-warning btn-md-link"> <i class=" text-warning btn-md-link fa fa-warning pl-10"></i><span></p>';
              }

                  echo '</div>  
                
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">lock_outline</i>
                    </span>
                  </div>
                  <input type="password" class="form-control" name="reset_password" id="inputPassword" placeholder="Password..." required="">
                </div>
 
               
              </div>
              <div class="footer text-center">
                <button type="submit" value="string" href="#pablo" class="btn btn-primary btn-link btn-wd btn-lg"   name="new_password"
                data-callback="onSubmit">submit</button>
              </div>
            </form>

    </div>
  </div>
</div><div class="row">
<div class="col-md-5"> </div> <div class="col-md-4"><p>we will never share your password</p></div></div>';

}






?>

 
    <!-- class"main main-rasied" -->
     <div  >
     <div  >
    <div class="profile-content " id="main">
      <div class="container">


    
        
          
             
         
           
         
      
   <!--      <div class="row">
          <div class="col-md-12 ml-auto mr-auto">
            <div class="profile-tabs">
              <ul class="nav nav-pills nav-pills-icons justify-content-center" id="tabTrack" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" href="#dashbaord" id="refresh" role="tab" data-toggle="tab">
                    <i class="material-icons">dashboard</i> dashboard
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#schedule"  role="tab" data-toggle="tab">
                    <i class="material-icons">schedule</i> schedule <span class="badge badge-default"><?php
                   // if (isset($schedule_list)) {
                    //  echo sizeof($schedule_list);
                  //  }else{
                  //    echo "0";
                  //  }
                     
                      ?></span>
                  </a>
                </li>
                   <li class="nav-item">
                  <a class="nav-link" href="post.php">
                    <i class="material-icons">post_add</i> post
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#list" role="tab" data-toggle="tab">
                    <i class="material-icons">list</i> subscriptions
                  </a>
                </li>
                  <li class="nav-item">
                  <a class="nav-link" href="profile.php">
                    <i class="material-icons">perm_identity</i> profile
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div> -->

 
   

        <div class=" tab-space cd-section" id="body">
          <div class="tab-pane active text-center gallery section section-sections" id="dashboard">
           <div class="row">

                    <nav class="nav">
 
  <a class="nav-link" href="#0"><button type="button" class="btn btn-primary btn-round">Posts</button></a>
  <a class="nav-link" href="#0"><button type="button" class="btn btn-primary btn-round">Videos</button></a>
  <a class="nav-link" href="#0"><button type="button" class="btn btn-primary btn-round">Activites</button></a>
  <a class="nav-link" href="#0"><button type="button" class="btn btn-primary btn-round">Music</button></a>
  <a class="nav-link" href="#0"><button type="button" class="btn btn-primary btn-round">Shows</button></a>
  <a class="nav-link" href="#0"><button type="button" class="btn btn-primary btn-round">Food</button></a>
  <a class="nav-link" href="#0"><button type="button" class="btn btn-primary btn-round">Art</button></a>
  <a class="nav-link" href="#0"><button type="button" class="btn btn-primary btn-round">Sports</button></a>
  
</nav>

          <?php if (count($errors_dashboard) > 0) : ?>
              <div class="error">
               <?php foreach ($errors_dashboard as $error) : ?>
                  <p><?php echo $error ?> <span class="text-warning btn-md-link"> <i class=" text-warning btn-md-link fa fa-warning pl-10"></i><span></p>
                     <?php endforeach ?>
              </div>
               <?php  endif ?>
          <?php
 
                

if (isset($dashboard_list)  ) {


  echo '<script type="text/javascript">
     


var dashboard_local_distance = '.json_encode($dashboard_list, JSON_PRETTY_PRINT).';
var size = dashboard_local_distance.length; 
var count = 0;
//console.log("dashboard_local_distance "+ dashboard_local_distance[0].address);

for (var i = dashboard_local_distance.length - 1; i >= 0; i--) {
 
   geolocation(dashboard_local_distance[i].address,dashboard_local_distance[i].publickey,size,count);
   count++;
  
}
   </script>';

 $key = array();

 
$key = array_column($dashboard_list, 'publickey');
 
$key = array_intersect($key,$local_distance);

 
 
  // make content dynamic
  // shuffle($dashboard_list);
                
    foreach($dashboard_list as $item) {
  
 
          if(in_array($item["publickey"], $key) || trim($item["post_type"])=="shipment") 

  { 

                           $cmd = $s3->getCommand('GetObject', [
                                        'Bucket' => ''.$bucket_name.'',
                                        'Key'    => ''.trim($item["img"]).'',
                            ]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();
     
            
              echo '<div class="col-md-4">';

          
              echo '<div class="contain">';

           
                $splitFileString = strtok(trim($item["img"]), '.' );
                $fileChecker = strtok('');
                $fileChecker = strtoupper($fileChecker);

                $string = trim($item["word_tag"]);
                $string = strtolower($string);
                $token = strtok($string, "_");

 

          if($presignedUrl && strlen(trim($item["img"]))>10 && ($fileChecker=='JPG' || $fileChecker=='JPEG' || $fileChecker=='PNG' || $fileChecker=='MOV')){
                 echo  '<img src="'.$presignedUrl.'" class="img rounded" onload="myFunction('.$presignedUrl.')">'; 
              }else{
                 echo  '<img src="../assets/img/image_placeholder.jpg" class="img rounded">';
              } 
 
              
                

                  if (trim($item['price']) =='0.00' || $item["price"]==NULL || $item["price"]==" ") {

                        echo '<div class="top-right h9"> 
                        <a href='.$item['url'].'><i class="material-icons">strikethrough_s</i></a></div>';

                        }else{

                  echo '<a href='.$item['url'].'><div class="top-right h6">$'.trim($item['price']).'</a></div>';
                  
                  }


                   if (isset($token) && $token =='product') {

                  
                    echo '<div class="top-left h6" style="width:10px;"><i class="material-icons">store</i></div>';


                  }else{

                    echo '<div class="top-left h6" style="width:10px;">'
                       .toString($item['date']).'</div>';

                  }

                  echo '<div class="centeredm h4">'.trim($item['description']).'</div>';


                  echo '<div class="bottom-left" style="font-weight: bolder;">
                        <a href="subscription.php?subscribe='.trim($item['publickey']).'">
                        <i class="material-icons" style="font-size:18pt;">bookmark_border</i></a></div>';

                  // echo '<div class="centered" style="font-weight: bolder;">
                  // <a href="#fav"><i class="material-icons" style="font-size:18pt">favorite_border</i></a></div>';

                 
                  echo '<div class="bottom-right" style="font-weight: bolder;">
                         <a href="order_page.php?order='.$item['publickey'].'"><i class="material-icons" style="font-size:18pt;">add_shopping_cart</i></a></div>';
 



                echo '</div>';
              
          
              
            echo '</div>';
          }else{
            // not local
          }
          
 
        
    } 



                  } 
               
              ?>
         
            </div>
          </div>
 
          <div class="tab-pane text-center gallery" id="schedule">
              <div class="row"> 

                  <?php if (count($errors_schedule) > 0) : ?>
                     <div class="error">
                      <?php foreach ($errors_schedule as $error) : ?>
                          <p><?php echo $error ?> <span class="text-warning btn-md-link"> <i class=" text-warning btn-md-link fa fa-warning pl-10"></i><span></p>
                      <?php endforeach ?>
                     </div>
                  <?php  endif ?>

            <?php 

                  
  // column sizes for row 
    $numberOfColumns = 8;
    $bootstrapColWidth = 12 / $numberOfColumns ;
if (sizeof($schedule_list) ==1 && isset($schedule_list)) {
    $arrayChunks = array_chunk($schedule_list, $numberOfColumns);
    $ticket_time = explode("-", $item["time"]);
    foreach($arrayChunks as $items) {
        echo '<div class="row">';
        foreach($items as $item) {

                        $cmd = $s3->getCommand('GetObject', [
                    'Bucket' => ''.$bucket_name.'',
                    'Key'    => ''.trim($item["img"]).'',
]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();

                $splitFileString = strtok(trim($item["img"]), '.' );
                $fileChecker = strtok('');
                $fileChecker = strtoupper($fileChecker);


 

          if($presignedUrl && strlen(trim($item["img"]))>10 && ($fileChecker=='JPG' || $fileChecker=='JPEG' || $fileChecker=='PNG' || $fileChecker=='MOV')){
                      $item['img']= $presignedUrl;  
              }else{
                   $item['img']= '../assets/img/image_placeholder.jpg';
              } 
          echo '<div class="col-md-12">
          <div class="contain">
            <div class="card card-background" style="background-image: url('.$item['img'].');">
              <div class="card-body">
                <h6 class="card-category text-info">'.$item['title'].'</h6>
                <a href="#pablo">
                  <h3 class="card-title">'.toString($item['date']).'</h3>
                  <h12 class="card-title">'.date('h:i A', strtotime($ticket_time[0])).'</h12>
                </a></br></br></br></br> 
                <p class="card-description" style="font-weight:bolder;font-family: "Anaheim";">
                 '.$item['address'].'
                </p><i class="material-icons" style="color:orange">room </i>
                </br>
                 
                  
              </div>
               
            </div>
           </div>
          </div>';
        
        }
        echo '</div>';
    } 

}else if(sizeof($schedule_list)==2){
  $arrayChunks = array_chunk($schedule_list, $numberOfColumns);
    foreach($arrayChunks as $items) {
        echo '<div class="row">';
        foreach($items as $item) {

                        $cmd = $s3->getCommand('GetObject', [
                    'Bucket' => ''.$bucket_name.'',
                    'Key'    => ''.trim($item["img"]).'',
]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();

                $splitFileString = strtok(trim($item["img"]), '.' );
                $fileChecker = strtok('');
                $fileChecker = strtoupper($fileChecker);

 

          if($presignedUrl && strlen(trim($item["img"]))>10 && ($fileChecker=='JPG' || $fileChecker=='JPEG' || $fileChecker=='PNG' || $fileChecker=='MOV')){
                      $item['img']= $presignedUrl;  
              }else{
                   $item['img']= '../assets/img/image_placeholder.jpg';
              } 
          echo '<div class="col-md-6">
            <div class="card card-background" style="background-image: url('.$item['img'].');">
              <div class="card-body">
                <h6 class="card-category text-info">'.$item['title'].'</h6>
                <a href="#pablo">
                  <h3 class="card-title">'.toString($item['date']).'</h3>
                </a>
               <p class="card-description" style="font-weight:bolder;font-family: "Anaheim";">
                 '.$item['address'].'
                </p><i class="material-icons" style="color:orange">room </i>
                </br>
                
              </div>
            </div>
           
          </div>';
        
        }
        echo '</div>';
    } 

}else{
  $arrayChunks = array_chunk($schedule_list, $numberOfColumns);
    foreach($arrayChunks as $items) {
        echo '<div class="row">';
        foreach($items as $item) {

                          $cmd = $s3->getCommand('GetObject', [
                    'Bucket' => ''.$bucket_name.'',
                    'Key'    => ''.trim($item["img"]).'',
]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();

                $splitFileString = strtok(trim($item["img"]), '.' );
                $fileChecker = strtok('');
                $fileChecker = strtoupper($fileChecker);

 

          if($presignedUrl && strlen(trim($item["img"]))>10 && ($fileChecker=='JPG' || $fileChecker=='JPEG' || $fileChecker=='PNG' || $fileChecker=='MOV')){
                      $item['img']= $presignedUrl;  
              }else{
                   $item['img']= '../assets/img/image_placeholder.jpg';
              } 

            

          echo '<div class="col-md-4">
            <div class="card card-background" style="background-image: url('.$item['img'].');">
              <div class="card-body">
                <h6 class="card-category text-info">'.$item['title'].'</h6>
                <a href="#pablo">
                  <h3 class="card-title">'.toString($item['date']).'</h3>
                </a>
                <p class="card-description" style="font-weight:bolder;font-family: "Anaheim";">
                 '.$item['address'].'
                </p><i class="material-icons" style="color:orange">room </i>
                </br>
              </div>  
            </div>
           
          </div>';
        
        }
        echo '</div>';
    } 
}
   
         

              ?>
        
    
        </div>
         
          </div>

          <div class="tab-pane text-center gallery" id="list">

            <div class="row">



<?php if (count($errors_list) > 0) : ?>
  <div class="error">
    <?php foreach ($errors_list as $error) : ?>
      <p><?php echo $error ?> <span class="text-warning btn-md-link"> <i class=" text-warning btn-md-link fa fa-warning pl-10"></i><span></p>
    <?php endforeach ?>
  </div>
<?php  endif ?>

            <?php 
if (isset($subscription_list)) {


                // // make content dynamic
                //   shuffle($subscription_list);
              
                 
  // column sizes for row 
    $numberOfColumns = 3;
    $bootstrapColWidth = 12 / $numberOfColumns ;

    $arrayChunks = array_chunk($subscription_list, $numberOfColumns);
    foreach($arrayChunks as $items) {
        echo '<div class="row">';
        foreach($items as $item) {

            echo '<div class="col-md-4">';

             // echo '<a href="subscription.php?subscribe='.trim($item['org_id']).'">';

             echo '<div class="contain">';
 

                   $cmd = $s3->getCommand('GetObject', [
                    'Bucket' => ''.$bucket_name.'',
                    'Key'    => ''.trim($item["img"]).'',
]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();
                
                $splitFileString = strtok(trim($item["img"]), '.' );
                $fileChecker = strtok('');
                $fileChecker = strtoupper($fileChecker);

 

          if($presignedUrl && strlen(trim($item["img"]))>10 && ($fileChecker=='JPG' || $fileChecker=='JPEG' || $fileChecker=='PNG' || $fileChecker=='MOV')){
                  echo  '<img src="'.$presignedUrl.'" class="rounded img">';  
              }else{
                 echo  '<img src="../assets/img/image_placeholder.jpg" class="rounded img">';
              } 

            


                  if (trim($item['price']) =='0.00') {

                        echo '<div class="top-right h9"> 
                        <i class="material-icons">strikethrough_s</i></div>';

                        }else{

                  echo '<div class="top-right h6">$'.trim($item['price']).'</div>';
                  
                  }

                  echo '<div class="top-left h6" style="width:10px;">'
                       .toString($item['date']).'</div>';

                  echo '<div class="centeredm h4">'.trim($item['description']).'</div>';

                   
                  echo '<div class="bottom-left" style="font-weight: bolder;">
                        <a href="subscription.php?unsubscribe='.$item['publickey'].'"><i class="material-icons">bookmark</i></a></div>';
                   
                  echo '<div class="bottom-right" style="font-weight: bolder;">
                        <a href="order_page.php?order='.$item['publickey'].'"><i class="material-icons">add_shopping_cart</i></a></div>';
 

                echo '</div>';
              
              // echo '</a>';
              
            echo '</div>';
        }
        echo '</div>';
    } 

         }

              ?>
         
             
            </div>

          </div>

        </div>
      </div>
    </div>
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
 by accepting this agreement and terms with using our services. you agree that all transactions and events are affiliated to independent third-party organizations in which our services only provides data without any association or having liability with third party organizations. accepting these terms our services is allowed to use data of your liking to provide events and or activitites.If you do not agree with our terms and policy then do not register, download, or use our services.
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button> -->
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</div>
  <footer class="footer footer-default cd-section" id="footer">
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
        <a href="https://www.aeravi.io" target="_blank">Aeravi</a>.
      </div>
    </div>
  </footer>
  
<!--   <script type="text/javascript">
    document.getElementById("refresh").onclick = function () {
        location.href = "dashboard.php";
    };
</script> -->

<script>
 
  
  <!--   Core JS Files   -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="../assets/js/core/jquery.min.js" type="text/javascript"></script>
  <script src="../assets/js/core/popper.min.js" type="text/javascript"></script>
  <script src="../assets/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
  <script src="../assets/js/plugins/moment.min.js"></script>
  <!--	Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker -->
  <script src="../assets/js/plugins/bootstrap-datetimepicker.js" type="text/javascript"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="../assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
  <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
  <script src="../assets/js/plugins/bootstrap-tagsinput.js"></script>
  <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
  <script src="../assets/js/plugins/bootstrap-selectpicker.js" type="text/javascript"></script>
  <!--	Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
  <script src="../assets/js/plugins/jasny-bootstrap.min.js" type="text/javascript"></script>
  <!--	Plugin for Small Gallery in Product Page -->
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

  <script>
 

 $("a").on('click', function() {

    history.replaceState(null, null, ' ');
  
     $('#tabTrack li').each(function() {
      $(this).removeClass('active');
    });

});

  </script>


    <script type="text/javascript">
      
       

  var hash = window.location.hash;
  
   
  if (hash != "") {
    
    $('#tabTrack a').each(function() {
      $(this).removeClass('active');
    });
    $('#body div').each(function() {
      $(this).removeClass('active');
    });
    
    var link = "";
    $('#tabTrack li').each(function() {
      link = $(this).find('a').attr('href');
      if (link == hash) {
        $(this).addClass('active');
      }
    });
    $('#body div').each(function() {
      link = $(this).attr('id');
      if ('#'+link == hash) {
        $(this).addClass('active');
      }
    });
  }else{



 

  }

    </script>

 
    <script type="text/javascript">
    $(document).ready(function() {
      materialKitDemo.presentationAnimations();
    });
  </script>

  <nav id="cd-vertical-nav">
    <ul>
      <li>
        <a href="#nav" data-number="1">
          <span class="cd-dot"></span>
          <span class="cd-label">Top</span>
        </a>
      </li>
      <li>
        <a href="#body" data-number="2">
          <span class="cd-dot"></span>
          <span class="cd-label">Content</span>
        </a>
      </li>
      <li>
        <a href="#footer" data-number="3">
          <span class="cd-dot"></span>
          <span class="cd-label">Bottom</span>
        </a>
      </li>
    
    </ul>
  </nav>
  <?php 


$temp = $_SESSION['temp_pw'];


if (isset($temp) && $temp == 1) {

echo '<script>
 
  document.getElementById("main").style.visibility = "hidden";
 
     </script>';
}else{

echo '<script>
 
  document.getElementById("main").style.visibility = "show";
 
     </script>';
}




  ?>
</body>

</html>
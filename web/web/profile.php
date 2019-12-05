<?php  include('feed_state.php'); // retrieves organizations for users
   
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

$bucket = getenv('S3_BUCKET')?: die('please try again later..');
$bucket_name = 'tuudu-official-file-storage';
 
   if (isset($_GET['dashboard'])) {
        unset($_SESSION['event_type']);
    unset($_SESSION['word_tags']);
    unset($_SESSION['eventTitle']);
    unset($_SESSION['phoneNumber]']);
    unset($_SESSION['publicKey']);
    unset($_SESSION['privateKey']);
    unset($_SESSION['img_src']);
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
<!--
 =========================================================
 Material Kit PRO - v2.1.1
 =========================================================

 Product Page: https://www.creative-tim.com/product/material-kit-pro
 Copyright 2019 Creative Tim (https://www.creative-tim.com)

 Coded by Creative Tim

 =========================================================

 The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  
<link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <link href='https://fonts.googleapis.com/css?family=Anaheim' rel='stylesheet'>
  <title>
    Profile
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="../assets/css/material-kit.css?v=2.1.1" rel="stylesheet" />
 
  <link href="../assets/demo/demo.css" rel="stylesheet" />
  <link href="../assets/demo/vertical-nav.css" rel="stylesheet" />
  <!-- custom css -->
  <link href="../assets/css/core.css" rel="stylesheet" />
   <script src="../assets/js/local.js"></script>

<!--   <script src="../assests/js/custom_js.js"></script> -->
  
 
 
</head>
 
<body class="profile-page  sidebar-collapse">
 
 
<nav class="navbar navbar-expand-lg bg-primary cd-section" id="nav">
    <div class="container">
 


<div class="modal fade" id="loginModal" tabindex="-1" role="">
    <div class="modal-dialog modal-login" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                  <div class="card-header card-header-primary text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                      <i class="material-icons">clear</i>
                    </button>

                    <h4 class="card-title">Account</h4>
                    <div class="social-line">
                    <div class="media row">
 
                  </div>
                     <h7>&#xB7; <?php echo $_SESSION['email']?></h7>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                </br>
                
               <div class="modal-footer justify-content-center">
                    <a href="post.php" class="btn btn-primary btn-link btn-wd btn-lg">Post event or activity</a>
                </div>
                 
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="#" class="btn btn-primary btn-link btn-wd btn-lg">Contact support</a>
                </div>
                 <div class="modal-footer justify-content-center">
                    <p>contact@tuudu.org</p>
                </div> 
            </div>
        </div>
    </div>
</div>
<?php 

$temp = $_SESSION['temp_pw'];


if (isset($temp) && $temp == TRUE) {
   
  echo ' <div class=" bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
     <form class="form" method="post" action="profile.php">
                 <input type="hidden" name="timezone" value="" id="timezone">
                 
             <div class="card-header card-header-primary text-center">
                <h4 class="card-title">new password</h4>
                
              </div>
          
              <div class="card-body">
                 <br/>
               <div style="margin-left: 10%;">';   

               include('errors.php');  

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
</div>';

}






?>
 

 

        <div class="navbar-translate">
            <a class="navbar-brand" data-toggle="modal" data-target="#loginModal" href="#"> Profile<i class="material-icons">sort</i></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="sectionsNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                     <a href="profile.php?logout='1'" class="nav-link">logoff</a> 
                </li>
                <li class="nav-item">
                    
                </li>
            </ul>

            <form class="form-inline ml-auto" method="GET" action="profile.php">
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
                    
                    <li class="dropdown nav-item">
                      <a href="#pablo" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <i class="material-icons">settings</i>settings
                        <b class="caret"></b>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right">
                        <h6 class="dropdown-header">Select interest</h6>
    
                        <a href="feed_state.php?word_tag=music" class="dropdown-item">Music
                        <?php  if (isset($settings_check_mark) && trim($settings_check_mark['music']) =='1') {
                          echo '<i class="material-icons" style="font-size: 12pt">check</i>';
                        }else{

                        } ?>  
                      </a>
                          <div class="dropdown-divider"></div>
                        <a href="feed_state.php?word_tag=fashion" class="dropdown-item">Fashion                        <?php  if (isset($settings_check_mark) && trim($settings_check_mark['fashion']) =='1') {
                          echo '<i class="material-icons" style="font-size: 12pt">check</i>';
                        }else{

                        } ?>  </a>
                          <div class="dropdown-divider"></div>
                        <a href="feed_state.php?word_tag=art" class="dropdown-item">Art <?php if (isset($settings_check_mark) && trim($settings_check_mark['art']) =='1') {
                          echo '<i class="material-icons" style="font-size: 12pt">check</i>';
                        }else{
                        } ?>
                          
                        </a>
                          <div class="dropdown-divider"></div>
                        <a href="feed_state.php?word_tag=sports" class="dropdown-item">Sports                        <?php  if (isset($settings_check_mark) && trim($settings_check_mark['sports']) =='1') {
                          echo '<i class="material-icons" style="font-size: 12pt">check</i>';
                        }else{

                        } ?>  </a>
                          <div class="dropdown-divider"></div>
                        <a href="feed_state.php?word_tag=festival" class="dropdown-item">Festivals
                          <?php  if (isset($settings_check_mark) && trim($settings_check_mark['festival']) =='1') {
                          echo '<i class="material-icons" style="font-size: 12pt">check</i>';
                        }else{

                        } ?>  </a>
                        <div class="dropdown-divider"></div>
                        <a href="feed_state.php?word_tag=food" class="dropdown-item">Food
                          <?php  if (isset($settings_check_mark) && trim($settings_check_mark['food']) =='1') {
                          echo '<i class="material-icons" style="font-size: 12pt">check</i>';
                        }else{

                        } ?>  </a>
                        <div class="dropdown-divider"></div>
                        <a href="feed_state.php?word_tag=outdoor" class="dropdown-item">Outdoors
                          <?php  if (isset($settings_check_mark) && trim($settings_check_mark['outdoor']) =='1') {
                          echo '<i class="material-icons" style="font-size: 12pt">check</i>';
                        }else{

                        } ?>  </a>
                      </div>
                    </li>
                  </ul>
                </div>
</nav>

 
    <!-- class"main main-rasied" -->
     <div id="main">
     <div  >
    <div class="profile-content ">
      <div class="container">
    
        
        <div class="row">
          <div class="col-md-6 ml-auto mr-auto">
            <div class="profile-tabs">
              <ul class="nav nav-pills nav-pills-icons justify-content-center" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" href="#studio" id="refresh" role="tab" data-toggle="tab">
                    <i class="material-icons">dashboard</i> dashboard
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#schedule"  role="tab" data-toggle="tab">
                    <i class="material-icons">schedule</i> schedule <span class="badge badge-default"><?php echo sizeof($schedule_list); ?></span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#list" role="tab" data-toggle="tab">
                    <i class="material-icons">list</i> List
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>

 
   <script src="../assets/js/dashboard.js"></script>

        <div class="tab-content tab-space cd-section" id="body">
          <div class="tab-pane active text-center gallery section section-sections" id="studio">
           <div class="row">

          <?php if (count($errors_dashboard) > 0) : ?>
              <div class="error">
               <?php foreach ($errors_dashboard as $error) : ?>
                  <p><?php echo $error ?> <span class="text-warning btn-md-link"> <i class=" text-warning btn-md-link fa fa-warning pl-10"></i><span></p>
                     <?php endforeach ?>
              </div>
               <?php  endif ?>
          <?php
 
                

if (isset($dashboard_list)  ) {
//  $key = array();

 
// $key = array_column($dashboard_list, 'publickey');
 
// $key = array_intersect($key,$local_distance);

 
 
  // make content dynamic
  shuffle($dashboard_list);
                
  // column sizes for row 
  $numberOfColumns = 3;
    $bootstrapColWidth = 12 / $numberOfColumns ;

    $arrayChunks = array_chunk($dashboard_list, $numberOfColumns);
    foreach($arrayChunks as $items) {
        echo '<div class="row">';
        foreach($items as $item) {
  // if(in_array($item["publickey"], $key)) 
  // { 
  //   echo '<div class="col-md-4">';

  //            // echo '<a href="#">';

  //            echo '<div class="contain">';

  //                 echo  '<img src="'.trim($item['img']).'" class="img rounded">';

  //                 if (trim($item['price']) =='0.00') {

  //                       echo '<div class="top-right h9"> 
  //                       <i class="material-icons">strikethrough_s</i></div>';

  //                       }else{

  //                 echo '<div class="top-right h6">$'.trim($item['price']).'</div>';
                  
  //                 }

  //                 echo '<div class="top-left h6" style="width:10px;">'
  //                      .toString($item['date']).'</div>';

  //                 echo '<div class="centeredm h4">'.trim($item['description']).'</div>';


  //                 echo '<div class="bottom-left" style="font-weight: bolder;">
  //                       <a href="subscription.php?subscribe='.trim($item['publickey']).'">
  //                       <i class="material-icons" style="font-size:18pt;">bookmark_border</i></a></div>';

  //                       // href="feed_state.php?val='.trim($item['org_id']).'"
  //                       // delete_outline 
  //                 echo '<div class="bottom-right" style="font-weight: bolder;">
  //                        <a href="order_page.php?order='.$item['publickey'].'"<i class="material-icons" style="font-size:18pt;">add_shopping_cart</i></a></div>';

            



  //               echo '</div>';
              
  //             // echo '</a>';
              
  //           echo '</div>';
  // } 
// else
//   { 
//   // echo "not found"; 
//   }
                           $cmd = $s3->getCommand('GetObject', [
                                        'Bucket' => ''.$bucket_name.'',
                                        'Key'    => ''.trim($item["img"]).'',
                            ]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();

              

            
              echo '<div class="col-md-4">';

          
              echo '<div class="contain">';

           
                
 

          if($presignedUrl){
                 echo  '<img src="'.$presignedUrl.'" class="img rounded" onload="myFunction('.$presignedUrl.')">'; 
              }else{
                 echo  '<img src="../assets/img/image_placeholder.jpg" class="img rounded">';
              } 
 
              
                

                  if (trim($item['price']) =='0.00' || $item["price"]==NULL || $item["price"]==" ") {

                        echo '<div class="top-right h9"> 
                        <i class="material-icons">strikethrough_s</i></div>';

                        }else{

                  echo '<div class="top-right h6">$'.trim($item['price']).'</div>';
                  
                  }


                  echo '<div class="top-left h6" style="width:10px;">'
                       .toString($item['date']).'</div>';

                  echo '<div class="centeredm h4">'.trim($item['description']).'</div>';


                  echo '<div class="bottom-left" style="font-weight: bolder;">
                        <a href="subscription.php?subscribe='.trim($item['publickey']).'">
                        <i class="material-icons" style="font-size:18pt;">bookmark_border</i></a></div>';

           
                  echo '<div class="bottom-right" style="font-weight: bolder;">
                         <a href="order_page.php?order='.$item['publickey'].'"<i class="material-icons" style="font-size:18pt;">add_shopping_cart</i></a></div>';
 



                echo '</div>';
              
          
              
            echo '</div>';
          
        }
        echo '</div>';
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
if (sizeof($schedule_list) ==1) {
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

          if($presignedUrl){
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

          if($presignedUrl){
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

          if($presignedUrl){
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

                // make content dynamic
                  shuffle($stories_list);
              
                 
  // column sizes for row 
    $numberOfColumns = 3;
    $bootstrapColWidth = 12 / $numberOfColumns ;

    $arrayChunks = array_chunk($stories_list, $numberOfColumns);
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

          if($presignedUrl){
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

         

              ?>
         
             
            </div>

          </div>
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
  
  <script type="text/javascript">
    document.getElementById("refresh").onclick = function () {
        location.href = "profile.php";
    };
    
</script>

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
  <!--  Google Maps Plugin    -->
 <!--  <script src="https://maps.googleapis.com/maps/api/js?key="></script> -->
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
</body>

</html>
<?php  
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
   <link href="../assets/css/material-kit.css?v=2.2.0" rel="stylesheet" />
 
  <link href="../assets/demo/demo.css" rel="stylesheet" />
  <link href="../assets/demo/vertical-nav.css" rel="stylesheet" />
  <!-- custom css -->
  <link href="../assets/css/core.css" rel="stylesheet" />

 <!--   <script src="../assets/js/local.js"></script> -->
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

 <!--  <script src="../assets/js/custom_js.js"></script> -->
  
 
 
</head>
 
<body class="profile-page  sidebar-collapse">
 
 
<nav class="navbar navbar-expand-lg bg-primary cd-section" id="nav">
    <div class="container">
  

        <div class="navbar-translate">
              <ul class="nav  navbar-nav" id="tabTrackMain" role="tablist">
                <li class="nav-item">
                  <a class="nav-link" href="dashboard.php">
                    <i class="material-icons">dashboard</i> dashboard
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="dashboard.php#schedule">
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
                  <a class="nav-link" href="post.php">
                    <i class="material-icons">post_add</i> post
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="dashboard.php#list">
                    <i class="material-icons">list</i> subscriptions
                  </a>
                </li>
                  <li class="nav-item active">
                  <a class="nav-link active" href="#profile" role="tab" data-toggle="tab">
                    <i class="material-icons">perm_identity</i> profile
                  </a>
                </li>
              </ul>
        </div>

        <div class="collapse navbar-collapse" id="sectionsNav" style="margin-left: 4px;">
            <ul class="navbar-nav">
                <li class="nav-item active">
                     <a href="profile.php?logout='1'" onclick="revokeAllScopes()" class="nav-link">logoff</a> 
                     <script type="text/javascript">
                      var revokeAllScopes = function() {
                         auth2.disconnect();
                      }
                     </script>
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
                        <a href="feed_state.php?word_tag=festivals" class="dropdown-item">Festivals
                          <?php  if (isset($settings_check_mark) && trim($settings_check_mark['festivals']) =='1') {
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
<?php 
$temp = " ";

if (isset($_SESSION['temp_pw'])) {
$temp = $_SESSION['temp_pw'];
}
 

if (isset($temp) && $temp ==1) {
 
   
 echo ' <div class=" bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
     <form class="form" method="post" action="profile.php">
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
        <div class="tab-content tab-space cd-section" id="body">
      
 <div class="tab-pane active text-center gallery" id="profile">
  <div class="container">
        <div class="row">

          <div class="col-md-6 ml-auto mr-auto">
            <div class="profile-tabs">
              <ul class="nav nav-pills nav-pills-icons justify-content-center" id="tabTrack" role="tablist" style="height: 0em;">
                <!--
                                                        color-classes: "nav-pills-primary", "nav-pills-info", "nav-pills-success", "nav-pills-warning","nav-pills-danger"
                                                -->
                <li class="nav-item">
                  <a class="nav-link active" href="#home" role="tab" data-toggle="tab">
                   <!--  <i class="material-icons">home</i> -->
                    Home
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#connections" role="tab" data-toggle="tab">
                    <!-- <i class="material-icons">people</i> -->
                    Connections
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#posted" role="tab" data-toggle="tab">
                    <!-- <i class="material-icons">camera</i> -->
                    Products
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="tab-content tab-space">
          <div class="tab-pane active work" id="home">
            <div class="row">

              <div class="col-md-7 ml-auto mr-auto ">
                <h4 class="title">Latest Collections</h4>
                <div class="row collections">
                  <div class="col-md-6">
                    <div class="card card-background" style="background-image: url('../assets/img/examples/mariya-georgieva.jpg')">
                      <a href="#pablo"></a>
                      <div class="card-body">
                        <label class="badge badge-warning">Spring 2016</label>
                        <a href="#pablo">
                          <h2 class="card-title">Stilleto</h2>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card card-background" style="background-image: url('../assets/img/examples/clem-onojeghuo.jpg')">
                      <a href="#pablo"></a>
                      <div class="card-body">
                        <label class="badge badge-info">Spring 2016</label>
                        <a href="#pablo">
                          <h2 class="card-title">High Heels</h2>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card card-background" style="background-image: url('../assets/img/examples/olu-eletu.jpg')">
                      <a href="#pablo"></a>
                      <div class="card-body">
                        <label class="badge badge-danger">Summer 2016</label>
                        <a href="#pablo">
                          <h2 class="card-title">Flats</h2>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card card-background" style="background-image: url('../assets/img/examples/darren-coleshill.jpg')">
                      <a href="#pablo"></a>
                      <div class="card-body">
                        <label class="badge badge-success">Winter 2015</label>
                        <a href="#pablo">
                          <h2 class="card-title">Men's Sneakers</h2>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-3 mr-auto ml-auto stats">
                  <div class="row">
          <div class="col-md-6 ml-auto mr-auto stats">
            <div class="profile">
              <div class="avatar">
                <img src="../assets/img/me.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              <div class="name">
                <h6 class="title">mani Alshar</h6>
                
              </div>
            </div>
            <div class="follow">
              <button class="btn btn-fab btn-primary btn-round" rel="tooltip" title="" data-original-title="Follow this user">
                <i class="material-icons">add</i>
              </button>
            </div>
          </div>
        </div>
                <h4 class="title">Stats</h4>
                <ul class="list-unstyled">
                  <li><b>3</b> Products</li>
                  <li><b>4</b> Collections</li>
                  <li><b>331</b> Followers</li>
                  <li><b>1.2K</b> Likes</li>
                </ul>
                <hr>
                <h4 class="title">About his Work</h4>
                <p class="description">French luxury footwear and fashion. The footwear has incorporated shiny, red-lacquered soles that have become his signature.</p>
                <hr>
                <h4 class="title">Focus</h4>
                <span class="badge badge-primary">Footwear</span>
                <span class="badge badge-rose">Luxury</span>
              </div>
            </div>
          </div>
          <div class="tab-pane connections" id="connections">
            <div class="row">

                <div class="col-md-4 ml-auto mr-auto">
              
              </div>

              <div class="col-md-2 ml-auto mr-auto" style="margin-right: 2em;">
                <a href="#Following" >
              <h3 style="margin-bottom: 70px; font-weight: bold">Following</h3>
            </a>
            
              </div>
              
          




              <div class="col-md-2 mr-auto ml-auto">
                <a href="#Followers" style="color: black">
                <h3 style="margin-bottom: 70px;font-weight: bold">Followers</h3>
              </a>
              </div>


                  <div class="col-md-3 ml-auto mr-auto">
              
              </div>
            </div>
         
          <div id="Followers" class="col-md-12" style="background-color: white;width: 100%;   display: flex;    overflow-x: auto; border-radius: 2px;">
     
              <div class="profileFollowingstyle" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
              <div class="avatar" style="width: 200px;">
                <img src="../assets/img/me.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              <div class="name">
                <h6 class="title">Mani Alshar</h6>
                
              </div>
            </div>
 
                  <div class="profileFollowing" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
              <div class="avatar" style="width: 120px;">
                <img src="../assets/img/faces/card-profile5-square.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">Sara </h6> <h16 style="font-size: 12px;"><a href=""><span class="material-icons">
remove_circle_outline
</span></a></h16>
                
              </div>
            </div>

            <div class="profileFollowing" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
              <div class="avatar" style="width: 120px;">
                <img src="../assets/img/faces/kendall.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">Kendall</h6>
                <h16 style="font-size: 12px;"><a href=""><span class="material-icons">
remove_circle_outline
</span></a></h16>
                
                
              </div>
            </div>
            
                  <div class="profileFollowing" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
              <div class="avatar" style="width: 120px;">
                <img src="../assets/img/faces/card-profile2-square.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">Yang Lee</h6>
                <h16 style="font-size: 12px;"><a href=""><span class="material-icons">
remove_circle_outline
</span></a></h16>
                
                
              </div>
            </div>
            
                  <div class="profileFollowing" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
              <div class="avatar" style="width: 120px;">
                <img src="../assets/img/faces/christian.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">Christian</h6>
                <h16 style="font-size: 12px;"><a href=""><span class="material-icons">
remove_circle_outline
</span></a></h16>
                
                
              </div>
            </div>
            
                  <div class="profileFollowing" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
              <div class="avatar" style="width: 120px;">
                <img src="../assets/img/faces/card-profile1-square.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">Mike</h6>
                <h16 style="font-size: 12px;"><a href=""><span class="material-icons">
remove_circle_outline
</span></a></h16>
                
                
              </div>
            </div>
            
                  <div class="profileFollowing" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
              <div class="avatar" style="width: 120px;">
                <img src="../assets/img/faces/card-profile4-square.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">Laura</h6>
                <h16 style="font-size: 12px;"><a href=""><span class="material-icons">
remove_circle_outline
</span></a></h16>
                
                
              </div>
            </div>
              <div class="profileFollowing" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
              <div class="avatar" style="width: 120px;">
                <img src="../assets/img/faces/card-profile5-square.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">Sara</h6>
                <h16 style="font-size: 12px;"><a href=""><span class="material-icons">
remove_circle_outline
</span></a></h16>
                
                
              </div>
            </div>

            <div class="profileFollowing" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
              <div class="avatar" style="width: 120px;">
                <img src="../assets/img/faces/kendall.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">Kendall</h6>
                <h16 style="font-size: 12px;"><a href=""><span class="material-icons">
remove_circle_outline
</span></a></h16>
                
                
              </div>
            </div>
            
                  <div class="profileFollowing" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
              <div class="avatar" style="width: 120px;">
                <img src="../assets/img/faces/card-profile2-square.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">Yang Lee</h6>
                <h16 style="font-size: 12px;"><a href=""><span class="material-icons">
remove_circle_outline
</span></a></h16>
                
                
              </div>
            </div>
            
                  <div class="profileFollowing" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
              <div class="avatar" style="width: 120px;">
                <img src="../assets/img/faces/christian.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">Christian</h6>
                <h16 style="font-size: 12px;"><a href=""><span class="material-icons">
remove_circle_outline
</span></a></h16>
                
                
              </div>
            </div>
            
                  <div class="profileFollowing" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
              <div class="avatar" style="width: 120px;">
                <img src="../assets/img/faces/card-profile1-square.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">Mike</h6>
                <h16 style="font-size: 12px;"><a href=""><span class="material-icons">
remove_circle_outline
</span></a></h16>
                
                
              </div>
            </div>
            
                  <div class="profileFollowing" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
              <div class="avatar" style="width: 120px;">
                <img src="../assets/img/faces/card-profile4-square.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">Laura</h6>
                <h16 style="font-size: 12px;"><a href=""><span class="material-icons">
remove_circle_outline
</span></a></h16>
                
                
              </div>
            </div>
            <div class="profileFollowing" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
              <div class="avatar" style="width: 120px;">
                <img src="../assets/img/faces/marc.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">Marc</h6>
                <h16 style="font-size: 12px;"><a href=""><span class="material-icons">
remove_circle_outline
</span></a></h16>
                
                
              </div>
            </div>
            
                <div class="profileFollowing" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
              <div class="avatar" style="width: 120px;">
                <img src="../assets/img/faces/card-profile2-square.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">Yang Lee</h6>
                <h16 style="font-size: 12px;"><a href=""><span class="material-icons">
remove_circle_outline
</span></a></h16>
                
                
              </div>
            </div>
            
                  <div class="profileFollowing" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
              <div class="avatar" style="width: 120px;">
                <img src="../assets/img/faces/christian.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 0px;">Christian</h6>
                <h16 style="font-size: 12px;"><a href=""><span class="material-icons">
remove_circle_outline
</span></a></h16>
                
                
              </div>
            </div>
            
            <div class="profileFollowing" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
              <div class="avatar" style="width: 120px;">
                <img src="../assets/img/faces/marc.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">Marc</h6>
                <h16 style="font-size: 12px;"><a href=""><span class="material-icons">
remove_circle_outline
</span></a></h16>
                
                
              </div>
            </div>
            
        <div class="profileFollowing" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
              <div class="avatar" style="width: 120px;">
                <img src="../assets/img/faces/kendall.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">Kendall</h6>
                <h16 style="font-size: 12px;"><a href=""><span class="material-icons">
remove_circle_outline
</span></a></h16>
                
                
              </div>
            </div>
            
                  <div class="profileFollowing" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
              <div class="avatar" style="width: 120px;">
                <img src="../assets/img/faces/card-profile2-square.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">Yang Lee</h6>
                <h16 style="font-size: 12px;"><a href=""><span class="material-icons">
remove_circle_outline
</span></a></h16>
                
                
              </div>
            </div>

 
            </div>
            
          </div>
          <div class="tab-pane text-center gallery" id="posted">

            <div class="row " >

                    <?php if (count($errors_products) > 0) : ?>
                     <div class="error">
                      <?php foreach ($errors_products as $error) : ?>
                          <p><?php echo $error ?> <span class="text-warning btn-md-link"> <i class=" text-warning btn-md-link fa fa-warning pl-10"></i><span></p>
                      <?php endforeach ?>
                     </div>
                  <?php  endif ?>


                  <?php
                  $product_list = array();

 $user_id = "";
                         
if (isset($_SESSION['id'])) {
 $user_id = $_SESSION['id'];

                        // select user org post where id == session
                        try{
   // $db_course = pg_connect("host=localhost dbname=postgres user=postgres password=manny6377");
   $db = pg_connect(getenv("DATABASE_URL"));

}catch(Execption $e){
header('location:oops.php');
}

  $result = pg_query($db,
    "SELECT * FROM organization NATURAL JOIN poststate WHERE id = $user_id");

  
  if ($result) {

      if (pg_num_rows($result) > 0) {
                  // output data of each row
                    while($row = pg_fetch_assoc($result)) {
                      
      
                      $product_list[] = array("word_tag" => $row["word_tag"], "id" =>$row["id"], "title" => $row["title"], "organization_name" => $row["organization_name"], "phonenumber" => $row['phonenumber'], "email" => $row['email'], "address" => $row['address'], "date" => $row['date'], "time" => $row['time'], "url" => $row['url'], "img" => $row['img'],
                        "description" => $row['description'], "content" => $row['content'], "publickey" => $row['publickey'], "fiatvalue" => $row['fiatvalue'], "views" => $row['views'], "date_submitted" => $row['date_submitted'], "payment_type" => $row['payment_type'], "favorites" => $row['favorites'],"user_id" => $row['user_id'], "favorite" => $row['favorite'], "message" => $row['message']);


                    }
                  
                  }else {
array_push($errors_products, "0 results");
                    
                  }



                       }else{
                        header('location:oops.php');
                       }

pg_close($db);

}


                       if (isset($product_list)) {

                          foreach($product_list as $item) {

                            $cmd = $s3->getCommand('GetObject', [
                            'Bucket' => ''.$bucket_name.'',
                            'Key'    => ''.trim($item["img"]).'',
                          ]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();


              echo ' <div class="col-md-4 ml-auto card card-product ">
                 <div style="padding-right: 2em;">';

          if($presignedUrl){
                  echo  '<img src="'.$presignedUrl.'" class="rounded card-header card-header-image">';  
              }else{
                 echo  '<img src="../assets/img/image_placeholder.jpg" class="rounded card-header card-header-image">';
              } 


              echo '</div>';

              echo ' <div class="card-body">
               
                <h4 class="card-title">
                  <a href="#ProductTitle">'.$item['title'].'</a>
                </h4>
                <div class="card-footer">
                  <a href="profile.php?publickey='.$item['publickey'].'" id="favsub">';

                  if ($item['favorite'] ==1) {
                    
                    echo '<i class="material-icons" style="margin-right: 40px; background-color=red;">favorite</i>';
                    echo "string";

                  }else{

                    echo '<i class="material-icons" style="margin-right: 40px;">favorite_border</i>';
                  }
                  

                echo'</a>
                 <a href="#">
                  <i class="material-icons" style="margin-right: 40px;">chat_bubble_outline</i>
                </a>
                 <a href="#">
                  <i class="material-icons" style="margin-right: 40px;">send</i>
                </a>
                 <a href="#">
                  <i class="material-icons" style="margin-right: 200px;">more_vert</i>
                </a>
                </div>
              </div>
            
              </div>';



                       }
                     }
                   ?>


            </div>
          </div>
        </div>
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
  
  <script type="text/javascript">
    document.getElementById("refresh").onclick = function () {
        location.href = "profile.php";
    };
    
     document.getElementById("pAccount").onclick = function () {
        location.href = "profile.php#profileAccount";
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

  <script>

      $(document).ready(function(){

          $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
               localStorage.setItem('activeTab', $(e.target).attr('href'));
          });

          var activeTab = localStorage.getItem('activeTab');
          
            if(activeTab){
       
               $('#tabTrack a[href="' + activeTab + '"]').tab('show');
           }
      });

    </script>
  <script>

      $(document).ready(function(){

          $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
               localStorage.setItem('activeTab', $(e.target).attr('href'));
          });

          var activeTab = localStorage.getItem('activeTab');
          
            if(activeTab){
       
               $('#tabTrackMain a[href="' + activeTab + '"]').tab('show');
           }
      });

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
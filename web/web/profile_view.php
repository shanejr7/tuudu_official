<?php 

include("server.php");
include('favorite.php');

/* DOCS

  * 
  * <view selected user data>
  *
  
*/


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
    Profile
  </title>

 <link rel="icon" 
      type="image/jpg" 
      href="../assets/img/logo_size.jpg"/>
<meta name="theme-color" content="#ffffff">
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


 <!--  <script src="../assets/js/custom_js.js"></script> -->
  
 <style type="text/css">
   
   .footer-btn{position: fixed;bottom: 3em;left: 600px;}
  

 </style>
 
</head>
 
<body class="profile-page  sidebar-collapse" onload="hide()">
 
 
<nav class="navbar navbar-expand-lg bg-primary cd-section" id="nav">
    <div class="container">
  

        <div class="navbar-translate">
              <ul class="nav  navbar-nav" id="tabTrackMain" role="tablist">
                <li class="nav-item">
                   <a href="home.php" class="nav-link"><i class="material-icons">home</i></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="dashboard.php#dashboard">
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
                  <li class="nav-item">
                  <a class="nav-link" href="profile.php">
                    <i class="material-icons">perm_identity</i> profile
                  </a>
                </li>
              </ul>
        </div>

        <div class="collapse navbar-collapse" id="sectionsNav" style="margin-left: 4px;">
            <ul class="navbar-nav">
                <li class="nav-item">
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

                </div>
                <a href="dashboard.php">
                <li class="btn btn-white btn-just-icon btn-round">
                    <i class="material-icons">search</i>
                </li>
              </a>
          

        </div>
           
    </div>
   <div class="collapse navbar-collapse">
                  <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                      <a data-toggle="modal" data-target="#loginModal" href="#settings" class="nav-link">
                        <i class="material-icons">settings</i>settings
                        <b class="caret"></b>
                      </a>
                      </li>
                    </ul>
                  </div>
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
 
                    <div class="media-body col-md-7">
              
                   
                    </div>
                  </div>
                     <h7>&#xB7; <?php echo $_SESSION['email']?></h7>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                </br>
              
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="#" class="btn btn-primary btn-link btn-wd btn-lg">Contact support</a>
                </div>
                 <div class="modal-footer justify-content-center">
                    <p>support@tuudu.org</p>
                </div> 
            </div>
        </div>
    </div>
</div>
</nav>


 
    <!-- class"main main-rasied" -->
     <div  >
     <div  >
    <div class="profile-content " id="main">
      <div class="container">
        <div class="tab-content tab-space cd-section" id="body">
      
 <div class="tab-pane active text-center gallery" id="profile">
  <div class="container">
        <div class="row">

          <div class="col-md-12 ml-auto mr-auto" style="margin-bottom: 60px;">
            <div class="profile-tabs">
              <ul class="nav nav-pills nav-pills-icons justify-content-center" id="tabTrack" role="tablist" style="height: 0em;">
                <!--
                                                        color-classes: "nav-pills-primary", "nav-pills-info", "nav-pills-success", "nav-pills-warning","nav-pills-danger"
                                                -->

                <li class="nav-item">
                    <div class="profileFollowing">
              <div class="avatar" data-toggle="modal"  id="#" style="width: 120px;height: 200px;">
                <?php 

                $splitFileString ="";
                $fileChecker = "";


                if (isset($_SESSION["img_src"])) {

                  $splitFileString = strtok(trim($_SESSION["img_src"]), '.' );
                  $fileChecker = strtok('');
                  $fileChecker = strtoupper($fileChecker);
                  
                }


                 

               

                if (isset($_SESSION['img_src']) && ($fileChecker=='JPG' || $fileChecker=='JPEG' || $fileChecker=='PNG')) {

                  $user_img = trim($_SESSION['img_src']);



                         $cmd = $s3->getCommand('GetObject', [
                            'Bucket' => ''.$bucket_name.'',
                            'Key'    => ''.$user_img.'',
                          ]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();
                  echo '<img src="'.$presignedUrl.'" title="edit" alt="Circle Image" class="img-raised rounded-circle img-fluid">';
                  
                }else{
                  echo '<img src="../assets/img/image_placeholder.jpg" title="edit" alt="Circle Image" class="img-raised rounded-circle img-fluid">';
                }


                ?>
              
               </div>
              
            </div>
                </li>
                <li class="nav-item">
                     <h4 style="font-weight: bold;"><?php if (isset($_SESSION['username'])) {
                       echo trim($_SESSION['username']);
                     } ?></h4>
                </li>
              </ul>
            </div>

          </div>

        </div>



    




        <div class="tab-content tab-space">
          <div class="tab-pane active work" id="home">
            <div class="row">

              <div class="col-md-8 ml-auto mr-auto " id="profile_tab_data">
               
                 <?php 

                      if (isset($_SESSION['id']) && isset($_GET['user']) && isset($_GET['id'])) {
                        
                        $user_signed_in_id = $_SESSION['id'];

                        try{

                               $db = pg_connect(getenv("DATABASE_URL"));
                            }catch(Execption $e){
  
                              header('location:oops.php');
                            }

                            	$publickey = pg_escape_string($db, $_GET['user']);

                            	$user_id = pg_escape_string($db, $_GET['id']);


                        if ($user_signed_in_id ==$user_id) {
                        	   header('location:profile.php');
                        }


                           $result = pg_query($db, "SELECT COUNT (id) FROM organization WHERE id = $user_id AND post_type = 'user_post' ");
                          $posts_count = pg_fetch_assoc($result);

                          $result = pg_query($db, "SELECT COUNT (user_following_id) FROM user_follow_user WHERE user_id = $user_id");
                          $following_count = pg_fetch_assoc($result);

                          $result = pg_query($db, "SELECT COUNT (user_following_id) FROM user_follow_user WHERE user_following_id = $user_id");
                          $followers_count = pg_fetch_assoc($result);



                          if (isset($posts_count)) {
                          	 echo '<h4 class="title" style="display: inline-block;margin-right: 5em;">Latest Posts '.$posts_count['count'].'</h4>
                 <h4 class="title" style="display: inline-block; margin-right: 2px;">Stats</h4>';
                          }else{
                          	 echo '<h4 class="title" style="display: inline-block;margin-right: 5em;">Latest Posts 0</h4>
                 <h4 class="title" style="display: inline-block; margin-right: 2px;">Stats</h4>';
                          }


                      if (isset($following_count)) {
                        
                        echo '<li id="following_count" style="display: inline-block;margin-right:3px;">Following <b>'.$following_count['count'].'</b></li>';
                      }

                      if (isset($followers_count)) {
                        
                        echo '<li id="followers_count" style="display: inline-block;">Followers <b>'.$followers_count['count'].'</b></li>';
                      }

                    }

                 ?>
            
                </div>
              </div>
    <div class="text-center gallery">
                <div class="row ">
          <?php


                 $home_list = array();

                 $user_id = "";
                         
                 if (isset($_SESSION['id'])) {
 
                      $user_id = $_SESSION['id'];

                      $db= "";
                      
                      try{
  
                          $db = pg_connect(getenv("DATABASE_URL"));

                      }catch(Execption $e){
            
                          header('location:oops.php');
                      }

                  

//                            $result_one = pg_query($db,"SELECT * FROM organization
// NATURAL JOIN poststate NATURAL JOIN user_follow_organization WHERE publickey in (select DISTINCT publickey from user_follow_organization
// WHERE userid = $user_id) AND user_id =$user_id AND date_submitted 
// is not NULL AND date is not NULL AND date::timestamp >= NOW() ORDER BY organization.date");

                      $result_one = pg_query($db,"SELECT * FROM organization
NATURAL JOIN poststate WHERE publickey in (select DISTINCT publickey from poststate
WHERE user_id = $user_id) AND post_type ='user_post' AND date_submitted 
is not NULL ORDER BY organization.date");


                      
                              if (pg_num_rows($result_one) > 0) {
                  
                        while($row = pg_fetch_assoc($result_one)) { 
      
                            $home_list[] = array("id" => $row["id"],"date" => $row["date"], "img" => $row["img"],"publickey" => $row["publickey"],"views" => $row["views"],"word_tag" => $row["word_tag"],"favorite" => $row["favorite"],"favorites" => $row["favorites"]);
                  
                        }

                        
                    
                    }else{
                      // echo "empty</br></br></br>";
                  
                     }
                    }

                     pg_close($db);

                   


                        if (isset($home_list) && sizeof($home_list) > 0) {
                

                          foreach($home_list as $item) {

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

                // $string = trim($item["word_tag"]);
                // $string = strtolower($string);
                // $token = strtok($string, "_");

 

          if($presignedUrl && strlen(trim($item["img"]))>10 && ($fileChecker=='JPG' || $fileChecker=='JPEG' || $fileChecker=='PNG' || $fileChecker=='MOV')){
                 echo  '<img src="'.$presignedUrl.'" class="img rounded">'; 
              }else{
                 echo  '<img src="../assets/img/image_placeholder.jpg" class="img rounded">';
              } 
 
              
                

                  // if (trim($item['price']) =='0.00' || $item["price"]==NULL || $item["price"]==" ") {

                  //       echo '<div class="top-right h9"> 
                  //       <a href="'.$item['url'].'"><i class="material-icons">strikethrough_s</i></a></div>';

                  //       }else{

                  // echo '<a href="'.$item['url'].'"><div class="top-right h6">$'.trim($item['price']).'</a></div>';
                  
                  // }

                  //  if (isset($token) && $token =='product') {

                  
                  //   echo '<div class="top-left h6" style="width:10px;"><i class="material-icons">store</i></div>';


                  // }else{

                  //   echo '<div class="top-left h6" style="width:10px;">'
                  //      .toString($item['date']).'</div>';

                  // }



                  // echo '<div class="centeredm h4">'.trim($item['title']).'</div>';


                  echo '<div class="bottom-left" style="font-weight: bolder;">
                        <a href="profile.php?publickey='.$item['publickey'].'">';

                        if ($item['favorite']==1) {
                          echo '<i class="material-icons" style="color:red;font-size:18pt;">favorite</i></a></div>';

                        }else{

                          echo '<i class="material-icons" style="font-size:18pt;">favorite</i></a></div>';
                        }

                     

                  // echo '<div class="centered" style="font-weight: bolder;">
                  // <a href="#fav"><i class="material-icons" style="font-size:18pt">favorite_border</i></a></div>';

                 
                  echo '<div class="bottom-right" style="font-weight: bolder;">
                         <a href="#" class="post_chat" data-key="'.$item['publickey'].'" data-id="'.$item['id'].'" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="material-icons" style="font-size:18pt;">chat_bubble_outline</i></a></div>';
 



                echo '</div>';
              
          
              
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

        </div>
      </div>
    </div>
  </div>

 
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-lg">
     <div class="modal-content">
         <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <h3 class="title text-center" style="margin-bottom: 0;padding-bottom: 0 ">Comments</h3>
    <!-- <span class="badge badge-default">3</span> -->
    <!-- <div class="blog-tags title text-center" style="margin-top: 0;padding-top: 0 ">
                  Tags:
                  <span class="badge badge-primary badge-pill">Photography</span>
                  <span class="badge badge-primary badge-pill">Stories</span>
                  <span class="badge badge-primary badge-pill">Castle</span>
    </div> -->
      
      <div class="section section-blog-info" style="margin: 0 0 0 0; padding: 0 0 0 0;">
        <div class="row">
          <div class="col-md-8 ml-auto mr-auto">
            <hr>
            <div class="card card-profile card-plain">
              <div class="row" id="user_post">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="section section-comments" style="display: flex;justify-content: space-around;align-items: flex-start;">
        <div class="row">
          <div class="col-md-12 ml-auto mr-auto" >
            <div class="media-area" id="users_post">
            </div>
       
           
            <div style="position: -webkit-sticky;position: sticky;bottom: 1px;align-self: flex-end;background-color: white">

                <div id="comment_post" >


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


$(document).ready(function() {


  $(document).on('click', '.unfollow_user_follow_btn', function () {

var key=$(this).data("key");
var id=$(this).data("userid");

unfollow_button(id,key);


 function unfollow_button(id,publickey)
 {
  

            $.ajax({
   url:"unfollow_user_follow.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){

       $.ajax({
   url:"fetch_user_connection_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#connection_follow_tab').html(data);
   
     
   }
  })

    $('#following').html(data);
   
             $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })


       $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
   
     
   }
  })

 }

 


    });

  $(document).on('click', '.unfollow_user_btn', function () {

var key=$(this).data("key");
var id=$(this).data("userid");

unfollow_button(id,key);


 function unfollow_button(id,publickey)
 {
  

            $.ajax({
   url:"unfollow_user.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){

       $.ajax({
   url:"fetch_user_connection_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#connection_follow_tab').html(data);
   
     
   }
  })

    $('#following').html(data);
   
             $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })


       $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
   
     
   }
  })

 }

 


    });

    $(document).on('click', '.post_unsubscribe', function () {

var key=$(this).data("publickey");
var id=$(this).data("id");
var pid=$(this).data("pid");


unfollow(pid,id,key);


 function unfollow(pid,id,publickey)
 {


    $.ajax({
   url:"subscription.php",
   method:"POST",
   data : {
        publickey : publickey,
        unsubscribe : publickey 
                    },
   success:function(data){

  
      $.ajax({
   url:"fetch_user_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : pid 
                    },
   success:function(data){
    $('#user_post').html(data);


        $.ajax({
   url:"fetch_users_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : pid 
                    },
   success:function(data){
    $('#users_post').html(data);



   }
  })
     
   }
  })
   
   }
  })
      $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);

      $.ajax({
   url:"fetch_user_connection_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#connection_follow_tab').html(data);

      $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
     
   }
  })
     
   }
  })

 }


    });

  $(document).on('click', '.post_subscribe', function () {

var key=$(this).data("publickey");
var id=$(this).data("id");
var pid=$(this).data("pid");


follow(pid,id,key);


 function follow(pid,id,publickey)
 {


    $.ajax({
   url:"subscription.php",
   method:"POST",
   data : {
        publickey : publickey,
        subscribe : publickey 
                    },
   success:function(data){
 

      $.ajax({
   url:"fetch_user_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : pid 
                    },
   success:function(data){
    $('#user_post').html(data);


        $.ajax({
   url:"fetch_users_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : pid 
                    },
   success:function(data){
    $('#users_post').html(data);



   }
  })
     
   }
  })
   
   }
  })
      $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);

      $.ajax({
   url:"fetch_user_connection_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#connection_follow_tab').html(data);

      $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
     
   }
  })
     
   }
  })

 }


    });

  $(document).on('click', '.post_unfollow_user', function () {

var key=$(this).data("publickey");
var id=$(this).data("id");


unfollow(id,key);


 function unfollow(id,publickey)
 {


    $.ajax({
   url:"unfollow_user.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){

      $('#following').html(data);


      $.ajax({
   url:"fetch_user_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#user_post').html(data);


        $.ajax({
   url:"fetch_users_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#users_post').html(data);
   }
  })
     
   }
  })



      $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);

      $.ajax({
   url:"fetch_user_connection_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#connection_follow_tab').html(data);

      $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
     
   }
  })
     
   }
  })


     



   
   }
  })


 }


    });


$(document).on('click', '.post_follow_user', function () {

var key=$(this).data("publickey");
var id=$(this).data("id");


follow(id,key);


 function follow(id,publickey)
 {


    $.ajax({
   url:"follow_user.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
   
    $('#following').html(data);

    $.ajax({
   url:"fetch_user_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#user_post').html(data);
     
   }
  })


    $.ajax({
   url:"fetch_users_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#users_post').html(data);
   }
  })



 
      $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){

    $('#profile_tab_data').html(data);
         $.ajax({
   url:"fetch_user_connection_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#connection_follow_tab').html(data);

          $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
     
   }
  })
     
   }
  })



  


   }
  })



 




 }


    });

$(document).on('click', '.remove_comment', function () {

    var key=$(this).data("key");
    var id=$(this).data("id");
    var uid=$(this).data("userid");
    var time=$(this).data("time");
     

  remove_post(uid,id,key,time);




 function remove_post(uid,id,publickey,time)
 {

        $.ajax({
   url:"remove_user_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid,
        time : time 
                    },
   success:function(data){

  $.ajax({
   url:"fetch_users_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#users_post').html(data);
   }
  })


    $.ajax({
   url:"fetch_user_comment_form.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id ,
        uid : uid
                    },
   success:function(data){
    $('#comment_post').html(data);
   }
  })

   }
  })


       $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
    
            $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#followers').html(data);
            $.ajax({
   url:"fetch_user_following.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })
   }
  })
   

 

 }

 


    });






$(document).on('click', '.edit_comment', function () {

    var key=$(this).data("key");
    var uid=$(this).data("userid");
    var id=$(this).data("id");
    var time=$(this).data("time");
    var username=$(this).data("username");
    var replyid=$(this).data("replyid");
    var post=$("#postText").val();




edit_comment(uid,id,key,time,username,replyid,post);


 function edit_comment(uid,id,publickey,time,username,replyid,post)
 {





  $.ajax({
   url:"user_post_comment.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid,
        post : post,
        username : username,
        time : time,
        username : username,
        replyid : replyid,
        post : post
                    },
   success:function(data){
    $('#cleanPost').html(data);


        $.ajax({
   url:"fetch_users_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id
                    },
   success:function(data){
    $('#users_post').html(data);
   }
  })




    $.ajax({
   url:"fetch_user_comment_form.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id ,
        uid : uid
                    },
   success:function(data){
    $('#comment_post').html(data);
   }
  })


       $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
             $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#followers').html(data);
            $.ajax({
   url:"fetch_user_following.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })
     
   }
  }) 
   
   }
  })


 

 }
 


    });


$(document).on('click', '.back_post', function () {

var key=$(this).data("key");
var id=$(this).data("id");
var uid=$(this).data("uid");



back_post(uid,id,key);


 function back_post(uid,id,publickey)
 {


    $.ajax({
   url:"fetch_user_comment_form.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id,
        uid : uid 
                    },
   success:function(data){
    $('#comment_post').html(data);
   }
  })


          $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
    
              $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#followers').html(data);
            $.ajax({
   url:"fetch_user_following.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })
   }
  })

 }


    });

$(document).on('click', '.reply_comment', function () {

var key=$(this).data("key");
var id=$(this).data("userid");



reply_post(id,key);


 function reply_post(id,publickey)
 {


    $.ajax({
   url:"fetch_user_comment_form.php",
   method:"POST",
   data : {
        publickey : publickey,
        replyid : id,
        id : id 
                    },
   success:function(data){
    $('#comment_post').html(data);
   }
  })

 }

       $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
             $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
            $.ajax({
   url:"fetch_user_following.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })
     
   }
  })


    });


  $(document).on('click', '.edit_post', function () {
         


          var key=$(this).data("key");
          var id=$(this).data("id");
          var uid=$(this).data("uid");
          var username=$(this).data("username");
          var post=$(this).data("message");
          var time=$(this).data("time");


          edit_post(uid,id,key,post,username,time);

           function edit_post(uid,id,publickey,post,username,time){

           


                  $.ajax({
                        url:"fetch_user_comment_form.php",
                        method:"POST",
                        data : {
                        publickey : publickey,
                        id : id,
                        uid : uid,
                        time : time,
                        username : username,
                        message : post
                    },
                        success:function(data){
                         $('#comment_post').html(data);
                          }
                   })


                        $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
    
              $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#followers').html(data);
            $.ajax({
   url:"fetch_user_following.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })
   }
  })


           }
        

    });




    $(document).on('click', '.favPost', function () {
         


          var key=$(this).data("key");
          var id=$(this).data("userid");
          var username=$(this).data("username");
          var time=$(this).data("time");
          

          fav_post(id,key,username,time);

           function fav_post(id,publickey,username,time){


                  $.ajax({
                        url:"fav_message.php",
                        method:"POST",
                        data : {
                        publickey : publickey,
                        id : id,
                        time : time,
                        username : username
                    },
                        success:function(data){
                             

                           $.ajax({
     url:"fetch_users_post.php",
      method:"POST",
        data : {
        publickey : publickey,
        id : id 
        },
       success:function(data){
        $('#users_post').html(data);
         }
    })
      $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
             $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
            $.ajax({
   url:"fetch_user_following.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })
     
   }
  })


                          }
                   })


 
           }
        

    });

     $(document).on('click', '.post_comment', function () {

 

var key=$(this).data("key");
var id=$(this).data("userid");
var pid =$(this).data("id");
var username=$(this).data("username");
var replyid=$(this).data("replyid");
var post=$("#postText").val();

 
user_post(pid,id,key,post,username,replyid);


 function user_post(pid,id,publickey,post,username,replyid)
 {
 
 
  $.ajax({
   url:"user_post_comment.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id,
        post : post,
        username : username,
        replyid : replyid 
                    },
   success:function(data){

    $('#cleanPost').html(data);

        $.ajax({
   url:"fetch_users_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : pid 
                    },
   success:function(data){
    $('#users_post').html(data);
   }
  })

          $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
             $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
            $.ajax({
   url:"fetch_user_following.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })
     
   }
  })
   
   }
  })


 



 }

});

$(document).on('click', '.post_chat', function () {

 
var key=$(this).data("key");
var id=$(this).data("id");

 
fetch_user(id,key);


 function fetch_user(id,publickey)
 {

 
 
  $.ajax({
   url:"fetch_user_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#user_post').html(data);
     
   }
  })


    $.ajax({
   url:"fetch_users_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#users_post').html(data);
        $.ajax({
   url:"fetch_user_comment_form.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#comment_post').html(data);
   }
  })
   }
  })



          $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
    
              $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
            $.ajax({
   url:"fetch_user_following.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })
   }
  })

 }

});


   });
 
</script>



 
 
  
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

<script type="text/javascript">
  
  function followingFunction(){


    var follower = document.getElementById("followers");
    var following = document.getElementById("following");
    var follower_color = document.getElementById("fe");
    var following_color = document.getElementById("fg");

        following.style.display = "block";
        follower.style.display = "none";
        following_color.style.color = "#3c4858";
        follower_color.style.color = "black";
        

  }

</script>

 <script>
function followerFunction() {

  var follower = document.getElementById("followers");
  var following = document.getElementById("following");
  var follower_color = document.getElementById("fe");
  var following_color = document.getElementById("fg");


    follower.style.display = "block";
    following.style.display = "none";
    follower_color.style.color = "#3c4858";
    following_color.style.color = "black";
  

}
</script>
 <script>
function hide() {

  var followers = document.getElementById("followers");
 


    followers.style.display = "none";
  
  

}
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
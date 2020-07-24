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
  
 
 
</head>
 
<body class="profile-page  sidebar-collapse" onload="hide()">
 
 
<nav class="navbar navbar-expand-lg bg-primary cd-section" id="nav">
    <div class="container">
  

        <div class="navbar-translate">
              <ul class="nav  navbar-nav" id="tabTrackMain" role="tablist">
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
                  <a class="nav-link active" href="#home" role="tab" data-toggle="tab">
                    <i class="material-icons">home</i>home
                  
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#connections" role="tab" data-toggle="tab">
                    <i class="material-icons">supervisor_account</i>connect
                    <!-- <i class="material-icons">supervised_user_circle</i> --> 
                
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#posted" role="tab" data-toggle="tab">
                    <i class="material-icons">insights</i>products
                    
                  </a>
                </li>

                <li class="nav-item">
                    <div class="profileFollowing">
              <div class="avatar" style="width: 120px;height: 200px;">
                <?php 

                if (isset($_SESSION['img_src'])) {

                  $user_img = trim($_SESSION['img_src']);

                         $cmd = $s3->getCommand('GetObject', [
                            'Bucket' => ''.$bucket_name.'',
                            'Key'    => ''.$user_img.'',
                          ]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();
                  echo '<img src="'.$presignedUrl.'" title="edit" data-toggle="modal" data-target="#uploadImage" alt="Circle Image" class="img-raised rounded-circle img-fluid">';
                  
                }else{
                  echo '<img src="../assets/img/image_placeholder.jpg" title="edit" data-toggle="modal" data-target="#uploadImage" alt="Circle Image" class="img-raised rounded-circle img-fluid">';
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

          <div class="modal fade" id="uploadImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">edit picture</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php 

        echo'<form enctype="multipart/form-data" method="post" action="'.$_SERVER['PHP_SELF'].'">
  <label>upload profile picture</label>
                 <div class="row"> 
                  <div class="col-md-4"></div>
                  <div class="col-md-4">
                   
                          <div class="form-group form-file-upload form-file-simple">
    <input type="text" class="form-control inputFileVisible" placeholder="upload image..." required>
    <input type="file" name="file1" class="inputFileHidden">
  </div>
                    </div>

                </div><button type="submit" class="btn radius-50   btn-default-transparent btn-bg " name="image" value="img" style="display:inline-block">upload</button></form>

              </div>';


          
if (isset($_POST['image']) && isset($_SESSION['id'])) {
  

$userid = $_SESSION['id'];
$randomString = " ";


//stores file to aws S3
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file1']) && $_FILES['file1']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['file1']['tmp_name'])) {

    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
   
    $n = 15;
  
    for ($i = 0; $i < $n; $i++) { 
        $index = rand(0, strlen($characters) - 1); 
        $randomString .= $characters[$index]; 
    } 
 
$source = fopen($_FILES['file1']['tmp_name'], 'rb');
$key =  "user_profile_img/".$randomString.''. $_FILES['file1']['name']; 

$destination = $key;

    $uploader = new ObjectUploader(
    $s3,
    $bucket_name,
    $key,
    $source 
);
    try
{
    // echo 'Attempting to delete ' . $keyname . '...' . PHP_EOL;

     try{

 $db = pg_connect(getenv("DATABASE_URL"));
}catch(Execption $e){
  header('location:oops.php');
}

$keyname = "";
if (isset($_SESSION['img_src'])) {
  $keyname = trim($_SESSION['img_src']);
}

$result = pg_query($db, "UPDATE public.users SET profile_pic_src=null WHERE id = $userid");

    $result = $s3->deleteObject([
        'Bucket' => $bucket_name,
        'Key'    => $keyname
    ]);

    if ($result['DeleteMarker'])
    {
        // echo $keyname . ' was deleted or does not exist.' . PHP_EOL;
    } else {
        // exit('Error: ' . $keyname . ' was not deleted.' . PHP_EOL);
    }
}
catch (S3Exception $e) {
    // exit('Error: ' . $e->getAwsErrorMessage() . PHP_EOL);
}

// 2. Check to see if the object was deleted.
// try
// {
//     // echo 'Checking to see if ' . $keyname . ' still exists...' . PHP_EOL;

//     // $result = $s3->getObject([
//     //     'Bucket' => $bucket,
//     //     'Key'    => $keyname
//     // ]);

//     // echo 'Error: ' . $keyname . ' still exists.';
// }
// catch (S3Exception $e) {
//     exit($e->getAwsErrorMessage());
// } 
   
    try {
       
        $upload = $uploader->upload($bucket, $destination, fopen($_FILES['file1']['tmp_name'], 'rb'), 'public-read');

          $image_src = $destination;

          unset($_SESSION['img_src']);

          $_SESSION['img_src'] = $destination;

 
            $db = pg_connect(getenv("DATABASE_URL"));
            // Check connection
            if (!$db) {
              die("Connection failed: " . pg_connect_error());
              header('location:oops.php');
            }

            // update user image
            pg_query($db,"UPDATE users SET profile_pic_src ='$image_src' WHERE id= $userid ");
 

            pg_close($db);

          


            } catch(Exception $e){
               header('location:oops.php');
          }

}else{
 
}

}

                ?>
      </div>
      <div class="modal-footer">
  
      </div>
    </div>
  </div>
</div>
        <div class="tab-content tab-space">
          <div class="tab-pane active work" id="home">
            <div class="row">

              <div class="col-md-8 ml-auto mr-auto ">
                <h4 class="title" style="display: inline-block;margin-right: 5em;">Latest Collections</h4>
                 <h4 class="title" style="display: inline-block; margin-right: 2px;">Stats</h4>
                 <?php 

                      if (isset($_SESSION['id'])) {
                        
                        $user_id = $_SESSION['id'];

                        try{

                               $db = pg_connect(getenv("DATABASE_URL"));
                            }catch(Execption $e){
  
                              header('location:oops.php');
                            }


                          $result = pg_query($db, "SELECT COUNT (id) FROM organization WHERE id = $user_id");
                          $product_count = pg_fetch_assoc($result);

                          $result = pg_query($db, "SELECT COUNT (user_following_id) FROM user_follow_user WHERE user_id = $user_id");
                          $following_count = pg_fetch_assoc($result);

                          $result = pg_query($db, "SELECT COUNT (user_following_id) FROM user_follow_user WHERE user_following_id = $user_id");
                          $followers_count = pg_fetch_assoc($result);

                          $result = pg_query($db, "SELECT COUNT (user_id) FROM temporary_tag_schedule WHERE user_id = $user_id");
                          $tag_schedule_count = pg_fetch_assoc($result);

                           $result = pg_query($db, "SELECT COUNT (userid) FROM user_follow_organization WHERE userid = $user_id");
                          $user_follow_organization_count = pg_fetch_assoc($result);



                      

                      if (isset($product_count)) {
                        echo ' <li style="display: inline-block;margin-right:3px;">Products <b>'.$product_count['count'].'</b> </li>';
                      }

                      if (isset($tag_schedule_count) && isset($user_follow_organization_count)) {

                        $collections_num_count =0;

                        $collections_num_count = $tag_schedule_count['count'] +  $user_follow_organization_count['count'];

                        echo '<li style="display: inline-block;margin-right:3px;">Collections <b>'.$collections_num_count.'</b></li>';
                        
                      }

                      if (isset($following_count)) {
                        
                        echo '<li style="display: inline-block;margin-right:3px;">Following <b>'.$following_count['count'].'</b></li>';
                      }

                      if (isset($followers_count)) {
                        
                        echo '<li style="display: inline-block;">Followers <b>'.$followers_count['count'].'</b></li>';
                      }

                    }

                 ?>
            
                </div>
              </div>
    
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

                           $result_one = pg_query($db,"SELECT * FROM user_follow_organization NATURAL JOIN organization NATURAL JOIN poststate WHERE id = $user_id AND date_submitted is not NULL AND date is not NULL AND date::timestamp >= NOW()");


                      


                          if (pg_num_rows($result_one) > 0) {
                  
                        while($row = pg_fetch_assoc($result_one)) { 
      
                            $home_list[] = array("date" => $row["date"], "time" => $row["time"], "price"=> $row["fiatvalue"], "img" => $row["img"],"publickey" => $row["publickey"],"description" => $row["description"],"views" => $row["views"],"word_tag" => $row["word_tag"],"email" => $row["email"],"content" => $row["content"],"address" => $row["address"],"url" => $row["url"],"phonenumber" => $row["phonenumber"],"organization_name" => $row["organization_name"],"favorite" => $row["favorite"],"favorites" => $row["favorites"]);
                  
                        }

                        
                    
                    }else{
                      // echo "empty</br></br></br>";
                  
                     }


                           $result_two = pg_query($db,"SELECT * FROM temporary_tag_schedule NATURAL JOIN organization NATURAL JOIN poststate WHERE id = $user_id AND date_submitted is not NULL AND date is not NULL AND date::timestamp >= NOW()");

                         

                              if (pg_num_rows($result_two) > 0) {
                  
                        while($row = pg_fetch_assoc($result_two)) { 
      
                            $home_list[] = array("date" => $row["date"], "time" => $row["time"], "price"=> $row["fiatvalue"], "img" => $row["img"],"publickey" => $row["publickey"],"description" => $row["description"],"views" => $row["views"],"word_tag" => $row["word_tag"],"email" => $row["email"],"content" => $row["content"],"address" => $row["address"],"url" => $row["url"],"phonenumber" => $row["phonenumber"],"organization_name" => $row["organization_name"],"favorite" => $row["favorite"],"favorites" => $row["favorites"]);
                  
                        }

                        
                    
                    }else{

                  // echo "empty</br></br></br>";
                     }



                  // the products or things the user posted 

                  //          $result_three = pg_query($db,"SELECT * FROM organization NATURAL JOIN poststate WHERE id= $user_id AND date_submitted is not NULL AND date is not NULL AND date::timestamp >= NOW()");

                             


                  //                if (pg_num_rows($result_three) > 0) {
                  
                  //       while($row = pg_fetch_assoc($result_three)) { 
      
                  //           $home_list[] = array("date" => $row["date"], "time" => $row["time"], "price"=> $row["fiatvalue"], "img" => $row["img"],"publickey" => $row["publickey"],"description" => $row["description"],"views" => $row["views"],"word_tag" => $row["word_tag"],"email" => $row["email"],"content" => $row["content"],"address" => $row["address"],"url" => $row["url"],"phonenumber" => $row["phonenumber"],"organization_name" => $row["organization_name"],"favorite" => $row["favorite"],"favorites" => $row["favorites"]);
                  
                  //       }

                         
                    
                  //   }else{

                  // // echo "empty</br></br></br>";
                  //    }

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

           
                
 

          if($presignedUrl){
                 echo  '<img src="'.$presignedUrl.'" class="img rounded">'; 
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
                        <a href="profile.php?publickey='.$item['publickey'].'">';

                        if ($item['favorite']==1) {
                          echo '<i class="material-icons" style="color:red;font-size:18pt;">favorite</i></a></div>';

                        }else{

                          echo '<i class="material-icons" style="font-size:18pt;">favorite</i></a></div>';
                        }

                     

                  // echo '<div class="centered" style="font-weight: bolder;">
                  // <a href="#fav"><i class="material-icons" style="font-size:18pt">favorite_border</i></a></div>';

                 
                  echo '<div class="bottom-right" style="font-weight: bolder;">
                         <a href="#"><i class="material-icons" style="font-size:18pt;">chat_bubble_outline</i></a></div>';
 



                echo '</div>';
              
          
              
            echo '</div>';


                       }
                     }



                    }

          ?>



              </div>



             
           
          </div>






          <div class="tab-pane connections" id="connections">
            <div class="row">

                <div class="col-md-4 ml-auto mr-auto">
              
              </div>
<?php 

  $followerArr = array();
  $userid =0;

if (isset($_SESSION['id'])) {

  $userid = $_SESSION['id'];
}

  try{

 $db = pg_connect(getenv("DATABASE_URL"));
}catch(Execption $e){
  header('location:oops.php');
}

$result = pg_query($db, "SELECT user_id, username, email, profile_pic_src
  FROM public.user_follow_user NATURAL JOIN users WHERE user_following_id = $userid");



 if (pg_num_rows($result) > 0) {
                  // output data of each row
                    while($row = pg_fetch_assoc($result)) { 
      
                      $followerArr[] = array("user_id" => $row["user_id"], "username" => $row["username"], "email"=> $row["email"], "img" => $row["profile_pic_src"]);
                  
                  }

            pg_close($db);

}else{

}


  $followingArr = array();

  try{

 $db = pg_connect(getenv("DATABASE_URL"));
}catch(Execption $e){
  header('location:oops.php');
}

$result = pg_query($db, "SELECT user_following_id, username, email, profile_pic_src
  FROM public.user_follow_user NATURAL JOIN users WHERE user_id = $userid");



 if (pg_num_rows($result) > 0) {
                  // output data of each row
                    while($row = pg_fetch_assoc($result)) { 
      
                      $followingArr[] = array("user_following_id" => $row["user_following_id"], "username" => $row["username"], "email"=> $row["email"], "img" => $row["profile_pic_src"]);
                  
                  }

            pg_close($db);
          }else{

          }


?>
              <div class="col-md-2 ml-auto mr-auto" style="margin-right: 2em;">
                <a href="#friends" style="text-decoration: none;color:#3c4858;" id="fg" onclick="followingFunction()" >
                  <?php 

                  if (isset($followingArr)) {
                    echo '<h3 style="margin-bottom: 70px; font-weight: bold">'.sizeof($followingArr).' Following</h3>';
                  }

                  ?>
              
            </a>
              </div>
              
          




              <div class="col-md-2 mr-auto ml-auto">
                <a href="#friends" style="text-decoration: none;color: black" id="fe" onclick="followerFunction()" >
                  <?php

                  if (isset($followerArr)) {
                    echo '<h3 style="margin-bottom: 70px;font-weight: bold">'.sizeof($followingArr).' Followers</h3>';
                  }

                   ?>
              </a>
              </div>


                  <div class="col-md-3 ml-auto mr-auto">

              
              </div>
            </div>
         
          


            <?php 


echo '<div id="followers" class="col-md-12 followers" style="background-color: white;width: 100%;display: flex;    overflow-x: auto; border-radius: 2px;">';

           


            //     if (isset($_SESSION['img_src'])) {
                
            //   $user_img = trim($_SESSION['img_src']);

            //              $cmd = $s3->getCommand('GetObject', [
            //                 'Bucket' => ''.$bucket_name.'',
            //                 'Key'    => ''.$user_img.'',
            //               ]);

            //   $request = $s3->createPresignedRequest($cmd, '+20 minutes');

            //   $presignedUrl = (string)$request->getUri();


          

            //   echo '<div class="profileUser" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
            //   <div class="avatar" style="width: 200px;">
            //     <img src="'.$presignedUrl.'" class="img-raised rounded-circle img-fluid">
            //   </div>
            //   <div class="name">
            //     <h6 class="title">'.$_SESSION['username'].'</h6>
                
            //   </div>
            // </div>';

            // }else{

            //   echo '<div class="profileUser" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
            //   <div class="avatar" style="width: 200px;">
            //     <img src="../assets/img/image_placeholder.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
            //   </div>
            //   <div class="name">
            //     <h6 class="title">'.$_SESSION['username'].'</h6>
                
            //   </div>
            // </div>';

            // }


 
 
              
            if (isset($followerArr)) {
              
              foreach($followerArr as $item) {


                if (isset($item['img'])) {
                 $user_img = trim($item['img']);

                         $cmd = $s3->getCommand('GetObject', [
                            'Bucket' => ''.$bucket_name.'',
                            'Key'    => ''.$user_img.'',
                          ]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();


                echo '<div class="profileFollowers" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
              <div class="avatar" style="width: 120px;">
                <img src="'.$presignedUrl.'" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">'.$item['username'].'</h6> <h16 style="font-size: 12px;"><a href=""><span class="material-icons">remove_circle_outline</span></a></h16>
                </div>
            </div>';
                }else{

                  echo '<div class="profileFollowers" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
              <div class="avatar" style="width: 120px;">
                <img src="../assets/img/image_placeholder.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">'.$item['username'].'</h6> <h16 style="font-size: 12px;"><a href=""><span class="material-icons">remove_circle_outline</span></a></h16>
                </div>
            </div>';
                }

                 

            }



            }

            echo '</div>';

            ?>
            






      
<?php


 echo '<div id="following" class="col-md-12" style="background-color: white;width: 100%;display: flex;    overflow-x: auto; border-radius: 2px;">';



            //     if (isset($_SESSION['img_src'])) {
                
            //   $user_img = trim($_SESSION['img_src']);

            //              $cmd = $s3->getCommand('GetObject', [
            //                 'Bucket' => ''.$bucket_name.'',
            //                 'Key'    => ''.$user_img.'',
            //               ]);

            //   $request = $s3->createPresignedRequest($cmd, '+20 minutes');

            //   $presignedUrl = (string)$request->getUri();


          

            //   echo '<div class="profileUser" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
            //   <div class="avatar" style="width: 200px;">
            //     <img src="'.$presignedUrl.'" class="img-raised rounded-circle img-fluid">
            //   </div>
            //   <div class="name">
            //     <h6 class="title">'.$_SESSION['username'].'</h6>
                
            //   </div>
            // </div>';

            // }else{

            //   echo '<div class="profileUser" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
            //   <div class="avatar" style="width: 200px;">
            //     <img src="../assets/img/image_placeholder.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
            //   </div>
            //   <div class="name">
            //     <h6 class="title">'.$_SESSION['username'].'</h6>
                
            //   </div>
            // </div>';

            // }


 
              
            if (isset($followingArr)) {
              
              foreach($followingArr as $item) {


                if (isset($item['img'])) {
                 $user_img = trim($item['img']);

                         $cmd = $s3->getCommand('GetObject', [
                            'Bucket' => ''.$bucket_name.'',
                            'Key'    => ''.$user_img.'',
                          ]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();


                echo '<div class="profileFollowing" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
              <div class="avatar" style="width: 120px;">
                <img src="'.$presignedUrl.'" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">'.$item['username'].'</h6> <h16 style="font-size: 12px;"><a href=""><span class="material-icons">remove_circle_outline</span></a></h16>
                </div>
            </div>';
                }else{

                  echo '<div class="profileFollowing" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
              <div class="avatar" style="width: 120px;">
                <img src="../assets/img/image_placeholder.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">'.$item['username'].'</h6> <h16 style="font-size: 12px;"><a href=""><span class="material-icons">remove_circle_outline</span></a></h16>
                </div>
            </div>';
                }

                 

            }



            }
          
            echo '</div>';
          

            ?>
 
       
            
          </div>
          <div class="tab-pane text-center gallery" id="posted" style="margin-top: 70px">

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
                        "description" => $row['description'], "content" => $row['content'], "publickey" => $row['publickey'], "price" => $row['fiatvalue'], "views" => $row['views'], "date_submitted" => $row['date_submitted'], "payment_type" => $row['payment_type'], "favorites" => $row['favorites'],"user_id" => $row['user_id'], "favorite" => $row['favorite'], "message" => $row['message']);


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



                        function compare_date($arr1, $arr2)
                          {
                            $time1 = strtotime($arr1['date_submitted']);
                            $time2 = strtotime($arr2['date_submitted']);
                            return $time1 - $time2;
                          }    
                          
                          usort($product_list, 'compare_date');

                          foreach($product_list as $item) {

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
          <?php 

            if (isset($_SESSION['id'])) { 





                echo '<form method="POST">
            <div class="media media-post">
              <a class="author float-left" href="#pablo">
                <div class="avatar">';

                    if (isset($_SESSION['img_src'])) {

                  $user_img = trim($_SESSION['img_src']);

                         $cmd = $s3->getCommand('GetObject', [
                            'Bucket' => ''.$bucket_name.'',
                            'Key'    => ''.$user_img.'',
                          ]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();

                   echo '<img class="media-object" src="'.$presignedUrl.'">';
                  
                }else{
                  echo '<img class="media-object" src="../assets/img/image_placeholder.jpg">';
                }
                   

                echo'</div>
              </a>
              <div class="media-body">
                <div class="form-group label-floating bmd-form-group">
                  <label class="form-control-label bmd-label-floating" for="exampleBlogPost"> Comment to mani_alshars post..</label>
                  <textarea class="form-control" rows="5" id="exampleBlogPost"></textarea>
                </div>
                <div class="media-footer" id="comment_post">
                  
                </div>
              </div>
            </div>  
          </form>';
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


  // $(document).on('click', '. post_comment', function () {


// var key=$(this).data("key");
// var id=$(this).data("id");

// user_post(id,key);


//  function user_post(id,publickey)
//  {

 
//   $.ajax({
//    url:"user_post_comment.php",
//    method:"POST",
//    data : {
//         publickey : publickey,
//         id : id 
//                     },
//    success:function(data){
//     $('#user_post').html(data);
//    }
//   })






//  }

// });

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
   }
  })

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

});

 
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
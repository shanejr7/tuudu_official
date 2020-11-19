<?php  
/* DOCS

  * 
  * profile.php --> feed_state.php <user generated data>
  *
  
*/

include('feed_state.php'); // retrieves organizations for users



   
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
                  <li class="nav-item active">
                  <a class="nav-link active" href="#profile" role="tab" data-toggle="tab">
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
        <div class="" id="body">
          <!-- tab-content tab-space cd-section -->
      
 <div class="" id="profile">
  <!-- tab-pane active text-center gallery -->
  <div class="container">
<!-- row -->

          <div class="modal fade" tabindex="-1" role="dialog" id="uploadImage" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
    
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php 
        $id_av ="";

        if (isset($_SESSION['id'])) {
          $id_av= $_SESSION['id'];
        }


        echo'<form enctype="multipart/form-data" method="post" action="user_image_upload.php">
 
                <div class="form-group label-floating has-success">
                  <label class="control-label">EDIT PROFILE PICTURE</label>
                  </div>
                 <div class="row"> 
                  <div class="col-md-3"></div>
                  <div class="col-md-6">
                   
                          <div class="form-group form-file-upload form-file-simple">
    <input type="text" class="form-control inputFileVisible" placeholder="upload image..." required>
    <input type="file" name="file1" class="inputFileHidden">
  </div>
                    </div>

                </div><button type="submit" class="avatar_uploader_form btn radius-50 btn-default-transparent btn-bg " data-userid="'.$id_av.'" name="image" value="img" style="display:inline-block">upload</button></form>

              </div>';

                ?>
      </div>
      <div class="modal-footer">
  
      </div>
    </div>
  </div>
</div>

          <div class="modal fade" tabindex="-1" role="dialog" id="uploadPost" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php 
        $id_av ="";

        if (isset($_SESSION['id'])) {
          $id_post= $_SESSION['id'];
        }


        echo'<form enctype="multipart/form-data" method="post" action="user_post_upload.php">
                 
                  <div class="form-group label-floating has-success">
                  <label class="control-label">POST</label>
                  </div>
                  <div class="row"> 
                
                  <div class="col-md-3"></div>
                  <div class="col-md-6">
                   
                  <div class="form-group form-file-upload form-file-simple">
                     <input type="text" class="form-control inputFileVisible" placeholder="upload image..." required>
                     
                     <input type="file" name="file1" class="inputFileHidden">
  
                  </div>

                  <div class="form-group label-floating has-success">
                    <label class="control-label">Post title</label>
                    <input type="text" value="" name="title" class="form-control" />
                    <span class="form-control-feedback">
                    <i class="material-icons">art_track</i>
                    </span>
  </div>

                    </div>

                </div><button type="submit" class="avatar_uploader_form btn radius-50 btn-default-transparent btn-bg " data-userid="'.$id_post.'" name="imagePost" value="img" style="display:inline-block">upload</button></form>

              </div>';

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

              <div class="col-md-8 ml-auto mr-auto " id="profile_tab_data">
                 <?php 

                      if (isset($_SESSION['id'])) {
                        
                        $user_id = $_SESSION['id'];

                        try{

                               $db = pg_connect(getenv("DATABASE_URL"));
                            }catch(Execption $e){
  
                              header('location:oops.php');
                            }

                          $result = pg_query($db, "SELECT COUNT(*) FROM organization WHERE id = $user_id AND post_type = 'user_post' ");
                          $posts_count = pg_fetch_assoc($result);

                          $result = pg_query($db, "SELECT COUNT (id) FROM organization WHERE id = $user_id AND post_type != 'user_post' ");
                          $product_count = pg_fetch_assoc($result);

                          $result = pg_query($db, "SELECT COUNT (user_following_id) FROM user_follow_user WHERE user_id = $user_id");
                          $following_count = pg_fetch_assoc($result);

                          $result = pg_query($db, "SELECT COUNT (user_following_id) FROM user_follow_user WHERE user_following_id = $user_id");
                          $followers_count = pg_fetch_assoc($result);

                          $result = pg_query($db, "SELECT COUNT (user_id) FROM temporary_tag_schedule WHERE user_id = $user_id");
                          $tag_schedule_count = pg_fetch_assoc($result);

                           $result = pg_query($db, "SELECT COUNT (userid) FROM user_follow_organization WHERE userid = $user_id");
                          $user_follow_organization_count = pg_fetch_assoc($result);



                      
                        if (isset($posts_count)) {
                             echo '<h4 class="title" style="display: inline-block;margin-right: 5em;">Latest <a class="nav-link active" href="#home" role="tab" data-toggle="tab">Posts</a> '.$posts_count['count'].'</h4>
                 <h4 class="title" style="display: inline-block; margin-right: 2px;">Stats</h4>';
                          }else{
                             echo '<h4 class="title" style="display: inline-block;margin-right: 5em;">Latest <a class="nav-link active" href="#home" role="tab" data-toggle="tab">Posts</a> 0</h4>
                 <h4 class="title" style="display: inline-block; margin-right: 2px;">Stats</h4>';
                          }


                      if (isset($product_count)) {

                        $products_num_count =0;

                        $products_num_count = $product_count['count'];
                        
                        echo ' <a  class="nav-link" href="#posted" role="tab" data-toggle="tab"><li style="display: inline-block;margin-right:3px;">Products <b>'.$products_num_count.'</b> </li></a>';
                      }

                      if (isset($tag_schedule_count) && isset($user_follow_organization_count)) {

                        $collections_num_count =0;

                        $collections_num_count = $tag_schedule_count['count'] +  $user_follow_organization_count['count'];

                        echo '<li style="display: inline-block;margin-right:3px;">Collections <b>'.$collections_num_count.'</b></li>';
                        
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
WHERE user_id = $user_id AND type='user_post') AND post_type ='user_post' AND type ='user_post' AND date_submitted 
is not NULL ORDER BY organization.date");


                      
                              if (pg_num_rows($result_one) > 0) {
                  
                        while($row = pg_fetch_assoc($result_one)) { 
      
                            $home_list[] = array("id" => $row["id"],"date" => $row["date"], "img" => $row["img"],"publickey" => $row["publickey"],"views" => $row["views"],"word_tag" => $row["word_tag"],"favorite" => $row["favorite"],"favorites" => $row["favorites"],"description" => $row["description"]);
                  
                        }

                        
                    
                    }else{
                      // echo "empty</br></br></br>";
                  
                     }
                   

                    //       if (pg_num_rows($result_one) > 0) {
                  
                    //     while($row = pg_fetch_assoc($result_one)) { 
      
                    //         $home_list[] = array("id" => $row["orgid"],"date" => $row["date"], "time" => $row["time"], "price"=> $row["fiatvalue"], "img" => $row["img"],"publickey" => $row["publickey"],"description" => $row["description"],"views" => $row["views"],"word_tag" => $row["word_tag"],"email" => $row["email"],"content" => $row["content"],"address" => $row["address"],"url" => $row["url"],"phonenumber" => $row["phonenumber"],"organization_name" => $row["organization_name"],"favorite" => $row["favorite"],"favorites" => $row["favorites"]);
                  
                    //     }

                        
                    
                    // }else{
                    //   // echo "empty</br></br></br>";
                  
                    //  }


                  //          $result_two = pg_query($db,"SELECT * FROM temporary_tag_schedule NATURAL JOIN organization NATURAL JOIN poststate WHERE id = $user_id AND date_submitted is not NULL AND date is not NULL AND date::timestamp >= NOW() ORDER BY organization.date");

                         

                  //             if (pg_num_rows($result_two) > 0) {
                  
                  //       while($row = pg_fetch_assoc($result_two)) { 
      
                  //           $home_list[] = array("id" => $row["orgid"],"date" => $row["date"], "time" => $row["time"], "price"=> $row["fiatvalue"], "img" => $row["img"],"publickey" => $row["publickey"],"description" => $row["description"],"views" => $row["views"],"word_tag" => $row["word_tag"],"email" => $row["email"],"content" => $row["content"],"address" => $row["address"],"url" => $row["url"],"phonenumber" => $row["phonenumber"],"organization_name" => $row["organization_name"],"favorite" => $row["favorite"],"favorites" => $row["favorites"]);
                  
                  //       }

                        
                    
                  //   }else{

                  // // echo "empty</br></br></br>";
                  //    }



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

               // id for post on page

                $randomString = "";
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
   
                $n = 10;
              
  
    for ($i = 0; $i < $n; $i++) { 
        $index = rand(0, strlen($characters) - 1); 
        $randomString .= $characters[$index]; 
    } 

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

                  //   if (isset($token) && $token =='product') {

                  
                  //   echo '<div class="top-left h6" style="width:10px;"><i class="material-icons">store</i></div>';


                  // }else{

                  //   echo '<div class="top-left h6" style="width:10px;">'
                  //      .toString($item['date']).'</div>';

                  // }

              echo '<div class="top-left h6" style="width:10px;">'
                       .toString($item['date']).'</div>';

               echo '<div  class="top-rightOpacity h6" style="width:10px;" id="like'.$randomString.'">
               <a href="#remove" data-toggle="modal" data-target=".bd-example-modal-sm">
               <i class="material-icons">more_horiz</i>
               </a>
               </div>';



                  echo '<div class="centeredm h4">'.trim($item['description']).'</div>';


              echo '<div class="bottom-left" style="font-weight: bolder;" id="postLike'.$randomString.'">
                        <a href="#postLike'.$randomString.'" class="fav_chat" data-key="'.$item['publickey'].'" data-id="'.$item['id'].'" data-cid="'.$randomString.'" data-toggle="0">';

                        if ($item['favorite']==1) {
                          echo '<i class="material-icons" style="color:red;font-size:18pt;">favorite</i></a>';

                        }else{

                          echo '<i class="material-icons" style="font-size:18pt;">favorite</i></a>';
                        }

                     echo '</div>';

                  // echo '<div class="centered" style="font-weight: bolder;">
                  // <a href="#fav"><i class="material-icons" style="font-size:18pt">favorite_border</i></a></div>';

                 
                  echo '<div class="bottom-right" style="font-weight: bolder;">
                         <a href="#" class="post_chat" data-key="'.$item['publickey'].'" data-id="'.$item['id'].'" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="material-icons" style="font-size:18pt;">chat_bubble_outline</i></a></div>';
 



                echo '</div>';
              
          
              
            echo '</div>';


                       }


                       echo '<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-sm">
                   <div class="modal-content">
                      Remove post..

      <form method="post" action="remove_post.php">
      <input type="hidden" value="'.$item['publickey'].'" name="publickey">
      <button type="submit" value="true" name="remove_post" class="btn btn-danger btn-sm">okay</button>
      </form>
                  </div>
              </div>
      </div>';
                     }



                    }

          ?>
        </div>

      

<div class="row">

  <div class="col-lg-6"> </div>

  <div class="footer-btn col-lg-4" data-toggle="modal" data-target="#uploadPost">

    <a href="#upload" style="color: darkblue"><i class="material-icons" style="font-size: 3em;">center_focus_weak</i></a>

  </div>

</div>

              </div>



             
           
          </div>






          <div class="tab-pane connections" id="connections">
            <div class="row" id="connection_follow_tab">

<?php 

  $followerArr = array();
  $followingArr = array();
  $userid =0;
  $db= "";

echo '<div class="col-md-4 ml-auto mr-auto"> </div>';



if (isset($_SESSION['id'])) {

  $userid = $_SESSION['id'];
}

  try{

 $db = pg_connect(getenv("DATABASE_URL"));
}catch(Execption $e){
  header('location:oops.php');
}


$result = pg_query($db, "SELECT id as user_id, username, email, profile_pic_src
  FROM users WHERE id IN(SELECT user_id FROM user_follow_user WHERE user_following_id =$userid)");



 if (pg_num_rows($result) > 0) {
                  // output data of each row
                    while($row = pg_fetch_assoc($result)) { 
      
                      $followerArr[] = array("user_id" => $row["user_id"], "username" => $row["username"], "email"=> $row["email"], "img" => $row["profile_pic_src"]);
                  
                  }

}else{

}





$result = pg_query($db, "SELECT id as user_following_id, username, email, profile_pic_src
  FROM users  WHERE id IN(SELECT user_following_id FROM user_follow_user WHERE user_id =$userid)");



 if (pg_num_rows($result) > 0) {
                  // output data of each row
                    while($row = pg_fetch_assoc($result)) { 
      
                      $followingArr[] = array("user_following_id" => $row["user_following_id"], "username" => $row["username"], "email"=> $row["email"], "img" => $row["profile_pic_src"]);
                  
                  }

           
          }else{

          }


           echo '<div class="col-md-2 ml-auto mr-auto" style="margin-right: 2em;">
                <a href="#friends" style="text-decoration: none;color:#3c4858;" id="fg" onclick="followingFunction()">';
                

                  if (isset($followingArr)) {
                  echo'<h3 style="margin-bottom: 70px; font-weight: bold">'.sizeof($followingArr).' Following</h3>';
                  }

                
              
            echo'</a>
              </div>
              <div class="col-md-2 mr-auto ml-auto">
                <a href="#friends" style="text-decoration: none;color: black" id="fe" onclick="followerFunction()" >';
          

                  if (isset($followerArr)) {
                   echo'<h3 style="margin-bottom: 70px;font-weight: bold">'.sizeof($followerArr).' Followers</h3>';
                  }



                  echo'</a>
              </div>
                  <div class="col-md-3 ml-auto mr-auto">

              </div>';

           

              pg_close($db);

              ?>
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


                $splitFileString = strtok(trim($item["img"]), '.' );
                $fileChecker = strtok('');
                $fileChecker = strtoupper($fileChecker);

                if (isset($item['img']) && ($fileChecker=='JPG' || $fileChecker=='JPEG' || $fileChecker=='PNG' || $fileChecker=='MOV')) {
                 $user_img = trim($item['img']);

                         $cmd = $s3->getCommand('GetObject', [
                            'Bucket' => ''.$bucket_name.'',
                            'Key'    => ''.$user_img.'',
                          ]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();


                echo '<div class="profileFollowers" style="margin-left:15px;;margin-top:15px;display: inline-block;  margin-right: 15px;">
                 <a href="profile_view.php?user='.$item['username'].'&id='.$item['user_id'].'">
              <div class="avatar" style="width: 120px;">
                <img src="'.$presignedUrl.'" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              </a>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">'.$item['username'].'</h6> <h16 style="font-size: 12px;"><a href="#" class="unfollow_user_follow_btn" data-userid='.$item['user_id'].' data-key="dummyString"><span class="material-icons">remove_circle_outline</span></a></h16>
                </div>
            </div>';
                }else{

                  echo '<div class="profileFollowers" style="margin-left:15px;margin-top:15px;display: inline-block;  margin-right: 15px;">
                   <a href="profile_view.php?user='.$item['username'].'&id='.$item['user_id'].'">
              <div class="avatar" style="width: 120px;">
                <img src="../assets/img/image_placeholder.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
              </div>
              </a>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">'.$item['username'].'</h6> <h16 style="font-size: 12px;">
              <a href="#" class="unfollow_user_follow_btn" data-userid='.$item['user_id'].' data-key="dummyString"><span class="material-icons">remove_circle_outline</span></a></form></h16>
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

                $splitFileString = strtok(trim($item["img"]), '.' );
                $fileChecker = strtok('');
                $fileChecker = strtoupper($fileChecker);

                if (isset($item['img']) && ($fileChecker=='JPG' || $fileChecker=='JPEG' || $fileChecker=='PNG')) {
                 $user_img = trim($item['img']);

                         $cmd = $s3->getCommand('GetObject', [
                            'Bucket' => ''.$bucket_name.'',
                            'Key'    => ''.$user_img.'',
                          ]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();


                echo '<div class="profileFollowing media media-post" style="margin-left:15px;margin-top:15px;display: inline-block;  margin-right: 15px;">
                <a href="profile_view.php?user='.$item['username'].'&id='.$item['user_following_id'].'">
              <div class="avatar" >
                <img src="'.$presignedUrl.'" alt="Circle Image" class="media-object">
              </div>
              </a>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">'.$item['username'].'</h6> <h16 style="font-size: 12px;"><a href="#" class="unfollow_user_btn" data-key="dummyString" data-userid="'.$item['user_following_id'].'"><span class="material-icons">remove_circle_outline</span></a></h16>
                </div>
            </div>';
                }else{

                  echo '<div class="profileFollowing media media-post" style="margin-left:15px;margin-top:15px;display: inline-block;  margin-right: 15px;">
                  <a href="profile_view.php?user='.$item['username'].'&id='.$item['user_following_id'].'">
              <div class="avatar" >
                <img src="../assets/img/image_placeholder.jpg" alt="Circle Image" class="media-object">
              </div>
              </a>
              <div class="name">
                <h6 class="title" style="display: inline-block; margin-right: 10px;">'.$item['username'].'</h6> <h16 style="font-size: 12px;"><a href="#" class="unfollow_user_btn" data-key="dummyString" data-userid="'.$item['user_following_id'].'"><span class="material-icons">remove_circle_outline</span></a></h16>
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
   
   $db = pg_connect(getenv("DATABASE_URL"));

}catch(Execption $e){
header('location:oops.php');
}

  $result = pg_query($db,
    "SELECT * FROM organization NATURAL JOIN poststate WHERE id = $user_id AND post_type != 'user_post' ORDER BY organization.date");

  
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



                          foreach($product_list as $item) {

                            $cmd = $s3->getCommand('GetObject', [
                            'Bucket' => ''.$bucket_name.'',
                            'Key'    => ''.trim($item["img"]).'',
                          ]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();

                  $randomString = "";
                  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
   
                $n = 10;
  
    for ($i = 0; $i < $n; $i++) { 
        $index = rand(0, strlen($characters) - 1); 
        $randomString .= $characters[$index]; 
    } 

    $randomString = trim($randomString);

              

               echo '<div class="col-md-4">';

          
              echo '<div class="contain carousel slide" data-ride="carousel">';

           
                
 
                $splitFileString = strtok(trim($item["img"]), '.' );
                $fileChecker = strtok('');
                $fileChecker = strtoupper($fileChecker);

                $string = trim($item["word_tag"]);
                $string = strtolower($string);
                $token = strtok($string, "_");

 

          if($presignedUrl && strlen(trim($item["img"]))>10 && ($fileChecker=='JPG' || $fileChecker=='JPEG' || $fileChecker=='PNG')){
                 echo  '<img src="'.$presignedUrl.'" class="img rounded" onload="myFunction('.$presignedUrl.')">'; 
              }else{
                 echo  '<img src="../assets/img/image_placeholder.jpg" class="img rounded">';
              } 
 
              
                

                  if (trim($item['price']) =='0.00' || $item["price"]==NULL || $item["price"]==" ") {

                        echo '<div class="top-right h9"> 
                         <a href="'.$item['url'].'"><i class="material-icons">strikethrough_s</i></a></div>';

                        }else{

                  echo ' <a href="'.$item['url'].'"><div class="top-right h6">$'.trim($item['price']).'</a></div>';
                  
                  }

   
                  if (isset($token) && $token =='product') {

                  
                    echo '<div class="top-left h6" style="width:10px;"><i class="material-icons">store</i></div>';


                  }else{

                    echo '<div class="top-left h6" style="width:10px;">'
                       .toString($item['date']).'</div>';

                  }

                

                  echo '<div class="centeredm h4">'.trim($item['description']).'</div>';


                  echo '<div class="bottom-left" style="font-weight: bolder;" id="productLike'.$randomString.'">
                       <a href="#productLike'.$randomString.'" class="fav_chat" data-key="'.$item['publickey'].'" data-id="'.$item['id'].'" data-cid="'.$randomString.'" data-toggle="1">';

                        if ($item['favorite']==1) {
                          echo '<i class="material-icons" style="color:red;font-size:18pt;">favorite</i></a>';

                        }else{

                          echo '<i class="material-icons" style="font-size:18pt;">favorite</i></a>';
                        }

                        echo '</div>';

                     

  //                 echo '<div class="centered"  style="font-weight: bolder;">
  //                   <ol class="carousel-indicators">
  //   <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active">1d</li>
  //   <li data-target="#carouselExampleIndicators" data-slide-to="1">1w</li>
  //   <li data-target="#carouselExampleIndicators" data-slide-to="2">2m</li>
  // </ol></div>';

                 
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
      $(document).on('click', '.fav_chat', function () {

var key=$(this).data("key");
var id=$(this).data("id");
var toggle=$(this).data("toggle");
var cid=$(this).data("cid");


fav(id,key,toggle,cid);


 function fav(id,publickey,toggle,cid)
 {


      $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id
                    },
   success:function(data){

    if (toggle ==0) {
         $.ajax({
   url:"favorite.php",
   method:"POST",
   data : {
        publickey : publickey,
        toggle : toggle,
        cid : cid,
        id : id
                    },
   success:function(data){
 $('#postLike'+cid).html(data);

   }
  })
    }else if(toggle==1){
         $.ajax({
   url:"favorite.php",
   method:"POST",
   data : {
        publickey : publickey,
        toggle : toggle,
        cid : cid,
        id : id
                    },
   success:function(data){
  $('#productLike'+cid).html(data);



   }
  })
    }
   

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
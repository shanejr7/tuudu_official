<?php
/* DOCS

  * 
  *
  
*/
include("server.php");


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
// issue may appear getting negative value when unfavoriting 


if (isset($_POST['id']) && isset($_POST['cid']) && isset($_POST['toggle']) && isset($_POST['publickey']) && isset($_SESSION['id'])) {
	  
	  $user_id = "";
	  $user_id = $_SESSION['id'];
    $data="";
    $pid ="";
    $home_list = array();
    $product_list = array();
    $posts_list = array();
    $publickey = "";
    $toggle = "";


	  $db = pg_connect(getenv("DATABASE_URL"));

     // Check connection
     if (!$db) {
        die("Connection failed: " . pg_connect_error());
        header('location:oops.php');
      }

   $pid = pg_escape_string($db,$_POST['id']);
   $css_id = pg_escape_string($db,$_POST['cid']);
   $toggle = pg_escape_string($db,$_POST['toggle']);
	 $publickey = pg_escape_string($db,$_POST['publickey']);
   $css_id = trim($css_id);
	 $publickey = trim($publickey);



	 // check if user already favorite post
	  $result = pg_query($db, "SELECT favorite FROM poststate WHERE publickey = '$publickey' AND user_id = $user_id LIMIT 1");

 	  $poststate = pg_fetch_assoc($result);


 if (pg_num_rows($result) <= 0) {

 	pg_query($db, "INSERT INTO poststate (user_id, publickey,favorite)
  VALUES($user_id,'$publickey',1)");


  pg_query($db, "UPDATE public.organization
    SET favorites = favorites + 1 
    WHERE publickey = '$publickey'");

 }elseif ($poststate['favorite']==1) {

 	 pg_query($db, "UPDATE poststate
    SET favorite = 0 WHERE publickey = '$publickey' AND user_id= $user_id");
 	
  pg_query($db, "UPDATE public.organization
    SET favorites = favorites - 1 
    WHERE publickey = '$publickey'");
  
  

 }elseif($poststate['favorite']==0){

 		 pg_query($db, "UPDATE poststate
    SET favorite = 1 WHERE publickey = '$publickey' AND user_id= $user_id");

     pg_query($db, "UPDATE public.organization
    SET favorites = favorites + 1 
    WHERE publickey = '$publickey'");
 	

 }elseif($poststate['favorite']==null ){

 	pg_query($db, "INSERT INTO poststate (user_id, publickey,favorite)
  VALUES($user_id,'$publickey',1)");

  pg_query($db, "UPDATE public.organization
    SET favorites = favorites + 1 
    WHERE publickey = '$publickey'");


 }


if ($toggle==0) {
  // home profile tab


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


              

               $data.= '<div class="col-md-4">';

          
              $data.= '<div class="contain">';

           
                
 
                $splitFileString = strtok(trim($item["img"]), '.' );
                $fileChecker = strtok('');
                $fileChecker = strtoupper($fileChecker);

                // $string = trim($item["word_tag"]);
                // $string = strtolower($string);
                // $token = strtok($string, "_");

 

          if($presignedUrl && strlen(trim($item["img"]))>10 && ($fileChecker=='JPG' || $fileChecker=='JPEG' || $fileChecker=='PNG' || $fileChecker=='MOV')){
                 $data.=  '<img src="'.$presignedUrl.'" class="img rounded">'; 
              }else{
                 $data.=  '<img src="../assets/img/image_placeholder.jpg" class="img rounded">';
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

               $data.= '<div  class="top-leftOpacity h6" style="width:10px;" id="like'.$randomString.'">
               <a href="#remove" data-toggle="modal" data-target=".bd-example-modal-sm">
               <i class="material-icons">more_horiz</i>
               </a>
               </div>';



                  // echo '<div class="centeredm h4">'.trim($item['title']).'</div>';


                  $data.= '<div class="bottom-left" style="font-weight: bolder;">
                        <a href="#like'.$randomString.'" class="fav_chat" data-key="'.$item['publickey'].'" data-id="'.$item['id'].'" data-toggle="0">';

                        if ($item['favorite']==1) {
                          $data.= '<i class="material-icons" style="color:red;font-size:18pt;">favorite</i></a></div>';

                        }else{

                          $data.= '<i class="material-icons" style="font-size:18pt;">favorite</i></a></div>';
                        }

                     

                  // echo '<div class="centered" style="font-weight: bolder;">
                  // <a href="#fav"><i class="material-icons" style="font-size:18pt">favorite_border</i></a></div>';

                 
                  $data.= '<div class="bottom-right" style="font-weight: bolder;">
                         <a href="#like'.$randomString.'" class="post_chat" data-key="'.$item['publickey'].'" data-id="'.$item['id'].'" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="material-icons" style="font-size:18pt;">chat_bubble_outline</i></a></div>';
 



                $data.= '</div>';
              
          
              
            $data.= '</div>';


                       


                       $data.= '<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
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
  
}elseif ($toggle==1) {
  // product profile tab


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



              

               $data.= '<div class="col-md-4">';

          
              $data.= '<div class="contain carousel slide" data-ride="carousel">';

           
                
 
                $splitFileString = strtok(trim($item["img"]), '.' );
                $fileChecker = strtok('');
                $fileChecker = strtoupper($fileChecker);

                $string = trim($item["word_tag"]);
                $string = strtolower($string);
                $token = strtok($string, "_");

 

          if($presignedUrl && strlen(trim($item["img"]))>10 && ($fileChecker=='JPG' || $fileChecker=='JPEG' || $fileChecker=='PNG')){
                 $data.=  '<img src="'.$presignedUrl.'" class="img rounded" onload="myFunction('.$presignedUrl.')">'; 
              }else{
                 $data.=  '<img src="../assets/img/image_placeholder.jpg" class="img rounded">';
              } 
 
              
                

                  if (trim($item['price']) =='0.00' || $item["price"]==NULL || $item["price"]==" ") {

                        $data.= '<div class="top-right h9"> 
                         <a href="'.$item['url'].'"><i class="material-icons">strikethrough_s</i></a></div>';

                        }else{

                  $data.= ' <a href="'.$item['url'].'"><div class="top-right h6">$'.trim($item['price']).'</a></div>';
                  
                  }

   
                  if (isset($token) && $token =='product') {

                  
                    $data.= '<div class="top-left h6" style="width:10px;"><i class="material-icons">store</i></div>';


                  }else{

                   $data.= '<div class="top-left h6" style="width:10px;">'
                       .toString($item['date']).'</div>';

                  }

                

                 $data.= '<div class="centeredm h4" >'.trim($item['description']).'</div>';


                 $data.= '<div class="bottom-left" style="font-weight: bolder;">
                       <a href="#like'.$randomString.'" class="fav_chat" data-key="'.$item['publickey'].'" data-id="'.$item['id'].'" data-toggle="1">';

                        if ($item['favorite']==1) {
                         $data.= '<i class="material-icons" style="color:red;font-size:18pt;">favorite</i></a></div>';

                        }else{

                          $data.= '<i class="material-icons" style="font-size:18pt;">favorite</i></a></div>';
                        }

                     

  //                 echo '<div class="centered"  style="font-weight: bolder;">
  //                   <ol class="carousel-indicators">
  //   <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active">1d</li>
  //   <li data-target="#carouselExampleIndicators" data-slide-to="1">1w</li>
  //   <li data-target="#carouselExampleIndicators" data-slide-to="2">2m</li>
  // </ol></div>';

                 
                  $data.= '<div class="bottom-right" style="font-weight: bolder;" id="like'.$randomString.'">
                         <a href="#" class="post_chat" data-key="'.$item['publickey'].'" data-id="'.$item['id'].'" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="material-icons" style="font-size:18pt;">chat_bubble_outline</i></a></div>';
 



                $data.= '</div>';
              
          
              
            $data.= '</div>';


                       }
                     }

  
}else if($toggle ==2){
  // dashboard post tab


   $result = pg_query($db, "SELECT DISTINCT favorite FROM poststate WHERE user_id =$user_id AND publickey = '$publickey' LIMIT 1");

   $user = pg_fetch_assoc($result);


                   $data.= '<a href="#like'.$css_id.'" class="fav_chat" data-key="'.$publickey.'" data-id="'.$pid.'" data-cid="'.$css_id.'" data-toggle="2">';

                        if ($user['favorite']==1) {
                         $data.= '<i class="material-icons" style="color:red;font-size:18pt;">favorite</i></a>';

                        }else{

                         $data.= '<i class="material-icons" style="font-size:18pt;">favorite</i></a>';
                        }

}

     

   echo $data;
	 pg_close($db);


   


}





 /* converts integer month to string*/
function toString(string $month_arr){

if ("01" == trim($month_arr[5].''.$month_arr[6])) {
  return "Jan".' '.$month_arr[8].''.$month_arr[9];
}
if ("02" == trim($month_arr[5].''.$month_arr[6])) {
  return "Feb".' '.$month_arr[8].''.$month_arr[9];
}
if ("03" == trim($month_arr[5].''.$month_arr[6])) {
  return "Mar".' '.$month_arr[8].''.$month_arr[9];
}
if ("04" == trim($month_arr[5].''.$month_arr[6])) {
  return "Apr".' '.$month_arr[8].''.$month_arr[9];
}
if ("05" == trim($month_arr[5].''.$month_arr[6])) {
  return "May".' '.$month_arr[8].''.$month_arr[9];
}
if ("06" == trim($month_arr[5].''.$month_arr[6])) {
  return "Jun".' '.$month_arr[8].''.$month_arr[9];
}
if ("07" == trim($month_arr[5].''.$month_arr[6])) {
  return "Jul".' '.$month_arr[8].''.$month_arr[9];
}
if ("08" == trim($month_arr[5].''.$month_arr[6])) {
  return "Aug".' '.$month_arr[8].''.$month_arr[9];
}
if ("09" == trim($month_arr[5].''.$month_arr[6])) {
  return "Sep".' '.$month_arr[8].''.$month_arr[9];
}
if ("10" == trim($month_arr[5].''.$month_arr[6])) {
  return "Oct".' '.$month_arr[8].''.$month_arr[9];
}
if ("11" == trim($month_arr[5].''.$month_arr[6])) {
  return "Nov".' '.$month_arr[8].''.$month_arr[9];
}
if ("12" == trim($month_arr[5].''.$month_arr[6])) {
  return "Dec".' '.$month_arr[8].''.$month_arr[9];
}
}







?>
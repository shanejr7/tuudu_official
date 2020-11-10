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


if (isset($_POST['publickey']) && isset($_SESSION['id'])) {
	  
	  $user_id = "";
	  $user_id = $_SESSION['id'];
    $data="";
    $home_list = array();
    $data.='in';

	  $db = pg_connect(getenv("DATABASE_URL"));

     // Check connection
     if (!$db) {
        die("Connection failed: " . pg_connect_error());
        header('location:oops.php');
      }

   $publickey = "";
	 $publickey = pg_escape_string($db,$_POST['publickey']);
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
                  $data.='fas';
                     }


                      if (isset($home_list) && sizeof($home_list) > 0) {
                $data.='start';

                          foreach($home_list as $item) {

                            $cmd = $s3->getCommand('GetObject', [
                            'Bucket' => ''.$bucket_name.'',
                            'Key'    => ''.trim($item["img"]).'',
                          ]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();


              

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

               $data.= '<div  class="top-leftOpacity h6" style="width:10px;">
               <a href="#remove" data-toggle="modal" data-target=".bd-example-modal-sm">
               <i class="material-icons">more_horiz</i>
               </a>
               </div>';



                  // echo '<div class="centeredm h4">'.trim($item['title']).'</div>';


                  $data.= '<div class="bottom-left" style="font-weight: bolder;">
                        <a href="#" class="fav_chat" data-key="'.$item['publickey'].'" data-id="'.$item['id'].'">';

                        if ($item['favorite']==1) {
                          $data.= '<i class="material-icons" style="color:red;font-size:18pt;">favorite</i></a></div>';

                        }else{

                          $data.= '<i class="material-icons" style="font-size:18pt;">favorite</i></a></div>';
                        }

                     

                  // echo '<div class="centered" style="font-weight: bolder;">
                  // <a href="#fav"><i class="material-icons" style="font-size:18pt">favorite_border</i></a></div>';

                 
                  $data.= '<div class="bottom-right" style="font-weight: bolder;">
                         <a href="#" class="post_chat" data-key="'.$item['publickey'].'" data-id="'.$item['id'].'" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="material-icons" style="font-size:18pt;">chat_bubble_outline</i></a></div>';
 



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

$data.='a';

                    }
$data.='q';
   echo $data;
	 pg_close($db);


   


}












?>
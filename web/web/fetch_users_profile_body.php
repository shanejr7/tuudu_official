<?php

include("server.php");
include('favorite.php');

 /* DOCS

  * 
  * 
  * <controls view for user profile body >
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





if (isset($_POST['id']) && isset($_POST['publickey'])) {

		

		$user_id = 0;
		$publickey = "";
		$user_post = "";
		$result ="";
    	$sid= "";
    	$data="";
    	$user_post_view = array();



    	$db="";


			try{
 	
 			$db = pg_connect(getenv("DATABASE_URL"));
	
			}catch(Execption $e){
 	
 				 header('location:oops.php');
			}


			$publickey = pg_escape_string($db, $_POST['publickey']);
			$publickey = trim($publickey);
			$user_id = pg_escape_string($db, $_POST['id']);

			if (isset($_SESSION['id'])) {
        
        		$sid = $_SESSION['id']; 
    
    		}


    		$result = pg_query($db, "SELECT DISTINCT organization.date, organization.time, organization.fiatvalue,organization.img, organization.id as org_id, organization.description,organization.views,organization.publickey, organization.address, organization.url,organization.post_type,organization.amount,organization.word_tag,organization.favorites,poststate.favorite,organization.address
      FROM public.organization NATURAL JOIN poststate WHERE id = $user_id AND post_type='user_post' ORDER BY date, views");

    		echo pg_num_rows($result);



    		 if (pg_num_rows($result) > 0) {
                  // output data of each row
                    while($row = pg_fetch_assoc($result)) { 
      
                      $user_post_view = array("date" => $row["date"], "time" => $row["time"], "price"=> $row["fiatvalue"], "img" => $row["img"],"org_id" => $row["org_id"],"description" => $row["description"],"views" => $row["views"],"word_tag" => $row["word_tag"], "publickey" => $row["publickey"], "url" => $row["url"],"post_type" => $row["post_type"], "amount" => $row["amount"],"favorite" => $row["favorite"],"favorites" => $row["favorites"],"address" => $row["address"]);
                       
                    }
                  
                  }



			if (isset($user_post_view)) {

				$data.='<div class="tab-content tab-space cd-section">
				<div class="tab-pane text-center gallery section section-sections">
				<div class="row">';

				foreach($user_post_view as $item) {


         $cmd = $s3->getCommand('GetObject', [
                                        'Bucket' => ''.$bucket_name.'',
                                        'Key'    => ''.trim($item["img"]).'',
                            ]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();

     
            
              $data.='<div class="col-md-6">';

          
              $data.='<div class="contain">';

           
                $splitFileString = strtok(trim($item['img']), '.' );
                $fileChecker = strtok('');
                $fileChecker = strtoupper($fileChecker);

                // $string = trim($item["word_tag"]);
                // $string = strtolower($string);
                // $token = strtok($string, "_");

 

          if($presignedUrl && strlen(trim($item['img']))>10 && ($fileChecker=='JPG' || $fileChecker=='JPEG' || $fileChecker=='PNG' || $fileChecker=='MOV')){
                 $data.= '<img src="'.$presignedUrl.'" class="img rounded" onload="myFunction('.$presignedUrl.')">'; 
              }else{
                 $data.= '<img src="../assets/img/image_placeholder.jpg" class="img rounded">';
              } 
 

                   
                      // $data.='<div class="top-right"> 
                      //    <a href="#" class="user_home_page" data-key="'.$item['publickey'].'" data-id="'.$item['org_id'].'" data-toggle="modal" data-target=".user_profile"><i class="material-icons" style="font-size:18pt;">account_box</i></a>
                      //    </div>';


                    $data.='<div class="top-left h6" style="width:10px;">'
                       .toString($item['date']).'</div>';

                

                  $data.='<div class="centeredm h4">'.trim($item['description']).'</div>';


                    $data.='<div class="bottom-left" style="font-weight: bolder;">
                        <a href="profile.php?publickey='.$item['publickey'].'">';

                        if ($item['favorite']==1) {
                          $data.='<i class="material-icons" style="color:red;font-size:18pt;">favorite</i></a></div>';

                        }else{

                          $data.='<i class="material-icons" style="font-size:18pt;">favorite</i></a></div>';
                        }

                  // $data.='<div class="centered" style="font-weight: bolder;">
                  // <a href="#fav"><i class="material-icons" style="font-size:18pt">favorite_border</i></a></div>';

                 
                 $data.='<div class="bottom-right" style="font-weight: bolder;">
                         <a href="#" class="post_chat" data-key="'.$item['publickey'].'" data-id="'.$item['org_id'].'" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="material-icons" style="font-size:18pt;">chat_bubble_outline</i></a></div>';
 



                $data.='</div>';
              
          
              
            $data.='</div>';


       }



				$data.='</div></div></div>';
	
			}





			pg_close($db);


    		  echo $data;


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
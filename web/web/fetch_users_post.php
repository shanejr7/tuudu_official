<?php 
include("server.php");


/* DOCS

  * 
  * profile.php --> fetch_user_post.php <USERS POST CHAT DATA>
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

// TIME CONVERTER FUNCTION
// IF LESS THAN YEAR 
        // IF LESS THAN MONTH
          // IF LESS THAN WEEK
            //IF LESS THAN DAY
               //IF LESS THAN HOUR
                 //IF LESS THAN MINUTES


function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}


  /* converts integer month to string*/
function toString(string $timestamp_arr){

  if (date("Y")<trim($timestamp_arr[0].''.$timestamp_arr[3])) {

    $year = trim($timestamp_arr[0].''.$timestamp_arr[3]);

    $year_ago = $year - date("Y");

    return $year_ago. ' '.'ago'; 
  

  }elseif(date("m")<trim($timestamp_arr[5].''.$timestamp_arr[6])) {
        
    $month = trim($timestamp_arr[5].''.$timestamp_arr[6]);

    $month_ago = $month - date("m");

    return $month_ago.' months ago'; 

  }elseif(date("d")<trim($timestamp_arr[8].''.$timestamp_arr[9]) && date("m")>=trim($timestamp_arr[5].''.$timestamp_arr[6])){


    $week = trim($timestamp_arr[0].''.$timestamp_arr[3]);

    $week_ago = $week - date("Y");

    return $week_ago. ' '.'ago'; 


  }elseif (date("h")>=trim($timestamp_arr[11].''.$timestamp_arr[12]) && date("d")==trim($timestamp_arr[8].''.$timestamp_arr[9]) && date("m")>=trim($timestamp_arr[5].''.$timestamp_arr[6])) {


    return 'at '.date("h:ia"); 

  }elseif (date("h")>trim($timestamp_arr[11].''.$timestamp_arr[12]) && date("i")>=trim($timestamp_arr[14].''.$timestamp_arr[15]) && date("d")==trim($timestamp_arr[8].''.$timestamp_arr[9]) && date("m")>=trim($timestamp_arr[5].''.$timestamp_arr[6])) {


    return 'just '. date("i").' minutes ago'; 


  }elseif(date("h")>trim($timestamp_arr[11].''.$timestamp_arr[12]) && date("i")>=trim($timestamp_arr[14].''.$timestamp_arr[15]) && date("d")==trim($timestamp_arr[8].''.$timestamp_arr[9]) && date("m")>trim($timestamp_arr[5].''.$timestamp_arr[6])){

    return 'just now';
  }


}

	if (isset($_POST['id']) && isset($_POST['publickey'])) {

 
 

		
		$user_id = 0;
		$publickey = "";
		$result ="";
    $comment_post_list = array();
    $comment_reply_list = array();
    $id_u="";
   

			$db="";


			try{
 	
 			$db = pg_connect(getenv("DATABASE_URL"));
	
			}catch(Execption $e){
 	
 				 header('location:oops.php');
			}

		$publickey = pg_escape_string($db, $_POST['publickey']);
		$publickey = trim($publickey);
		$user_id = pg_escape_string($db, $_POST['id']);




				$result = pg_query($db, "SELECT * FROM messagestate  WHERE publickey = '$publickey' AND reply_to_id = 0 ORDER BY timestamp_message ASC");


           if (pg_num_rows($result) > 0) {
                  // output data of each row
                    while($row = pg_fetch_assoc($result)) { 
      
                      $comment_post_list[] = array("username" => $row["username"],"user_id" => $row["user_id"],"message" => $row["message"],"publickey" => $row["publickey"],"reply_to_id" => $row["reply_to_id"],"timestamp" => $row["timestamp_message"],"favorite" => $row["favorite"],"img" => $row["src"]);
                       
                    }
                  
                  }else {

                  }



                   $result = pg_query($db, "SELECT * FROM messagestate  WHERE publickey = '$publickey' AND reply_to_id != 0 ORDER BY timestamp_message ASC");


           if (pg_num_rows($result) > 0) {
                  // output data of each row
                    while($row = pg_fetch_assoc($result)) { 
      
                      $comment_list[] = array("username" => $row["username"],"user_id" => $row["user_id"],"message" => $row["message"],"publickey" => $row["publickey"],"reply_to_id" => $row["reply_to_id"],"timestamp" => $row["timestamp_message"],"favorite" => $row["favorite"],"img" => $row["src"]);
                       
                    }
                  
                  }else {

                  }
 



 foreach ($comment_post_list as $item) {
   



   if (in_array($item['user_id'], array_column($comment_list, 'reply_to_id'))) {

                  $col_reply_to = array_column($comment_reply_list, 'reply_to_id');
                  $row_index = array_search($item['user_id'], $col_reply_to);

            

            $data.=' <div class="media">
                <a class="float-left post_account" href="#" data-id="'.$item['user_id'].'">
                  <div class="avatar">';

             if (isset($item['img']) && strlen(trim($item['img']))>30) {
                    
                    $user_img = trim($item['img']);

                         $cmd = $s3->getCommand('GetObject', [
                            'Bucket' => ''.$bucket_name.'',
                            'Key'    => ''.$user_img.'',
                          ]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();

                $data.='<img class="media-object"  src="'.$presignedUrl.'">';

              }else{

                $data.='<img class="media-object" src="../../assets/img/image_placeholder.jpg">';
              }
                   

                  $data.='</div>
                </a>
                <div class="media-body">
                 <button type="button" style="cursor: pointer;" class="edit_post"  data-uid="'.$item['user_id'].'" data-id="'.$user_id.'" data-username="'.$item['username'].'" data-key="'.$item['publickey'].'" data-time="'.$item['timestamp'].'" data-message="'.$item['message'].'"><h4 class="media-heading">'.$item['username'].'<small>&#xB7; '.$item['timestamp'].'</small></h4></button>
                  <p>'.$item['message'].'</p>
                  <div class="media-footer">
                    <!--<a href="#" class="reply_comment btn btn-primary btn-link float-right"  rel="tooltip" title="Reply to Comment" data-userid="'.$item['user_id'].'" data-key="'.$item['publickey'].'" >
                      <i class="material-icons">reply</i> Reply
                    </a>-->';

                    if ($item['favorite']>0 && isset($_SESSION['id'])) {
                      $data.='  <a href="#" class="favPost btn btn-danger btn-link float-right" data-userid="'.$item['user_id'].'" data-username="'.$item['username'].'" data-key="'.$item['publickey'].'"  data-time="'.$item['timestamp'].'">
                      <i class="material-icons">favorite</i>'.$item['favorite'].'
                    </a>';
                    }elseif($item['favorite']<=0 && isset($_SESSION['id'])){
                      $data.=' <a href="#" class="favPost btn btn-link float-right" data-userid="'.$item['user_id'].'" data-username="'.$item['username'].'" data-key="'.$item['publickey'].'"  data-time="'.$item['timestamp'].'">
                      <i class="material-icons">favorite</i>
                    </a>';
                    }

                    

                  $data.='</div>';

        

                    $id_u =$item['user_id'];
                  // reply comment below 
                   $result = pg_query($db, "SELECT * FROM messagestate  WHERE publickey = '$publickey' AND reply_to_id = $id_u");


           if (pg_num_rows($result) > 0) {
                  // output data of each row
                    while($row = pg_fetch_assoc($result)) { 
      
                      $comment_reply_list[] = array("username" => $row["username"],"user_id" => $row["user_id"],"message" => $row["message"],"publickey" => $row["publickey"],"reply_to_id" => $row["reply_to_id"],"timestamp" => $row["timestamp_message"],"favorite" => $row["favorite"],"img" => $row["src"]);
                       
                    }
                  
                  }else {

                  }
                
                    foreach ($comment_reply_list as $reply) {
                       
                   
                          
                                 $data.=' <div class="media">
                    <a class="float-left post_account" href="#" data-id="'.$reply['user_id'].'">
                      <div class="avatar">';
                          if (isset($reply['img'])) {
                    
                    $user_img = trim($reply['img']);

                         $cmd = $s3->getCommand('GetObject', [
                            'Bucket' => ''.$bucket_name.'',
                            'Key'    => ''.$user_img.'',
                          ]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();

                $data.='<img class="media-object"  src="'.$presignedUrl.'">';

              }else{

                $data.='<img class="media-object" src="../../assets/img/image_placeholder.jpg">';
              }


                     $data.='</div>
                    </a>
                    <div class="media-body">
                     <button type="button" style="cursor: pointer;" class="edit_post" data-uid="'.$item['user_id'].'"  data-id="'.$reply['user_id'].'" data-username="'.$reply['username'].'" data-key="'.$reply['publickey'].'" data-time="'.$reply['timestamp'].'" data-message="'.$reply['message'].'"><h4 class="media-heading">'.$reply['username'].'<small>&#xB7; '.$reply['timestamp'].'</small></h4></button>
                      <p>'.$reply['message'].'</p>
                 
                      <div class="media-footer">
                        <!--<a href="#" class="btn btn-primary btn-link float-right" rel="tooltip" title="Reply to Comment">
                          <i class="material-icons">reply</i> Reply
                        </a>-->';
                         if ($reply['favorite']>0) {
                      $data.='  <a href="#" class="favPost btn btn-danger btn-link float-right" data-userid="'.$reply['user_id'].'" data-username="'.$reply['username'].'" data-key="'.$reply['publickey'].'"  data-time="'.$reply['timestamp'].'">
                      <i class="material-icons">favorite</i>'.$reply['favorite'].'
                    </a>';
                    }else{
                      $data.=' <a href="#" class="favPost btn btn-link float-right"  data-userid="'.$reply['user_id'].'" data-username="'.$reply['username'].'" data-key="'.$reply['publickey'].'"  data-time="'.$reply['timestamp'].'">
                      <i class="material-icons">favorite</i>
                    </a>';
                    }
                      $data.='</div>
                    </div>
                  </div>';
                 }


                  
             
                 
            

              
      
                   
           $data.='</div>
              </div>';


              

   }else{
    
// single comment

          $data.='<div class="media col-lg-12">
                <a class="float-left" href="#">
                  <div class="avatar">';

                      $splitFileString ="";
                      $fileChecker = "";


                if (isset($item["img"])) {

                  $splitFileString = strtok(trim($item["img"]), '.' );
                  $fileChecker = strtok('');
                  $fileChecker = strtoupper($fileChecker);
                  
                }


                     if (isset($item['img']) && ($fileChecker=='JPG' || $fileChecker=='JPEG' || $fileChecker=='PNG')) {
                    
                    $user_img = trim($item['img']);

                         $cmd = $s3->getCommand('GetObject', [
                            'Bucket' => ''.$bucket_name.'',
                            'Key'    => ''.$user_img.'',
                          ]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();

                $data.='<img class="media-object"  src="'.$presignedUrl.'">';

              }else{

                $data.='<img class="media-object" src="../../assets/img/image_placeholder.jpg">';
              }

                 $data.='</div>
                </a>
                <div class="media-body">
                  <button type="button" style="cursor: pointer;" class="edit_post" data-uid="'.$item['user_id'].'" data-id="'.$user_id.'" data-username="'.$item['username'].'" data-key="'.$item['publickey'].'" data-time="'.$item['timestamp'].'" data-message="'.$item['message'].'"><h4 class="media-heading">'.$item['username'].'<small>&#xB7; '.time_elapsed_string($item['timestamp']).'</small></h4></button>
                  <h6 class="text-muted"></h6>
                  <p class="col-lg-9">'.$item['message'].'</p>
                  <div class="media-footer">
                    <!--<a href="#" class="reply_comment btn btn-primary btn-link float-right" rel="tooltip" title="Reply to Comment" data-userid="'.$item['user_id'].'" data-key="'.$item['publickey'].'">
                      <i class="material-icons">reply</i> Reply
                    </a>-->';

                       if ($item['favorite']>0 && isset($_SESSION['id'])) {
                      $data.='  <a href="#" class="favPost btn btn-danger btn-link float-right"  data-userid="'.$item['user_id'].'" data-username="'.$item['username'].'" data-key="'.$item['publickey'].'"  data-time="'.$item['timestamp'].'">
                      <i class="material-icons">favorite</i>'.$item['favorite'].'
                    </a>';
                    }elseif($item['favorite']<=0 && isset($_SESSION['id'])){
                      $data.=' <a href="#" class="favPost btn btn-link float-right"  data-userid="'.$item['user_id'].'" data-username="'.$item['username'].'" data-key="'.$item['publickey'].'"  data-time="'.$item['timestamp'].'">
                      <i class="material-icons">favorite</i>
                    </a>';
                    }

                    
                      $data.='</div>
                    </div>
                  </div>';
                  }
                  $data.='</div>
                </div>
              </div>
              <hr>';



 }

// ajax refresh chat box works but keeps on increasing method call speed
// $data.='      <script type="text/javascript">
              

//        $(document).ready(function() { setInterval(function(){
                   
                   
//                 var key="'.$publickey.'";
//                 var id='.$user_id.';
//                 console.log(key + " "+ id);
//                     user_post(id,key);
                    
//                     function user_post(id,publickey)
//  {
//   console.log("in");
//         $.ajax({
//    url:"fetch_users_post.php",
//    method:"POST",
//    data : {
//         publickey : publickey,
//         id : id 
//                     },
//    success:function(data){
//     $("#users_post").html(data);
//      console.log("work");
//    }
//   })

//    }
    
//   },5000); 


//   myStopFunction();

//    });


//    function myStopFunction() {
//   clearTimeout(time);
// }

// var time = setTimeout(user_post(id,key), 5000);
 
//             </script>';

                  echo $data;



 				pg_close($db);



	}


?>
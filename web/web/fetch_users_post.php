<?php 
include("server.php");
// USER POST CHAT DATA  

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
		$result ="";
    $comment_post_list = array();
    $comment_reply_list = array();
    $index = 0;

			$db="";


			try{
 	
 			$db = pg_connect(getenv("DATABASE_URL"));
	
			}catch(Execption $e){
 	
 				 header('location:oops.php');
			}

		$publickey = pg_escape_string($db, $_POST['publickey']);
		$publickey = trim($publickey);
		$user_id = pg_escape_string($db, $_POST['id']);




				$result = pg_query($db, "SELECT * FROM messagestate  WHERE publickey = '$publickey' AND reply_to_id = 0");


           if (pg_num_rows($result) > 0) {
                  // output data of each row
                    while($row = pg_fetch_assoc($result)) { 
      
                      $comment_post_list[] = array("username" => $row["username"],"user_id" => $row["user_id"],"message" => $row["message"],"publickey" => $row["publickey"],"reply_to_id" => $row["reply_to_id"],"timestamp" => $row["timestamp_message"],"favorite" => $row["favorite"],"user_post_id" => $row["id"],"img" => $row["src"]);
                       
                    }
                  
                  }else {

                  }
 
 $result = pg_query($db, "SELECT * FROM messagestate  WHERE publickey = '$publickey' AND reply_to_id != 0");


           if (pg_num_rows($result) > 0) {
                  // output data of each row
                    while($row = pg_fetch_assoc($result)) { 
      
                      $comment_reply_list[] = array("username" => $row["username"],"user_id" => $row["user_id"],"message" => $row["message"],"publickey" => $row["publickey"],"reply_to_id" => $row["reply_to_id"],"timestamp" => $row["timestamp_message"],"favorite" => $row["favorite"],"user_post_id" => $row["id"],"img" => $row["src"]);
                       
                    }
                  
                  }else {

                  }



 foreach ($comment_post_list as $item) {
   



   if (in_array($item['user_id'], array_column($comment_reply_list, 'reply_to_id')) {

                  $col_reply_to = array_column($comment_reply_list, 'reply_to_id');
                  $row_index = array_search($item['user_id'], $col_reply_to);

            

            $data.=' <div class="media">
                <a class="float-left post_account" href="#" data-id="'.$item['user_id'].'">
                  <div class="avatar">';

             if (isset($item['img'])) {
                    
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
                  <h4 class="media-heading">'.$item['username'].'<small>&#xB7; '.$item['timestamp'].'</small></h4>
                  <p>'.$item['message'].'</p>
                  <div class="media-footer">
                    <a href="#" class="reply_comment btn btn-primary btn-link float-right"  rel="tooltip" title="Reply to Comment" data-userid="'.$item['user_id'].'" data-key="'.$item['publickey'].'" >
                      <i class="material-icons">reply</i> Reply
                    </a>';

                    if ($item['favorite']>0) {
                      $data.='  <a href="#" class="favPost btn btn-danger btn-link float-right" data-userid="'.$item['user_id'].'" data-username="'.$item['username'].'" data-key="'.$item['publickey'].'"  data-time="'.$item['timestamp'].'">
                      <i class="material-icons">favorite</i>'.$item['favorite'].'
                    </a>';
                    }else{
                      $data.=' <a href="#" class="favPost btn btn-link float-right" data-userid="'.$item['user_id'].'" data-username="'.$item['username'].'" data-key="'.$item['publickey'].'"  data-time="'.$item['timestamp'].'">
                      <i class="material-icons">favorite</i>
                    </a>';
                    }

                    

                  $data.='</div>';

        
                  // reply comment below 
                
                    
                          
                                 $data.=' <div class="media">
                    <a class="float-left post_account" href="#" data-id="'.$comment_reply_list[$row_index]['user_id'].'">
                      <div class="avatar">';
                          if (isset($comment_reply_list[$row_index]['img'])) {
                    
                    $user_img = trim($comment_reply_list[$row_index]['img']);

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
                      <h4 class="media-heading">'.$comment_reply_list[$row_index]['username'].'<small>&#xB7; '.$comment_reply_list[$row_index]['timestamp'].'</small></h4>
                      <p>'.$comment_reply_list[$row_index]['message'].'</p>
                 
                      <div class="media-footer">
                        <!--<a href="#" class="btn btn-primary btn-link float-right" rel="tooltip" title="Reply to Comment">
                          <i class="material-icons">reply</i> Reply
                        </a>-->';
                         if ($comment_reply_list[$row_index]['favorite']>0) {
                      $data.='  <a href="#" class="favPost btn btn-danger btn-link float-right" data-userid="'.$comment_reply_list[$row_index]['user_id'].'" data-username="'.$comment_reply_list[$row_index]['username'].'" data-key="'.$comment_reply_list[$row_index]['publickey'].'"  data-time="'.$comment_reply_list[$row_index]['timestamp'].'">
                      <i class="material-icons">favorite</i>'.$comment_reply_list[$row_index]['favorite'].'
                    </a>';
                    }else{
                      $data.=' <a href="#" class="favPost btn btn-link float-right" data-userid="'.$comment_reply_list[$row_index]['user_id'].'" data-username="'.$comment_reply_list[$row_index]['username'].'" data-key="'.$comment_reply_list[$row_index]['publickey'].'"  data-time="'.$comment_reply_list[$row_index]['timestamp'].'">
                      <i class="material-icons">favorite</i>
                    </a>';
                    }
                      $data.='</div>
                    </div>
                  </div>';



                     // to make sure it is not shown multiple times to same id replied to
                unset($comment_reply_list[$row_index]);
                 
            

              
      
                   
           $data.='</div>
              </div>';


              

   }else{
    
// single comment

          $data.='<div class="media">
                <a class="float-left" href="#">
                  <div class="avatar">';

                     if (isset($item['img'])) {
                    
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
                  <button type="button" style="cursor: pointer;" class="edit_post" data-id="'.$item['user_id'].'" data-username="'.$item['username'].'" data-key="'.$item['publickey'].'" data-time="'.$item['timestamp'].'" data-message="'.$item['message'].'"><h4 class="media-heading">'.$item['username'].'<small>&#xB7; '.$item['timestamp'].'</small></h4></button>
                  <h6 class="text-muted"></h6>
                  <p>'.$item['message'].'</p>
                  <div class="media-footer">
                    <a href="#" class="reply_comment btn btn-primary btn-link float-right" rel="tooltip" title="Reply to Comment" data-userid="'.$item['user_id'].'" data-key="'.$item['publickey'].'">
                      <i class="material-icons">reply</i> Reply
                    </a>';

                       if ($item['favorite']>0) {
                      $data.='  <a href="#" class="favPost btn btn-danger btn-link float-right" data-userid="'.$item['user_id'].'" data-username="'.$item['username'].'" data-key="'.$item['publickey'].'"  data-time="'.$item['timestamp'].'">
                      <i class="material-icons">favorite</i>'.$item['favorite'].'
                    </a>';
                    }else{
                      $data.=' <a href="#" class="favPost btn btn-link float-right" data-userid="'.$item['user_id'].'" data-username="'.$item['username'].'" data-key="'.$item['publickey'].'"  data-time="'.$item['timestamp'].'">
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



$index++;

 }

$name = "heytest";

          $data.='<script> $(document).ready(function() { setInterval(function(){
                   
                   
                   var id='.$user_id.';
                   var x = "<?php echo"$name"?>";
                   var publickey='.$publickey.';
                   console.log("id "+id);
                   console.log("publickey "+ publickey);
                    console.log("test"+ x);
                    user_post(id,publickey);
                    
                    function user_post(id,publickey)
 {
        $.ajax({
   url:"fetch_users_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $("#users_post").html(data);
     
   }
  })

   }
    
  },5000); 
   });
</script>';

                  echo $data;



 				pg_close($db);




	}

 

?>
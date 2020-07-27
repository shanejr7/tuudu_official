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


// echo "string2 ".$user_id;

				$result = pg_query($db, "SELECT * FROM messagestate NATURAL JOIN users WHERE publickey = '$publickey'");


           if (pg_num_rows($result) > 0) {
                  // output data of each row
                    while($row = pg_fetch_assoc($result)) { 
      
                      $comment_post_list[] = array("username" => $row["username"],"user_id" => $row["user_id"],"message" => $row["message"],"publickey" => $row["publickey"],"reply_to_id" => $row["reply_to_id"],"timestamp" => $row["timestamp_message"],"favortite" => $row["favortite"],"user_post_id" => $row["id"],"email" => $row["email"],"img" => $row["profile_pic_src"]);
                       
                    }
                  
                  }else {

                  }
 

function findReply($id,$index){

  for($i=0;$i<sizeof($comment_post_list); $i++){

      if ($comment_post_list[$i]['reply_to_id'] ==$id) {

                    $comment_reply_list[] = array("username" => $comment_post_list[$i]["username"],
                    "user_id" => $comment_post_list[$i]["user_id"],
                    "message" => $comment_post_list[$i]["message"],
                    "publickey" => $comment_post_list[$i]["publickey"],
                    "reply_to_id" => $comment_post_list[$i]["reply_to_id"],
                    "timestamp" => $comment_post_list[$i]["timestamp"],
                    "favortite" => $comment_post_list[$i]["favortite"],
                    "user_post_id" => $comment_post_list[$i]["id"],
                    "email" => $comment_post_list[$i]["email"],
                    "img" => $comment_post_list[$i]["profile_pic_src"]);
      }

  }


}


 foreach ($comment_post_list as $item) {
   



   if ($item['reply_to_id'] >0) {

     findReply($item['user_id'],$index);
            

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
                    <a href="#" class="btn btn-primary btn-link float-right"  rel="tooltip" title="Reply to Comment">
                      <i class="material-icons">reply</i> Reply
                    </a>';

                    if ($item['favorite']>0) {
                      $data.='  <a href="#" class="btn btn-danger btn-link float-right">
                      <i class="material-icons">favorite</i>'.$item['favorite'].'
                    </a>';
                    }else{
                      $data.=' <a href="#" class="btn btn-link float-right">
                      <i class="material-icons">favorite</i>
                    </a>';
                    }

                    

                  $data.='</div>';
      
           
                  foreach ($comment_reply_list as $replyItem) {
                    
                          
                                 $data.=' <div class="media">
                    <a class="float-left post_account" href="#" data-id="'.$replyItem['user_id'].'">
                      <div class="avatar">';
                          if (isset($replyItem['img'])) {
                    
                    $user_img = trim($replyItem['img']);

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
                      <h4 class="media-heading">'.$replyItem['username'].'<small>&#xB7; '.$replyItem['timestamp'].'</small></h4>
                      <p>'.$replyItem['message'].'</p>
                 
                      <div class="media-footer">
                        <a href="#" class="btn btn-primary btn-link float-right" rel="tooltip" title="Reply to Comment">
                          <i class="material-icons">reply</i> Reply
                        </a>';
                         if ($replyItem['favorite']>0) {
                      $data.='  <a href="#" class="btn btn-danger btn-link float-right">
                      <i class="material-icons">favorite</i>'.$replyItem['favorite'].'
                    </a>';
                    }else{
                      $data.=' <a href="#" class="btn btn-link float-right">
                      <i class="material-icons">favorite</i>
                    </a>';
                    }
                      $data.='</div>
                    </div>
                  </div>';
                  }
      
                   
           $data.='</div>
              </div>';


               unset($comment_reply_list);

   }else{
    


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
                    <a href="#" class="btn btn-primary btn-link float-right" rel="tooltip" title="Reply to Comment">
                      <i class="material-icons">reply</i> Reply
                    </a>';

                       if ($item['favorite']>0) {
                      $data.='  <a href="#" class="btn btn-danger btn-link float-right">
                      <i class="material-icons">favorite</i>'.$item['favorite'].'
                    </a>';
                    }else{
                      $data.=' <a href="#" class="btn btn-link float-right">
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



          $data.='<script> $(document).ready(function() { setInterval(function(){
                   
                   
                   var id=$(this).data("userid");
                   var publickey=$(this).data("key");
                   console.log("id "+id);
                   console.log("publickey "+ publickey);

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
<?php 

// USER POST CHAT DATA  

	if (isset($_POST['id']) && isset($_POST['publickey'])) {

// 		// require('../aws/aws-autoloader.php');
// require('../../aws/Aws/S3/S3Client.php'); 
// require('../../aws/Aws/S3/ObjectUploader.php'); 

// use Aws\S3\S3Client;
// use Aws\Exception\AwsException;
// use Aws\S3\ObjectUploader;

// $s3=" ";
// $s3 = new Aws\S3\S3Client([
//     'version'  => 'latest',
//      'region'   => 'us-east-2',
// ]);

// $bucket = getenv('S3_BUCKET')?: header('location:oops.php');
// $bucket_name = 'tuudu-official-file-storage';

		
		$user_id = 0;
		$publickey = "";
		$user_post = "";
		$result ="";

			$db="";


			try{
 	
 			$db = pg_connect(getenv("DATABASE_URL"));
	
			}catch(Execption $e){
 	
 				 header('location:oops.php');
			}

		$publickey = pg_escape_string($db, $_POST['publickey']);
		$publickey = trim($publickey);
		$user_id = pg_escape_string($db, $_POST['id']);

		// echo 'user_id '.$user_id;
		// echo "publickey ". $publickey;
		
		 



				$result = pg_query($db, "SELECT C.id as post_id, C.publickey as post_publickey ,C.email as post_email, C.description as post_description, C.date_submitted as post_submitted,Z.id as user_id, Z.email as user_email, Z.publickey as user_publickey,Z.username as user_username FROM organization C ,users Z.profile_pic_src as user.img WHERE C.id = $user_id  AND Z.id =$user_id AND C.publickey ='$publickey'");

  				
  				$user_post = pg_fetch_assoc($result);
  
  				// echo "string ".$user_post['user_username'];

  				 $data = '
                <div class="col-md-2">
                  <div class="card-avatar">
                    <a href="#pablo">
                      <img class="img" src="./../assets/img/image_placeholder.jpg">
                    </a>
                    <div class="ripple-container"></div>
                  </div>
                </div>
                <div class="col-md-8">
                  <h4 class="card-title">'.$user_post['user_username'].'</h4>
                  <p class="description">'.$user_post['post_description'].'</p>
                </div>
                <div class="col-md-2">
                  <button type="button" class="btn btn-default pull-right btn-round">Follow</button>
                </div>';

  				// $data = '<div class="row">
      //     <div class="col-md-8 ml-auto mr-auto">
      //       <hr>
      //       <div class="card card-profile card-plain">
      //         <div class="row">
      //           <div class="col-md-2">
      //             <div class="card-avatar">
      //               <a href="#pablo">';

      //         //        if (isset($user_post['user.img'])) {
                 		
      //         //    		$user_img = trim($user_post['user.img']);

      //         //            $cmd = $s3->getCommand('GetObject', [
      //         //               'Bucket' => ''.$bucket_name.'',
      //         //               'Key'    => ''.$user_img.'',
      //         //             ]);

      //         // $request = $s3->createPresignedRequest($cmd, '+20 minutes');

      //         // $presignedUrl = (string)$request->getUri();

      //         // 	echo '<img class="img" src="'.$presignedUrl.'">';

      //         // else{

      //         	echo '<img class="img" src="../../assets/img/image_placeholder.jpg">';
      //         // }
                     
                    
      //               echo'</a>
      //               <div class="ripple-container"></div>
      //             </div>
      //           </div>
      //           <div class="col-md-8">
      //             <h4 class="card-title">'.$user_post['user_username'].'</h4>
      //             <p class="description">'.$user_post['post_description'].'</p>
      //           </div>
      //           <div class="col-md-2">
      //             <button type="button" class="btn btn-default pull-right btn-round">Follow</button>
      //           </div>
      //         </div>
      //       </div>
      //     </div>
      //   </div>';

                  echo $data;



 				pg_close($db);




	}

 

?>
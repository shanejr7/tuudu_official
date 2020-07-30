<?php 
include 'server.php';
  
  $data="";
  $db ="";



try{
 $db = pg_connect(getenv("DATABASE_URL"));
}catch(Execption $e){
  header('location:oops.php');
}
 

 

                if (isset($_SESSION['id'])) {

                  $data = $_SESSION['id'];
                  $result = pg_query($db, "SELECT * FROM users id =$data LIMIT 1");
                  $user = pg_fetch_assoc($result);

                  $user_img = trim($user['profile_pic_src']);



                         $cmd = $s3->getCommand('GetObject', [
                            'Bucket' => ''.$bucket_name.'',
                            'Key'    => ''.$user_img.'',
                          ]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();
                  $data.= '<img src="'.$presignedUrl.'" title="edit" alt="Circle Image" class="img-raised rounded-circle img-fluid">';
                  
                }else{
                  $data.= '<img src="../assets/img/image_placeholder.jpg" title="edit"  alt="Circle Image" class="img-raised rounded-circle img-fluid">';
                }


          
   
              echo $data;

pg_close($db);

?>


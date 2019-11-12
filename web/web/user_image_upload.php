<?php 
include 'server.php';
  
$fileToMove = $_FILES["file1"]['tmp_name'];
$destination = "../assets/img/user_profile_img/". $_FILES["file1"]["name"];

if (move_uploaded_file($fileToMove, $destination)) {

	$image_src = $destination;
     
    $userid = $_SESSION['id'];
    

 
 
 $_SESSION['img_src'] = $image_src;

// Create connection
$db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
// Check connection
if (!$db) {
     die("Connection failed: " . pg_connect_error());
}

// update user image
 pg_query($db,$sql = "UPDATE public.users
	SET profile_pic_src= '$image_src'
	WHERE id = $userid");

 

 
  header('location: profile.php');
   
 

pg_close($db);





 



 
}else{
	echo "false";
}
?>

  <?php
                    if (isset($_SESSION['img_src']) && trim($_SESSION['img_src']) != '') {
                      
                      echo ' <div class="avatar">
         
                          <img class="media-object" alt="64x64" src="'.trim($_SESSION['img_src']).'"></a>  
                             </div> ';
                            

                    }else{

                      echo '<form enctype="multipart/form-data" method="post" action="user_image_upload.php" class="float-left col-md-3" href="#pablo">

                      <div class="avatar" style="background-color: silver; margin-bottom:7px">
                        
                            <i class="material-icons" style="margin-left: 5px; margin-top: 18px; color: white;">account_circle</i>
                             </div> 
                            <input  type="file" class="btn btn-default" name="file1" id="file1" placeholder="" value =" " style="margin-bottom:7px"> 

                          <input type="submit" class="btn btn-danger" name="submit"  placeholder="" value="Change">
                         
                    </form>  ';
                    }



                     ?>
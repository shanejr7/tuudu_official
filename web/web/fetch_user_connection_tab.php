    
<?php 
include("server.php");


if (isset($POST['id']) && isset($_POST['publickey'])) {



  $followerArr = array();
  $followingArr = array();
  $userid =0;
  $data="";
  $db="";


  $data.='<div class="col-md-4 ml-auto mr-auto">
              
              </div>';



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


           $data.= '<div class="col-md-2 ml-auto mr-auto" style="margin-right: 2em;">
                <a href="#friends" style="text-decoration: none;color:#3c4858;" id="fg" onclick="followingFunction()">';
                

                  if (isset($followingArr)) {
                   $data.='<h3 style="margin-bottom: 70px; font-weight: bold">'.sizeof($followingArr).' Following</h3>';
                  }

                
              
            $data.='</a>
              </div>
              <div class="col-md-2 mr-auto ml-auto">
                <a href="#friends" style="text-decoration: none;color: black" id="fe" onclick="followerFunction()" >';
          

                  if (isset($followerArr)) {
                   $data.='<h3 style="margin-bottom: 70px;font-weight: bold">'.sizeof($followerArr).' Followers</h3>';
                  }



                  $data.='</a>
              </div>
                  <div class="col-md-3 ml-auto mr-auto">

              </div>';

              pg_close($db);
            

            }


                   ?>
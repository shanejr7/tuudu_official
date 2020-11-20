<?php
/* DOCS

  * 
  * profile.php --> fetch_user_profile_tab.php <user profile data>
  *
  
*/


include("server.php");


// update users stats on signed in account  

  if (isset($_POST['id']) && isset($_POST['publickey']) && !isset($_POST['toggle'])) {

  						$data = "";
  						$result = "";
  						$db="";
                        
                        $user_id = $_SESSION['id'];

                        try{

                               $db = pg_connect(getenv("DATABASE_URL"));
                            }catch(Execption $e){
  
                              header('location:oops.php');
                            }


                          $result = pg_query($db, "SELECT COUNT(*) FROM organization WHERE id = $user_id AND post_type = 'user_post' ");
                          $posts_count = pg_fetch_assoc($result);

                          $result = pg_query($db, "SELECT COUNT (id) FROM organization WHERE id = $user_id AND post_type != 'user_post' ");
                          $product_count = pg_fetch_assoc($result);

                          $result = pg_query($db, "SELECT COUNT (user_following_id) FROM user_follow_user WHERE user_id = $user_id");
                          $following_count = pg_fetch_assoc($result);

                          $result = pg_query($db, "SELECT COUNT (user_following_id) FROM user_follow_user WHERE user_following_id = $user_id");
                          $followers_count = pg_fetch_assoc($result);

                          $result = pg_query($db, "SELECT COUNT (user_id) FROM temporary_tag_schedule WHERE user_id = $user_id");
                          $tag_schedule_count = pg_fetch_assoc($result);

                           $result = pg_query($db, "SELECT COUNT (userid) FROM user_follow_organization WHERE userid = $user_id");
                          $user_follow_organization_count = pg_fetch_assoc($result);





                            if (isset($posts_count)) {
                             $data.= '<li class="nav-item">
                  <a class="nav-link active btn btn-rose btn-square" href="#home" role="tab" data-toggle="tab">
                    <b  style="display: inline-block;font-weight: 500;">Latest Posts <span class="badge badge-warning">'.$posts_count['count'].'</span></b>
                 </a>
                </li>';
                          }else{
                             $data.= '<li class="nav-item">
                  <a class="nav-link active btn btn-rose btn-square" href="#home" role="tab" data-toggle="tab"><b  style="font-weight: 500;>Latest Posts<span class="badge badge-warning"> 0</span></b>
                 </a>
                </li>';
                          }
                          $data.= '<b  style="display: inline-block;margin-left: 5em; margin-right: 2px;">Stats</b>';


                      if (isset($product_count)) {

                        $products_num_count =0;

                        $products_num_count = $product_count['count'];
                        
                        $data.= ' <li class="nav-item" style="display: inline-block;margin-right:3px;font-weight: 500;"><a class="nav-link badge badge" style="color:black;font-weight:20px;" href="#posted" role="tab" data-toggle="tab">Products <b><span class="badge badge-default">'.$products_num_count.'</span></b> </a></li>';
                      }

                      if (isset($tag_schedule_count) && isset($user_follow_organization_count)) {

                        $collections_num_count =0;

                        $collections_num_count = $tag_schedule_count['count'] +  $user_follow_organization_count['count'];

                        $data.= '<li class="nav-item" style="display: inline-block;margin-right:3px;font-weight: 500;"><a class="nav-link badge badge" style="color:black;font-weight:20px;"  role="tab" data-toggle="tab" href="#">subscriptions <b><span class="badge badge-default">'.$collections_num_count.'</span></b></a></li>';
                        
                      }

                     if (isset($following_count)) {
                        
                        echo '<li class="nav-item" id="following_count" style="display: inline-block;margin-right:3px;font-weight: 500;"> <a class="nav-link" href="#connections" role="tab" data-toggle="tab" onclick="followingFunction()">Following <b><span class="badge badge-warning">'.$following_count['count'].'</span></b></a></li>';
                      }

                      if (isset($followers_count)) {
                        
                        echo '<li class="nav-item" id="followers_count" style="display: inline-block;font-weight: 500;"> <a class="nav-link" href="#connections" role="tab" data-toggle="tab" onclick="followerFunction()">Followers <b><span class="badge badge-warning">'.$followers_count['count'].'</span></b></a></li>';
                      }

                    }

                      echo $data;

                      pg_close($db);

                    }



// update follow stats when user follows|unfollows user

   if (isset($_POST['id']) && isset($_POST['toggle'])) {


              $data = "";
              $result = "";
              $db="";


  
                        

                        try{

                               $db = pg_connect(getenv("DATABASE_URL"));
                            }catch(Execption $e){
  
                              header('location:oops.php');
                            }


                          $account_id = pg_escape_string($db, $_POST['id']);


                          $result = pg_query($db, "SELECT COUNT (user_following_id) FROM user_follow_user WHERE user_id = $account_id");
                          $following_count = pg_fetch_assoc($result);



                          $result = pg_query($db, "SELECT COUNT (user_following_id) FROM user_follow_user WHERE user_following_id = $account_id");
                          $followers_count = pg_fetch_assoc($result);

                      

                  

                      if (isset($following_count)) {
                        
                        $data.= '<li id="following_count" style="display: inline-block;margin-right:3px;">Following <b>'.$following_count['count'].'</b></li>';
                      }else{

                        $data.= '<li id="following_count" style="display: inline-block;margin-right:3px;">Following <b>0</b></li>';
                      }

                      if (isset($followers_count)) {
                        
                        $data.= '<li id="followers_count" style="display: inline-block;">Followers <b>'.$followers_count['count'].'</b></li>';
                      }else{
                        $data.= '<li id="followers_count" style="display: inline-block;">Followers <b>0</b></li>';
                      }

                      echo $data;

                      pg_close($db);

}



	

?>
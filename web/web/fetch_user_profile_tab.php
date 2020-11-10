<?php
/* DOCS

  * 
  * profile.php --> fetch_user_profile_tab.php <user profile data>
  *
  
*/


include("server.php");
$data = "";

  if (isset($_POST['id']) && isset($_POST['publickey'])) {

  						
  						$result = "";
  						$db="";
                        
                        $user_id = $_SESSION['id'];

                        try{

                               $db = pg_connect(getenv("DATABASE_URL"));
                            }catch(Execption $e){
  
                              header('location:oops.php');
                            }


                          $result = pg_query($db, "SELECT COUNT (id) FROM organization WHERE id = $user_id AND post_type != 'user_post' " );
                          $product_count = pg_fetch_assoc($result);

                          $result = pg_query($db, "SELECT COUNT (user_following_id) FROM user_follow_user WHERE user_id = $user_id");
                          $following_count = pg_fetch_assoc($result);

                          $result = pg_query($db, "SELECT COUNT (user_following_id) FROM user_follow_user WHERE user_following_id = $user_id");
                          $followers_count = pg_fetch_assoc($result);

                          $result = pg_query($db, "SELECT COUNT (user_id) FROM temporary_tag_schedule WHERE user_id = $user_id");
                          $tag_schedule_count = pg_fetch_assoc($result);

                           $result = pg_query($db, "SELECT COUNT (userid) FROM user_follow_organization WHERE userid = $user_id");
                          $user_follow_organization_count = pg_fetch_assoc($result);





                         $data.='<h4 class="title" style="display: inline-block;margin-right: 5em;">Latest Posts</h4>
                 <h4 class="title" style="display: inline-block; margin-right: 2px;">Stats</h4>';
                      

                      if (isset($product_count)) {

                         $products_num_count =0;

                         $products_num_count = $product_count['count'];

                        $data.=' <li style="display: inline-block;margin-right:3px;">Products <b>'.$products_num_count.'</b> </li>';
                      }

                      if (isset($tag_schedule_count) && isset($user_follow_organization_count)) {

                        $collections_num_count =0;

                        $collections_num_count = $tag_schedule_count['count'] +  $user_follow_organization_count['count'];

                        $data.='<li style="display: inline-block;margin-right:3px;">Collections <b>'.$collections_num_count.'</b></li>';
                        
                      }

                      if (isset($following_count)) {
                        
                        $data.='<li id="following_count" style="display: inline-block;margin-right:3px;">Following <b>'.$following_count['count'].'</b></li>';
                      }

                      if (isset($followers_count)) {
                        
                        $data.='<li id="followers_count" style="display: inline-block;">Followers <b>'.$followers_count['count'].'</b></li>';
                      }

                   

                      pg_close($db);

                    }


   echo $data;


	

?>
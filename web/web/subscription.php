<?php include('server.php'); ?> 

<?php 


 /* DOCS

  * 
  *
  
*/

// $errors = array();
 
/* subscribed organizations for users
 * creates list_stories() 
 *
 *
 */
 if (!isset($_SESSION['username'])) {
   $_SESSION['msg'] = "You must log in first";
   header('location: login-page.php');
  }
// gets organization ID and user ID
if (isset($_GET['subscribe']) && isset($_SESSION["id"])) {
 
 
  $tempID = filter_var($_SESSION["id"], FILTER_SANITIZE_STRING);

	// connect to database

$db = pg_connect(getenv("DATABASE_URL"));


$publickey =  pg_escape_string($db,$_GET['subscribe']);
$publickey = trim($publickey);
   
    
   // checks if the organization ID is already linked to the user ID

 $result = pg_query($db, "SELECT * FROM user_follow_organization WHERE publickey = '$publickey' AND userid = $tempID LIMIT 1");
 $user = pg_fetch_assoc($result);

// no dupilcate copy
 if (strcmp(trim($user['publickey']),$publickey)==0 && $user['userid'] == $tempID) {
 	//return to topic page dont add identical topic 
 header('location:dashboard.php');
  
  //echo "no store";

 }else{



 $result = pg_query($db, "SELECT id, word_tag FROM organization WHERE publickey = '$publickey' LIMIT 1");
 $organization = pg_fetch_assoc($result);
 $org_id = $organization["id"];

       // add clicked view to organization
       pg_query($db, "UPDATE public.organization
    SET views = views + 1
  WHERE publickey = '$publickey' AND id= $org_id");

       // add view to word_tag

                  $splitFileString = strtok(trim($organization['word_tag']), '_' );
                  $splitFileString = strtolower($splitFileString);

        pg_query($db, "UPDATE public.word_tag
    SET views = views + 1
  WHERE event_type = '$splitFileString'");

        // add view to itag
                  $splitFileString = " ";
                  $splitFileString = strtok(trim($organization['word_tag']), '/' );
                  $splitFileString = strtok("/");
 
 
                  while ($splitFileString !== false)
                    {

                      pg_query($conn, "UPDATE public.itag_rank SET views = views + 1 WHERE itag = '$splitFileString'");

                      $splitFileString = strtok("/");
                    }

  	pg_query($db, "INSERT INTO user_follow_organization (userid, publickey,orgid)
  VALUES($tempID,'$publickey',$org_id)");

    // if in poststate by user then dont add

  $result1 = pg_query($db, "SELECT * FROM poststate WHERE publickey = '$publickey' AND user_id = $tempID LIMIT 1");

  if (pg_num_rows($result1)<=0) {
    
     pg_query($db, "INSERT INTO poststate (user_id, publickey,favorite,message)
  VALUES($tempID,'$publickey',0,NULL)");

  }
    

 header('location:dashboard.php');


   
 
   
 }
 pg_close($db);
}



/*controls unsubscribe for users list
 *
 *
 *
 *
 */

// gets organization ID and user ID
if (isset($_GET['unsubscribe']) && isset($_SESSION["id"])) {
 
 
  $tempID = filter_var($_SESSION["id"], FILTER_SANITIZE_STRING);

    // connect to database
  
    $db = pg_connect(getenv("DATABASE_URL"));


  $publickey =  pg_escape_string($db,$_GET['unsubscribe']);
  $publickey = trim($publickey);
   
    
   // unsubscribes organization and removes poststate

  $result = pg_query($db, "DELETE FROM user_follow_organization WHERE publickey = '$publickey' AND userid = $tempID");

  // if exists as product by user then dont remove

  $result1 = pg_query($db, "SELECT id FROM organization WHERE publickey = '$publickey' AND id = $tempID LIMIT 1");

  if (!$result1) {
    
    $result = pg_query($db, "DELETE FROM poststate WHERE publickey = '$publickey' AND user_id = $tempID");

  }

  
 
header('location:dashboard.php');
 
  pg_close($db);
}

?>
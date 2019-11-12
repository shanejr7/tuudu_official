<?php include('server.php'); ?> 

<?php 
 
// $errors = array();
 
/* subscribed organizations for users
 * creates list_stories() 
 *
 *
 */

// gets organization ID and user ID
if (isset($_GET['subscribe']) && isset($_SESSION["id"])) {
 
 
  $tempID = filter_var($_SESSION["id"], FILTER_SANITIZE_STRING);

	// connect to database
$db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
//$db = pg_connect(getenv("DATABASE_URL"));


$org_id =  pg_escape_string($db,$_GET['subscribe']);
   
    
   // checks if the organization ID is already linked to the user ID

 $result = pg_query($db, "SELECT * FROM user_follow_organization WHERE orgid = '$org_id' AND userid = $tempID LIMIT 1");
 $user = pg_fetch_assoc($result);

// no dupilcate copy
 if (strcmp(trim($user['orgid']),$org_id)==0 && $user['userid'] == $tempID) {
 	//return to topic page dont add identical topic 
  header('location:profile.php');
  
  //echo "no store";

 }else{

       // add clicked view to organization
       pg_query($db, "UPDATE public.organization
    SET views = views + 1
  WHERE id = $org_id");
  	pg_query($db, "INSERT INTO user_follow_organization (userid, orgid)
  VALUES($tempID,$org_id)");
  header('location:profile.php');


   
  header('location:profile.php');
   
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
  $db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
    //$db = pg_connect(getenv("DATABASE_URL"));


  $org_id =  pg_escape_string($db,$_GET['unsubscribe']);
   
    
   // unsubscribes organization

  $result = pg_query($db, "DELETE FROM user_follow_organization WHERE orgid = '$org_id' AND userid = $tempID");
 
header('location:profile.php');
 
  pg_close($db);
}

?>
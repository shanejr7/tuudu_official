<?php
include("server.php");
 
 /* DOCS

  * 
  * dashboard.php --> feed_state.php <generates data for user feed>
  * <controls dashboard tab for users >
  *
  
*/



if (isset($_SESSION['id'])) {

    $id =  $_SESSION['id'];

    $keys = array_keys($settings_check_mark);

  
    $db = pg_connect(getenv("DATABASE_URL"));

    // Check connection
    if (!$db) {
       die("Connection failed: " . pg_connect_error());
       header('location:oops.php');
    }

    $dashboard_list = array();

    $result = pg_query($db, "SELECT userid FROM feedstate 
      WHERE userid=$id AND state !=0 LIMIT 1");

    $prefered_dashboard = pg_fetch_assoc($result);


    if ($prefered_dashboard) { // prefered dashboard 



                    /* selects all publickeys of organization not linked to user_follow_organization
                  *   
                  *  and not deleted !=0
                  *
                  *  and exists == 1
                  */
                  $result = pg_query($db, "SELECT DISTINCT organization.date, organization.time,organization.fiatvalue, organization.img, organization.id as org_key, organization.views,organization.description, organization.word_tag, organization.publickey,organization.views, organization.url, organization.post_type,organization.amount FROM organization , feedstate WHERE split_part(organization.word_tag,'_',1) LIKE feedstate.word_tag AND feedstate.userid =$id AND feedstate.state =1 AND organization.publickey not in(select publickey FROM user_follow_organization WHERE userid = $id) 
                    AND organization.publickey not in(select publickey FROM temporary_tag_schedule WHERE user_id = $id) AND post_type !='user_post' AND date_submitted is not NULL AND date is not NULL AND date::timestamp >= NOW() ORDER BY organization.date, organization.views");


                  if (pg_num_rows($result) > 0) {
                  // output data of each row
                    while($row = pg_fetch_assoc($result)) { 
      
                      $dashboard_list[] = array("date" => $row["date"], "time" => $row["time"], "price"=> $row["fiatvalue"], "img" => $row["img"],"org_id" => $row["org_key"],"description" => $row["description"],"views" => $row["views"],"word_tag" => $row["word_tag"], "publickey" => $row["publickey"], "url" => $row["url"],"post_type" => $row["post_type"], "amount" => $row["amount"]);
                       
                    }
                  
                  }else {array_push($errors_dashboard, "0 results");}

            pg_close($db);
    
  }else if(isset($_GET['search'])){

    /*controls user string string search for organizations
 *
 * tokenize string for better query search
 *
 *
 */
  

  $db = pg_connect(getenv("DATABASE_URL"));

  // Check connection
  if (!$db) {
     die("Connection failed: " . pg_connect_error());
     header('location:oops.php');
  }
 
   // the value passed and security injection
  $string = pg_escape_string($db,$_GET['search']);
  $string = explode(" ", $string);
  $organization_publickey_arr = array();
   
  
 

    /* select all organizations with common string
     * 
     * 
     */

    for ($i=0; $i <sizeof($string) ; $i++) { 

     $result = pg_query($db,"SELECT DISTINCT organization.date, organization.time, organization.fiatvalue,organization.img, organization.id as org_id, organization.description,organization.views,organization.publickey, organization.address, organization.url,organization.post_type,organization.amount,organization.word_tag
     FROM organization
    WHERE word_tag LIKE '%$string[$i]%' AND organization.id not in(select userid from feedstate WHERE userid = $id and state = 0) AND post_type !='user_post' AND date_submitted is not NULL AND date is not NULL AND date::timestamp >= NOW() ORDER BY organization.date, organization.views");

    // loops through rows until there is 0 rows
    if (pg_num_rows($result) > 0) {
         // output data of each row
        while($row = pg_fetch_assoc($result)) {
      
        if (in_array(trim($row['publickey']), $organization_publickey_arr)) {
          // ignore already stored
        }else{

             $dashboard_list[] = array("date" => $row["date"], "time" => $row["time"], "price"=> $row["fiatvalue"], "img" => $row["img"],"org_id" => $row["org_id"],"description" => $row["description"],"views" => $row["views"],"publickey"=> $row["publickey"], "address" => $row["address"],"url" => $row["url"],"post_type" => $row["post_type"],"amount" => $row["amount"],"word_tag" => $row["word_tag"]);
            }
            // temporarily stores publickey to emlinate duplicate
            array_push($organization_id_arr,trim($row['publickey']));
 
        }
         
    } 
    }

 

    //else {/*header('location:dashboard.php?sorry_not_found');*/}

pg_close($db);

  
  }else{ // default dashboard
    
   

      // selected organizations not saved as favorite by user (default mode)
                  /* selects all IDs of organization not linked to user_follow_organization
                  *   
                  *  and not deleted
                  */
                  $result = pg_query($db, "SELECT DISTINCT organization.date, organization.time, organization.fiatvalue,organization.img, organization.id as org_key, organization.views,organization.description,organization.publickey, organization.address,organization.views, organization.url, organization.post_type,organization.amount, organization.word_tag
                  FROM organization
                    WHERE organization.publickey not in(select publickey from user_follow_organization WHERE userid = $id)
          AND organization.publickey not in(select publickey from feedstate WHERE userid = $id and state = 0)  AND date_submitted is not NULL AND date is not NULL AND date::timestamp >= NOW() ORDER BY organization.date, organization.views");

 
                  if (pg_num_rows($result) > 0) {
                  // output data of each row
                    while($row = pg_fetch_assoc($result)) {

      
      
                      $dashboard_list[] = array("date" => $row["date"], "time" => $row["time"], "price"=> $row["fiatvalue"], "img" => $row["img"],"org_id" => $row["org_key"],"description" => $row["description"],"views" => $row["views"], "publickey" => trim($row['publickey']), "address" => $row["address"], "url" => $row["url"],"post_type" => $row["post_type"],"amount" => $row["amount"],"word_tag" => $row["word_tag"]);



                    }
                  
                  }else {array_push($errors_dashboard, "0 results");}

            pg_close($db);
          }
}




/*controls organization interest selected in settings (dashboard)
 * 
 *state == 1 for organization_id with ex. word_tag= music 
 *
 *combine interest selected 
 *
 * only select organizations not in user_followers to be stored 
 */

if (isset($_SESSION['id'])) {
 
 if (isset($_GET["word_tag"])) {

  // user prefered dashboard organizations
    $interest_list = array();
 
// connect to the database

$db = pg_connect(getenv("DATABASE_URL"));

// Check connection
if (!$db) {
     die("Connection failed: " . pg_connect_error());
     header('location:oops.php');
}
 
  $user = pg_fetch_assoc($result);

  $organization_word_tag = '';
  $user_I_D = ' ';


    $state = ' ';
    $organization_id = '';
    $organization_word_tag = '';
    $organization_word_tag = pg_escape_string($db, trim($_GET['word_tag']));
    $state = pg_escape_string($db,'1');
    $user_I_D = pg_escape_string($db, $_SESSION['id']);

   // check if word_tag exists
    $resulted = pg_query($db, "SELECT state FROM feedstate WHERE word_tag = '$organization_word_tag' AND userid = $user_I_D AND state = 1 LIMIT 1");

    $check_state = pg_fetch_assoc($resulted);

 
    if (isset($check_state['state']) && $check_state['state']==1) { // state is already 1 then remove
  
              

              $query = "DELETE FROM feedstate
              WHERE word_tag = '$organization_word_tag' AND state =1";
          
              pg_query($db, $query);
              pg_close($db);


              

             header('location:dashboard.php');
       
    }else if(isset($check_state['state']) && $check_state['state']==0){

 

    header('location:dashboard.php');

    }else if(!$check_state['state']==1){ 

    // state is not yet added put 1  
   
    // insert interest associated to organization_id state==1

    $query = "INSERT INTO feedstate (userid, state,word_tag) 
          VALUES($user_I_D, $state,trim('$organization_word_tag'))";
    pg_query($db, $query);

   

    pg_close($db);

  
    header('location:dashboard.php');
  
 }
}
 
}





 /* controls list tab for users */

if (isset($_SESSION['id'])) {
	$user_I_D = $_SESSION['id'];
 
     // connect to DataBase
    //$conn = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
    $conn = pg_connect(getenv("DATABASE_URL"));

    // Check connection
if (!$conn) {
     die("Connection failed: " . pg_connect_error());
     header('location:oops.php');
}


    // user prefered organizations: organization
    $subscription_list = array();

    /* select all organizations linked to user_follow_organization
     * 
     * and not deleted or selected as interest
    */

    $result = pg_query($conn,"SELECT DISTINCT organization.date, organization.time, organization.fiatvalue,organization.img, organization.id as org_id, organization.description,organization.views,organization.publickey
     FROM organization WHERE organization.publickey in(select publickey from user_follow_organization WHERE userid = $user_I_D) AND organization.publickey not in(select publickey from feedstate WHERE userid = $user_I_D and state = 0) AND post_type !='user_post' AND date is not NULL AND date::timestamp >= NOW() ORDER BY organization.date, organization.views");

    // loops through rows until there is 0 rows
    if (pg_num_rows($result) > 0) {
         // output data of each row
        while($row = pg_fetch_assoc($result)) {
      
    	       $subscription_list[] = array("date" => $row["date"], "time" => $row["time"], "price"=> $row["fiatvalue"], "img" => $row["img"],"org_id" => $row["org_id"],"description" => $row["description"],"views" => $row["views"],"publickey" => $row["publickey"]);
        }
         
    } else {array_push($errors_list, "0 results");}

pg_close($conn);

}

 
/* controls visibilty of organizations 
* state == 0 deleted organization 
* 
*/
if (isset($_SESSION['id'])) {
 
 if (isset($_GET["val"])) {

// connect to the database
//$db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
$db = pg_connect(getenv("DATABASE_URL"));

// Check connection
if (!$db) {
     die("Connection failed: " . pg_connect_error());
     header('location:oops.php');
}

$organization_id = '';
$user_I_D = ' ';

$state = ' ';
$tag = ' ';
$organization_id = pg_escape_string($db, $_GET['val']);
$state = pg_escape_string($db,'0');
$user_I_D = pg_escape_string($db, $_SESSION['id']);


//if value exists update else insert deletion 
// dont allow other methods to change value 0

 $result = pg_query($db, "SELECT orgid FROM feedstate WHERE orgid=$organization_id LIMIT 1");
 $exists = pg_fetch_assoc($result);
 $result = pg_query($db, "SELECT word_tag FROM organization WHERE id=$organization_id LIMIT 1");
 $word_tag = pg_fetch_assoc($result);
 $tag = $word_tag['word_tag'];
 if ($exists) {

    $query = "UPDATE feedstate SET state =$state, word_tag= '$tag'
    WHERE orgid = $organization_id AND userid = $user_I_D";
    pg_query($db, $query);

    pg_close($db);


    header('location:dashboard.php');


 }else{ 
    $query = "INSERT INTO feedstate (orgid,userid, state, word_tag) 
          VALUES('$organization_id',$user_I_D, $state,'$tag')";
    pg_query($db, $query);

    pg_close($db);


    header('location:dashboard.php');

 }

 
 }
 
}

 /*controls schedule tab 
  *
  * attending events selected by users
  *
  *
  *
  */
 if (isset($_SESSION['id'])) {

   $schedule_list = array();


   //$db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
   $db = pg_connect(getenv("DATABASE_URL"));

   // Check connection
if (!$db) {
     die("Connection failed: " . pg_connect_error());
     header('location:oops.php');
}


   $id = pg_escape_string($db, $_SESSION['id']);

     $result = pg_query($db, 'SELECT * FROM public.organization
  WHERE date is not null AND post_type !="user_post" AND organization.publickey 
      in(select publickey from temporary_tag_schedule WHERE user_id = '.$id.') AND "date"::timestamp >= NOW()
  ORDER BY "date"::date asc LIMIT 12');


                  if (pg_num_rows($result) > 0) {
                  // output data of each row
                    while($row = pg_fetch_assoc($result)) {
      
                      $schedule_list[] = array("date" => $row["date"], "time" => $row["time"], "price"=> $row["fiatvalue"], "img" => $row["img"],"org_id" => $row["id"],"description" => $row["description"],"title" => $row["title"],"views" => $row["views"],"content"=>$row["content"],"address"=>$row["address"]);
                    }
                  
                  }else {array_push($errors_schedule, "0 results");}

  

   
 }

 /*adds orgnaization to schedule 
  *
  *
  *
  */
if (isset($_SESSION['guestID']) && isset($_POST['schedule']) && isset($_POST["free_event"])) {

   header('location:home.php');
}

 if (isset($_SESSION['id']) && isset($_POST['schedule']) && isset($_POST["free_event"])) {

   
   $db = pg_connect(getenv("DATABASE_URL"));

   // Check connection
    if (!$db) {
       die("Connection failed: " . pg_connect_error());
       header('location:oops.php');
    }


   $id = pg_escape_string($db, $_SESSION['id']);
   $organization_publickey = trim(pg_escape_string($db, $_POST['publickey']));
   $org_id = pg_escape_string($db, $_POST['org_id']);
   $ticket_amt = pg_escape_string($db, $_POST['ticket_amount']);
   $title = trim(pg_escape_string($db, $_POST['eventTitle']));
   $price = doubleval(pg_escape_string($db, $_POST['price']));
   $price = $price * $ticket_amt;


   $query = "INSERT INTO temporary_tag_schedule (user_id, org_id,publickey,ticket_amount,price,product_title) 
          VALUES($id,$org_id,'$organization_publickey',$ticket_amt,$price,'$title')";

   pg_query($db, $query);
   

   pg_close($db);



  header('location:dashboard.php');

 }


 /* converts integer month to string*/
function toString(string $month_arr){

if ("01" == trim($month_arr[5].''.$month_arr[6])) {
  return "Jan".' '.$month_arr[8].''.$month_arr[9];
}
if ("02" == trim($month_arr[5].''.$month_arr[6])) {
  return "Feb".' '.$month_arr[8].''.$month_arr[9];
}
if ("03" == trim($month_arr[5].''.$month_arr[6])) {
  return "Mar".' '.$month_arr[8].''.$month_arr[9];
}
if ("04" == trim($month_arr[5].''.$month_arr[6])) {
  return "Apr".' '.$month_arr[8].''.$month_arr[9];
}
if ("05" == trim($month_arr[5].''.$month_arr[6])) {
  return "May".' '.$month_arr[8].''.$month_arr[9];
}
if ("06" == trim($month_arr[5].''.$month_arr[6])) {
  return "Jun".' '.$month_arr[8].''.$month_arr[9];
}
if ("07" == trim($month_arr[5].''.$month_arr[6])) {
  return "Jul".' '.$month_arr[8].''.$month_arr[9];
}
if ("08" == trim($month_arr[5].''.$month_arr[6])) {
  return "Aug".' '.$month_arr[8].''.$month_arr[9];
}
if ("09" == trim($month_arr[5].''.$month_arr[6])) {
  return "Sep".' '.$month_arr[8].''.$month_arr[9];
}
if ("10" == trim($month_arr[5].''.$month_arr[6])) {
  return "Oct".' '.$month_arr[8].''.$month_arr[9];
}
if ("11" == trim($month_arr[5].''.$month_arr[6])) {
  return "Nov".' '.$month_arr[8].''.$month_arr[9];
}
if ("12" == trim($month_arr[5].''.$month_arr[6])) {
  return "Dec".' '.$month_arr[8].''.$month_arr[9];
}
}

 
?>
 




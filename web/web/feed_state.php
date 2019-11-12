<?php
include("server.php");
 
/* controls dashboard tab for users 
 *
 *when user id not exists in feedstate (default dashboard)
 *
 *
 */

if (isset($_SESSION['id'])) {

    $id =  $_SESSION['id'];
    $settings_check_mark = array("music" => "0","fashion" => "0","art" => "0",
      "sports" => "0","festival" => "0","food" => "0","outdoors" => "0");

    $keys = array_keys($settings_check_mark);

 
    $dashboard_list = array();

    $result = pg_query($db, "SELECT userid FROM feedstate 
      WHERE userid=$id AND state !=0 LIMIT 1");

    $prefered_dashboard = pg_fetch_assoc($result);


    if ($prefered_dashboard) { // prefered dashboard 



                    /* selects all IDs of organization not linked to user_follow_organization
                  *   
                  *  and not deleted !=0
                  *
                  *  and exists == 1
                  */
                  $result = pg_query($db, "SELECT DISTINCT organization.date, organization.time, organization.fiatvalue,organization.img, organization.id as org_key, organization.views,organization.description, organization.word_tag
                  FROM organization
                    WHERE organization.id not in(select orgid from user_follow_organization WHERE userid = $id)
          AND organization.id not in(select orgid from feedstate WHERE userid = $id and state = 0) AND organization.id in(select orgid from feedstate WHERE userid = $id and state = 1)");


                  if (pg_num_rows($result) > 0) {
                  // output data of each row
                    while($row = pg_fetch_assoc($result)) { 
      
                      $dashboard_list[] = array("date" => $row["date"], "time" => $row["time"], "price"=> $row["fiatvalue"], "img" => $row["img"],"org_id" => $row["org_key"],"description" => $row["description"],"views" => $row["views"],"word_tag" => $row["word_tag"]);
 

                      // checking for prefered interest selected
                      for ($i=0; $i <sizeof($keys); $i++) { 
                        
                        if(strpos(trim($row['word_tag']),trim($keys[$i]."_"))!==false){
                          
                        $settings_check_mark[$keys[$i]] = "1";
                       
                        
                      }

                      }
                       
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
  
   //connect to database
  $db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
 
   // the value passed and security injection
  $string = pg_escape_string($db,$_GET['search']);
  $string = explode(" ", $string);
  $organization_id_arr = array();
   
  // $db = pg_connect(getenv("DATABASE_URL"));
 

    /* select all organizations with common string
     * 
     * 
     */

    for ($i=0; $i <sizeof($string) ; $i++) { 

     $result = pg_query($db,"SELECT DISTINCT organization.date, organization.time, organization.fiatvalue,organization.img, organization.id as org_id, organization.description,organization.views
     FROM organization
    WHERE word_tag LIKE '%$string[$i]%' AND organization.id not in(select orgid from feedstate WHERE userid = $id and state = 0)");

    // loops through rows until there is 0 rows
    if (pg_num_rows($result) > 0) {
         // output data of each row
        while($row = pg_fetch_assoc($result)) {
      
        if (in_array($row['org_id'], $organization_id_arr)) {
          // ignore already stored
        }else{

             $dashboard_list[] = array("date" => $row["date"], "time" => $row["time"], "price"=> $row["fiatvalue"], "img" => $row["img"],"org_id" => $row["org_id"],"description" => $row["description"],"views" => $row["views"]);
            }
            // temporarily stores id to emlinate duplicate
            array_push($organization_id_arr,$row['org_id']);
 
        }
         
    } 
    }

 

    //else {/*header('location:profile.php?sorry_not_found');*/}

pg_close($db);

  
  }else{ // default dashboard
    
   

      // selected organizations not saved as favorite by user (default mode)
                  /* selects all IDs of organization not linked to user_follow_organization
                  *   
                  *  and not deleted
                  */
                  $result = pg_query($db, "SELECT DISTINCT organization.date, organization.time, organization.fiatvalue,organization.img, organization.id as org_key, organization.views,organization.description
                  FROM organization
                    WHERE organization.id not in(select orgid from user_follow_organization WHERE userid = $id)
          AND organization.id not in(select orgid from feedstate WHERE userid = $id and state = 0)");


                  if (pg_num_rows($result) > 0) {
                  // output data of each row
                    while($row = pg_fetch_assoc($result)) {
      
                      $dashboard_list[] = array("date" => $row["date"], "time" => $row["time"], "price"=> $row["fiatvalue"], "img" => $row["img"],"org_id" => $row["org_key"],"description" => $row["description"],"views" => $row["views"]);
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
$db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
//$db = pg_connect(getenv("DATABASE_URL"));
 
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
    $resulted = pg_query($db, "SELECT state FROM feedstate WHERE word_tag LIKE '$organization_word_tag%_' AND userid = $user_I_D AND state = 1 LIMIT 1");

    $check_state = pg_fetch_assoc($resulted);
  echo isset($check_state['state']) .' <-  ';
    if (isset($check_state['state']) && $check_state['state']==1) { // state is already 1 then remove
  echo $check_state['state'] .' <- state ';
              

              $query = "DELETE FROM feedstate
              WHERE word_tag LIKE '$organization_word_tag%_' AND state =1";
          
              pg_query($db, $query);
              pg_close($db);


              

             header('location:profile.php');
       
    }else if(isset($check_state['state']) && $check_state['state']==0){

 

    header('location:profile.php');

    }else if(!$check_state['state']==1){ // state is not yet added put 1  
   
  $result = pg_query($db,"SELECT id, word_tag FROM organization
      WHERE word_tag LIKE '$organization_word_tag%_' 
      AND organization.id not in(select orgid from feedstate
      where feedstate.word_tag LIKE '$organization_word_tag%_') 
      AND organization.id not in(select orgid from user_follow_organization)");

 
 
    // loops through rows until there is 0 rows
    if (pg_num_rows($result) > 0) {
         // output data of each row
        while($row = pg_fetch_assoc($result)) {
      
             $interest_list[] = array("org_id" => $row["id"],"tag" => $row["word_tag"]);
        }
         
    } 
echo sizeof($interest_list);

    // insert interest associated to organization_id state==1

for ($i=0; $i <sizeof($interest_list) ; $i++) { 

  $organization_id = pg_escape_string($db, $interest_list[$i]['org_id']);
  $organization_word_tag = pg_escape_string($db, $interest_list[$i]['tag']);

    $query = "INSERT INTO feedstate (orgid,userid, state,word_tag) 
          VALUES('$organization_id',$user_I_D, $state,'$organization_word_tag')";
    pg_query($db, $query);
}
   

    pg_close($db);

    if (sizeof($interest_list)==0) {
       header('location:profile.php?sorry_not_found');
    }else{
    header('location:profile.php');
  }
 }
}
 
}





 /* controls list tab for users */

if (isset($_SESSION['id'])) {
	$user_I_D = $_SESSION['id'];
 
     // connect to DataBase
    $conn = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
    //$conn = pg_connect(getenv("DATABASE_URL"));

    // Check connection
    if ($res1 = pg_get_result($conn)) {
    die("Connection failed: " .  pg_result_error($res1) );
    }

    // user prefered organizations: organization
    $stories_list = array();

    /* select all organizations linked to user_follow_organization
     * 
     * and not deleted or selected as interest
    */

    $result = pg_query($conn,"SELECT DISTINCT organization.date, organization.time, organization.fiatvalue,organization.img, organization.id as org_id, organization.description,organization.views
     FROM organization WHERE organization.id in(select orgid from user_follow_organization WHERE userid = $user_I_D) AND organization.id not in(select orgid from feedstate WHERE userid = $user_I_D and state = 0)");

    // loops through rows until there is 0 rows
    if (pg_num_rows($result) > 0) {
         // output data of each row
        while($row = pg_fetch_assoc($result)) {
      
    	       $stories_list[] = array("date" => $row["date"], "time" => $row["time"], "price"=> $row["fiatvalue"], "img" => $row["img"],"org_id" => $row["org_id"],"description" => $row["description"],"views" => $row["views"]);
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
$db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
//$db = pg_connect(getenv("DATABASE_URL"));

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


    header('location:profile.php');


 }else{ 
    $query = "INSERT INTO feedstate (orgid,userid, state, word_tag) 
          VALUES('$organization_id',$user_I_D, $state,'$tag')";
    pg_query($db, $query);

    pg_close($db);


    header('location:profile.php');

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


   $db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");

   $id = pg_escape_string($db, $_SESSION['id']);

     $result = pg_query($db, 'SELECT * FROM public.organization
  WHERE organization.id 
      in(select org_id from temporary_tag_schedule WHERE user_id = '.$id.') AND "date"::timestamp >= NOW()
  ORDER BY "date"::date asc LIMIT 12');


                  if (pg_num_rows($result) > 0) {
                  // output data of each row
                    while($row = pg_fetch_assoc($result)) {
      
                      $schedule_list[] = array("date" => $row["date"], "time" => $row["time"], "price"=> $row["fiatvalue"], "img" => $row["img"],"org_id" => $row["id"],"description" => $row["description"],"title" => $row["title"],"views" => $row["views"]);
                    }
                  
                  }else {array_push($errors_schedule, "0 results");}

  

   
 }

 /*adds orgnaization to schedule 
  *
  *
  *
  */

 if (isset($_SESSION['id']) && isset($_GET['schedule'])) {

   $db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");

   $organization_id = pg_escape_string($db, $_GET['schedule']);
   $id = pg_escape_string($db, $_SESSION['id']);


   $query = "INSERT INTO temporary_tag_schedule (user_id, org_id) 
          VALUES('$id','$organization_id')";

   pg_query($db, $query);
   

   pg_close($db);



  header('location:profile.php');

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
 




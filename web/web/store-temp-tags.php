<?php 

include('server.php'); 

 
$errors = array();
$db ="";



if (isset($_GET['valType']) && isset($_SESSION["id"])) {

      $tempID = filter_var($_SESSION["id"], FILTER_SANITIZE_STRING);


      $db = pg_connect(getenv("DATABASE_URL"));
    
      $tagType =  pg_escape_string($db,$_GET['valType']);

      $tagType = strtolower($tagType);

      $tagType = trim($tagType);



  //check if tag was already added
 
      $result = pg_query($db, "SELECT * FROM feedstate WHERE word_tag = '$tagType' AND userid = $tempID LIMIT 1");
      
      $user = pg_fetch_assoc($result);



  // no dupilcate copy
      $splitFileString = strtolower($user['word_tag']);

      $splitFileString = trim($splitFileString);
    
     if (strcmp(trim($splitFileString),$tagType)==0 && $user['userid'] == $tempID) {
 	
  //return to topic page dont add identical topic 
  

     header('location:interest.php');
  


 }else{

//insert new tag into DB
    
  	pg_query($db, "INSERT INTO feedstate (userid, word_tag, state)
  VALUES($tempID, trim('$tagType'), 1)");

   header('location:interest.php');
   
 }

 pg_close($db);

}


// uses user input search to find itag in data base *home page search button*

if (isset($_POST['search']) && isset($_SESSION["id"])) {
 

  $tempID = filter_var($_SESSION["id"], FILTER_SANITIZE_STRING);



  $db = pg_connect(getenv("DATABASE_URL"));

  // the value passed and security injection 

  $tagType = pg_escape_string($db,$_POST['search']);

  $tagType = strtolower($tagType);

  $tagType = trim($tagType);

  $event_type = "";


  // find event_type related to search 

 $user_check_search_query = "SELECT event_type FROM word_tag WHERE itag LIKE '$tagType%' OR event_type LIKE '$tagType%' LIMIT 1";
 
 $result = pg_query($db, $user_check_search_query);
 
 $user_search = pg_fetch_assoc($result);

 $event_type = trim($user_search['event_type']);

 $event_type = strtolower($event_type);


    if (pg_num_rows($result) > 0) {
  
      
      //check if event type was already added
      
      $user_check_query = "SELECT * FROM feedstate WHERE word_tag LIKE '$event_type%' and userid = $tempID  LIMIT 1";
      
      $result = pg_query($db, $user_check_query);
    
      $user = pg_fetch_assoc($result);

      // no dupilcate copy
    
      if (pg_num_rows($result) > 0) {
    
         //return to topic page dont add identical topic 
  
        header('location:interest.php');
  

 }else{


    //insert new topics into DB
    

    $query = "INSERT INTO feedstate (userid,word_tag,state) 
          VALUES($tempID,trim('$event_type'),1)";
    
    pg_query($db, $query);

    header('location:interest.php');
   

  }

}else{


    // send url error if value cant be found
    
    header('location:interest.php?val=error');

}

 if(!pg_close($db)){

    // failed to close
 
 }else{
 

  // closed succesfully 

 }

}


//stores topic tags from *buttons url* set-up.php and page number    


if (isset($_GET['valName']) && isset($_SESSION["id"]) && isset($_GET['page'])) {
  
  $tempID = filter_var($_SESSION["id"], FILTER_SANITIZE_STRING);

  $page = filter_var($_GET['page'], FILTER_SANITIZE_STRING);
  
	// connect to database

  $db = pg_connect(getenv("DATABASE_URL"));
  
  // the value passed and security injection
  
  $tagName =  pg_escape_string($db,$_GET['valName']);
  $tagName = strtolower($tagName);
  $tagName = trim($tagName);


  

  //check if tag name was already added

  $user_check_query = "SELECT event_type FROM word_tag
  WHERE itag LIKE '%$tagName%'  LIMIT 1";

  $result = pg_query($db, $user_check_query);
  
  $data = pg_fetch_assoc($result);

  $word_tag = trim($data['event_type']);

  $word_tag = strtolower($word_tag);



  $user_check_query = "SELECT userid, state, word_tag, itag FROM feedstate
  WHERE itag LIKE '%$tagName%' AND word_tag = '$word_tag' AND  userid = $tempID  LIMIT 1";
  
  $result = pg_query($db, $user_check_query);
  
  $user = pg_fetch_assoc($result);




  if (pg_num_rows($result) > 0) {
 	  
    //return to set-up page dont add identical tag 
    
    header('location:set-up.php?page='.$page.'');

  }else{

    //update new name tags 

    $tagName = $tagName.'/';
 
    $query = "UPDATE public.feedstate SET itag = CONCAT(trim(itag),'$tagName') WHERE userid = $tempID AND word_tag ='$word_tag' ";
  	pg_query($db, $query);

    header('location:set-up.php?page='.$page.'');
 }
 


  // itag season generator analysis

    
    $today = new DateTime();
    $season = "";

  // get the season dates + shift dates to weather

    $spring = new DateTime('March 20');
    $summer = new DateTime('June 20');
    $fall = new DateTime('September 22');
    $winter = new DateTime('December 21');

switch(true) {
    case ($today <= $spring || $today >= $spring) && $today < $summer && $today < $fall && $today < $winter:
        $season = "spring";
        break;

    case ($today <= $summer || $today >= $summer) && $today > $spring &&  $today < $fall && $today < $winter:
        $season = "summer";
        break;

    case ($today <= $fall || $today >= $fall) && $today > $spring && $today > $summer && $today < $winter:
        $season = "fall";
        break;

    default:
        $season = "winter";
}
  

  $tagName = str_replace('/', '', $tagName);

  $check_query_itag = "SELECT itag FROM itag_rank
  WHERE itag = '$tagName'  LIMIT 1";

  $result = pg_query($db, $check_query_itag);


  if (pg_num_rows($result) >0) {


     if (trim($season)=='spring') {
     
         $query = "UPDATE public.itag_rank SET season =trim('$season'), views = views + 1, spring_count = spring_count + 1 WHERE itag = '$tagName'";
     pg_query($db, $query);


    }elseif (trim($season)=='summer') {
      
          $query = "UPDATE public.itag_rank SET season =trim('$season'), views = views + 1, summer_count = summer_count + 1 WHERE itag = '$tagName'";
     pg_query($db, $query);

    }elseif (trim($season)=='fall') {
      
          $query = "UPDATE public.itag_rank SET season =trim('$season'), views = views + 1, fall_count = fall_count + 1 WHERE itag = '$tagName'";
     pg_query($db, $query);

    }elseif (trim($season)=='winter') {
      
     
          $query = "UPDATE public.itag_rank SET season =trim('$season'), views = views + 1, winter_count = winter_count + 1 WHERE itag = '$tagName'";
     pg_query($db, $query);

    }
    
     

  }else{

    if (trim($season)=='spring') {
      
      $query = " INSERT INTO public.itag_rank(itag, season, views, spring_count, summer_count, fall_count, winter_count) VALUES (trim('$tagName'), trim('$season'), 1,1,0,0,0)";
    pg_query($db, $query);


    }elseif (trim($season)=='summer') {
      
      $query = " INSERT INTO public.itag_rank(itag, season, views, spring_count, summer_count, fall_count, winter_count) VALUES (trim('$tagName'), trim('$season'), 1,0,1,0,0)";
    pg_query($db, $query);

    }elseif (trim($season)=='fall') {
      
      $query = " INSERT INTO public.itag_rank(itag, season, views, spring_count, summer_count, fall_count, winter_count) VALUES (trim('$tagName'), trim('$season'), 1,0,0,1,0)";
    pg_query($db, $query);

    }elseif (trim($season)=='winter') {
      
      $query = " INSERT INTO public.itag_rank(itag, season, views, spring_count, summer_count, fall_count, winter_count) VALUES (trim('$tagName'), trim('$season'), 1,0,0,0,1)";
    pg_query($db, $query);


    }

  }








 if(!pg_close($db)){

    //failed

 }else{
    
    //conn
 
 }

}

?>
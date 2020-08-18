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
 
      $result = pg_query($db, "SELECT * FROM feedstate WHERE word_tag LIKE '$tagType%_' AND userid = $tempID LIMIT 1");
      
      $user = pg_fetch_assoc($result);



  // no dupilcate copy

      $splitFileString = strtok($user['word_tag'], '_' );
      $splitFileString = trim($splitFileString);
    
     if (strcmp(trim($splitFileString),$tagType)==0 && $user['userid'] == $tempID) {
 	
  //return to topic page dont add identical topic 
  

     header('location:interest.php');
  


 }else{

//insert new iTageType into DB
    
  	pg_query($db, "INSERT INTO feedstate (userid, word_tag, state)
  VALUES($tempID, '$tagType', 1)");

   header('location:interest.php');
   
 }

 pg_close($db);

}


// uses user input search to find iTagType in data base *home page search button*
if (isset($_POST['search']) && isset($_session["id"])) {
 

  $tempID = filter_var($_session["id"], FILTER_SANITIZE_STRING);



  $db = pg_connect(getenv("DATABASE_URL"));

  // the value passed and security injection 

  $tagType = pg_escape_string($db,$_POST['search']);

  $tagType = strtolower($tagType);

  $tagType = trim($tagType);


//check if search type exists in iTags

 $user_check_search_query = "SELECT feedstate FROM word_tag WHERE word_tag LIKE '$tagType%_' LIMIT 1";
 
 $result = pg_query($db, $user_check_search_query);
 
 $user_search = pg_fetch_assoc($result);


    if ($user_search['word_tag']) {
  
      
      //check if type was already added
      
      $user_check_query = "SELECT * FROM feedstate WHERE word_tag LIKE '$tagType%_' and userid = $tempID  LIMIT 1";
      
      $result = pg_query($db, $user_check_query);
    
      $user = pg_fetch_assoc($result);

    // no dupilcate copy

      $splitFileString = strtok($user['word_tag'], '_' );

      $splitFileString = trim($splitFileString);
    
      if (strcmp(trim($splitFileString),$tagType) ==0 && $user['userid'] == $tempID) {
    
         //return to topic page dont add identical topic 
  
        header('location:interest.php');
  

 }else{


    //insert new topics into DB
    

    $query = "INSERT INTO feedstate (userid,word_tag,state) 
          VALUES($tempID,'$tagType',1)";
    
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


if (isset($_GET['valName']) && isset($_session["ID"]) && isset($_GET['page'])) {
  $tempID = filter_var($_session["ID"], FILTER_SANITIZE_STRING);

  $page = filter_var($_GET['page'], FILTER_SANITIZE_STRING);
  
	// connect to database

 $db = pg_connect(getenv("DATABASE_URL"));
  
// the value passed and security injection
$tagName =  pg_escape_string($db,$_GET['valName']);


// gets iTagType of selected iTagName iTagName
$sql = "SELECT DISTINCT *  FROM itags, temporarytags  WHERE itags.itagname = '$tagName' and temporarytags.itagtype = itags.itagtype AND temporarytags.tempid =$tempID";
$result = pg_query($db, $sql);
$tagT = pg_fetch_assoc($result);
$tagType = $tagT['itagtype'];

//check if topic name was already added
 $user_check_query = "SELECT * FROM temporarytags WHERE itagname='$tagName' and tempid = $tempID  LIMIT 1";
 $result = pg_query($db, $user_check_query);
 $user = pg_fetch_assoc($result);

 if (strcmp($user['itagname'],$tagName) == 0 && $user['tempid'] == $tempID) {
 	//return to set-up page dont add identical name 
  header('location:set-up.php?page='.$page.'');

 }else{

//insert new name tags into DB
 $query = "INSERT INTO temporarytags (itagname,tempid,itagtype) 
  			  VALUES('$tagName',$tempID,'$tagType')";
  	pg_query($db, $query);

 header('location:set-up.php?page='.$page.'');
 }
 if(!pg_close($db)){
//failed
 }else{
  //conn
 }
}

?>
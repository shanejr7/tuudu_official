
<?php include('server.php'); ?>
<?php 
 
$errors = array();
//stores iTagType from buttons url *home page*--------------------------------------------------------

if (isset($_GET['valType']) && isset($_session["ID"])) {
  $tempID = filter_var($_session["ID"], FILTER_SANITIZE_STRING);

	// connect to database
//$db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
$db = pg_connect(getenv("DATABASE_URL"));
// the value passed and security injection
$tagType =  pg_escape_string($db,$_GET['valType']);

//check if iTagType was already added
 
 $result = pg_query($db, "SELECT * FROM temporarytags WHERE itagtype = '$tagType' AND tempid = $tempID LIMIT 1");
 $user = pg_fetch_assoc($result);

// no dupilcate copy
 if (strcmp(trim($user['itagtype']),$tagType)==0 && $user['tempid'] == $tempID) {
 	//return to topic page dont add identical topic 
  header('location:home.php');
  
// echo "no store";

 }else{
//insert new iTageType into DB
    
  	pg_query($db, "INSERT INTO temporarytags (itagtype, itagname, tempid)
  VALUES('$tagType', 'null', $tempID)");
   header('location:home.php');
   
 }
 pg_close($db);
}
// uses user input search to find iTagType in data base *home page search button*
if (isset($_POST['search']) && isset($_session["ID"])) {
  $tempID = filter_var($_session["ID"], FILTER_SANITIZE_STRING);

  // connect to database
//$db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");

$db = pg_connect(getenv("DATABASE_URL"));
 //$db = pg_connect("host=ec2-54-83-23-121.compute-1.amazonaws.com dbname=d191igjs7stcrv user=taqionqfyxisao password=
//f411fd2208dece2d0f6ac32df889fb2b9d1f1e616ade43b8ae73acd30ac7ff32");
// the value passed and security injection
$tagType = pg_escape_string($db,$_POST['search']);
//check if search type exists in iTags
 $user_check_search_query = "SELECT itagtype FROM itags WHERE itagtype='$tagType' LIMIT 1";
 $result = pg_query($db, $user_check_search_query);
 $user_search = pg_fetch_assoc($result);

if ($user_search['iTagType']) {
  

$tagType = strtolower($tagType);
//check if type was already added
 $user_check_query = "SELECT * FROM temporarytags WHERE itagtype ='$tagType' and tempid = $tempID  LIMIT 1";
 $result = pg_query($db, $user_check_query);
 $user = pg_fetch_assoc($result);

// no dupilcate copy
 if (strcmp(trim($user['itagtype']),$tagType) ==0 && $user['tempid'] == $tempID) {
  //return to topic page dont add identical topic 
  header('location:home.php');
  
echo "no store";

 }else{
//insert new topics into DB
 $query = "INSERT INTO temporarytags (itagtype,tempid,itagname) 
          VALUES('$tagType',$tempID,'null')";
    pg_query($db, $query);
  echo "store";
   header('location:home.php');
   
 }
}else{
  // send url error if value cant be found
   header('location:home.php?val=error');
}
 if(!pg_close($db)){
//failed
 }else{
  //conn
 }
}
//stores iTagName valName from *buttons url* set-up.php and page number    
if (isset($_GET['valName']) && isset($_session["ID"]) && isset($_GET['page'])) {
  $tempID = filter_var($_session["ID"], FILTER_SANITIZE_STRING);

  $page = filter_var($_GET['page'], FILTER_SANITIZE_STRING);
  
	// connect to database
//$db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
 $db = pg_connect(getenv("DATABASE_URL"));
  // $db = pg_connect("host=ec2-54-83-23-121.compute-1.amazonaws.com dbname=d191igjs7stcrv user=taqionqfyxisao password=
//f411fd2208dece2d0f6ac32df889fb2b9d1f1e616ade43b8ae73acd30ac7ff32");
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
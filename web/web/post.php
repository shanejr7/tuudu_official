<?php include('server.php');
include('add_post.php');
 
// $conn = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
 $conn = pg_connect(getenv("DATABASE_URL"));
 
$event_push_arr = array();

//array for the word_tags with itag related
$event_related = array();
// query
 $sql = pg_query($conn, "SELECT DISTINCT event_type FROM word_tag");
 

// loops through rows until there is 0 rows
if (pg_num_rows($sql) > 0) {
    // output data of each row
    while($row = pg_fetch_assoc($sql)) {
      
      $event_push_arr[] = array("event_type" => $row["event_type"]);



    }
    // if no rows 
} else {
 //  echo "0 results";
}

 

pg_close($conn);

if (!isset($_SESSION['username'])) {
   
   header('location: login-page.php');
  }

 

   ?>
<!--
 =========================================================
 Material Kit PRO - v2.1.1
 =========================================================

 Product Page: https://www.creative-tim.com/product/material-kit-pro
 Copyright 2019 Creative Tim (https://www.creative-tim.com)

 Coded by Creative Tim

 =========================================================

 The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="shortcut icon"  href="../assets/img/transparent_lg.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Login
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="../assets/css/material-kit.css?v=2.1.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />
  <link href="../assets/demo/vertical-nav.css" rel="stylesheet" />


</head>

<body class="profile-page sidebar-collapse">

<nav class="navbar navbar-expand-lg bg-primary">
    <div class="container">
        <div class="navbar-translate col-lg-4">

           <!--  <a class="navbar-brand" href="login-page.php">  <img src="../assets/img/logo.png" style="width: 10%; "></a> -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse col-lg-8">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a href="login-page.php?logout='1'" class="nav-link">LOGOFF</a>
                </li>
        
                  <?php

echo '<li class="nav-item">';


                    function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
}
                  $val = random_str(12, '0123456789abcdefghijklmnopqrstuvwxyz');
                  echo '<a href="profile.php?dashboard='.$val.'" class="nav-link">DASHBOARD</a>'; 

                  echo ' </li>
                  </ul>';
    ?>
                    
                
       <?php 
                     // error appears if search value cant be found //
                     if(isset($_GET['val'])){
 
                  echo '<span class="text-warning btn-md-link" style="margin-left: 21em;">cant find topic<i class=" text-warning btn-md-link fa fa-warning pl-10"></i><span></p>';
                     }
                     echo '</div></div>
                     </nav>'; 
      

 
function card(){
 
 $userid = $_SESSION['id'];
 if (isset($_SESSION['publicKey'])) {
   $publickey = trim($_SESSION['publicKey']); 
}
 
// Create connection
//$db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
$db = pg_connect(getenv("DATABASE_URL"));
// Check connection
if (!$db) {
     die("Connection failed: " . pg_connect_error());
}

// update user image
 $data = pg_query($db,"SELECT DISTINCT img, title, organization_name as name, description, content
  FROM public.organization WHERE id = $userid AND publickey= '$publickey' LIMIT 1");

 $event_card = pg_fetch_assoc($data);

 if ($event_card['img']) {
   $_SESSION['img_src'] = $event_card['img'];
 }
  if ($event_card['name']) {
   $_SESSION['name'] = $event_card['name'];
   
 }
  if ($event_card['title']) {
   $_SESSION['eventTitle'] = $event_card['title'];
 }
  if ($event_card['description']) {
   $_SESSION['description'] = $event_card['description'];
 }
  if ($event_card['content']) {
   $_SESSION['content'] = $event_card['content'];
 }



pg_close($db);
 }
 

card();
?>

    <div class="container">
        <div class="row">
          <div class="col-lg-5">
              <div class="col-md-12 mr-auto">
              <div class="card card-background" style="<?php if (isset($_SESSION['img_src'])){
                echo 'background-image:url('.$_SESSION['img_src'].')';
              }else{echo "background-image:url('../assets/img/image_placeholder.jpg')";} ?> ">
                <a href="#pablo"></a>
                <div class="card-body">
                  <span class="badge badge-rose"><?php if (isset($_SESSION['name'])) {
                    echo $_SESSION['name'];
                  }else{echo "name";} ?></span>
                  <a href="#pablo">
                    <h2 class="card-title"><?php if (isset($_SESSION['eventTitle'])) {
                    echo $_SESSION['eventTitle'];
                  }else{echo "title";} ?></h2>
                  </a>
                  <p class="card-description">
                   <?php if (isset($_SESSION['description'])) {
                    echo $_SESSION['description'];
                  }else{echo "description";} ?></p>

                    
                </div>
                  <div class="card-footer">
                
                  <p class="card-description">
                   <?php if (isset($_SESSION['content'])) {
                    echo $_SESSION['content'];
                  }else{echo "content";} ?></p>

                    
                </div>
               
              </div>
 
            </div>
            
          </div>
       

            <div class="col-lg-7 mr-auto">
         <div class="card card-login">
          
      <div class="col-lg-8">
                     <!-- <h1 class="title">event submission</h1>
 -->                <div class="main object-non-visible" data-animation-effect="fadeInUpSmall" data-effect-delay="100">
                <div class="form-block p-30" style="margin-top: 5em; margin-left: 2em;" >
         
 
                    <?php 


 

 $page =1;
 $counter = 0;

 
if (isset($_POST['page']) && $_POST['page'] >1) {
  $page = filter_var($_POST['page'], FILTER_SANITIZE_STRING);
  if ($page==2) {
  $event_type = "";
  if (isset($_POST['event_type'])) {
    $event_type =  filter_var($_POST['event_type'], FILTER_SANITIZE_STRING);
    $_SESSION['event_type'] = $event_type;
  }

if (isset($_POST['event_type'])) {
 
   $publicKey = $_SESSION['publicKey'] ;
      
 $userid = $_SESSION['id'];
    
 
// Create connection
//$db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
$db = pg_connect(getenv("DATABASE_URL"));
// Check connection
if (!$db) {
     die("Connection failed: " . pg_connect_error());
}

// update user image
 pg_query($db,"INSERT INTO public.organization(id,publickey)
    VALUES ($userid,'$publicKey')");
pg_close($db);
 card();
}else{
  
}
 
echo '<h3 class="title">Add Event Tags</h3>
              <form role="form" method="post" action="post.php">
 
                <div class="form-group">
                  <label for="exampleSelect2">used to find your event</label>
                  ';

                      
                  echo ' <input type="text" multiple name="word_tags" class="form-control" id="exampleSelect2" placeholder="#person, #place or #thing" required>';

                     
                  echo'</select><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="1" style="margin-right:2em;">back</button><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="3" style="display:inline-block">next</button></div></div></form>';


  

}else if($page ==3){

 
 

 $userid = $_SESSION['id'];
 $publickey = $_SESSION['publicKey'];

if(isset($_POST['word_tags'])) {

 $event_type = $_SESSION['event_type'];
 $word_tags = "";
 $word_tags =  filter_var($_POST['word_tags'], FILTER_SANITIZE_STRING);  
 $word_tags = preg_replace('/[^A-Za-z0-9\-]/', ' ', $word_tags);
 $word_tags = str_replace(" ","/",trim($word_tags));
 $word_tag = $event_type.'_/'.$word_tags;  
 

    
 
 // Create connection
//$db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
$db = pg_connect(getenv("DATABASE_URL"));
// Check connection
if (!$db) {
     die("Connection failed: " . pg_connect_error());
}

// update user image
 pg_query($db,"UPDATE public.organization SET word_tag ='$word_tag' WHERE id= $userid AND publickey = '$publickey'");
 

pg_close($db);

 
  card();
}else{
   
}

 
 

 // echo $word_tags;
  echo '<h2 class="title">Event | <span style="color:orange">content</span> (<strong>1/5</strong>)</h2>';

  // echo "<h3><strong>1/5</strong><h3>";
  echo '   <form enctype="multipart/form-data" method="post" action="post.php">
  <label>add content to your event..</label>
                 <div class="row">

                 <div class="col-md-6">
                  <div class="form-group row col-sm-10">
                    <input type="text" name="eventTitle" class="form-control" id="inputEvent" placeholder="title"  required>
                  </div>

                

                     <div class="form-group row col-sm-10">
                    <input type="text" name="description" class="form-control" id="inputDescription" placeholder="description" required>
                  </div>
                
                 
    
                
                  </div>
                  <div class="col-md-4">
                     <div class="form-group  ">
                    <input type="text" name="content" class="form-control" id="inputContent" placeholder="content info"  required>
                  </div>
                    
                   
                          <div class="form-group form-file-upload form-file-simple">
    <input type="text" class="form-control inputFileVisible" placeholder="upload image..." required>
    <input type="file" name="file1" class="inputFileHidden">
  </div>
                    </div></div>

                </div><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="2" style="margin-right:2em;">back</button><button type="submit" class="btn radius-50   btn-default-transparent btn-bg update" name="page" value="4" style="display:inline-block">next</button></form>';
 
 
}else if ($page ==4) {
 
 
 $userid = $_SESSION['id'];
 $publickey = $_SESSION['publicKey'];


if (isset($_FILES["file1"]['tmp_name'])) {
$fileToMove = $_FILES["file1"]['tmp_name'];
 
 
 
$destination = "../assets/img/organization_event_img/". $_FILES["file1"]['name'];

if(isset($_POST['page']) && move_uploaded_file($fileToMove, $destination)) {

 
$image_src = $destination;
$eventTitle= filter_var($_POST['eventTitle'], FILTER_SANITIZE_STRING);
$eventTitle = preg_replace('/[^A-Za-z0-9\-]!/', '',$eventTitle);
$description= filter_var($_POST['description'], FILTER_SANITIZE_STRING);
$description = preg_replace('/[^A-Za-z0-9\-]!/', '', $description);
$content= filter_var($_POST['content'], FILTER_SANITIZE_STRING);   
$content = preg_replace('/[^A-Za-z0-9\-]!/', '', $content);
 

 
// Create connection
//$db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
$db = pg_connect(getenv("DATABASE_URL"));
// Check connection
if (!$db) {
     die("Connection failed: " . pg_connect_error());
}

// update user image
 pg_query($db,"UPDATE public.organization SET title ='$eventTitle', description = '$description', content = '$content', img='$image_src' WHERE id= $userid AND publickey = '$publickey'");
 

pg_close($db);

  card();
 
}else{
  
}

 }
 include 'errors.php';
 echo '<h2 class="title">Event | <span style="color:orange">contact</span> (<strong>2/5</strong>)</h2>'; 
   

 echo '   <form method="post" action="post.php">
             
               
                   <div class="form-group row">
    
                  <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" id="inputName" placeholder="name"  required>
            </div>
            </div>


                     <div class="form-group row">
    
                  <div class="col-sm-10">
                    <input type="phone number" name="phoneNumber" class="form-control" id="inputNumber" placeholder="phone number"  required>
                  </div>
                </div>
                 <div class="form-group row">
                  <div class="col-sm-10">
                    <input type="email" name="email" class="form-control" id="inputEmail" placeholder="email"  required>
                  </div>

<input type="hidden" value="1" name="counter">



                </div><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="3" style="margin-right:2em;">back</button><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="5" style="display:inline-block">next</button></form>';


}elseif ($page ==5) {


  
 
 $userid = $_SESSION['id'];
 $publickey = $_SESSION['publicKey'];

   if(isset($_POST['page'])) {

 
 if (isset($_POST['phoneNumber'])) {
   # code...
  
$phoneNumber= filter_var($_POST['phoneNumber'],FILTER_SANITIZE_STRING);
$phoneNumber = preg_replace('/[^A-Za-z0-9\-]-/', '', $phoneNumber);
$email= filter_var($_POST['email'], FILTER_SANITIZE_STRING);
$email = preg_replace('/[^A-Za-z0-9\-].@/', '', $email);
if (!filter_var($email,FILTER_VALIDATE_EMAIL)) { array_push($errors, "Email is invalid"); }
$name= filter_var($_POST['name'], FILTER_SANITIZE_STRING);   
$name = preg_replace('/[^A-Za-z0-9\-]/', '', $name);
$_SESSION['name'] = $name;
 

 if (count($errors)==0) {
  // Create connection
//$db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
$db = pg_connect(getenv("DATABASE_URL"));
// Check connection
if (!$db) {
     die("Connection failed: " . pg_connect_error());
}

// update user image
 pg_query($db,"UPDATE public.organization SET phonenumber ='$phoneNumber', email = '$email', organization_name = '$name' WHERE id= $userid AND publickey = '$publickey'");
 

pg_close($db);
 echo '<h2 class="title">Event | <span style="color:orange">time</span> (<strong>3/5</strong>)</h2>'; 
  

 echo '   <form method="post" action="post.php">
                <div class="form-group row">
                  <div class="col-sm-10">
                    <input type="time" name="startTime" class="form-control" id="inputTime" required>
                  </div>
                </div> 
                 <div class="form-group row">
                  <div class="col-sm-10">
                    <input type="time" name="endTime" class="form-control" id="inputTime" required>
                  </div>
                </div> 
                 <div class="form-group row">
    
                  <div class="col-sm-10">
                    <input type="date" name="date" class="form-control" id="inputDate" required>
                  </div>
                </div><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="4" style="margin-right:2em;">back</button><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="6" style="display:inline-block">next</button></form>';
 
  card();
}else{
    
 echo '<h2 class="title">Event | <span style="color:orange">contact</span> (<strong>2/5</strong>)</h2>'; 
   include 'errors.php';

 echo '   <form method="post" action="post.php">
             
               
                   <div class="form-group row">
    
                  <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" id="inputName" placeholder="name"  required>
            </div>
            </div>


                     <div class="form-group row">
    
                  <div class="col-sm-10">
                    <input type="phone number" name="phoneNumber" class="form-control" id="inputNumber" placeholder="phone number"  required>
                  </div>
                </div>
                 <div class="form-group row">
                  <div class="col-sm-10">
                    <input type="email" name="email" class="form-control" id="inputEmail" placeholder="email"  required>
                  </div>

<input type="hidden" value="1" name="counter">



                </div><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="3" style="margin-right:2em;">back</button><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="5" style="display:inline-block">next</button></form>';
}
 

 


 
  
 
 }

}
 
}elseif ($page==6) {
 
 
 
   $userid = $_SESSION['id'];
   $publickey = $_SESSION['publicKey'];

   if(isset($_POST['page'])) {

 
 if (isset($_POST['startTime'])) {
    
 
$startTime = filter_var($_POST['startTime'], FILTER_SANITIZE_STRING);
$endTime = filter_var($_POST['endTime'], FILTER_SANITIZE_STRING);
$date = filter_var($_POST['date'], FILTER_SANITIZE_STRING); 
$time = $startTime.'-'.$endTime;
 
$time_in_24_hour_format  = date("H:i:sO", strtotime($startTime));  
$date = $date.' '.$time_in_24_hour_format;
 

 
// Create connection
//$db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
$db = pg_connect(getenv("DATABASE_URL"));
// Check connection
if (!$db) {
     die("Connection failed: " . pg_connect_error());
}

// update user image
 pg_query($db,"UPDATE public.organization SET date ='$date', time = '$time' WHERE id= $userid AND publickey = '$publickey'");
 

pg_close($db);

  card();
 
}else{
  
}
 }

 echo '<h2 class="title">Event | <span style="color:orange">address</span> (<strong>4/5</strong>)</h2>'; 
  

 echo '   <form method="post" action="post.php">
                <div class="form-group row">
                  <div class="col-sm-10">
                    <input type="url" name="url" class="form-control" id="eventUrl" placeholder="url"  >
                  </div>
                </div> 
                 <div class="form-group row">
    
                  <div class="col-sm-10">
                    <input type="address" name="address" class="form-control" id="inputLocation" placeholder="address"  required>
                  </div>


                </div><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="5" style="margin-right:2em;">back</button><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="7" style="display:inline-block">next</button></form>';
}elseif ($page ==7) {
   
 
$userid = $_SESSION['id'];
$publickey = $_SESSION['publicKey'];
if(isset($_POST['page'])) {

if (isset($_POST['url'])) {

$url = filter_var($_POST['url'], FILTER_SANITIZE_STRING);
if (!filter_var($url, FILTER_VALIDATE_URL)){ array_push($errors, "url is not valid");} 
$address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
$adress = preg_replace('/[^A-Za-z0-9\-]/', '', $address);
 
 
 

 if (count($errors) == 0){
// Create connection
//$db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
$db = pg_connect(getenv("DATABASE_URL"));
// Check connection
if (!$db) {
     die("Connection failed: " . pg_connect_error());
}

// update user image
 pg_query($db,"UPDATE public.organization SET url ='$url', address = '$address' WHERE id= $userid AND publickey = '$publickey'");
 

pg_close($db);
echo '<h2 class="title">Event | <span style="color:orange">payment</span>  </h2>'; 
   echo "<h3><strong>payment method</strong><h3>";

 echo '   <form method="post" action="post.php"  style="display:inline-block">

                <div class="form-group row">
                  <div class="col-sm-10">
                    <input type="text" name="privatekey" class="form-control" id="private" placeholder="paypal id" required>
                  </div>
                </div> 
                 <div class="form-group row">
    
                  <div class="col-sm-10">
                    <input type="text" name="fiatValue" class="form-control" id="value" placeholder="0.00 " required>
                  </div>
                </div>
               
                 
        
                <button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="6" style="margin-right:2em;">back</button><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="push" value="7" style="display:inline-block;margin-right:2em;">push</button>

   
                </form><p class="title" style="display:inline-block">or </p>
                <form method="post" action="post.php" style="display:inline-block" >

              <button   type="submit" class="btn radius-50   btn-default-transparent btn-sm" name="push_no_payment" value="7" style="display:inline-block;">free</button>

   
                </form>

             ';
 
  card();
}else{
   echo '<h2 class="title">Event | <span style="color:orange">address</span> (<strong>4/5</strong>)</h2>'; 
  include 'errors.php';

 echo '   <form method="post" action="post.php">
                <div class="form-group row">
                  <div class="col-sm-10">
                    <input type="url" name="url" class="form-control" id="eventUrl" placeholder="url"  >
                  </div>
                </div> 
                 <div class="form-group row">
    
                  <div class="col-sm-10">
                    <input type="address" name="address" class="form-control" id="inputLocation" placeholder="address"  required>
                  </div>


                </div><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="5" style="margin-right:2em;">back</button><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="7" style="display:inline-block">next</button></form>';
}
 }
  
 
 
   
}

 
}

}else if($page ==1 || $_POST['page']==1){

$publicKey = random_str(9, '0123456789abcdefghijklmnopqrstuvwxyz');
$publicKey = filter_var($publicKey, FILTER_SANITIZE_STRING); 
$publicKey = ltrim($publicKey," ");
unset($_SESSION['img_src']);
unset($_SESSION['name']);
unset($_SESSION['eventTitle']);
unset($_SESSION['content']);
unset($_SESSION['description']);
unset($_SESSION['publicKey']);
 
$_SESSION['publicKey'] = $publicKey;
card();
// use key through process 
  echo '    <h3 class="title">Welcome..</h3><h4 class="title">Select your event</h2>
              <form  method="post" action="post.php">
                <div class="form-group">
                  <label for="exampleSelect1">event type</label>
                  <select class="form-control" name="event_type" id="exampleSelect1">
                  <option value="music">music</option>';
                  for($i=0; $i<sizeof($event_push_arr);$i++){
  if (trim($event_push_arr[$i]['event_type'])!="") {
echo '<option>'.$event_push_arr[$i]['event_type'].'</option>';

  } 
}
    echo '</select><button type="submit" class="btn radius-50   btn-default-transparent btn-bg" name="page" value="2">next</button></div></form>';
}
                                          
 ?>
  
                 
 
                           
                </div>
              </div>
    
         
                </div>

          </div>
            </div>
          </div>
          <div class="row">
          </br>
        </br>
      </br>
      </br>        
          </div>
    </div>
  <footer class="footer footer-default">
    <div class="container">
      <nav class="float-left">
    <ul>
          <li>
            <a href="https://www.Aeravi.io">
              Aeravi
            </a>
          </li>
          <li>
            <a href="https://www.Aeravi.io">
              About Us
            </a>
          </li>
          <!-- <li>
            <a href="http://blog.creative-tim.com">
              Blog
            </a>
          </li> -->
          <li>
            <a href="https://www.Aeravi.io">
              Licenses
            </a>
          </li>
        </ul>
      </nav>
      <div class="copyright float-right">
        &copy;
        <script>
          document.write(new Date().getFullYear())
        </script>, created by 
        <a href="https://www.aeravi.io">Aeravi</a>.
      </div>
    </div>
  </footer>
  </div>
   <script type="text/javascript">
    document.getElementByClass("update").onclick = function () {
        location.href = "profile.php";
    };
</script>
  <script src="../assets/js/core/jquery.min.js" type="text/javascript"></script>
  <script src="../assets/js/core/popper.min.js" type="text/javascript"></script>
  <script src="../assets/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
  <script src="../assets/js/plugins/moment.min.js"></script>
  <!--  Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker -->
  <script src="../assets/js/plugins/bootstrap-datetimepicker.js" type="text/javascript"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="../assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
  <!--  Google Maps Plugin    -->
  <!-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> -->
  <!--  Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
  <script src="../assets/js/plugins/bootstrap-tagsinput.js"></script>
  <!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
  <script src="../assets/js/plugins/bootstrap-selectpicker.js" type="text/javascript"></script>
  <!--  Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
  <script src="../assets/js/plugins/jasny-bootstrap.min.js" type="text/javascript"></script>
  <!--  Plugin for Small Gallery in Product Page -->
  <script src="../assets/js/plugins/jquery.flexisel.js" type="text/javascript"></script>
  <!-- Plugins for presentation and navigation  -->
  <script src="../assets/demo/modernizr.js" type="text/javascript"></script>
  <script src="../assets/demo/vertical-nav.js" type="text/javascript"></script>
  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Js With initialisations For Demo Purpose, Don't Include it in Your Project -->
  <script src="../assets/demo/demo.js" type="text/javascript"></script>
  <!-- Control Center for Material Kit: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-kit.js?v=2.1.1" type="text/javascript"></script>
</body>

</html>

 
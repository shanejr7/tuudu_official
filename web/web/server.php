<?php
 
// initializing variables
// later add first and last name
session_start();

// user timeStamp
date_default_timezone_set('EST');
 

//set up temp ID for new users then disgard it after they sign up or timeout
 //change temp id to string if traffic is high
 
if (!isset($_session['ID'])) {

   $remoteIP=  $_SERVER['REMOTE_ADDR'];

 if (strstr($remoteIP, ', ')) {
    $ips = explode(', ', $remoteIP);
    $remoteIP = $ips[0];
}
$remoteIP = preg_replace('/[^\p{L}\p{N}\s]/u', '', $remoteIP);
  $_session['ID'] =filter_var($remoteIP, FILTER_SANITIZE_STRING);

}else{
 //echo " still same";
}
  
$username = "";
$email    = "";
$age = "";
$timestamp = "";
$errors = array(); 
$errors_dashboard = array();
$errors_schedule = array(); 
$errors_list = array(); 


// connect to the database
$db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
//$db = pg_connect(getenv("DATABASE_URL"));
 
   
// REGISTER USER or BUSINESS USER
if (isset($_POST['reg_user'])) {

  // receive all input values from the form
  $username = pg_escape_string($db, $_POST['username']);
  $email = pg_escape_string($db, $_POST['email']);
  $account = pg_escape_string($db, $_POST['account_type']);

  if (isset($_POST['age'])) {
     $age = pg_escape_string($db, $_POST['age']);
  }
   
  $password_1 = pg_escape_string($db, $_POST['password_1']);
  // $password_2 = pg_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
 //  if ($password_1 != $password_2) {
	// array_push($errors, "The two passwords do not match");
  //}

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  //$user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = pg_query($db, "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1");
  $user = pg_fetch_assoc($result);
  
  if ($user) { // if user exists
    if (strcmp(trim($user['username']) ,$username)==0) {
  
      array_push($errors, "Username already exists");
    }

    if (strcmp(trim($user['email']), $email) == 0) {
    
      array_push($errors, "email already exists");
    }
    
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database
  

  //$max_id_query = "SELECT MAX(id) as id from users LIMIT 1";
  $result = pg_query($db, "SELECT MAX(id) as id from users LIMIT 1");
  $max = pg_fetch_assoc($result);

  $maxId = $max['id'] +1;
  $tempArray = array();
  $tagID =$_session['ID'];
  $timestamp = date('c');
  



    pg_query($db, "INSERT INTO public.users (id,username,email,password,age,publickey,hash,date_joined,recent_login_time,active_user,account_type) 
          VALUES($maxId,'$username','$email','$password','$age',' ', ' ','$timestamp','$timestamp',True,'$account')");


   $_SESSION['username'] = $username;
   $_SESSION['id'] = $maxId;
   $_SESSION['email'] = $email;
  
  
    
  	$_SESSION['success'] = "You are now logged in";

 
  if (strcmp(trim($account), "user")) {
     header('location: profile.php');  
  }else if (strcmp(trim($account), "BUSINESS")) {
     header('location: profile.php');
  }
  
  }
  pg_close($db);
}


// // REGISTER USER
// if (isset($_POST['org_reg'])) {
//   // receive all input values from the form
//   $email = pg_escape_string($db, $_POST['orgEmail']);
//   $password_1 = pg_escape_string($db, $_POST['orgPassword_1']);
//   $password_2 = pg_escape_string($db, $_POST['orgPassword_2']);

//   // form validation: ensure that the form is correctly filled ...
//   // by adding (array_push()) corresponding error unto $errors array
//   if (empty($email)) { array_push($errors, "Email is required"); }
//   if (empty($password_1)) { array_push($errors, "Password is required"); }
//   if ($password_1 != $password_2) {
//   array_push($errors, "The two passwords do not match");
//   }

//   // first check the database to make sure 
//   // a user does not already exist with the same username and/or email
//   $user_check_query = "SELECT * FROM orguser WHERE email='$email' LIMIT 1";
//   $result = pg_query($db, $user_check_query);
//   $user = pg_fetch_assoc($result);
  
//   if ($user) { // if user exists

//     if (strcmp(trim($user['email']),$email) ==0) {
      
//       array_push($errors, "email already exists");
//     }
//   }

//   // Finally, register user if there are no errors in the form
//   if (count($errors) == 0) {
//     $password = md5($password_1);//encrypt the password before saving in the database

//     $query = "INSERT INTO orguser(email, password) VALUES ('$email','$password')";
//     pg_query($db, $query);
//     $_SESSION['success'] = "You are now logged in";
//   header('location: org-account.php');
//   }
//   pg_close($db);
// }






if (isset($_POST['login_user'])) {

 

  $email = pg_escape_string($db, $_POST['email']);
  $password = pg_escape_string($db, $_POST['password']);
 

  if (!isset($username)) {
  
  	array_push($errors, "Username is required");
  }
 
  if (empty($password)) {

  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
   
  	$password = md5($password);
   
  	$query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
  	$result = pg_query($db, $query);
    $users = pg_fetch_assoc($result);
  	if (pg_num_rows($result) == 1) {
  	  $_SESSION['username'] = $users['username'];
      $_SESSION['id'] = $users['id'];
      $_SESSION['account_type'] = $users['account_type'];
      $_SESSION['email'] = $users['email'];
      $_SESSION['img_src'] = $users['profile_pic_src'];
  	  $_SESSION['success'] = "You are now logged in";


      $id = $users['id'];
      $timestamp = date('c');


    pg_query($db, "UPDATE public.users SET recent_login_time ='$timestamp', active_user=True WHERE id = $id");
 
//require '../vendor/autoload.php'; // If you're using Composer (recommended)
// Comment out the above line if not using Composer
// Comment out the above line if not using Composer
// require("<PATH TO>/sendgrid-php.php");
// If not using Composer, uncomment the above line and
// download sendgrid-php.zip from the latest release here,
// replacing <PATH TO> with the path to the sendgrid-php.php file,
// which is included in the download:
// https://github.com/sendgrid/sendgrid-php/releases

// $apiKey = getenv('SENDGRID_API_KEY');
// $sg = new \SendGrid($apiKey);

// try {
//     $response = $sg->client->suppression()->bounces()->get();
//     print $response->statusCode() . "\n";
//     print_r($response->headers());
//     print $response->body() . "\n";
// } catch (Exception $e) {
//     echo 'Caught exception: '.  $e->getMessage(). "\n";
// }
 

 header('location: profile.php');  
  
   
  	}else {
  		array_push($errors, "Wrong username/password combination");
  	}
  }
  pg_close($db);
}



// if (isset($_POST['org_user'])) {
// $orgPassword='';
// if (isset($_POST['orgPassword'])) {
//   $orgPassword = pg_escape_string($db, $_POST['orgPassword']);
// }
//     $orgPassword = md5($orgPassword);

//   if (empty($orgPassword)) {

//     array_push($errors, "password is required");
//   }

//   if (count($errors) == 0) {
   
   
//     $query = "SELECT * FROM orguser WHERE password='$orgPassword'";
//     $result = pg_query($db, $query);
//  $orgUser = pg_fetch_assoc($result);
//     if (pg_num_rows($result) == 1) {

//       $_SESSION['success'] = "You are now logged in";
//       $_SESSION['email'] = $orgUser['email'];
//      header('location: org-account.php'); 
//     }else {
//       array_push($errors, "Wrong password combination");
//     }
//   }
//   pg_close($db);
// }
?>
 <!DOCTYPE html>
 <html>
 <head>
   <title></title>


     <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
 </head>
 <body  >
  
  </head>
  <body>
 

  <!--   <div id="lat_lng"></div> -->

    <script>

  // organization geocode data 
// function init2() {
//     $.ajax({
//         url: "https://maps.googleapis.com/maps/api/geocode/json?address=4057+woodlandcreek+dr&key=AIzaSyBidE-PE8nRTYLn-tqLiLipd86XT3yDoiY",
//         type: "GET",
//         dataType: "json",
//         async: false,
//         success: function (data) {
//             console.log(data);
//         }
//     });
// }
// init2();


// user device location with permission

// function init1() {
//     $.ajax({
//         url: "Access-Control-Allow-Origin:https://maps.googleapis.com/maps/api/js?key=AIzaSyBidE-PE8nRTYLn-tqLiLipd86XT3yDoiY&callback=initMap",
//         type: "GET",
//         dataType: "json",
//         async: false,
//         success: function (data) {
//             console.log(data);
//         }
//     });
// }
// init1();
 
    </script>
   
 
<!--  
    <p id="demo">demo </p>

   
  <script>
console.log("hello");


var x = document.getElementById("demo");

getLocation();
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    x.innerHTML = "Latitude: " + position.coords.latitude + 
    "<br>Longitude: " + position.coords.longitude;
}
</script> -->
 

 </body>
 </html>

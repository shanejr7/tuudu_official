<?php
 
// later add first and last name
session_start();
 include 'local_distance.php';

 require '../../vendor/autoload.php';

 use Mailgun\Mailgun;
 

 

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
$new_password_error = array(); 



// connect to the database
//$db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
$db = pg_connect(getenv("DATABASE_URL"));
 
   
// REGISTER USER or BUSINESS USER
if (isset($_POST['reg_user'])) {

  // receive all input values from the form
  $username = pg_escape_string($db, $_POST['username']);
  $email = pg_escape_string($db, $_POST['email']);
  $account = pg_escape_string($db, $_POST['account_type']);


     $timezone = pg_escape_string($db, $_POST['timezone']);
 
     $timezone = explode(" ", $timezone);
     $timezone_str =  date('Y-m-d',strtotime($timezone[1].' '.$timezone[2].' '.$timezone[3]));
     $timezone_str = $timezone_str .' '.$timezone[4];

     $zone = substr($timezone[6],1,1).''.substr($timezone[7],0,1).''.substr($timezone[8],0,1);

     date_default_timezone_set($zone);

     $O = explode("-", $timezone[5]);
 

     $timezone_str = $timezone_str.''.date("O", strtotime($O[1]));
 

  if (isset($_POST['age'])) {
     $age = pg_escape_string($db, $_POST['age']);
  }
   
  $password_1 = pg_escape_string($db, $_POST['password_1']);
  // $password_2 = pg_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if(sizeof($username)>26){array_push($errors, "Username is too long"); }
  if (!preg_match("/^[a-zA-Z] /",trim($username))==0) { array_push($errors, "Username is invalid"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (!filter_var($email,FILTER_VALIDATE_EMAIL)) { array_push($errors, "Email is invalid"); }
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
  $timestamp = $timezone_str;
  



    pg_query($db, "INSERT INTO public.users (id,username,email,password,age,publickey,hash,date_joined,recent_login_time,active_user,account_type) 
          VALUES($maxId,'$username','$email','$password','$age',' ', ' ','$timestamp','$timestamp',True,'$account')");


   $_SESSION['username'] = $username;
   $_SESSION['id'] = $maxId;
   $_SESSION['email'] = $email;
  
  
    
  $_SESSION['success'] = "You are now logged in";

  $mgClient = Mailgun::create('3c3cf6e0e1734cfbcd9fbf8f1fd6d011-e470a504-8d00075c'); // For US servers

  $domain = "sandboxfa5d66d41cd74a59bd70dc47dc88118e.mailgun.org";
 
  $result = $mgClient->messages()->send($domain, array(
  'from'  => 'contact@tuudu.org',
  'to'  => 'contact@tuudu.org',
  'subject' => 'Weclome!',
  'text'  => '<!DOCTYPE html>
<html style="font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Actionable emails e.g. reset password</title>


<style type="text/css">
img {
max-width: 100%;
}
body {
-webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em;
}
body {
background-color: #f6f6f6;
}
@media only screen and (max-width: 640px) {
  body {
    padding: 0 !important;
  }
  h1 {
    font-weight: 800 !important; margin: 20px 0 5px !important;
  }
  h2 {
    font-weight: 800 !important; margin: 20px 0 5px !important;
  }
  h3 {
    font-weight: 800 !important; margin: 20px 0 5px !important;
  }
  h4 {
    font-weight: 800 !important; margin: 20px 0 5px !important;
  }
  h1 {
    font-size: 22px !important;
  }
  h2 {
    font-size: 18px !important;
  }
  h3 {
    font-size: 16px !important;
  }
  .container {
    padding: 0 !important; width: 100% !important;
  }
  .content {
    padding: 0 !important;
  }
  .content-wrap {
    padding: 10px !important;
  }
  .invoice {
    width: 100% !important;
  }
}
</style>
</head>

<body itemscope itemtype="http://schema.org/EmailMessage" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

<table class="body-wrap" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6"><tr style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
    <td class="container" width="600" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
      <div class="content" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
        <table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope itemtype="http://schema.org/ConfirmAction" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff"><tr style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-wrap" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;" valign="top">
              <meta itemprop="name" content="Confirm Email" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;" /><table width="100%" cellpadding="0" cellspacing="0" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                   <h2>Hello,</h2><h2>we received your registration</h2> Please confirm your email address by clicking the link below.
                  </td>
                </tr><tr style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                    We may need to send you critical information about our service and it is important that we have an accurate email address.
                  </td>
                </tr><tr style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" itemprop="handler" itemscope itemtype="http://schema.org/HttpActionHandler" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                    <a href="http://www.tuudu.org" class="btn-primary" itemprop="url" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #348eda; margin: 0; border-color: #348eda; border-style: solid; border-width: 10px 20px;">Confirm email address</a>
                  </td>
                </tr><tr style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                    &mdash; from tuudu
                  </td>
                </tr></table></td>
          </tr></table><div class="footer" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
          <table width="100%" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="aligncenter content-block" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">Any questions? <a href="#" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">contact@tuudu.org</a> contact us.</td>
            </tr></table></div></div>
    </td>
    <td style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
  </tr></table></body>
</html>'
));

  if (strcmp(trim($account), "user")) {
     header('location: profile.php');  
  }else if (strcmp(trim($account), "BUSINESS")) {
     header('location: profile.php');
  }
  
  }
  pg_close($db);
}

 





if (isset($_POST['login_user'])) {

 

  $email = pg_escape_string($db, $_POST['email']);
  $password = pg_escape_string($db, $_POST['password']);
  $timezone = pg_escape_string($db, $_POST['timezone']);
  


  
    $timezone = explode(" ", $timezone);
    $timezone_str =  date('Y-m-d',strtotime($timezone[1].' '.$timezone[2].' '.$timezone[3]));
    $timezone_str = $timezone_str .' '.$timezone[4];

    $zone = substr($timezone[6],1,1).''.substr($timezone[7],0,1).''.substr($timezone[8],0,1);

    date_default_timezone_set($zone);

    $O = explode("-", $timezone[5]);
 

    $timezone_str = $timezone_str.''.date("O", strtotime($O[1]));


 
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
      $_SESSION['temp_pw'] = $users['temp_password'];
  	  $_SESSION['success'] = "You are now logged in";


      $id = $users['id'];
      $timestamp = $timezone_str;

     


    pg_query($db, "UPDATE public.users SET recent_login_time ='$timestamp', active_user=True WHERE id = $id");
 
 
 
 
 
 


header('location: profile.php');  
  
   
  	}else {
  		array_push($errors, "Wrong username/password combination");
  	}
  }
  pg_close($db);
}
 


 if (isset($_POST["email_recovery"])) {

    $user_email = pg_escape_string($db, $_POST['email_recovery']);

    $string = "";

    $result = pg_query($db, "SELECT * FROM users WHERE email='$user_email' LIMIT 1");
    $user = pg_fetch_assoc($result);
    
  if ($user) { // if user exists
 

    if (strcmp(trim($user['email']), trim($user_email)) == 0) {
       $timezone = pg_escape_string($db, $_POST['timezone']);
  


  
    $timezone = explode(" ", $timezone);
    $timezone_str =  date('Y-m-d',strtotime($timezone[1].' '.$timezone[2].' '.$timezone[3]));
    $timezone_str = $timezone_str .' '.$timezone[4];

    $zone = substr($timezone[6],1,1).''.substr($timezone[7],0,1).''.substr($timezone[8],0,1);

    date_default_timezone_set($zone);

    $O = explode("-", $timezone[5]);
 

    $timezone_str = $timezone_str.''.date("O", strtotime($O[1]));
     // send email to user and contact
      // send temporary password string to user email
      // set temporary password to user account
     $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
     $password_1 = ''; 
  
    for ($i = 0; $i < 10; $i++) { 
        $index = rand(0, strlen($characters) - 1); 
        $password_1 .= $characters[$index]; 
    } 

        $new_password = $password_1;
        $password = md5($password_1);//encrypt the password before saving in the database
    
echo $new_password;
    pg_query($db, "UPDATE public.users SET password='$password',temp_password=True, recent_login_time ='$timezone_str' WHERE email = '$user_email'");


  $string = "email sent";
 
  $mgClient = Mailgun::create('3c3cf6e0e1734cfbcd9fbf8f1fd6d011-e470a504-8d00075c'); // For US servers

  $domain = "sandboxfa5d66d41cd74a59bd70dc47dc88118e.mailgun.org";
 
  $result = $mgClient->messages()->send($domain, array(
  'from'  => 'contact@tuudu.org',
  'to'  => 'contact@tuudu.org',
  'subject' => 'user forgot password',
  'text'  => 'email sent requesting new password '.$new_password.' to '.$user_email.''
));
    
   
    }else{

        array_push($errors, "email doesn't exists");
 
    }
    
  }else{
     array_push($errors, "email doesn't exists");
  } 
  
 
   pg_close($db);
}

// after random passsword sent to email
  // user logs in and sets up new password

if (isset($_POST['reset_password'])) {
  
    $email = $_SESSION['email'];
    $password = pg_escape_string($db, $_POST['reset_password']);
    $timezone = pg_escape_string($db, $_POST['timezone']);
  

    if (empty($password)) {

    array_push($errors, "Password is required");
  }
  if (count($errors)==0) {
    
    $reset_password = md5($password);



    $timezone = explode(" ", $timezone);
    $timezone_str =  date('Y-m-d',strtotime($timezone[1].' '.$timezone[2].' '.$timezone[3]));
    $timezone_str = $timezone_str .' '.$timezone[4];

    $zone = substr($timezone[6],1,1).''.substr($timezone[7],0,1).''.substr($timezone[8],0,1);

    date_default_timezone_set($zone);

    $O = explode("-", $timezone[5]);
 

    $timezone_str = $timezone_str.''.date("O", strtotime($O[1]));


    pg_query($db, "UPDATE public.users SET password = '$reset_password', recent_login_time ='$timezone_str', active_user=True, temp_password =False WHERE email = '$email'");

       
        $_SESSION['temp_pw'] = False;
  }
  
  


   pg_close($db);
}
 

      
?>
 <!DOCTYPE html> 
 <html lang="en">
 <head>
   <title></title>
  
     <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
     <!--   <script src="../assets/js/custom_js.js"></script> -->
     <script src="https://browser.sentry-cdn.com/5.9.1/bundle.min.js" integrity="sha384-/x1aHz0nKRd6zVUazsV6CbQvjJvr6zQL2CHbQZf3yoLkezyEtZUpqUNnOLW9Nt3v" crossorigin="anonymous">
</script>
 </head>

<body>

<script type="text/javascript">Sentry.init({ dsn: 'https://3aef67b48f3f4fce8a6f199673e536b7@sentry.io/1840301' });
</script>
 
 

<?php 
 
 

// local location
 
// $dynamic_cordinates=array();
// $static_cordinates =array();
// $local_distance = array();
//   if (isset($_COOKIE["dynamic_location"])) {

//    $_SESSION["dynamic_location"] = $_COOKIE["dynamic_location"];
//  }else if (empty($_COOKIE['dynamic_location'])) {
//    // error
//   // echo 'Cookie does not exists or is empty';
// }


//  if (isset($_SESSION["dynamic_location"])) {
//    $dynamic_cordinates = explode("/",$_SESSION["dynamic_location"]);
//   // echo 'user location: '.$dynamic_cordinates[0].' '.$dynamic_cordinates[1];
//  }


//    if (isset($_COOKIE["static_location0"])) {

//    $_SESSION["static_location"] = $_COOKIE["static_location0"];
    
//  }else if (empty($_COOKIE['static_location'])) {
//    // error
//   // echo 'Cookie does not exists or is empty';
// }


//  if (isset($_SESSION["static_location"])) {
//    $static_cordinates = explode("/",$_SESSION["static_location"]);
//   // echo 'organization location: '.$static_cordinates[0].' '.$static_cordinates[1];
//   for ($i=0; $i <$static_cordinates[2] ; $i++) { 

 
//      $static_cordinates = explode("/",$_COOKIE["static_location".$i]);
    
//      $bool = getDistance($dynamic_cordinates,$static_cordinates);
     
//      if ($bool ==="yes") {
//         // echo "string " .$static_cordinates[3];
//         //  echo 'local = '.$bool;
//        array_push($local_distance,trim($static_cordinates[3]));
//      }

//   }
    
//  }

 

 ?>
 
 

 </body>
 </html>

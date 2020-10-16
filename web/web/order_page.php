<?php   
/*order page */

/* DOCS

  * 
  *
  
*/

include('feed_state.php');
include('add_cart.php');
include('favorite.php');

// require('../aws/aws-autoloader.php');
require('../aws/Aws/S3/S3Client.php'); 
require('../aws/Aws/S3/ObjectUploader.php'); 

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\ObjectUploader;

$s3=" ";
$s3 = new Aws\S3\S3Client([
    'version'  => 'latest',
     'region'   => 'us-east-2',
]);

$bucket = getenv('S3_BUCKET')?: header('location:oops.php');
$bucket_name = 'tuudu-official-file-storage';



  if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    unset($_SESSION['id']);
    unset($_SESSION['email']);
    header("location: login-page.php");
  }

if ((isset($_SESSION['id']) && isset($_GET['order'])) || (isset($_SESSION['guestID']) && isset($_GET['order']))) {
 
 
     // connect to DataBase
     $conn = pg_connect(getenv("DATABASE_URL"));

     // Check connection
     if (!$conn) {
        die("Connection failed: " . pg_connect_error());
        header('location:oops.php');
      }

     $user_I_D =0;

     if (isset($_SESSION['id'])) {
       $user_I_D = $_SESSION['id'];
     }elseif (isset($_SESSION['guestID'])) {
       $user_I_D = $_SESSION['guestID'];
     }

     $organization_publickey = pg_escape_string($conn,$_GET['order']);

     
    $order_list = array();

    /* 
     * 
     * 
    */

    $result = pg_query($conn,"SELECT DISTINCT organization.date, organization.time, organization.fiatvalue,organization.img, organization.id as org_id, organization.description,organization.views, organization.title,organization.organization_name as org_name, organization.date,  organization.address, organization.word_tag,organization.publickey, organization.privatekey,organization.url, organization.email, organization.amount
     FROM organization WHERE publickey = '$organization_publickey' LIMIT 1");

    // loops through rows until there is 0 rows
    if (pg_num_rows($result) > 0) {
         // output data of each row
        while($row = pg_fetch_assoc($result)) {
      
             $order_list[] = array("date" => $row["date"], "time" => $row["time"], "price"=> $row["fiatvalue"], "img" => $row["img"],"org_id" => $row["org_id"],"description" => $row["description"],"views" => $row["views"], "title" => $row["title"],"name" => $row["org_name"],"address" => $row["address"],"type" => $row["word_tag"], "publickey" => $row['publickey'],"privatekey"=>$row["privatekey"],"url"=>$row["url"], "email" => $row["email"],"amount" => $row["amount"]);
        }

    //increment view to organization event
     
        $org_id = $order_list[0]['org_id'];

        $result = pg_query($conn, "SELECT id, word_tag, title, description, content FROM organization WHERE publickey = '$organization_publickey' LIMIT 1");
      $organization = pg_fetch_assoc($result);
      $org_id = $organization["id"];

       // add clicked view to organization
       pg_query($conn, "UPDATE public.organization SET views = views + 1 WHERE publickey = '$organization_publickey' 
        AND id=$org_id");


       // add view to word_tag

                  $splitFileString = strtok(trim($organization['word_tag']), '_' );
                  $splitFileString = strtolower($splitFileString);

                   pg_query($conn, "UPDATE public.word_tag SET views = views + 1 WHERE event_type = '$splitFileString'");

      // add view to itag
                  $splitFileString = " ";
                  $splitFileString = strtok(trim($organization['word_tag']), '/' );
                  $splitFileString = strtok("/");
 
 
                  while ($splitFileString !== false)
                    {

                      pg_query($conn, "UPDATE public.itag_rank SET views = views + 1 WHERE itag = '$splitFileString'");

                      $splitFileString = strtok("/");
                    }


    } else {header('location:oops.php'); }

pg_close($conn);
 
}

 



  if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    unset($_SESSION['id']);
    unset($_SESSION['email']);
    header("location: login-page.php");
  }
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    order page
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
   <link href="../assets/css/material-kit.css?v=2.2.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />
  <link href="../assets/demo/vertical-nav.css" rel="stylesheet" />
  <!-- custom css -->
  <link href="../assets/css/core.css" rel="stylesheet" />

   <script src="../assets/js/local.js"></script>
 
 


 
</head>

<body class="profile-page  sidebar-collapse">
 
<nav class="navbar navbar-expand-lg bg-primary cd-section" id="nav">
    <div class="container">
 


      
          <div class="navbar-translate col-lg-4">

           
            <a class="navbar-brand" href="order_page.php">  <img src="../assets/img/logo.png" style="width: 30%; "></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
            </button>
        </div>
                <div class="col-lg-8 collapse navbar-collapse" id="sectionsNav">
            <ul class="navbar-nav">
              <?php

                  if (isset($_SESSION['username'])) {
                      
                    $number =1;

                    echo ' <li class="nav-item">
                   <a href="home.php" class="nav-link"><i class="material-icons">home</i></a>
                </li>
                <li class="nav-item ">
                     <a href="dashboard.php" class="nav-link">Dashboard</a> 
                </li>
                 <li class="nav-item ">
                     <a href="profile.php" class="nav-link">Profile</a> 
                </li>
                     <li class="nav-item">
                     <a href="dashboard.php?logout='.$number.'" onclick="revokeAllScopes()" class="nav-link">logoff</a> 
                      <script type="text/javascript">
                      var revokeAllScopes = function() {
                         auth2.disconnect();
                      }
                     </script>
                </li>';

                  }else{

                    echo ' <li class="nav-item">
                   <a href="home.php" class="nav-link"><i class="material-icons">home</i></a>
                </li>
                <li class="nav-item">
                    <a href="login-page.php" class="nav-link">Login</a>
                </li>
                <li class="nav-item">
                    <a href="signup-page.php" class="nav-link">Signup</a>
                </li>';
                  }


              ?>

            </ul>

        </div>

       
           
    </div>
 
</nav>

 
    <!-- class"main main-rasied" -->
     <div id="main">

    <div class="profile-content ">
      <div class="container">
    
      
        <div class="container">
       <div class="row"> 
<div class="col-md-4"></div>
      

          <?php   
 

                    if(isset($order_list) && !isset($_POST["schedule"])){


                    echo'<div class="post_chat" data-key="'.$order_list[0]['publickey'].'" data-id="'.$order_list[0]['org_id'].'"></div>';

                      $string = $order_list[0]["type"];
                      $string = strtolower($string);
                      $token = strtok($string, "_");

                      $amount = intval($order_list[0]["amount"]);

                      if (strcmp(trim($order_list[0]["amount"]), 'unlimited') == 0 || $amount >0) {
                        
                    

                      $ticket_name = explode("_", $order_list[0]["type"]);
                      $ticket_date = explode(" ", $order_list[0]["date"]);
                      $ticket_time = explode("-", $order_list[0]["time"]);

                      echo '<div class="col-md-8"><h2 class="title"> ';

                      echo strtoupper($order_list[0]["title"]).'\'S PAGE <h15 style="color: #0000FF"><a href="'.trim($order_list[0]["url"]).'">web link <i class="material-icons">info</i></a></h15></h2>';
                      echo '</div>';



                      echo '<div class="col-md-4">';

                       echo '<div class="contain">';




                           $cmd = $s3->getCommand('GetObject', [
                            'Bucket' => ''.$bucket_name.'',
                            'Key'    => ''.trim($order_list[0]["img"]).'',
                          ]);

                           $request = $s3->createPresignedRequest($cmd, '+20 minutes');

                           $presignedUrl = (string)$request->getUri();

                            $splitFileString = strtok(trim($order_list[0]["img"]), '.' );
                $fileChecker = strtok('');
                $fileChecker = strtoupper($fileChecker);

 

          if($presignedUrl && strlen(trim($order_list[0]["img"]))>10 && ($fileChecker=='JPG' || $fileChecker=='JPEG' || $fileChecker=='PNG' || $fileChecker=='MOV')){
                 echo  '<img src="'.$presignedUrl.'" class="img rounded" style="width:200px">'; 
              }else{
                 echo  '<img src="../assets/img/image_placeholder.jpg" class="img rounded" style="width:200px">';
              } 
 
              
                

                //  if (trim($order_list[0]['price']) =='0.00' || $order_list[0]["price"]==NULL || $order_list[0]["price"]==" ") {

                     //   echo '<div class="top-right h9"> 
                     //   <a href="'.$order_list[0]['url'].'"><i class="material-icons">strikethrough_s</i></a></div>';

                      //  }else{

                  //echo '<a href="#"><div class="top-right h6">$'.trim($order_list[0]['price']).'</a></div>';
                  
                 // }


                 // echo '<div class="top-left h6" style="width:10px;">'
                    //   .toString($order_list[0]['date']).'</div>';

                //  echo '<div class="centeredm h4">'.trim($order_list[0]['description']).'</div>';

                 // if (isset($_SESSION['id'])) {
                    
                  
                 // echo '<div class="bottom-left" style="font-weight: bolder;">
                     //   <a href="profile.php?publickey='.$order_list[0]['publickey'].'">';

                     //   if ($order_list[0]['favorite']==1) {
                       //   echo '<i class="material-icons" style="color:red;font-size:18pt;">favorite</i></a></div>';

                       // }else{

                        //  echo '<i class="material-icons" style="font-size:18pt;">favorite</i></a></div>';
                       // }

                     

                  // echo '<div class="centered" style="font-weight: bolder;">
                  // <a href="#fav"><i class="material-icons" style="font-size:18pt">favorite_border</i></a></div>';

                 
                  //echo '<div class="bottom-right" style="font-weight: bolder;">
                      //   <a href="#" class="post_chat" data-key="'.$order_list[0]['publickey'].'" data-id="'.$order_list[0]['org_id'].'" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="material-icons" style="font-size:18pt;">chat_bubble_outline</i></a></div>';


                  //  }



                        echo'</div>';

                           

                      echo'</div>';

                      if (isset($token) && $token =='product') {
                         //echo '<div class="col-md-8 title"></div>';
                      }else{
                          // if product,rental, certain activites dont show date
                      echo '<div class="col-md-8 title">'.date("d-m-Y",strtotime($ticket_date[0])).' | '.date('h:i A', strtotime($ticket_time[0])).'-'.date('h:i A', strtotime($ticket_time[1])).'</div>';  
                      }

                    

                      // if free dont show payment button
                      echo '<div class="description col-md-3">';

                         
          

if (isset($order_list[0]["price"]) && trim($order_list[0]["price"]) ==trim("0.00")) {
                // echo ' <div class="form-group">
                //  <label  style="color: black; font-weight: bold;">price $'.$order_list[0]["price"].'</label>
                //  <input type="hidden" name="price" value="'. $order_list[0]["price"].'">
                // </br></br></br>
                // <button type="submit" class="btn btn-warning  radius-50 btn-sm" value="free" name="free_event">submit</button>';
}else if(isset($order_list[0]["price"])){

                echo '
                <form method="POST" action="order_page.php">
        
                   <input type="hidden" name="schedule" value="schedule">
                   <input type="hidden" name="timezone" value="" id="timezone">
                   <input type="hidden" name="publickey" value="'.$order_list[0]["publickey"].'">
                   <input type="hidden" name="privatekey" value="'.$order_list[0]["privatekey"].'">
                   <input type="hidden" name="org_id" value="'.$order_list[0]["org_id"].'">
                   <input type="hidden" name="price" value="'.$order_list[0]["price"].'">
                    <input type="hidden" name="email" value="'.$order_list[0]["email"].'">
                   <input type="hidden" name="eventTitle" value="'.$order_list[0]["title"].'">
                   <h6>'.$order_list[0]["title"].'</h6>
                   <br>
                   <div class="form-group">
                   <label for="exampleFormControlSelect1">select amount.</label>
                   <select class="form-control select picker" data-style="btn btn-link" id="exampleFormControlSelect1" name="ticket_amount">
                   <option>1</option>
                   <option>2</option>
                   <option>3</option>
                   <option>4</option>
                   <option>5</option>
                   </select>
                   </div>';

                echo ' <div class="form-group">
                <label  style="color: black; font-weight: bold;">price $'.$order_list[0]["price"].'</label>
                <input type="hidden" name="add_cart" value="cart">
                <input type="hidden" name="price" value="'. $order_list[0]["price"].'"></br></br></br> <button type="submit" class="btn btn-warning  radius-50 btn-sm" value="payment" name="paid_event">submit</button> ';

                echo '</div></form>';
  }

    //add messenger comment on right md4 


       echo '</div>';


                      



        echo '<div class="col-md-5">';

       

        echo '  <div class="modal-dialog modal-lg">
     <div class="modal-content">
       
    <h3 class="title text-center" style="margin-bottom: 0;padding-bottom: 0 ">Comments</h3>
    <!-- <span class="badge badge-default">3</span> -->
    <!-- <div class="blog-tags title text-center" style="margin-top: 0;padding-top: 0 ">
                  Tags:
                  <span class="badge badge-primary badge-pill">Photography</span>
                  <span class="badge badge-primary badge-pill">Stories</span>
                  <span class="badge badge-primary badge-pill">Castle</span>
    </div> -->
      
      <div class="section section-blog-info" style="margin: 0 0 0 0; padding: 0 0 0 0;">
        <div class="row">
          <div class="col-md-8 ml-auto mr-auto">
            <hr>
            <div class="card card-profile card-plain">
              <div class="row" id="user_post">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="section section-comments" style="display: flex;justify-content: space-around;align-items: flex-start;">
        <div class="row">
          <div class="col-md-12 ml-auto mr-auto" >
            <div class="media-area" id="users_post">
            </div>
       
           
            <div style="position: -webkit-sticky;position: sticky;bottom: 1px;align-self: flex-end;background-color: white">

                <div id="comment_post" >


                </div>

          </div>
          </div>
        </div>
      </div>
    </div>
    </div>';

        echo '</div>';

  }else{

                      $ticket_name = explode("_", $order_list[0]["type"]);
                      $ticket_date = explode(" ", $order_list[0]["date"]);
                      $ticket_time = explode("-", $order_list[0]["time"]);

                      echo '<div class="col-md-8"><h2 class="title"> ';

                      echo strtoupper($order_list[0]["title"]).'\'S PAGE</h2>';
                      echo '</div>';


                      echo '<div class="col-md-4"></div>';

                       if (isset($token) && $token =='product') {
                        echo '<div class="col-md-8 title"></div>';
                      }else{
                          // if product,rental, certain activites dont show date
                       echo '<div class="col-md-8 title">'.date("d-m-Y",strtotime($ticket_date[0])).' | '.date('h:i A', strtotime($ticket_time[0])).'-'.date('h:i A', strtotime($ticket_time[1])).'</div>'; 
                      }

                      
                       echo '<div class="col-md-4"></div>';
                      echo '<div class="col-md-8"><h2>sold out</h2></div>';

  }
           }
        ?>
 


<?php /*adds to schedule
  *
  *
  *
  */

 if ((isset($_SESSION['id']) || isset($_SESSION['guestID'])) && isset($_POST['schedule']) && isset($_POST["paid_event"]) ) {

   $db = pg_connect(getenv("DATABASE_URL"));
   // Check connection
    if (!$db) {
         die("Connection failed: " . pg_connect_error());
         header('location:oops.php');
    }

   $id =0;

   if (isset($_SESSION['id'])) {
       $id = pg_escape_string($db, $_SESSION['id']);
     }elseif (isset($_SESSION['guestID'])) {
       $id = pg_escape_string($db, $_SESSION['guestID']);
     }
   
   $organization_publickey = trim(pg_escape_string($db, $_POST['publickey']));
   $organization_privatekey_paypal = trim(pg_escape_string($db, $_POST['privatekey']));
   $organization_email = trim(pg_escape_string($db, $_POST['email']));
   $org_id = pg_escape_string($db, $_POST['org_id']);
   $ticket_amt = pg_escape_string($db, $_POST['ticket_amount']);
   $title = pg_escape_string($db, $_POST['eventTitle']);
   $price = doubleval(pg_escape_string($db, $_POST['price']));
   $price = $price * $ticket_amt;
   $tax = doubleval(pg_escape_string($db,0.06));
   $total =0;
   if ($price>=1) {
    $tax = $tax * $price;
   }else{
    $tax = 0;
   }
    
    $total = $price + $tax;

    $total = number_format($total,2);


 pg_close($db);
 

 echo '<div class="col-md-12"> </div>
        <div class="col-md-4"> </div> <div class="col-md-8">  <h2 class="title"> ready to checkout</h2></div>
 
         <div class="col-md-4"> </div> <div class="col-md-4">
        
             <div class="table-responsive">
            <table class="table table-shopping">
              <thead>
                <tr>
                  <th class="text-center"></th>
                  <th>Product</th>
                  <th class="text-right">Price + tax</th>
                  <th class="text-right">Qty</th>
                   
                
                </tr>
              </thead>
              <tbody>
                <tr>
                <td class="text-center"></td>
                <td>
                   <h10 class="title">'.$title.'</h10>
                </td>

                   <td>
                   <h4 class="title text-right">$'.$total.'</h4>
                </td>
                <td>
                   <h4 class="title text-right">'.$ticket_amt.'</h4>
                </td>
 
             </tr>
          
                </table>
                </div>
       
        </div>';

          


            echo ' <div class="col-md-4"></div><div class="col-md-4"></div><div class="col-md-3"><div id="paypal-button-container"></div></div>

<script src="https://www.paypal.com/sdk/js?client-id='.$organization_privatekey_paypal.'&currency=USD" data-sdk-integration-source="button-factory">
</script>

<script>
    paypal.Buttons({
        style: {
            shape: "rect",
            color: "gold",
            layout: "horizontal",
            label: "paypal",
            
        },
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                  "description": "'.trim($title).'",
                    amount: {
                        "currency_code": "USD",
                        value: "'.$total.'",
                        quantity:"'.$ticket_amt.'",
                        
                    },
                   
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                  window.location.replace("add_cart.php?purchased='.$id.'");
                  
            });
        }
    }).render("#paypal-button-container");
</script>';

 
echo "</br></br> </br></br></br></br>
"; 

 }?>  

       </div>
             
          </div>
        </div>
      </div>
 
  </div>
 </br>
</br>
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Policy for payments</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
by accepting this agreement and terms with using our services. you agree that all transactions and events are affiliated to independent third party organizations in which our services only provides data without any association or having liability with third-party organizations. accepting these terms and payment services you agree with our policy. refunds may not be requested after purchases, unless items are found not to be authentic. If you do not agree with our terms and policy, then do not make any purchases.
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button> -->
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
  <footer class="footer footer-default cd-section" id="footer">
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
          <li>
           <a href="https://www.Aeravi.io">
              Licenses
            </a>
          </li>
            <li>
           <a href="#" data-toggle="modal" data-target="#exampleModal">
            Terms
            </a>
          </li>
        </ul>
      </nav>
      <div class="copyright float-right">
        &copy;
        <script>
          document.write(new Date().getFullYear())
        </script> created by 
        <a href="https://www.aeravi.io" target="_blank">Aeravi</a>.
      </div>
    </div>
  </footer>
  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script> 


$(document).ready(function() {


  $(document).on('click', '.unfollow_user_follow_btn', function () {

var key=$(this).data("key");
var id=$(this).data("userid");

unfollow_button(id,key);


 function unfollow_button(id,publickey)
 {
  

            $.ajax({
   url:"unfollow_user_follow.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){

       $.ajax({
   url:"fetch_user_connection_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#connection_follow_tab').html(data);
   
     
   }
  })

    $('#following').html(data);
   
             $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })


       $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
   
     
   }
  })

 }

 


    });

  $(document).on('click', '.unfollow_user_btn', function () {

var key=$(this).data("key");
var id=$(this).data("userid");

unfollow_button(id,key);


 function unfollow_button(id,publickey)
 {
  

            $.ajax({
   url:"unfollow_user.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){

       $.ajax({
   url:"fetch_user_connection_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#connection_follow_tab').html(data);
   
     
   }
  })

    $('#following').html(data);
   
             $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })


       $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
   
     
   }
  })

 }

 


    });

    $(document).on('click', '.post_unsubscribe', function () {

var key=$(this).data("publickey");
var id=$(this).data("id");
var pid=$(this).data("pid");


unfollow(pid,id,key);


 function unfollow(pid,id,publickey)
 {


    $.ajax({
   url:"subscription.php",
   method:"POST",
   data : {
        publickey : publickey,
        unsubscribe : publickey 
                    },
   success:function(data){

  
      $.ajax({
   url:"fetch_user_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : pid 
                    },
   success:function(data){
    $('#user_post').html(data);


        $.ajax({
   url:"fetch_users_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : pid 
                    },
   success:function(data){
    $('#users_post').html(data);



   }
  })
     
   }
  })
   
   }
  })
      $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);

      $.ajax({
   url:"fetch_user_connection_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#connection_follow_tab').html(data);

      $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
     
   }
  })
     
   }
  })

 }


    });

  $(document).on('click', '.post_subscribe', function () {

var key=$(this).data("publickey");
var id=$(this).data("id");
var pid=$(this).data("pid");


follow(pid,id,key);


 function follow(pid,id,publickey)
 {


    $.ajax({
   url:"subscription.php",
   method:"POST",
   data : {
        publickey : publickey,
        subscribe : publickey 
                    },
   success:function(data){
 

      $.ajax({
   url:"fetch_user_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : pid 
                    },
   success:function(data){
    $('#user_post').html(data);


        $.ajax({
   url:"fetch_users_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : pid 
                    },
   success:function(data){
    $('#users_post').html(data);



   }
  })
     
   }
  })
   
   }
  })
      $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);

      $.ajax({
   url:"fetch_user_connection_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#connection_follow_tab').html(data);

      $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
     
   }
  })
     
   }
  })

 }


    });

  $(document).on('click', '.post_unfollow_user', function () {

var key=$(this).data("publickey");
var id=$(this).data("id");


unfollow(id,key);


 function unfollow(id,publickey)
 {


    $.ajax({
   url:"unfollow_user.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){

      $('#following').html(data);


      $.ajax({
   url:"fetch_user_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#user_post').html(data);


        $.ajax({
   url:"fetch_users_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#users_post').html(data);
   }
  })
     
   }
  })



      $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);

      $.ajax({
   url:"fetch_user_connection_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#connection_follow_tab').html(data);

      $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
     
   }
  })
     
   }
  })


     



   
   }
  })


 }


    });


$(document).on('click', '.post_follow_user', function () {

var key=$(this).data("publickey");
var id=$(this).data("id");


follow(id,key);


 function follow(id,publickey)
 {


    $.ajax({
   url:"follow_user.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
   
    $('#following').html(data);

    $.ajax({
   url:"fetch_user_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#user_post').html(data);
     
   }
  })


    $.ajax({
   url:"fetch_users_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#users_post').html(data);
   }
  })



 
      $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){

    $('#profile_tab_data').html(data);
         $.ajax({
   url:"fetch_user_connection_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#connection_follow_tab').html(data);

          $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
     
   }
  })
     
   }
  })



  


   }
  })



 




 }


    });

$(document).on('click', '.remove_comment', function () {

    var key=$(this).data("key");
    var id=$(this).data("id");
    var uid=$(this).data("userid");
    var time=$(this).data("time");
     

  remove_post(uid,id,key,time);




 function remove_post(uid,id,publickey,time)
 {

        $.ajax({
   url:"remove_user_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid,
        time : time 
                    },
   success:function(data){

  $.ajax({
   url:"fetch_users_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#users_post').html(data);
   }
  })


    $.ajax({
   url:"fetch_user_comment_form.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id ,
        uid : uid
                    },
   success:function(data){
    $('#comment_post').html(data);
   }
  })

   }
  })


       $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
    
            $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#followers').html(data);
            $.ajax({
   url:"fetch_user_following.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })
   }
  })
   

 

 }

 


    });






$(document).on('click', '.edit_comment', function () {

    var key=$(this).data("key");
    var uid=$(this).data("userid");
    var id=$(this).data("id");
    var time=$(this).data("time");
    var username=$(this).data("username");
    var replyid=$(this).data("replyid");
    var post=$("#postText").val();




edit_comment(uid,id,key,time,username,replyid,post);


 function edit_comment(uid,id,publickey,time,username,replyid,post)
 {





  $.ajax({
   url:"user_post_comment.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid,
        post : post,
        username : username,
        time : time,
        username : username,
        replyid : replyid,
        post : post
                    },
   success:function(data){
    $('#cleanPost').html(data);


        $.ajax({
   url:"fetch_users_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id
                    },
   success:function(data){
    $('#users_post').html(data);
   }
  })




    $.ajax({
   url:"fetch_user_comment_form.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id ,
        uid : uid
                    },
   success:function(data){
    $('#comment_post').html(data);
   }
  })


       $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
             $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#followers').html(data);
            $.ajax({
   url:"fetch_user_following.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })
     
   }
  }) 
   
   }
  })


 

 }
 


    });


$(document).on('click', '.back_post', function () {

var key=$(this).data("key");
var id=$(this).data("id");
var uid=$(this).data("uid");



back_post(uid,id,key);


 function back_post(uid,id,publickey)
 {


    $.ajax({
   url:"fetch_user_comment_form.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id,
        uid : uid 
                    },
   success:function(data){
    $('#comment_post').html(data);
   }
  })


          $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
    
              $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#followers').html(data);
            $.ajax({
   url:"fetch_user_following.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })
   }
  })

 }


    });

$(document).on('click', '.reply_comment', function () {

var key=$(this).data("key");
var id=$(this).data("userid");



reply_post(id,key);


 function reply_post(id,publickey)
 {


    $.ajax({
   url:"fetch_user_comment_form.php",
   method:"POST",
   data : {
        publickey : publickey,
        replyid : id,
        id : id 
                    },
   success:function(data){
    $('#comment_post').html(data);
   }
  })

 }

       $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
             $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
            $.ajax({
   url:"fetch_user_following.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })
     
   }
  })


    });


  $(document).on('click', '.edit_post', function () {
         


          var key=$(this).data("key");
          var id=$(this).data("id");
          var uid=$(this).data("uid");
          var username=$(this).data("username");
          var post=$(this).data("message");
          var time=$(this).data("time");


          edit_post(uid,id,key,post,username,time);

           function edit_post(uid,id,publickey,post,username,time){

           


                  $.ajax({
                        url:"fetch_user_comment_form.php",
                        method:"POST",
                        data : {
                        publickey : publickey,
                        id : id,
                        uid : uid,
                        time : time,
                        username : username,
                        message : post
                    },
                        success:function(data){
                         $('#comment_post').html(data);
                          }
                   })


                        $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
    
              $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#followers').html(data);
            $.ajax({
   url:"fetch_user_following.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : uid 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })
   }
  })


           }
        

    });




    $(document).on('click', '.favPost', function () {
         


          var key=$(this).data("key");
          var id=$(this).data("userid");
          var username=$(this).data("username");
          var time=$(this).data("time");
          

          fav_post(id,key,username,time);

           function fav_post(id,publickey,username,time){


                  $.ajax({
                        url:"fav_message.php",
                        method:"POST",
                        data : {
                        publickey : publickey,
                        id : id,
                        time : time,
                        username : username
                    },
                        success:function(data){
                             

                           $.ajax({
     url:"fetch_users_post.php",
      method:"POST",
        data : {
        publickey : publickey,
        id : id 
        },
       success:function(data){
        $('#users_post').html(data);
         }
    })
      $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
             $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
            $.ajax({
   url:"fetch_user_following.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })
     
   }
  })


                          }
                   })


 
           }
        

    });

     $(document).on('click', '.post_comment', function () {

 

var key=$(this).data("key");
var id=$(this).data("userid");
var pid =$(this).data("id");
var username=$(this).data("username");
var replyid=$(this).data("replyid");
var post=$("#postText").val();

 
user_post(pid,id,key,post,username,replyid);


 function user_post(pid,id,publickey,post,username,replyid)
 {
 
 
  $.ajax({
   url:"user_post_comment.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id,
        post : post,
        username : username,
        replyid : replyid 
                    },
   success:function(data){

    $('#cleanPost').html(data);

        $.ajax({
   url:"fetch_users_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : pid 
                    },
   success:function(data){
    $('#users_post').html(data);
   }
  })

          $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
             $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
            $.ajax({
   url:"fetch_user_following.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })
     
   }
  })
   
   }
  })


 



 }

});

$(document).ready(function () {

 
var key=$(".post_chat").data("key");
var id=$(".post_chat").data("id");

 
fetch_user(id,key);


 function fetch_user(id,publickey)
 {

 
 
  $.ajax({
   url:"fetch_user_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#user_post').html(data);
     
   }
  })


    $.ajax({
   url:"fetch_users_post.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#users_post').html(data);
        $.ajax({
   url:"fetch_user_comment_form.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#comment_post').html(data);
   }
  })
   }
  })



          $.ajax({
   url:"fetch_user_profile_tab.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#profile_tab_data').html(data);
    
              $.ajax({
   url:"fetch_user_followers.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
            $.ajax({
   url:"fetch_user_following.php",
   method:"POST",
   data : {
        publickey : publickey,
        id : id 
                    },
   success:function(data){
    $('#followers').html(data);
     
   }
  })
   }
  })
   }
  })

 }

});


   });
 
</script>
  <!--   Core JS Files   -->
 
  <script src="../assets/js/core/jquery.min.js" type="text/javascript"></script>
  <script src="../assets/js/core/popper.min.js" type="text/javascript"></script>
  <script src="../assets/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
  <script src="../assets/js/plugins/moment.min.js"></script>
  <!--	Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker -->
  <script src="../assets/js/plugins/bootstrap-datetimepicker.js" type="text/javascript"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="../assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
  <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
  <script src="../assets/js/plugins/bootstrap-tagsinput.js"></script>
  <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
  <script src="../assets/js/plugins/bootstrap-selectpicker.js" type="text/javascript"></script>
  <!--	Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
  <script src="../assets/js/plugins/jasny-bootstrap.min.js" type="text/javascript"></script>
  <!--	Plugin for Small Gallery in Product Page -->
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
    <script type="text/javascript">
    $(document).ready(function() {
      materialKitDemo.presentationAnimations();
    });
  </script>

</body>

</html>
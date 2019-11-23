<?php   
/*order page */
include('feed_state.php');

 
  if (!isset($_SESSION['username'])) {
   $_SESSION['msg'] = "You must log in first";
   header('location: login-page.php');
  }

  if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    unset($_SESSION['id']);
    unset($_SESSION['email']);
    header("location: login-page.php");
  }

if (isset($_SESSION['id']) && isset($_GET['order'])) {
 
 
     // connect to DataBase
    //$conn = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
    $conn = pg_connect(getenv("DATABASE_URL"));
     $user_I_D =  pg_escape_string($conn, $_SESSION['id']);
     $organization_publickey = pg_escape_string($conn,$_GET['order']);

    // Check connection
    if ($res1 = pg_get_result($conn)) {
    die("Connection failed: " .  pg_result_error($res1) );
    }

    // 
    $order_list = array();

    /* 
     * 
     * 
    */

    $result = pg_query($conn,"SELECT DISTINCT organization.date, organization.time, organization.fiatvalue,organization.img, organization.id as org_id, organization.description,organization.views, organization.title,organization.organization_name as org_name, organization.date,  organization.address, organization.word_tag,organization.publickey, organization.privatekey
     FROM organization WHERE publickey = '$organization_publickey' LIMIT 1");

    // loops through rows until there is 0 rows
    if (pg_num_rows($result) > 0) {
         // output data of each row
        while($row = pg_fetch_assoc($result)) {
      
             $order_list[] = array("date" => $row["date"], "time" => $row["time"], "price"=> $row["fiatvalue"], "img" => $row["img"],"org_id" => $row["org_id"],"description" => $row["description"],"views" => $row["views"], "title" => $row["title"],"name" => $row["org_name"],"address" => $row["address"],"type" => $row["word_tag"], "publickey" => $row['publickey'],"privatekey"=>$row["privatekey"]);
        }
         
    } else { }

pg_close($conn);
 
}
 

 

  if (!isset($_SESSION['username'])) {
   $_SESSION['msg'] = "You must log in first";
   header('location: login-page.php');
  }

  if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    unset($_SESSION['id']);
    unset($_SESSION['email']);
    header("location: login-page.php");
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
    order page
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
  <!-- custom css -->
  <link href="../assets/css/core.css" rel="stylesheet" />
 
<!-- organization paypal_ID / public_key -->
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>


 
</head>

<body class="profile-page  sidebar-collapse">
 
<nav class="navbar navbar-expand-lg bg-primary cd-section" id="nav">
    <div class="container">
 <!-- 
     <button class="btn btn-round" data-toggle="modal" data-target="#loginModal">
    Profile<i class="material-icons">assignment</i>

</button>
 -->
<div class="modal fade" id="loginModal" tabindex="-1" role="">
    <div class="modal-dialog modal-login" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                  <div class="card-header card-header-primary text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                      <i class="material-icons">clear</i>
                    </button>

                    <h4 class="card-title">Account</h4>
                    <div class="social-line">
                    <div class="media row">

                    <?php
                   // img uploader
                     ?>
                   
                    <div class="media-body col-md-7">
              
                   
                    </div>
                  </div>
                     <h7>&#xB7; <?php echo $_SESSION['email']?></h7>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                </br>
              
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="#" class="btn btn-primary btn-link btn-wd btn-lg">Contact support</a>
                </div>
                 <div class="modal-footer justify-content-center">
                    <p>contact@aeravi.io</p>
                </div> 
            </div>
        </div>
    </div>
</div>

        <div class="navbar-translate ">
            <a class="navbar-brand" data-toggle="modal" data-target="#loginModal" href="#"> Profile<i class="material-icons">sort</i></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
            </button>
        </div>
                <div class="collapse navbar-collapse" id="sectionsNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                     <a href="profile.php?logout='1'" class="nav-link">logoff</a> 
                </li>
                <li class="nav-item ">
                     <a href="profile.php" class="nav-link">Dashboard</a> 
                </li>
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
       	<h2 class="title">     
<?php /*adds to schedule
  *
  *
  *
  */

 if (isset($_SESSION['id']) && isset($_POST['schedule']) && isset($_POST["paid_event"]) ) {

   //$db = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
   $db = pg_connect(getenv("DATABASE_URL"));
   $id = pg_escape_string($db, $_SESSION['id']);
   $organization_publickey = trim(pg_escape_string($db, $_POST['publickey']));
   $organization_privatekey_paypal = trim(pg_escape_string($db, $_POST['privatekey']));
   $org_id = pg_escape_string($db, $_POST['org_id']);
   $ticket_amt = pg_escape_string($db, $_POST['ticket_amount']);
   $title = pg_escape_string($db, $_POST['eventTitle']);
   $price = doubleval(pg_escape_string($db, $_POST['price']));
   $price = $price * $ticket_amt;


   $query = "INSERT INTO temporary_tag_schedule (user_id, org_id,publickey,ticket_amount) 
          VALUES($id,$org_id,'$organization_publickey',$ticket_amt)";

   pg_query($db, $query);
   

   pg_close($db);


 echo '<div class=col-md-12>
            <h2 class="title"> ready to checkout</h2>
          <div class="table-responsive">
            <table class="table table-shopping">
              <thead>
                <tr>
                  <th class="text-center"></th>
                  <th>Product</th>
                  <th class="text-right">Price</th>
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
                   <h4 class="title text-right">$'.$price.'</h4>
                </td>
                <td>
                   <h4 class="title text-right">'.$ticket_amt.'</h4>
                </td>
 
             </tr>
          
                </table>
                </div>
             
               
                


        </div>';

            echo '<div class="col-md-12" id="paypal-button-container"></div>';

echo ' <script>
      
        paypal.Button.render({

            env: "production", // sandbox | production

            // PayPal Client IDs - replace with your own
            // Create a PayPal app: https://developer.paypal.com/developer/applications/create
            client: {
                sandbox:"",
                production:"'.$organization_privatekey_paypal.'"


            },

            // Show the buyer a "Pay Now" button in the checkout flow
            commit: true,

            // payment() is called when the button is clicked
            payment: function(data, actions) {

                // Make a call to the REST api to create the payment
                return actions.payment.create({
                    payment: {
                        "transactions": [
                            {

                              "amount": { total: '.$price.', currency: "USD"}, "quantity": "'.$ticket_amt.'",


                               
                         
                            }

                        ] 


                    }
                });
            },

            // onAuthorize() is called when the buyer approves the payment
            onAuthorize: function(data, actions) {

                // Make a call to the REST api to execute the payment
                return actions.payment.execute().then(function() {
   
                    loadDoc();
                
                   
                });
            }



        }, "#paypal-button-container");
                              function loadDoc() {
                                //window.location.replace("location:profile.php");

}
    </script>';

  //header('location:profile.php');

 }?><?php   




      


                    if(isset($order_list) && !isset($_POST["schedule"])){

                    	$ticket_name = explode("_", $order_list[0]["type"]);
                    	$ticket_date = explode(" ", $order_list[0]["date"]);
                      $ticket_time = explode("-", $order_list[0]["time"]);
                    	echo strtoupper($ticket_name[0]).' TICKET | '.date("d-m-Y",strtotime($ticket_date[0])).' | '.date('h:i A', strtotime($ticket_time[0])).'-'.date('h:i A', strtotime($ticket_time[1])); } ?></h2>

       </div>
       
         </br>
          <div class="row">
            <div class="col-md-5 ml-auto">
              <div class="info info-horizontal">
                <div class="icon icon-rose">
                <!--   <i class="material-icons">ticket</i> -->
                </div>

                <?php 

if (!isset($_POST["schedule"])) {
          echo '<div class="description">
                <form method="POST" action="order_page.php">
        
                   <input type="hidden" name="schedule" value="schedule">
                   <input type="hidden" name="publickey" value="'.$order_list[0]["publickey"].'">
                   <input type="hidden" name="privatekey" value="'.$order_list[0]["privatekey"].'">
                   <input type="hidden" name="org_id" value="'.$order_list[0]["org_id"].'">
                   <input type="hidden" name="price" value="'.$order_list[0]["price"].'">
                   <input type="hidden" name="eventTitle" value="'.$order_list[0]["title"].'">

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

if (isset($order_list[0]["price"]) && trim($order_list[0]["price"]) ==trim("0.00")) {
                echo ' <div class="form-group">
                 <label  style="color: black; font-weight: bold;">price $'.$order_list[0]["price"].'</label>
                 <input type="hidden" name="price" value="'. $order_list[0]["price"].'">
                </br></br></br>
                <button type="submit" class="btn btn-warning  radius-50 btn-sm" value="free" name="free_event">submit</button>';
}else if(isset($order_list[0]["price"])){

                echo ' <div class="form-group">
                <label  style="color: black; font-weight: bold;">price $'.$order_list[0]["price"].'</label>
                <input type="hidden" name="price" value="'. $order_list[0]["price"].'"></br></br></br> <button type="submit" class="btn btn-warning  radius-50 btn-sm" value="payment" name="paid_event">submit</button>


    ';
}

  
   
   echo '</div>
 
</form>';
 
}

     ?>       
   
                </div>
              </div>
              
            
            </div>

            <?php

            if (!isset($_POST["schedule"])) {
                    echo '      <div class="col-md-5 mr-auto">
              <div class="card card-background" style="background-image:url(';
              if(isset($order_list)){ echo $order_list[0]["img"].')">
                <a href="#pablo"></a>
                <div class="card-body">
                  <span class="badge badge-rose">'; }  
                  if(isset($order_list)){ echo $order_list[0]["name"].'</span>
                  <a href="#pablo">
                    <h2 class="card-title">'; }

                    if(isset($order_list)){ echo $order_list[0]["title"].' </a>
                  <p class="card-description">'; } 
                  
                if(isset($order_list)){ echo $order_list[0]["description"].'        
                </div>
              </div>
                  <h3 class="title"><i class="material-icons">room </i>'; } 

          
                    if(isset($order_list)){echo  $order_list[0]["address"].'</h3>
            </div>' ; }   
                    }        
   ?>
        
            	 
          </div>
        </div>
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
        </ul>
      </nav>
      <div class="copyright float-right">
        &copy;
        <script>
          document.write(new Date().getFullYear())
        </script>, created by 
        <a href="https://www.aeravi.io" target="_blank">Aeravi</a>.
      </div>
    </div>
  </footer>
  
  
  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js" type="text/javascript"></script>
  <script src="../assets/js/core/popper.min.js" type="text/javascript"></script>
  <script src="../assets/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
  <script src="../assets/js/plugins/moment.min.js"></script>
  <!--	Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker -->
  <script src="../assets/js/plugins/bootstrap-datetimepicker.js" type="text/javascript"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="../assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
  <!--  Google Maps Plugin    -->
 <!--  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBidE-PE8nRTYLn-tqLiLipd86XT3yDoiY"></script> -->
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
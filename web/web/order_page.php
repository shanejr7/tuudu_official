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
    $conn = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
    //$conn = pg_connect(getenv("DATABASE_URL"));
     $user_I_D =  pg_escape_string($conn, $_SESSION['id']);
     $org_id = pg_escape_string($conn,$_GET['order']);

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

    $result = pg_query($conn,"SELECT DISTINCT organization.date, organization.time, organization.fiatvalue,organization.img, organization.id as org_id, organization.description,organization.views, organization.title,organization.organization_name as org_name, organization.date,  organization.address, organization.word_tag
     FROM organization WHERE organization.id = $org_id LIMIT 1");

    // loops through rows until there is 0 rows
    if (pg_num_rows($result) > 0) {
         // output data of each row
        while($row = pg_fetch_assoc($result)) {
      
             $order_list[] = array("date" => $row["date"], "time" => $row["time"], "price"=> $row["fiatvalue"], "img" => $row["img"],"org_id" => $row["org_id"],"description" => $row["description"],"views" => $row["views"], "title" => $row["title"],"name" => $row["org_name"],"address" => $row["address"],"type" => $row["word_tag"]);
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
    Profile
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
                     <a href="profile.php?" class="nav-link">Dashboard</a> 
                </li>
            </ul>

        </div>

       
           
    </div>
 <!--     <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                <li class="nav-item active">
                     <a href="profile.php?" class="nav-link">Dashboard</a> 
                </li>
                <li class="nav-item">
                    
                </li>
            </ul>
                </div> -->
</nav>

 <!--  <div class="page-header header-filter" data-parallax="true" style="background-image: url('../assets/img/city-profile.jpg');"></div> -->
 <div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none; " id="mySidebar">
  <button class="btn btn-primary btn-link"
  onclick="w3_close()">Close &times;</button>
  <ul class="nav flex-column">
    <div class="card bg-info">
    <div class="card-body">
       

        <div class="card-stats">
            <div class="author">
                <a href="#pablo">
                   <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=334&q=80&ixid=dW5zcGxhc2guY29tOzs7Ozs%3D" alt="..." class="avatar img-raised">
                   <span>Tania Andrew</span>
                </a>
            </div>
           <div class="stats ml-auto">
                <i class="material-icons">favorite</i> 2.4K &#xB7;
                <i class="material-icons">share</i> 45
            </div>
        </div>

    </div>

</div>
  
</ul> 
</div>
    <!-- class"main main-rasied" -->
     <div id="main">
     
    <div class="profile-content ">
      <div class="container">
    
      
        <div class="container">
       <div class="row"> 
<div class="col-md-4"></div>
       	<h2 class="title"><?php   
                    if(isset($order_list)){
                    	$ticket_name = explode("_", $order_list[0]["type"]);
                    	$ticket_date = explode(" ", $order_list[0]["date"]);
                    	echo strtoupper($ticket_name[0]).' TICKET | '.$ticket_date[0].' | '.$order_list[0]["time"]; } ?></h2>

       </div>
       
         </br>
          <div class="row">
            <div class="col-md-5 ml-auto">
              <div class="info info-horizontal">
                <div class="icon icon-rose">
                <!--   <i class="material-icons">ticket</i> -->
                </div>
                <div class="description">
         <form>
       	
  <div class="form-group">
    <label for="exampleFormControlSelect1">select amount.</label>
    <select class="form-control selectpicker" data-style="btn btn-link" id="exampleFormControlSelect1">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
  </div>
   <div class="form-group">
    <label  style="color: black; font-weight: bold;">price $<?php if(isset($order_list)){ echo $order_list[0]["price"]; }?></label>
    <input type="hidden" name="price"  <?php if(isset($order_list)){ echo 'value="'. $order_list[0]["price"].'"'; }?>>
   
  </div>
</br>
</br>
</form>
   <div id="paypal-button-container"></div>

    <script>
    	
        paypal.Button.render({

            env: 'production', // sandbox | production

            // PayPal Client IDs - replace with your own
            // Create a PayPal app: https://developer.paypal.com/developer/applications/create
            client: {
                sandbox:    'AftTS3zFAZ4egAOj31jfwRBWcFXKY0a9gjYwvVjAhbJJN_4Ozr42E9Uc1jFWn8kENX0UNba0ZUk_VFBA',
                production: 'AXg10y3D3xzUHtFkynnIvGFvEvPOSe1WAzuTA-3U4T3IWeSoukrOz1CdzB7OcUQfhW4hFOKzcPL7R4OD'


            },

            // Show the buyer a 'Pay Now' button in the checkout flow
            commit: true,

            // payment() is called when the button is clicked
            payment: function(data, actions) {

                // Make a call to the REST api to create the payment
                return actions.payment.create({
                    payment: {
                        "transactions": [
                            {

                               "amount": { total: '0.01', currency: 'USD'}, "quantity": '1',


                               
                         
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



        }, '#paypal-button-container');
                              function loadDoc() {
                              	// window.location.replace("order_page.php");

}
    </script>

                 <!--  <h4 class="info-title">Ticket</h4> -->
                <!--   <p class="description">
                    We&apos;ve created the marketing campaign of the website. It was a very interesting collaboration.
                  </p> -->
                </div>
              </div>
              
            
            </div>
            <div class="col-md-5 mr-auto">
              <div class="card card-background" style="background-image:url('<?php if(isset($order_list)){ echo $order_list[0]["img"]; }?>')">
                <a href="#pablo"></a>
                <div class="card-body">
                  <span class="badge badge-rose"> <?php if(isset($order_list)){ echo $order_list[0]["name"]; }?></span>
                  <a href="#pablo">
                    <h2 class="card-title"><?php if(isset($order_list)){ echo $order_list[0]["title"]; }?></h2>
                  </a>
                  <p class="card-description">
                    <?php if(isset($order_list)){ echo $order_list[0]["description"]; }?>

                    
                </div>
               
              </div>
<h3 class="title"><i class="material-icons">room </i> <?php   
                    if(isset($order_list)){echo  $order_list[0]["address"] ; } ?></h3>
            </div>
            	 
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
            <a href="https://creative-tim.com/presentation">
              About Us
            </a>
          </li>
          <li>
            <a href="http://blog.creative-tim.com">
              Blog
            </a>
          </li>
          <li>
            <a href="https://www.creative-tim.com/license">
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
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBidE-PE8nRTYLn-tqLiLipd86XT3yDoiY"></script>
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

<!--   <nav id="cd-vertical-nav">
    <ul>
      <li>
        <a href="#nav" data-number="1">
          <span class="cd-dot"></span>
          <span class="cd-label">Top</span>
        </a>
      </li>
      <li>
        <a href="#body" data-number="2">
          <span class="cd-dot"></span>
          <span class="cd-label">Content</span>
        </a>
      </li>
      <li>
        <a href="#footer" data-number="3">
          <span class="cd-dot"></span>
          <span class="cd-label">Bottom</span>
        </a>
      </li>
    
    </ul>
  </nav> -->
</body>

</html>
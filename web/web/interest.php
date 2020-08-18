<?php 
include('server.php');


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
   
 <link rel="icon" 
      type="image/jpg" 
      href="../assets/img/logo_size.jpg"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Interest
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
 <!--  <link rel="stylesheet" type="text/css" href="../assets/css/style.css"> -->
  


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
                    <a href="login-page.php?logout='1'" onclick="revokeAllScopes()" class="nav-link">LOGOFF</a>
                    <script type="text/javascript">
                      var revokeAllScopes = function() {
                         auth2.disconnect();
                      }
                     </script>
                </li>
                  <li class="nav-item">
                    <a href="dashboard.php" class="nav-link">DASHBOARD</a>
                </li>
        
        
   </ul>          
                
       </div></div>
                     </nav>
      

    <div class="container" style="margin-bottom: 3em;">
        <div class="row">
          <div class="col-lg-2"></div>
           <div class="col-lg-8" style="margin-top: 1em">
            <h2 style="font-weight: bold;">Select topics</h2>

                     <?php 

                     // error appears if search value cant be found //
                     if(isset($_GET['val'])){
 
                  echo '<span class="text-warning btn-md-link" style="margin-left: 21em;">cant find topic<i class=" text-warning btn-md-link fa fa-warning pl-10"></i><span></p>';
                     }
                     ?>
          
                     <!-- select al from word tags and put each word into a tag -->

                     <!-- next get tags that are related -->
                     <div id="textareaTags">
                         <div class="row">
  

            <div class="col-lg-6">
              <div class="title">
               <!-- <h3>Tags</h3> -->
              </div>
              <a href="store-temp-tags.php?valType=sports" class="btn btn-rose btn-round"><i class="material-icons">sports_soccer</i></a>
              <!-- You can change data-color="rose" with one of our colors primary | warning | info | danger | success -->
              <!--proceeds to set-up.php to select iTagName for iTagTypes that were selected  -->
                <a href="set-up.php" class="btn radius-50 btn-default-transparent btn-sm">enter</a>
            </div>
          </div>
        </div>
                      <!--  <a href="store-temp-tags.php?valType=sports">
                        <span class="icon circle small default-bg"><i class="fa fa-futbol-o"></i> </span>
                      </a> -->
                    </div>
      
           

                      <!-- search for iTagType ------------------------------------------------------>
                    <a href="#"class=" dropdown-toggle--no-caret" id="header-drop-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">  <span class="icon circle small default-bg"><i class="material-icon">search</i></span></a>
                   
                  <!-- this form searches for iTagType in table itags using store-temp-tags.php ------------------------------------>
                        <form role="search" action="store-temp-tags.php" method="post" class="dropdown-menu dropdown-menu-left dropdown-animation" aria-labelledby="header-drop-1"  > 
                          <div class="form-group has-feedback" style="margin-bottom: -6em; margin-top: -1em;">
                            <input type="text" class="form-control" name="search" placeholder="Search">
                            <i class="icon-search form-control-feedback"></i>
                          </div>
                        </form>
                  
                  
                
                  
              
               
          
        </div>
    </div>
    
         

     <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Terms & Agreement</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
         <div class="modal-body">
 by accepting this agreement and terms with using our services. you agree that all transactions and events are affiliated to independent third-party organizations in which our services only provides data without any association or having liability with third party organizations. accepting these terms our services is allowed to use data of your liking to provide events and or activitites.If you do not agree with our terms and policy then do not register, download, or use our services.
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
  </div>

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

 
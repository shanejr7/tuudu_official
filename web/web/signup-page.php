<?php 
/* DOCS

  * 
  * [users] <creates user account>
  * signup-page.php --> server.php 
  *
  
*/

  include('server.php')
 
 ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />

   <link rel="icon" 
      type="image/jpg" 
      href="../assets/img/logo_size.jpg"/>
 
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

 

  <title>
    Signup
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
  <script src="https://apis.google.com/js/api:client.js"></script>
  <script type="text/javascript">
     
  var googleUser = {};
  var randomStr = "";
  var startApp = function() {
    gapi.load('auth2', function(){
      // Retrieve the singleton for the GoogleAuth library and set up the client.
      auth2 = gapi.auth2.init({
        client_id: '364968110969-p4uifadifi3la4pia4j8d8rar97tepu3.apps.googleusercontent.com',
        cookiepolicy: 'single_host_origin',
        // Request scopes in addition to 'profile' and 'email'
        //scope: 'additional_scope'
      });
      attachSignin(document.getElementById('customBtn'));
    });
  };


  function attachSignin(element) {
    console.log(element.id);
    auth2.attachClickHandler(element, {},
        function(googleUser) {
          document.getElementById('inputName').value = googleUser.getBasicProfile().getName();
          document.getElementById('inputEmail').value = googleUser.getBasicProfile().getEmail();
          document.getElementById('inputPassword').value = googleUser.getBasicProfile().getId();
          document.getElementById('account_type').value = 'google_user'; 
          document.getElementById('policy').value = 'true'; 
          document.getElementById('signup').submit(); 
          
        }, function(error) {
          alert(JSON.stringify(error, undefined, 2));
        });
  }

  </script>


</head>

<body class="profile-page sidebar-collapse">
<nav class="navbar navbar-expand-lg bg-primary">
    <div class="container">
        <div class="navbar-translate col-lg-4">

            <a class="navbar-brand" href="signup-page.php">  <img src="../assets/img/logo.png" style="width: 30%; "></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse col-lg-8">
             <ul class="navbar-nav">
              <li class="nav-item">
                   <a href="home.php" class="nav-link"><i class="material-icons">home</i></a>
                </li>
                <li class="nav-item">
                    <a href="login-page.php" class="nav-link">Login</a>
                </li>
                <li class="nav-item active">
                    <a href="signup-page.php" class="nav-link">Signup</a>
                </li>
               
            </ul>
        </div>
    </div>
</nav>
 <!--  <div class="page-header header-filter" data-parallax="true" style="background-image: url('../assets/img/city-profile.jpg');"></div> -->
 
    <!-- class"main main-rasied" -->
     <div >
   <div class="container">
     <div class="row">
            <div class="col-md-5 ml-auto">
              <div class="info info-horizontal">
                <div class="icon icon-rose">
                  <i class="material-icons">timeline</i>
                </div>
                <div class="description">
                  <h4 class="info-title">Explore</h4>
                  <p class="description">
                    Find things going on in your community. 
                  </p>
                </div>
              </div>
              <div class="info info-horizontal">
                <div class="icon icon-success">
                  <i class="material-icons">group</i>
                </div>
                <div class="description">
                  <h4 class="info-title">Share & Stay connected</h4>
                  <p class="description">
                    Discover the world around you. Share what you&apos;re
                    doing and stay connected.
                  </p>
                </div>
              </div>
        
            </div>
            <div class="col-md-5 mr-auto">
         <div class="card card-login">
             
            <form class="form" method="post" id="form" action="signup-page.php">
                 
                 
              <div class="card-header card-header-primary text-center">
                <h4 class="card-title">signup</h4>
                <div class="social-line"  >
                  <!-- <a href="#pablo" class="btn btn-just-icon btn-link">
                    <i class="fa fa-facebook-square" style="color: #898F9C;"></i>
                  </a> -->
                 <!--  <a href="#pablo" class="btn btn-just-icon btn-link">
                    <i class="fa fa-twitter"></i>
                  </a> -->
                  <a href="#googleSignin" id="customBtn"  class="btn btn-just-icon btn-link">
                    <i class="fa fa-google-plus" style="color: yellowgreen;"></i>
                  </a>
                </div>
                 <script>startApp();</script>
              </div>  <div style="margin-left: 30%;"> <?php include('errors.php'); ?></div>  
           <!--    <p class="description text-center">Or Be Classical</p> -->
              <div class="card-body">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">face</i>
                    </span>
                  </div>
                  <input type="text" class="form-control" name="username" id="inputName" placeholder="User Name..." required>
                   <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">cake</i>
                    </span>
                    <input type="text" class="form-control datepicker" name="age" value="<?php echo date('m/d/Y') ?>" required>
                  </div>
                </div>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">mail</i>
                    </span>
                  </div>
                  <input type="email" class="form-control" name="email" id="inputEmail" placeholder="Email..."   required>
                </div>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">lock_outline</i>
                    </span>
                  </div>
                  <input type="password" class="form-control"name="password_1" id="inputPassword" placeholder="Password..." required>
                  <input type="hidden" name="account_type" id="account_type" value="user">
                </div>
                  <div class="form-check">
                  <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" id="policy" value="" required>Accept our policy &mdash;
                      <span class="form-check-sign">
                          <span class="check"></span>
                      </span> 
                    </label>
                    <a href="#">  <button type="button" class="btn btn-info radius-50 btn-sm" style="background-color: orange;" data-toggle="modal" data-target="#exampleModal">policy agreement</button></a>
                </div>
  
                    <!-- recaptcha -->
              <!-- </div> -->
              <div class="footer text-center">
                <button type="submit" value="string" href="#" class="btn btn-primary btn-link btn-wd btn-lg" id="signup" name="reg_user"
                data-callback='onSubmit'>Get Started</button>
              </div>
            </form>

          </div>
            </div>
   
          </div>
      
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
 by accepting this agreement and terms with using our services. you agree that all transactions and events are affiliated to independent third-party organizations in which our services only provides data without any association or having liability with third-party organizations. accepting these terms our services is allowed to use data of your liking to provide events and or activitites.If you do not agree with our terms and policy then do not register, download, or use our services.
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button> -->
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
 <div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Terms & Agreement</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
 by accepting this agreement and terms with using our services. you agree that all transactions and events are affiliated to independent third-party organizations in which our services only provides data without any association or having liability with third-party organizations. accepting these terms our services is allowed to use data of your liking to provide events and or activitites.If you do not agree with our terms and policy then do not register, download, or use our services.
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button> -->
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
  <footer class="footer footer-default"  >
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
           <a href="#terms" data-toggle="modal" data-target="#termsModal">
            Terms
            </a>
          </li>
          <li>
           <a href="https://www.tuudu.org/web/contact-us.php">
            Contact Us
            </a>
          </li>
        </ul>
      </nav>
      <div class="copyright float-right">
        &copy;
        <script>
          document.write(new Date().getFullYear())
        </script> created by 
        <a href="https://www.aeravi.io">Aeravi</a>.
      </div>
    </div>
  </footer>
  </div>
  <!--   Core JS Files   -->
    <script>
    $(document).ready(function() {
      //init DateTimePickers
      materialKit.initFormExtendedDatetimepickers();

      // Sliders Init
      materialKit.initSliders();
    });
  </script>
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
</body>

</html>
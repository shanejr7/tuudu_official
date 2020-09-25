<?php include('server.php');
/* DOCS

  * <form to send email message>
  *
  *
  
*/ 
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
    Contact Us
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

</head>
<style type="text/css">* {
        margin: 0;
        padding: 0;
        border: 0;
        outline: 0;
        font-size: 100%;
        vertical-align: baseline;
        background: transparent;
    }</style>

<body class="contact-page sidebar-collapse">
<nav class="navbar fixed-top navbar-expand-lg bg-primary" color-on-scroll="100" id="sectionsNav">
    
    <div class="container">
        <div class="navbar-translate col-lg-4">

            <a class="navbar-brand" href="contact-us.php">  <img src="../assets/img/logo.png" style="width: 30%; "></a>
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
                <li class="nav-item">
                    <a href="signup-page.php" class="nav-link">Signup</a>
                </li>
            </ul>
    
          
        </div>
    
    </div>
</nav>
  <div id="contactUsMap" class="big-map"></div>
  <div class="main main-raised">
    <div class="contact-content">
      <div class="container">
        <h2 class="title">Send us a message  <div class="col-md-4" style="margin-left: 10%; color: orange;"> <?php include('errors.php'); if(count($errors)==0 && isset($string)){echo $string;} ?>
                        </div> </h2>
        <div class="row">
          <div class="col-md-6">
            <p class="description">You can contact us with anything related to our plaftform. We&apos;ll get in touch with you as soon as possible.<br><br>
            </p>
            <form role="form" id="contact-form" method="post" action="contact-us.php">
              <div class="form-group">
                <label for="name" class="bmd-label-floating">Your name</label>
                <input type="text" class="form-control" name="contactName" id="name">
              </div>
              <div class="form-group">
                <label for="exampleInputEmails" class="bmd-label-floating">Email address</label>
                <input type="email" class="form-control" name="contactEmail" id="exampleInputEmails">
                <span class="bmd-help">We'll never share your email with anyone else.</span>
              </div>
              <div class="form-group">
                <label for="phone" class="bmd-label-floating">Phone</label>
                <input type="text" class="form-control" name="contactNumber" id="phone">
              </div>
              <div class="form-group label-floating">
                <label class="form-control-label bmd-label-floating" for="message"> Your message</label>
                <textarea class="form-control" rows="6" name="contactMessage" id="message"></textarea>
              </div>
              <div class="submit text-center">
                <input type="submit" name="contactUs" class="btn btn-primary btn-raised btn-round" value="Contact Us">
              </div>
            </form>
          </div>
          <div class="col-md-4 ml-auto">
            <div class="info info-horizontal">
              <div class="icon icon-primary">
                <i class="material-icons">pin_drop</i>
              </div>
              <div class="description">
                <h4 class="info-title">Find us at the office</h4>
                <p> Grand Rapids, MI 49503,<br>
                  <!-- 7652 Bucharest,<br> -->
                  United States
                </p>
              </div>
            </div>
            <div class="info info-horizontal">
              <div class="icon icon-primary">
                <i class="material-icons">phone</i>
              </div>
              <div class="description">
                <h4 class="info-title">Give us a ring</h4>
                <p> +1 616 264 4429<br>
                  Mon - Fri, 9:00am-3:00pm
                </p>
              </div>
            </div>
            <div class="info info-horizontal">
              <div class="icon icon-primary">
                <i class="material-icons">business_center</i>
              </div>
              <div class="description">
                <h4 class="info-title">Legal Information</h4>
                <p>Aeravi</p>
             <!--    <p> Creative Tim Ltd.<br>
                  VAT &#xB7; EN2341241<br>
                  IBAN &#xB7; EN8732ENGB2300099123<br>
                  Bank &#xB7; Great Britain Bank
                </p> -->
              </div>
            </div>
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
  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js" type="text/javascript"></script>
  <script src="../assets/js/core/popper.min.js" type="text/javascript"></script>
  <script src="../assets/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
  <script src="../assets/js/plugins/moment.min.js"></script>
  <!--  Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker -->
  <script src="../assets/js/plugins/bootstrap-datetimepicker.js" type="text/javascript"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="../assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAusWjyb2Li6ezpM7E6kpUsDwXdaMWPHUE"></script>
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
  <script src="../assets/js/material-kit.js?v=2.2.0" type="text/javascript"></script>
  <script>
    $().ready(function() {
      materialKitDemo.initContactUsMap();
    });
  </script>
</body>

</html>
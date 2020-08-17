<?php  include_once('server.php'); // * server.php gives each new user a special id for oraganzing data through set up process
// home page:
// * new users start on homepage and begin selecting iTagType
// ------------------------------------------more details at line 180

 
?>
 
<!DOCTYPE html>
<!--[if IE 9]> <html lang="zxx" class="ie9"> <![endif]-->
<!--[if gt IE 9]> <html lang="zxx" class="ie"> <![endif]-->
<!--[if !IE]><!-->
<html dir="ltr" lang="zxx">
	<!--<![endif]-->

  <head>
    <meta charset="utf-8">
    <title>Tuudu | Interest</title>
    <meta name="description" content="The project">
    <meta name="Aeravi" content="htmlcoder.Aeravi">

    <!-- Mobile Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="shortcut icon"  href="images/transparent_lg.png">
    <!-- location finder -->
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
    <!-- Web Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:700,400,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=PT+Serif' rel='stylesheet' type='text/css'>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Font Awesome CSS -->
    <link href="fonts/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Fontello CSS -->
    <link href="fonts/fontello/css/fontello.css" rel="stylesheet">

    <!-- Plugins -->
    <link href="plugins/magnific-popup/magnific-popup.css" rel="stylesheet">
    <link href="plugins/rs-plugin-5/css/settings.css" rel="stylesheet">
    <link href="plugins/rs-plugin-5/css/layers.css" rel="stylesheet">
    <link href="plugins/rs-plugin-5/css/navigation.css" rel="stylesheet">
    <link href="css/animations.css" rel="stylesheet">
    <link href="plugins/owlcarousel2/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="plugins/owlcarousel2/assets/owl.theme.default.min.css" rel="stylesheet">
    <link href="plugins/hover/hover-min.css" rel="stylesheet">		
     <link href="plugins/jquery.countdown/css/jquery.countdown.css" rel="stylesheet">
    <!-- The Project's core CSS file -->
    <!-- Use css/rtl_style.css for RTL version -->
    <link href="css/style.css" rel="stylesheet" >
    <!-- The Project's Typography CSS file, includes used fonts -->
    <!-- Used font for body: Roboto -->
    <!-- Used font for headings: Raleway -->
    <!-- Use css/rtl_typography-default.css for RTL version -->
    <link href="css/typography-default.css" rel="stylesheet" >
    <!-- Color Scheme (In order to change the color scheme, replace the blue.css with the color scheme that you prefer)-->
    <link href="css/skins/light_blue.css" rel="stylesheet">
    
 <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNNP7DU7U95uTSOgWzYgXnkOgE8NOfTEA&callback=initMap"
  type="text/javascript"></script>
    <!-- Custom css --> 
    <link href="css/custom.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 <style>
 
/* Popup container - can be anything you want */
.popup {
    position: relative;
    display: inline-block;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* The actual popup */
.popup .popuptext {
    visibility: hidden;
    width: 20em;
    height:22em;
    background-color:  orange;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 8px 0;
    position: absolute;
   top: 1px;
    z-index: 1;
    bottom: 50%;
    left: 60em;
    margin-left: -80px;
}
.space{
  margin-left: 3px;
  margin-right: 3px;
}
/* Popup arrow */
.popup .popuptext::after {
    content: "";
    position: absolute;
    top: 200%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #555 transparent transparent transparent;
}

/* Toggle this class - hide and show the popup */
.popup .show {
    visibility: visible;
    -webkit-animation: fadeIn 1s;
    animation: fadeIn 1s;
}

/* Add animation (fade in the popup) */
@-webkit-keyframes fadeIn {
    from {opacity: 0;} 
    to {opacity: 1;}
}

@keyframes fadeIn {
    from {opacity: 0;}
    to {opacity:1 ;}
}




/* Popup container - can be anything you want */
.popup1 {
    position: relative;
    display: inline-block;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* The actual popup */
.popup1 .popuptext1 {
    visibility: hidden;
    width: 160px;
    background-color: orange;
    color: #fff ;
    text-align: center;
    border-radius: 6px;
    padding: 8px 0;
    position: absolute;
    z-index: 1;
    bottom: 125%;
    left: 50%;
    margin-left: -80px;
}

/* Popup arrow */
.popup1 .popuptext1::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #555 transparent transparent transparent;
}
.popup1 .show1 {
    visibility: visible;
    -webkit-animation: fadeIn 1s;
    animation: fadeIn 1s;
}
/* Toggle this class - hide and show the popup */
 

</style>
  </head>

  <!-- body classes:  -->
  <!-- "boxed": boxed layout mode e.g. <body class="boxed"> -->
  <!-- "pattern-1 ... pattern-9": background patterns for boxed layout mode e.g. <body class="boxed pattern-1"> -->
  <!-- "transparent-header": makes the header transparent and pulls the banner to top -->
  <!-- "gradient-background-header": applies gradient background to header -->
  <!-- "page-loader-1 ... page-loader-6": add a page loader to the page (more info @components-page-loaders.html) -->
  <body class="front-page " onload="getLocation()">
 
<!-- <p id="demo"></p> -->

<script>

var x = document.getElementById("demo");

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
</script>
 

    <!-- scrollToTop -->
    <!-- ================ -->
    <div class="scrollToTop circle"><i class="icon-up-open-big"></i></div>

    <!-- page wrapper start -->
    <!-- ================ -->
    <div class="page-wrapper">
      <!-- header-container start -->
      <div id="header" class="header-container">
        <!-- header start -->
        <!-- classes:  -->
        <!-- "fixed": enables fixed navigation mode (sticky menu) e.g. class="header fixed clearfix" -->
        <!-- "fixed-desktop": enables fixed navigation only for desktop devices e.g. class="header fixed fixed-desktop clearfix" -->
        <!-- "fixed-all": enables fixed navigation only for all devices desktop and mobile e.g. class="header fixed fixed-desktop clearfix" -->
        <!-- "dark": dark version of header e.g. class="header dark clearfix" -->
        <!-- "full-width": mandatory class for the full-width menu layout -->
        <!-- "centered": mandatory class for the centered logo layout -->
        <!-- ================ --> 
        <!-- or have pv 20 8em; for header size -->
        <header style="color: white; background-color:  #2D51A3; height: 80px;">
          <div class="container">
           

      
                    <div class="row" >
                         <div class=" col-lg-12 logo-header"  ><img id="logo-header" class="mx-auto" src="images/logo_size_invert.jpg" alt="">
  
              </div>

                   <div class= "  pv-20">
                    <a href="apply.php" title="hos"ting an event?">#Whois</a><br>
 <span style="color: orange">Hosting an event?</span>

                </div>

            
                  <div class="col-lg-2">

 

               <!--  <ul class="social-links text-md-right text-center-xs animated-effect-1 circle small clearfix">
                  <li class="twitter"><a target="_blank" href="http://www.twitter.com"><i class="fa fa-twitter"></i></a></li>
                  <li class="googleplus"><a target="_blank" href="http://plus.google.com"><i class="fa fa-google-plus"></i></a></li>
                  <li class="youtube"><a target="_blank" href="http://www.youtube.com"><i class="fa fa-youtube-play"></i></a></li>
                 
                 
                </ul> -->
    
              </div>
             
            
              
           

          </div>
        
          
          </div>
        </header>

        <!-- header end -->
      </div>

      </div>
      <!-- banner end -->

      <!-- main-container start -->
      <!-- ================ -->
      <section class="main-container">

        <div class="container" >
          <div class="row">
            <!-- main start -->
            <!-- ================ -->
            <div class="main col-md-12">
         
              <div class="row ">
                <div class="col-lg-2">
<!-- space to fill up in column -->
   <aside class="col-lg-12 col-xl-10 order-lg-12">
   	
              <div class="sidebar" style="margin-top: 2em">
                <div class="block clearfix">
                
                  <div class="separator-2" style="width: 8em"></div>
                  <nav>
                    <ul class="nav flex-column">
                      <li class="nav-item"><a class="nav-link active" href="home.php">Home</a></li>
                      <li class="nav-item"><a class="nav-link" href="home.php">Setup</a></li>
                      <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                      <li class="nav-item popup"  ><a class="nav-link" onclick="myFunction()" href="#">About</a>  <span class="popuptext" id="myPopup"><h4>About Us</h4><hr><p class="space">Tuudu is sorta like a to-do list app but instead it gathers up events and activites to make up a schedule based off wants and needs.</p><hr><p>Our mission is to connect the online community through social events to make a smarter & faster connected world !</p><hr><i class="fa fa-globe"><p>Explore the world around you..</p></i> </span></li>
                      <li class="nav-item popup1" onclick="myFunction1()"><a class="nav-link"
                      href="#">Contact</a>  <span class="popuptext1" id="myPopup1"><h5>email us</h5><hr><p><i class="fa fa-envelope-open-o"></i> <strong>contact@tuudu.org</strong></p> </span></li>
                       
                      
                    </ul>
                  </nav>
                      <!-- <div style="margin-top: 4em"><i class="fa fa-cube fa-5x" style="color: orange"></i><strong style="color: #2D51A3">blockchain</strong></div> -->
               
                </div>
              
      <!--  
           <div style=" margin-left: 0em"><i class="fa fa-cube fa-2x" style="color: orange"></i><strong>blockchain payments</strong></div>
                   </div>
    <div style="margin-left: 0em; margin-top: 2em"><i class="fa fa-cubes fa-2x" style="  color: orange"></i><strong>multiple currencies</strong></div> -->

            </aside>

                </div>

                <div class="col-lg-8" style="margin-top: 1em">
                     <?php 
                     // error appears if search value cant be found //
                     if(isset($_GET['val'])){
 
                  echo '<span class="text-warning btn-md-link" style="margin-left: 21em;">cant find topic<i class=" text-warning btn-md-link fa fa-warning pl-10"></i><span></p>';
                     }
                     ?>
          

                  <div class="circle-container ">
                  <div class="deg90 media xq2">
                    <div class="d-flex pr-4">
                       <a href="store-temp-tags.php?valType=sports">
                        <span class="icon circle small default-bg"><i class="fa fa-futbol-o"></i> </span>
                      </a>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading">#Sports</h4>
                      <!-- text can go here -->
                    </div>
                  </div>
                  <div class="deg0 media xq2">
                    <div class="d-flex pr-4">
                      <a href="store-temp-tags.php?valType=music">
                        <span class="icon circle small default-bg "><i class="icon-music"></i> </span>
                      </a>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading">#Music</h4>
                     <!-- text can go here -->
                    </div>
                  </div>
                      <div class="deg45 media xq2">
                    <div class="d-flex pr-4">
                      <a href="store-temp-tags.php?valType=media">
                        <span class="icon circle small default-bg"><i class="fa fa-tv"></i> </span>
                      </a>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading">#Cinema</h4>
                      <!-- text can go here -->
                    </div>
                  </div>
                  <div class="deg135 media xq2">
                    <div class="d-flex pr-4">
                     <a href="store-temp-tags.php?valType=outdoors">
                      <!-- icon map -->
                        <span class="icon circle small default-bg"><i class="fa fa-tree"></i> </span>
                      </a>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading">#Outdoors</h4>
                       <!-- text can go here -->
                    </div>
                  </div>
                  <div class="media deg225 xq2">
                    <div class="d-flex pr-4">
                       <a href="store-temp-tags.php?valType=festival">
                        <span class="icon circle small default-bg"><i class="fa fa-birthday-cake"></i> </span>
                      </a>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading">#Festival</h4>
                       <!-- text can go here -->
                    </div>
                  </div>
                   <div class="media deg315 xq2">
                    <div class="d-flex pr-4">
                     <a href="store-temp-tags.php?valType=hangouts">
                        <span class="icon circle small default-bg"><i class="fa fa-street-view"></i> </span>
                      </a>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading">#HangOuts</h4>
                       <!-- text can go here -->
                    </div>
                  </div>
                  <div class="media deg180 xq2">
                    <div class="d-flex pr-4">
                       <a href="store-temp-tags.php?valType=attractions">
                        <span class="icon circle small default-bg"><i class="fa fa-universal-access"></i> </span>
                      </a>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading">#Attraction</h4>
                       <!-- text can go here -->
                    </div>
                  </div>
                  <div class="media deg270 xq2" id="topic">
                    <div class="d-flex pr-4">
           

                      <!-- search for iTagType ------------------------------------------------------>
                    <a href="#"class=" dropdown-toggle--no-caret" id="header-drop-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">  <span class="icon circle small default-bg"><i class="icon-search"></i></span></a>
                   
                  <!-- this form searches for iTagType in table itags using store-temp-tags.php ------------------------------------>
                        <form role="search" action="store-temp-tags.php" method="post" class="dropdown-menu dropdown-menu-left dropdown-animation" aria-labelledby="header-drop-1" style="top: 200%; margin-top: -7em; margin-left: -3.5em; padding-bottom: 0%; " > 
                          <div class="form-group has-feedback" style="margin-bottom: -6em; margin-top: -1em;">
                            <input type="text" class="form-control" name="search" placeholder="Search">
                            <i class="icon-search form-control-feedback"></i>
                          </div>
                        </form>
                  
                  
                
                      <!-- ------------------------- -->
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading">Search</h4>
                       <!-- text can go here -->
                    </div>
                  </div>
                  <div class="xq2" >
                <!--proceeds to set-up.php to select iTagName for iTagTypes that were selected  -->
                <a href="set-up.php" class="btn radius-50 btn-default-transparent btn-sm">enter</a>
                 </div>
                </div>
         
                </div>
   <div class="col-lg-2 " id="aside" style="margin-top: 2em;">
             <i class="fa fa-drivers-license  fa-5x" style=" color:orange; "></i> <p><strong > build your personal profile</strong></p>
            <!--   <i class="fa fa-address-card-o fa-5x" style=" color:red;background-color: orange"></i> -->
              <!--   <i class="fa fa-spinner fa-spin fa-5x"></i> -->
<!-- <i class="fa fa-circle-o-notch fa-spin"></i> -->
<i class="fa fa-level-up  fa-4x  fa-flip-horizontal" style=" margin-top: 20px;  display: inline-block;"></i>  <p style="color: orange"><strong>stay connected</strong></p>
<i class="fa fa-level-down  fa-4x  " style=" margin-left: 2em;  display: inline-block;"></i>  
 <i class="fa fa-globe  fa-5x" style=" color:orange; margin-top: 20px;  " ></i><p><strong > retrieve events from the community</strong></p>
<!-- <i class="fa fa-spinner fa-pulse "></i> -->
              </div>
              </div>
            
              
            <!--  <span style="color: orange; "><strong>Tuudu</strong> </span> <i class="fa fa-trademark"></i> -->
                    </div>
            <!-- main end -->
     
          </div>
        </div>
      </section>
      <!-- main-container end -->

      <!-- section end -->

      <!-- section start -->
      <!-- ================ -->
      <div class="pv-40"  style="color: white; background-color:  #ffffff; height: 1em;  " >
      <!-- section end -->

      <!-- ================ -->
      <footer id="footer" class="clearfix " style="color: white; background-color:  #ffffff;">

        <!-- .footer start -->
        <!-- ================ -->
        <div class="footer" style="color: white; background-color:  #ffffff;">
          <div class="container">
            <div class="footer-inner">
              <div class="row justify-content-lg-center">
                <div class="col-lg-6">
                  <div class="footer-content text-center padding-ver-clear">
          
               <!--      <ul class="list-inline mb-20">
                      <li class="list-inline-item"><i class="text-default fa fa-map-marker pr-1"></i>Address</li>
                      <li class="list-inline-item"><a href="tel:+00 1234567890" class="link-dark"><i class="text-default fa fa-phone pl-10 pr-1"></i>#phone</a></li>
                      <li class="list-inline-item"><a href="" class="link-dark"><i class="text-default fa fa-envelope-o pl-10 pr-1"></i>email@</a></li>
                    </ul> -->
                  
                    <p class="text-center margin-clear" style="color: black;">Created by <a target="_blank" href="https://www.aeravi.io">Aeravi</a>. 2018</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- .footer end -->

      </footer>
      <!-- footer end -->
    </div>
    <!-- page-wrapper end -->

    <!-- JavaScript files placed at the end of the document so the pages load faster -->
    <!-- ================================================== -->
    <!-- Jquery and Bootstap core js files -->
     
     <script>

// When the user clicks on div, open the popup
function myFunction() {
    var popup = document.getElementById("myPopup");
    $("#aside").toggle();
    popup.classList.toggle("show");
}
function myFunction1() {
    var popup = document.getElementById("myPopup1");
    popup.classList.toggle("show1");
}
$(document).ready(function(){
 $("#appear").hide();
    $("#toggle").click(function(){
        $("#appear").toggle();
    });
});


</script>
    <script type="text/javascript" src="plugins/jquery.min.js"></script>
    <script type="text/javascript" src="plugins/popper.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
         <!-- Bootstrap Notify javascript -->
    <script type="text/javascript" src="plugins/bootstrap-notify/bootstrap-notify.js"></script>
    <!-- Modernizr javascript -->
    <script type="text/javascript" src="plugins/modernizr.js"></script>
    <!-- jQuery Revolution Slider  -->
    <script type="text/javascript" src="plugins/rs-plugin-5/js/jquery.themepunch.tools.min.js?rev=5.0"></script>
    <script type="text/javascript" src="plugins/rs-plugin-5/js/jquery.themepunch.revolution.min.js?rev=5.0"></script>
    <!-- Isotope javascript -->
    <script type="text/javascript" src="plugins/isotope/imagesloaded.pkgd.min.js"></script>
    <script type="text/javascript" src="plugins/isotope/isotope.pkgd.min.js"></script>
    <!-- Magnific Popup javascript -->
    <script type="text/javascript" src="plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
    <!-- Appear javascript -->
    <script type="text/javascript" src="plugins/waypoints/jquery.waypoints.min.js"></script>
    <script type="text/javascript" src="plugins/waypoints/sticky.min.js"></script>
    <!-- Count To javascript -->
      <!-- Count Down javascript -->
    <script type="text/javascript" src="plugins/jquery.countdown/js/jquery.plugin.js"></script>
    <script type="text/javascript" src="plugins/jquery.countdown/js/jquery.countdown.js"></script>
    <script type="text/javascript" src="js/coming.soon.config.js"></script>
    <script type="text/javascript" src="plugins/jquery.countTo.js"></script>
    <!-- Parallax javascript -->
    <script src="plugins/jquery.parallax-1.1.3.js"></script>
    <!-- Contact form -->
    <script src="plugins/jquery.validate.js"></script>
    <!-- Owl carousel javascript -->
    <script type="text/javascript" src="plugins/owlcarousel2/owl.carousel.min.js"></script>
    <!-- Initialization of Plugins -->
    <script type="text/javascript" src="js/template.js"></script>
    <!-- Custom Scripts -->
    <script type="text/javascript" src="js/custom.js"></script>
 


  </body>
</html>

<?php  include('show-temp-tags.php'); // query selects iTageName from selected iTagType from table itags
// setup page:
// * stores subset iTagName related to iTagType user selected  
// * setup -> # this page
// ------------------------------------------more details at line 193,214,246


?> 

<!DOCTYPE html>
<!--[if IE 9]> <html lang="zxx" class="ie9"> <![endif]-->
<!--[if gt IE 9]> <html lang="zxx" class="ie"> <![endif]-->
<!--[if !IE]><!-->
<html dir="ltr" lang="zxx">
	<!--<![endif]-->

  <head>
    <meta charset="utf-8">
    <title>Tuudu | set-up</title>
    <meta name="description" content="The project">
    <meta name="Aeravi" content="htmlcoder.Aeravi">

    <!-- Mobile Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

     <!-- Favicon -->
       <link rel="shortcut icon"  href="images/transparent_lg.png">

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
    

    <!-- Custom css --> 
    <link href="css/custom.css" rel="stylesheet">
    
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<style type="text/css">
  
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
 
/*  Popup container - can be anything you want */
.popup2 {
    position: relative;
    display: inline-block;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* The actual popup */
.popup2 .popuptext2 {
    visibility: hidden;
    width: 250px;
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
.popup2 .popuptext2::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #555 transparent transparent transparent;
}
.popup2 .show2 {
    visibility: visible;
    -webkit-animation: fadeIn 1s;
    animation: fadeIn 1s;

}
</style>
  </head>
 
  <!-- body classes:  -->
  <!-- "boxed": boxed layout mode e.g. <body class="boxed"> -->
  <!-- "pattern-1 ... pattern-9": background patterns for boxed layout mode e.g. <body class="boxed pattern-1"> -->
  <!-- "transparent-header": makes the header transparent and pulls the banner to top -->
  <!-- "gradient-background-header": applies gradient background to header -->
  <!-- "page-loader-1 ... page-loader-6": add a page loader to the page (more info @components-page-loaders.html) -->

  <body class="page-loader-6 " onload="tuuduBot()">
 
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
           <header class="header" style="color: white; background-color:  #2D51A3; height: 84px;">
          <div class="container">
           

      
                    <div class="row" >
                   <div class="col-lg-2" style="margin-top: 1em">
 
 <span >pick event tags that interest you...</span>

                </div>

          <!--     <div class="col-lg-8 logo-header"  ><img id="logo-header" class="mx-auto" src="snow_tuudu.gif" alt="">
  
              </div> -->

                  <div class="col-lg-2">
         <!--        <ul class="social-links text-md-right text-center-xs animated-effect-1 circle small clearfix">
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
      <!-- header-container end -->
      <!-- banner start -->
      <!-- ================ -->
    
    
        <!-- section end -->
        <!-- section start -->
        <!-- ================ -->
  <!--  -->
        <!-- section end -->
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
   <aside class="col-lg-4 col-xl-10 order-lg-4">
              <div class="sidebar">
                <div class="block clearfix">
                
                  <div class="separator-2"></div>
                  <nav>
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link active" href="#">Setup</a></li>
                      <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                            <li class="nav-item popup" onclick="myFunction()"><a class="nav-link"    href="#">About</a>  <span class="popuptext" id="myPopup"><h4>About Us</h4><hr><p class="space">Tuudu is sorta like a to-do list app but instead it gathers up events and activites to make up a schedule based off wants and needs.</p><hr><p>Our mission is to connect the online community through social events to make a smarter & faster connected world !</p><hr><i class="fa fa-globe"><p>Explore the world around you..</p></i> </span></li>
                      <li class="nav-item popup1" onclick="myFunction1()"><a class="nav-link"
                      href="#">Contact</a>  <span class="popuptext1" id="myPopup1"><h5>email us</h5><hr><p><i class="fa fa-envelope-open-o"></i> <strong>contact@tuudu.org</strong></p> </span></li>
                    </ul>
                  </nav>
                </div>
              
              </div>
            </aside>
                </div>
                <div class="col-lg-9" id="tag">
          
                         
              <?php 
if (isset($_session['ID'])) {
// connect to database -----------------------------------------------------------------------------------------------------

// given from session.php
$tagID = $_session["ID"];



// Create connection
//$conn = pg_connect("host=localhost dbname=db_tuudu user=postgres password=Javaoop12!");
$conn = pg_connect(getenv("DATABASE_URL"));
 // $conn = pg_connect("host=ec2-54-83-23-121.compute-1.amazonaws.com dbname=d191igjs7stcrv user=taqionqfyxisao password=
//f411fd2208dece2d0f6ac32df889fb2b9d1f1e616ade43b8ae73acd30ac7ff32");
// Check connection
if ($res1 = pg_get_result($conn)) {
    die("Connection failed: " .  pg_result_error($res1) );
}

$temp = array();
// gets user iTagType and the iTagName related to iTagType they selected
$sql = "SELECT DISTINCT temporarytags.itagtype FROM temporarytags, itags WHERE temporarytags.itagtype = itags.itagtype AND temporarytags.tempid =$tagID";
$result = pg_query($conn,$sql);

// loops through rows until there is 0 rows
if (pg_num_rows($result) > 0) {
    // output data of each row
    while($row = pg_fetch_assoc($result)) {
      
      $temp[] = array("temporarytags.iTagType" => $row["itagtype"]);

    }
    // if no rows 
} else {
  // echo "0 results";
}

if(!pg_close($conn)){//failed
}else{
  //passed
}


}

// uses each iTagType as a page counter to display its iTagNames
$max=0;
$count=0;
$set = sizeof($temp);
$max = sizeof($temp)-1;
if (isset($_GET['page'])) {
  $count = $_GET['page'];
}


  
  // while loop goes through each iTagType in array and displays subsets of iTagName that can be selected ----------------------
  // stores selected iTagName in store-temp-tags.php in a row related to its iTagType ------------------------------------------
            
while ($count <= $max && isset($temp[0])) {
 
 if ($count == 0) {
  echo ' <h2>tag: #'.$temp[$count]['temporarytags.iTagType'].'</h2>'   ;
        for ($x=0; $x < sizeof($tempArray) ; $x++) { 
          if ($tempArray[$x]['temporarytags.iTagType'] == $temp[$count]['temporarytags.iTagType']) {
             echo ' <a href="store-temp-tags.php?valName='.$tempArray[$x]['itags.iTagName'].'&page='.$count.'" class="btn btn-default-transparent btn-sm">'.$tempArray[$x]['itags.iTagName'].'</a> ';
          }
       
        }
   
if ($count == $max) {
  echo ' <div class="col-lg-9"  ><a href="sign-up.php?" style="display: inline-block;margin-left:1em; " class="btn radius-50 btn-default-transparent btn-bg">sign up</a>';
 
}else{
       //button sends next value to this page to go to next phase
    echo  '  <div class="col-lg-9"  >
   <a href="set-up.php?page=1" style="display: inline-block;" class="btn radius-50 btn-default-transparent btn-bg">continue</a>';
}
echo '</div>';
 }else if($count > 0 && $count < $max){
   echo ' <h2>tag: #'.$temp[$count]['temporarytags.iTagType'].'</h2>'   ;
        for ($x=0; $x < sizeof($tempArray) ; $x++) { 
          if ($tempArray[$x]['temporarytags.iTagType'] == $temp[$count]['temporarytags.iTagType']) {
            // if topic added does not have a tag name give option to add
            if ($tempArray[$x]['itags.iTagName'] =="") {
              echo "string";
              break;
            }
             echo ' <a href="store-temp-tags.php?valName='.$tempArray[$x]['itags.iTagName'].'&page='.$count.'" class="btn btn-default-transparent btn-sm">'.$tempArray[$x]['itags.iTagName'].'</a> ';
          }
       
        }
           //button sends next value to this page to go to next phase
          echo  '  <div class="col-lg-9">
   <a href="set-up.php?page='.--$count.'" style="display: inline-block;" class="btn radius-50 btn-default-transparent btn-bg">back</a>
';
if ($count == $max) {
   echo '<a href="sign-up.php?" style="display: inline-block;margin-left:1em; " class="btn radius-50 btn-default-transparent btn-bg">sign up</a>';
}else{
  ++$count; echo ' <a href="set-up.php?page='.++$count.'" style="display: inline-block;margin-left:1em;" class="btn radius-50 btn-default-transparent btn-bg">continue</a>';

        
}
}else if ($count == $max) {
   echo ' <h2>tag: #'.$temp[$count]['temporarytags.iTagType'].'</h2>'   ;
        for ($x=0; $x < sizeof($tempArray) ; $x++) { 


          if ($tempArray[$x]['temporarytags.iTagType'] == $temp[$count]['temporarytags.iTagType']) {
            // if topic added does not have a tag name give option to add else show tag name
          
           if ($tempArray[$x]['itags.iTagName'] =="") {
              echo " add tag name for topic.... must be a is a relationship..fix add this later";
              
            }else{
            echo ' <a href="store-temp-tags.php?valName='.$tempArray[$x]['itags.iTagName'].'&page='.$count.'" class="btn btn-default-transparent btn-sm">'.$tempArray[$x]['itags.iTagName'].'</a> ';
            }
          }
       
        }
           //button sends next value to this page to go to next phase
          echo  '  <div class="col-lg-9">
   <a href="set-up.php?page='.--$count.'" style="display: inline-block;" class="btn radius-50 btn-default-transparent btn-bg">back</a>
';
 echo '<a href="sign-up.php?" style="display: inline-block;margin-left:1em; " class="btn radius-50 btn-default-transparent btn-bg">sign up</a>';
 
}
break;
}

    
              ?>
                </div>
              </div>
                    </div>
            <!-- main end -->
          </div>
          <div class="row">
<div class="col-lg-8">
         <div id="tuuduBot" style="margin-left: 50em; margin-top: 4em" ><div class="nav-item popup2"><a class="nav-link" href="#"></a>  <span class="popuptext2" id="myPopup2"><h5>Tuudu Bot <i class="fa fa-eercast fa-spin" style="color: white"></i></h5> <hr><p><strong>picking certain event tags will connect you to social events related to the topic #tag  </strong></p>  </span></div></div> 
</div>

 
          </div>
        </div>

       
      </section>

      <!-- main-container end -->

      <!-- section end -->

      <!-- section start -->
      <!-- ================ -->
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
         

                     <p class="text-center margin-clear" style="color: black;">Created by <a target="_blank" href="https://www.aeravi.io"  >Aeravi</a>. 2018</p>
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
     <script>

// When the user clicks on div, open the popup
function myFunction() {
    var popup = document.getElementById("myPopup");
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

function tuuduBot() {

    var popup = document.getElementById("myPopup2");
    popup.classList.toggle("show2");
  
 
}
</script>
    <!-- JavaScript files placed at the end of the document so the pages load faster -->
    <!-- ================================================== -->
    <!-- Jquery and Bootstap core js files -->
    <script type="text/javascript" src="plugins/jquery.min.js"></script>
    <script type="text/javascript" src="plugins/popper.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
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
    <script type="text/javascript" src="plugins/jquery.countTo.js"></script>
    <!-- Parallax javascript -->
    <script src="plugins/jquery.parallax-1.1.3.js"></script>
     <!-- Count Down javascript -->
    <script type="text/javascript" src="plugins/jquery.countdown/js/jquery.plugin.js"></script>
    <script type="text/javascript" src="plugins/jquery.countdown/js/jquery.countdown.js"></script>
    <script type="text/javascript" src="js/coming.soon.config.js"></script>
    <script type="text/javascript" src="plugins/jquery.countTo.js"></script>
    <!-- Contact form -->
    <script src="plugins/jquery.validate.js"></script>
    <!-- Owl carousel javascript -->
    <script type="text/javascript" src="plugins/owlcarousel2/owl.carousel.min.js"></script>
    <!-- Initialization of Plugins -->
    <script type="text/javascript" src="js/template.js"></script>
    <!-- Custom Scripts -->
    <script type="text/javascript" src="js/custom.js"></script>
    <!-- pace page loader -->
<script type="text/javascript" src="plugins/pace/pace.min.js"></script>
  </body>
</html>

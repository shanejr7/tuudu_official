<?php 
/* DOCS

  *
  * [feedstate] <stores user selected topic tag into>
  * show-temp-tags.php --> set-up.php <show user selected tag>
  * set-up.php --> store-temp-tags.php <stores user selected topic tag>
  *
  
*/

include('show-temp-tags.php');


if (!isset($_SESSION['username'])) {
   
   header('location: login-page.php');
  }

 

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
  <!-- <link href="../assets/css/interest.css" rel="stylesheet" /> -->
 <!--  <link rel="stylesheet" type="text/css" href="../assets/css/style.css"> -->


</head>

<body class="profile-page sidebar-collapse">

<nav class="navbar navbar-expand-lg bg-primary">
    <div class="container">
        <div class="navbar-translate col-lg-4">

            <a class="navbar-brand" href="interest.php">  <img src="../assets/img/logo.png" style="width: 30%; "></a>
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
                    <a href="dashboard.php" class="nav-link">DASHBOARD</a>
                </li>
                 <li class="nav-item">
                    <a href="profile.php" class="nav-link">PROFILE</a>
                </li>
                <li class="nav-item active">
                    <a href="login-page.php?logout='1'" onclick="revokeAllScopes()" class="nav-link">LOGOFF</a>
                    <script type="text/javascript">
                      var revokeAllScopes = function() {
                         auth2.disconnect();
                      }
                     </script>
                </li>
        
        
   </ul>          
                
       </div></div>
                     </nav>
      

    <div class="container" style="margin-bottom: 3em;">
        <div class="row">
          <div class="col-lg-2"></div>
           <div class="col-lg-8" style="margin-top: 1em">
          
                         
<?php 

  $temp = array();

if (isset($_SESSION['id'])) {


    // given from session.php
    
    $tagID = $_SESSION["id"];



    // Create connection

    $conn = pg_connect(getenv("DATABASE_URL"));
 

    // Check connection
    
    if ($res1 = pg_get_result($conn)) {
      die("Connection failed: " .  pg_result_error($res1) );
    }



    // gets tag related to topic they selected limit 20 of best selected options from pool
    
    $sql = "SELECT DISTINCT word_tag.event_type, word_tag.itag FROM word_tag, feedstate 
    WHERE word_tag.event_type = feedstate.word_tag AND feedstate.userid = $tagID LIMIT 20";
    
    $result = pg_query($conn,$sql);

    // loops through rows until there is 0 rows
    
    if (pg_num_rows($result) > 0) {
      
      // output data of each row
      while($row = pg_fetch_assoc($result)) {
      
         $temp[] = array("event_type" => $row["event_type"] ,"itag" => $row["itag"]);

    }

    // if no rows 

} else {

  // echo "0 results";

}

if(!pg_close($conn)){

//failed

}else{

  //passed
}


}

// Each selected topic will display tags


$max=0;
$count=0;
$set = sizeof($temp);
$max = sizeof($temp)-1;

if (isset($_GET['page'])) { $count = $_GET['page'];}


            
while ($count <= $max && isset($temp[0])) {
 
 if ($count == 0) {
  echo '<h2 style="font-weight: bold;margin-bottom: 2em;">Select topic: #'.$temp[$count]['event_type'].'</h2>';
        for ($x=0; $x < sizeof($tempArray) ; $x++) { 
          if ($tempArray[$x]['event_type'] == $temp[$count]['event_type']) {

             $split = explode("/", $tempArray[$x]['itag']);

              for ($i=0; $i <sizeof($split) ; $i++) { 
                
                echo ' <a href="store-temp-tags.php?valName='.trim($split[$i]).'&page='.$count.'" class="btn btn-rose btn-round">'.trim($split[$i]).'</a> ';
              }

          }
       
        }
   
if ($count == $max) {
  echo ' <br><br><br> <a href="dashboard.php?"  class="btn radius-50 btn-default-transparent btn-sm">submit</a>';
 
}else{
       //button sends next value to this page to go to next phase
    echo  '
   <br><br><br><a href="set-up.php?page=1" style="display: inline-block;" class="btn radius-50 btn-default-transparent btn-sm">continue</a>';
}

 }else if($count > 0 && $count < $max){
   echo '<h2 style="font-weight: bold;margin-bottom: 2em;">Select topic: #'.$temp[$count]['event_type'].'</h2>';
        for ($x=0; $x < sizeof($tempArray) ; $x++) { 
          if ($tempArray[$x]['event_type'] == $temp[$count]['event_type']) {
            // if topic added does not have a tag name give option to add
            if (trim($tempArray[$x]['itag'])=="") {
            
              break;
            }

              $split = explode("/", $tempArray[$x]['itag']);

              for ($i=0; $i <sizeof($split) ; $i++) { 
                
                echo ' <a href="store-temp-tags.php?valName='.trim($split[$i]).'&page='.$count.'" class="btn btn-rose btn-round">'.trim($split[$i]).'</a> ';
              }

          }
       
        }
           //button sends next value to this page to go to next phase
          echo  '
   <br><br><br><a href="set-up.php?page='.--$count.'" style="display: inline-block;" class="btn radius-50 btn-default-transparent btn-sm">back</a>
';
if ($count == $max) {
   echo '<a href="dashboard.php" style="display: inline-block;margin-left:1em;" class="btn radius-50 btn-default-transparent btn-sm">submit</a>';
}else{
  ++$count; echo ' <a href="set-up.php?page='.++$count.'" style="display: inline-block;margin-left:1em;" class="btn radius-50 btn-default-transparent btn-sm">continue</a>';

        
}
}else if ($count == $max) {
   echo '<h2 style="font-weight: bold;margin-bottom: 2em;">Select topic: #'.$temp[$count]['event_type'].'</h2>';
        for ($x=0; $x < sizeof($tempArray) ; $x++) { 


          if ($tempArray[$x]['event_type'] == $temp[$count]['event_type']) {
            // if topic added does not have a tag name give option to add else show tag name
          
           if (trim($tempArray[$x]['itag'] =="")) {
              echo " add tag name for topic.... must be a is a relationship..fix add this later";
              
            }else{

              $split = explode("/", $tempArray[$x]['itag']);

              for ($i=0; $i <sizeof($split) ; $i++) { 
                
                echo ' <a href="store-temp-tags.php?valName='.trim($split[$i]).'&page='.$count.'" class="btn btn-rose btn-round">'.trim($split[$i]).'</a> ';
              }
            
            }
          }
       
        }
           //button sends next value to this page to go to next phase
          echo  '
   <br><br><br><a href="set-up.php?page='.--$count.'" style="display: inline-block;" class="btn radius-50 btn-default-transparent btn-sm">back</a>
';
 echo '<a href="dashboard.php?" style="margin-left:1em;" class="btn radius-50 btn-default-transparent btn-sm">submit</a>';
 
}
break;
}
    
              ?>
      
          
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

 
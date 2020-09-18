<?php 
/* DOCS

  * 
  * <general page>
  * hub.php --> server.php 
  *
  
*/
  // // local location
include 'local_distance.php';
  
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
    Hub
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
  <script src="../assets/js/local.js"></script>
  <script src="https://apis.google.com/js/api:client.js"></script>
  <script src="../assets/js/custom_js.js"></script>

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

<body class="profile-page sidebar-collapse">

<nav class="navbar navbar-expand-lg bg-primary">
    <div class="container">
        <div class="navbar-translate col-lg-4">

            <a class="navbar-brand" href="login-page.php">  <img src="../assets/img/logo.png" style="width: 30%; "></a>
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
                    <a href="login-page.php" class="nav-link">Login</a>
                </li>
                <li class="nav-item">
                    <a href="signup-page.php" class="nav-link">Signup</a>
                </li>
               
            </ul>
    
          
        </div>
    
    </div>
</nav>
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
 
    <!-- class"main main-rasied" -->
     <div class="tab-content tab-space cd-section">
          <div class="tab-pane active text-center gallery section section-sections">
           <div class="row">


          <?php



$dynamic_cordinates=array();
$static_cordinates =array();
$local_distance = array();
  if (isset($_COOKIE["dynamic_location"])) {

   $_SESSION["dynamic_location"] = $_COOKIE["dynamic_location"];
 }else if (empty($_COOKIE['dynamic_location'])) {
   // error
  // echo 'Cookie does not exists or is empty e_dynamic';
}


 if (isset($_SESSION["dynamic_location"])) {
   $dynamic_cordinates = explode("/",$_SESSION["dynamic_location"]);
   // echo 'user location: '.$dynamic_cordinates[0].' '.$dynamic_cordinates[1];
 }


   if (isset($_COOKIE["static_location0"])) {

   $_SESSION["static_location"] = $_COOKIE["static_location0"];
    
 }else if (empty($_COOKIE['static_location'])) {
   // error
  // echo 'Cookie does not exists or is empty e_static';
}


 if (isset($_SESSION["static_location"])) {
   $static_cordinates = explode("/",$_SESSION["static_location"]);
  // echo 'organization location: '.$static_cordinates[0].' '.$static_cordinates[1];
  for ($i=0; $i <$static_cordinates[2] ; $i++) { 

 
     $static_cordinates = explode("/",$_COOKIE["static_location".$i]);
    
     $bool = getDistance($dynamic_cordinates,$static_cordinates);
     
     if ($bool ==="yes") {
         // echo "string " .$static_cordinates[3];
          // echo 'local = '.$bool;
       array_push($local_distance,trim($static_cordinates[3]));
     }

  }
    
 }

   $db = pg_connect(getenv("DATABASE_URL"));

    // Check connection
    if (!$db) {
       die("Connection failed: " . pg_connect_error());
       header('location:oops.php');
    }

    $general_list = array();

     // selected organizations not saved as favorite by user (default mode)
                  /* selects all IDs of organization not linked to user_follow_organization
                  *   
                  *  and not deleted
                  */
                  $result = pg_query($db, "SELECT DISTINCT organization.date, organization.time, organization.fiatvalue,organization.img, organization.id as org_key, organization.views,organization.description,organization.publickey, organization.address,organization.views, organization.url
                  FROM organization WHERE date_submitted is not NULL AND date is not NULL AND date::timestamp >= NOW() ORDER BY organization.date, organization.views");

 
                  if (pg_num_rows($result) > 0) {
                  // output data of each row
                    while($row = pg_fetch_assoc($result)) {

      
      
                      $general_list[] = array("date" => $row["date"], "time" => $row["time"], "price"=> $row["fiatvalue"], "img" => $row["img"],"org_id" => $row["org_key"],"description" => $row["description"],"views" => $row["views"], "publickey" => trim($row['publickey']), "address" => $row["address"], "url" => $row["url"]);



                    }
                  
                  }else {

                  }

            pg_close($db);


if (isset($general_list)  ) {


  echo '<script type="text/javascript">
     


var dashboard_local_distance = '.json_encode($general_list, JSON_PRETTY_PRINT).';
var size = dashboard_local_distance.length; 
var count = 0;
console.log("dashboard_local_distance "+ dashboard_local_distance[0].address);

for (var i = dashboard_local_distance.length - 1; i >= 0; i--) {
 
   geolocation(dashboard_local_distance[i].address,dashboard_local_distance[i].publickey,size,count);
   count++;
  
}
   </script>';

 $key = array();

 
$key = array_column($general_list, 'publickey');
 
$key = array_intersect($key,$local_distance);

 
 
  // make content dynamic
  // shuffle($general_list);
                
    foreach($dashboard_list as $item) {
  
 
          if(in_array($item["publickey"], $key)) 

  { 

                           $cmd = $s3->getCommand('GetObject', [
                                        'Bucket' => ''.$bucket_name.'',
                                        'Key'    => ''.trim($item["img"]).'',
                            ]);

              $request = $s3->createPresignedRequest($cmd, '+20 minutes');

              $presignedUrl = (string)$request->getUri();
     
            
              echo '<div class="col-md-4">';

          
              echo '<div class="contain">';

           
                $splitFileString = strtok(trim($item["img"]), '.' );
                $fileChecker = strtok('');
                $fileChecker = strtoupper($fileChecker);

 

          if($presignedUrl && strlen(trim($item["img"]))>10 && ($fileChecker=='JPG' || $fileChecker=='JPEG' || $fileChecker=='PNG' || $fileChecker=='MOV')){
                 echo  '<img src="'.$presignedUrl.'" class="img rounded" onload="myFunction('.$presignedUrl.')">'; 
              }else{
                 echo  '<img src="../assets/img/image_placeholder.jpg" class="img rounded">';
              } 
 
              
                

                  if (trim($item['price']) =='0.00' || $item["price"]==NULL || $item["price"]==" ") {

                        echo '<div class="top-right h9"> 
                        <a href='.$item['url'].'><i class="material-icons">strikethrough_s</i></a></div>';

                        }else{

                  echo '<a href='.$item['url'].'><div class="top-right h6">$'.trim($item['price']).'</a></div>';
                  
                  }


                  echo '<div class="top-left h6" style="width:10px;">'
                       .toString($item['date']).'</div>';

                  echo '<div class="centeredm h4">'.trim($item['description']).'</div>';


                  echo '<div class="bottom-left" style="font-weight: bolder;">
                        <a href="login-page.php">
                        <i class="material-icons" style="font-size:18pt;">bookmark_border</i></a></div>';

                  // echo '<div class="centered" style="font-weight: bolder;">
                  // <a href="#fav"><i class="material-icons" style="font-size:18pt">favorite_border</i></a></div>';

                 
                  echo '<div class="bottom-right" style="font-weight: bolder;">
                         <a href="login-page.php"><i class="material-icons" style="font-size:18pt;">add_shopping_cart</i></a></div>';
 



                echo '</div>';
              
          
              
            echo '</div>';
          }else{
            // not local
          }
          
 
        
    } 



                  } 

          ?>
            
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
  </div>
 
  <script src="../assets/js/core/jquery.min.js" type="text/javascript"></script>
  <script src="../assets/js/core/popper.min.js" type="text/javascript"></script>
  <script src="../assets/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
  <script src="../assets/js/plugins/moment.min.js"></script>
  <!--	Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker -->
  <script src="../assets/js/plugins/bootstrap-datetimepicker.js" type="text/javascript"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="../assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
  <!--  Google Maps Plugin    -->
  <!-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> -->
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
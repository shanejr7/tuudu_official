// converts php organization address to json

<script type="text/javascript">
  
var dashboard_local_distance = <?php echo json_encode($dashboard_list, JSON_PRETTY_PRINT) ?>;
var size = dashboard_local_distance.length; 
var count = 0;

for (var i = dashboard_local_distance.length - 1; i >= 0; i--) {
   geolocation(dashboard_local_distance[i].address,dashboard_local_distance[i].publickey,size,count);
   count++;
  
}


 </script> 
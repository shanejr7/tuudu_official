// timezone for user
      $(document).ready(function () { 
      var timezone = new Date();
      document.getElementById("timezone").value = timezone; 
      
      }); 


//           $(document).ready(function () { 

//     if (navigator.geolocation) {
//         navigator.geolocation.getCurrentPosition(showPosition);

//         function showPosition(position) {

//         	  document.getElementById("lat").value =  position.coords.latitude; 
//         	  document.getElementById("lng").value = position.coords.longitude; 
   
//     }

      
//     } else { 
//       console.log("Geolocation is not supported by this browser.");
//     }

     
// }); 

 
 $("#sched").on('click', function() {
    
    document.getElementById("topics").style.visibility = "hidden";

 });

  $("#dash").on('click', function() {
    document.getElementById("topics").style.visibility = "visible";

    });
    $("#lis").on('click', function() {
      document.getElementById("topics").style.visibility = "visible";

    });

 $("a").on('click', function() {

    
    history.replaceState(null, null, ' ');
  
     $('#tabTrack li').each(function() {
      $(this).removeClass('active');
    });

});



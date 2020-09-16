 // Creating a cookie after the document is ready 

    $(document).ready(function () { 

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
        function showPosition(position) {

        createCookie("dynamic_location",1, position.coords.latitude,position.coords.longitude, "30","n/a"); 
        console.log(position.coords.latitude +' '+position.coords.longitude);
    }

      
    } else { 
      console.log("Geolocation is not supported by this browser.");
    }

     
}); 


 // organization geocode data 
    // $(document).ready(function () { 


//       var address = "<?php echo $organization_address ?>"; 
// var address = "107 E Michigan Ave apt #304";    
// // loop through and return bool in php

// geolocation(address);

 function geolocation(address,publickey,size,count){

     address = address.trim();
     publickey = publickey.trim();

    for (var i = address.length - 1; i >= 0; i--) {
      address = address.replace(/[&\/\\#,()$~%.'":*?<>{}]/g, "");
      address = address.replace(" ", "+");
    }


// console.log('address ' + address);

    $.ajax({
        url: "https://maps.googleapis.com/maps/api/geocode/json?address="+address+"&key=AIzaSyBrLsD0gljC6jh4YKY9lGg6Sx6Zc7BowbY",
        type: "GET",
        dataType: "json",
        async: true,
        success: function (data) {
            // console.log('geo'+data.results[0].geometry.location);
            createCookie("static_location"+count,size,
            	data.results[0].geometry.location.lat,data.results[0].geometry.location.lng,
            	 "1",publickey); 
             console.log("static_location"+document.cookie);

        }
    });
 }

// });



    // Function to create the cookie 
    function createCookie(name,size, latitude,longitude, minutes,publickey) { 
 
 
      var expires; 
      
       if (minutes) { 
        var date = new Date(); 
        date.setTime(date.getTime() + (30 * 60 * 1000)); 
        expires = "; expires=" + date.toTimeString(); 
       } 
       else { 
        expires = ""; 
        } 
      
         document.cookie = escape(name) + "=" + escape(latitude)+ "/"
          + escape(longitude)+"/"+ escape(size)+"/"+ escape(publickey) + expires + "; path=/"; 
        
        console.log(expires);
        console.log(document.cookie); 


    } 
   

   function delete_cookie( name ) {
  document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

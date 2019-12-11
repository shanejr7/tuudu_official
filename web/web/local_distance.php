<?php 
// provides local distance between users and organization 

function getDistance(array $location1, array $location2, $precision =0, $useMiles = true){
	// earth's radius in miles
	$radius = $useMiles ? 3955.00465 : 6364.963;
	// convert latitude from degrees to radians
	$lat1 = deg2rad($location1[0]);
	$lat2 = deg2rad($location2[0]);
	// get the difference bewteen longitudes and convert to radius
	$long = deg2rad($location2[1] - $location1[1]);
	// calculate the distance
	$distance = round(acos(sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($long)) * $radius, $precision);

	if ($distance <=34) {
		return "yes";
	}else{
		return "no ";
	}
 return 0;
} 

 
?>
<script type="text/javascript"></script>

 
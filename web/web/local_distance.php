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
	return round(acos(sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($long)) * $radius, $precision);

} 

// user & entitys location 
/*could be more than one entity ..array storage*/
$ny = [40.758895,-73.9873197];
$la = [33.914329,-118.2849236];

echo getDistance($ny,$la). ' miles';
?>
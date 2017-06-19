<?php
// Pre-parse forecast cache file.
function parse_cache($timeFrame=''){
  // Get json string
  $string = file_get_contents("http://localhost/bourbon-wp/wp-content/plugins/sc-dark-weather/forecast.json");

  // Convert to array
  $array = json_decode($string, true);

  // If $timeFrame is specified
  if ($timeFrame != ''){
    $array = $array[$timeFrame];
  } else {
    $array = $array;
  }

  return $array;
}

// Output cache data
function output_cache($timeFrame, $key){

  if($timeFrame == "currently"){
    $timeFrame = parse_cache( 'currently' );
  } else if ($timeFrame == "hourly"){
    $timeFrame = parse_cache( 'hourly' );
  } else if ($timeFrame == "daily"){
    $timeFrame = parse_cache( 'daily' );
  } else if ($timeFrame == ""){
    $timeFrame = parse_cache( '' );
  }

  return $timeFrame[$key];
}

// get address
function google_apis_address( $lat, $long )
{
  $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&sensor=false";

  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_HEADER, false);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_ENCODING, "");
  $curlData = curl_exec($curl);
  curl_close($curl);

  $address = json_decode($curlData);

  $obj = $address->results;
  $obj = $obj[0]->address_components;
  $locale = $obj[1];
  $locale = $locale->long_name;
  $region = $obj[3];
  $region = $region->short_name;
  $country = $obj[4];
  $country = $country->long_name;

  $address = $locale . ', ' . $region . ', ' . $country;

  return $address;
}


//$sc_offset = parse_cache()['offset'];
$sc_tz = parse_cache()['timezone'];

$sc_update_time = output_cache('currently', 'time');
$lat = parse_cache()['latitude'];
$long = parse_cache()['longitude'];
$sc_location = google_apis_address( $lat, $long );
$sc_updated_last = date( "H:i()", $sc_update_time );

date_default_timezone_set($sc_tz); // your user's timezone
$sc_updated_last = date( "H:i", $sc_update_time );

echo date('Y-m-d H:i:s', strtotime("$sc_updated_last"));


//echo "updated: " . $sc_updated_last;

<?php
 $geocode = file_get_contents('https://maps.googleapis.com/maps/api/place/textsearch/json?query=spotsoon&key=AIzaSyDrzFiJ5JJoenQOj-c6TPqVE8zHJDDZlHU');
 var_dump($geocode);
  $output = json_decode($geocode);
  var_dump($output);
  echo $output->results[0]->place_id;
 //echo $output['results'][0]['place_id'];
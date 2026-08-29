<?php 

require('config.php');

$curl = curl_init();

curl_setopt_array(
    $curl, 
    [
        CURLOPT_URL => "https://api.themoviedb.org/3/movie/11?language=en-US",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer ".TMDB_TOKEN,
            "accept: application/json"
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {

  //docode JSON to object
  $data = json_decode($response);

  echo "1. Decode JSON to object"."<br>";

  $title_object = $data->title;
  $adult_object = $data->adult;

  echo "Title: ".$title_object;

  if($adult_object == false) echo "<br>"."adult = false"."<br>";
  else echo $adult_object;

  //docode JSON to array
  $data_array =json_decode($response, true);

  echo "2. Decode JSON to array"."<br>";

  $title_array = $data_array['title'];
  $adult_array = $data_array['adult'];

  echo "Title: ".$title_array;

  if($adult_array == false) echo "<br>"."adult = false"."<br>";
  else echo $adult_array;


  // echo genres from movie 11 - foreach
  echo "3. Genres"."<br>";
  //print_r($data_array['genres']);
  foreach($data_array['genres'] as $gatunek){
    echo "genre id: ". $gatunek['id']. " ". "genre name: " .$gatunek['name']."<br>";
  }

}
?>
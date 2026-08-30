<?php 

require('config.php');
require_once 'Movie.php';
require_once 'TmdbClient.php';
require_once 'Database.php';

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

  //new object, we need deliver fields
  $movie = new Movie("Czas Honoru", 8.2, "2011-2024", ["Wojenny", "Romans"]);

  echo $movie->getTitle()."</br>";
  echo $movie->getRating()."</br>";
  echo $movie->getReleaseDate()."</br>";
  print_r($movie->getGenres());
  echo "<br><br>";


  //our main target for now - using object based on Movie class but created via TmdbClient class
  echo "--------------------------------------"."<br>";
  echo "NEW MOVIE OBJECT BUT CREATED BY TMDB CLASS"."<br><br>";
  //new object based on Tmdb class, we send him token, our Constans, token needed to connect with REST API, curl
  $tmdb_client = new TmdbClient(TMDB_TOKEN);
  //we need new object based on Movie class and exaxtly getMovie method from TmdbClient returns new object based on Movie class,
  //so we need that, we need to deliver int to getMovie method, to get fields from only one movie
  //tmdb returns object based on Movie class, so we can use her methods
  //movie_name is our new object based on Movie class. 
  // This object uses some fields exactly 11-th movie form tmdb (Movie class has constructor method)
  $movie_name = $tmdb_client->getMovie(11);
  //if we have new Movie object, we can finally use her methods ;)
  //below not comments needed :)
  echo $movie_name->getTitle()."<br>";
  echo $movie_name->getRating()."<br>";
  echo $movie_name->getReleaseDate()."<br>";
  print_r($movie_name->getGenres());
  echo "<br><br>";
  echo "--------------------------------------"."<br>";

  $db = new Database($dsn, $user, $password, $options);
  $pdo_con = $db->getConnection();

}
?>
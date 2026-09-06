<?php 

require('config.php');
require_once 'Movie.php';
require_once 'TmdbClient.php';
require_once 'Database.php';


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
//Database->PDO pdo is private, so if we want use it, we need method 
$pdo_con = $db->getConnection();

//insert first movie to movies table
$stmt = $pdo_con->prepare("INSERT INTO movies (tmdb_id, title, rating, release_date, genres) VALUES(:tmdb_id, :title, :rating, :release_date, :genres)");
$stmt->execute(
  [
    ':tmdb_id' => 11,
    ':title' => $movie_name->getTitle(),
    ':rating' => $movie_name->getRating(),
    ':release_date' => $movie_name->getReleaseDate(),
    ':genres' => json_encode($movie_name->getGenres())
  ]
);
?>
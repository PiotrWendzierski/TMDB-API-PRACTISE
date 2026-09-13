<?php

require(__DIR__.'/../config/config.php');
require_once __DIR__.'/../src/TmdbClient.php';
require_once __DIR__.'/../src/Movie.php';
require_once __DIR__.'/../src/Database.php';
require_once __DIR__.'/../src/MovieRepositoryInterface.php';
require_once __DIR__.'/../src/PdoMovieRepository.php';

header('Content-Type: application/json');

//if request is POST method
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //get raw body
    $json = file_get_contents('php://input');
    //decode JSON as array
    $data = json_decode($json, true);

    if(isset($data['tmdb_id'])) $movie_id= $data['tmdb_id'];

    //if there is no tmdb_id in payload
    if(!isset($movie_id)){
        //set status 400
        http_response_code(400);
        //echo message
        echo json_encode(['message' => 'No tmdb_id!']);
    }
    else{
        //new TmdbClient object
        $tmdb = new TmdbClient(TMDB_TOKEN);
        //getMovie returns new Movie object
        $movie = $tmdb->getMovie($movie_id);
        //new Database object
        $db = new Database($dsn, $user, $password, $options);
        //return pdo connection
        $pdo = $db->getConnection();
        //PdoMovieRepository object
        $repo = new PdoMovieRepository($pdo);
        //save movie from payload to db
        try{
            $repo->save($movie);
            //set status 201 (new created)
            http_response_code(201);
            //return response as array converted to JSON
            echo json_encode([
                'status' => 'ok',
                'movie_name' => $movie->getTitle()
            ]);
        }
        catch (PDOException $e){
            //set status 201 (new created)
            http_response_code(409);            
            echo json_encode([
                'status' => 'no, duplicate',
                'movie_name' => $movie->getTitle()
            ]);
        }
    }
}

?>
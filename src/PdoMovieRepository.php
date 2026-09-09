<?php

class PdoMovieRepository implements MovieRepositoryInterface{
    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function save(Movie $movie_name):void{

        $id = $movie_name->getTmdbId();

        try{
            $stmt = $this->pdo->prepare("INSERT INTO movies (tmdb_id, title, rating, release_date, genres) VALUES(:tmdb_id, :title, :rating, :release_date, :genres)");
            $stmt->execute(
                [
                ':tmdb_id' => $id,
                ':title' => $movie_name->getTitle(),
                ':rating' => $movie_name->getRating(),
                ':release_date' => $movie_name->getReleaseDate(),
                ':genres' => json_encode($movie_name->getGenres())
                ]
            );
        }
        catch(PDOException $e){
            if($e->getCode() == "23000") echo "This movie: ".$id. " alreade exists in database";
            else throw $e;
        }

    }

    public function findAll(): array{
        $rows = $this->pdo->query("SELECT * FROM movies")->fetchAll();
        //our array with Movie objects
        $movies = [];
        foreach($rows as $row){
            $movie = new Movie(
                (int)$row['tmdb_id'],
                (string)$row['title'],
                (float)$row['rating'],
                (string)$row['release_date'],
                //genres is JSON in db
                json_decode($row['genres'], true)
            );

            $movies[] = $movie;
        }
        //returns array with Movies objects based on db
        return $movies;
    } 
}
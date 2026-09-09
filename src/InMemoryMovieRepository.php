<?php

//second class which implements MovieRepositoryInterface
class InMemoryMovieRepository implements MovieRepositoryInterface{

    //property of this class - array
    //php 8 -> typing variables
    private array $movies = [];

    //we have to deliver Movie object
    public function save(Movie $movie): void{
        //single Movie object ($movie) fits movies[] property ($this->movies[])
        $this->movies[] = $movie;
    }
    public function findAll(): array{
        //return what we have got in PROPERTY of this class (array $movies = []) (NOT GLOBAL VARIABLE)
        return $this->movies;
    }
}
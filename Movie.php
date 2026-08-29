<?php

class Movie{

    //php 8 -> typing variables, properties private, only if you ask for them, not allowed changing
    private string $title;
    private float $rating;
    private string $releaseDate;
    private array $genres;

    public function __construct(string $title, float $rating, string $releaseDate, array $genres){
        $this->title = $title;
        $this->rating = $rating;
        $this->releaseDate = $releaseDate;
        $this->genres = $genres;
    }

    //main public methods
    public function getTitle(): string{
        return $this->title;
    }

    public function getRating(): float{
        return $this->rating;
    }

    public function getReleaseDate(): string{
        return $this->releaseDate;
    }

    public function getGenres(): array{
        return $this->genres;
    }
}
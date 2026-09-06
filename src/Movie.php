<?php

class Movie{

    //php 8 -> typing variables, properties private, only if you ask for them, not allowed changing
    private int $tmdb_id;
    private string $title;
    private float $rating;
    private string $releaseDate;
    private array $genres;

    public function __construct(int $tmdb_id, string $title, float $rating, string $releaseDate, array $genres){
        $this->tmdb_id = $tmdb_id;
        $this->title = $title;
        $this->rating = $rating;
        $this->releaseDate = $releaseDate;
        $this->genres = $genres;
    }

    //main public methods, writes fields from delivered fields (it it constructor)
    public function getTmdbId(): int{
        return $this->tmdb_id;
    }

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
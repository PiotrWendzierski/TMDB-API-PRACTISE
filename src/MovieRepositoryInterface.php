<?php 

interface MovieRepositoryInterface{
    public function save(Movie $movie): void;
    public function findAll(): array;
}
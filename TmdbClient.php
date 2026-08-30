<?php

require_once 'config.php';

class TmdbClient{

    //php 8 -> typing variables
    private string $token;

    //get token Dependency Injection, thanks to __construct, you can use many tokens in one project.
    //Thanks to constructor, you can this class in other projects too.
    public function __construct(string $token){
        $this->token = $token;
    }

    //curl + return new object based od Movie class, after ,,:" we write what will be returned
    public function getMovie(int $id): Movie{
        //curl, 1. curl init, pasted from TMDB API documentation
        $curl = curl_init();
        // 2. curl_set_opt
        curl_setopt_array(
            $curl, 
            [
                CURLOPT_URL => "https://api.themoviedb.org/3/movie/".$id."?language=en-US",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer ".$this->token,
                    "accept: application/json"
            ],
        ]);

        //curl_exec saved to $response
        $response = curl_exec($curl);

        //if error, save in $error
        $err = curl_error($curl);

        //curl_close
        curl_close($curl);


        //if any error occurs, for example bad token
        if ($err) {
            echo "cURL Error #:" . $err;
        //return new Movie object
        } else {
            //docode JSON to array
            $data_array =json_decode($response, true);

            //get properties from array (from array created from json)
            //we need them to deliver to constructor for object created from Movie class
            $name = $data_array['title'];
            $rating = $data_array['vote_average'];
            $release_date = $data_array['release_date'];
            $genres = $data_array['genres'];
            //return new Movie class object
            return new Movie($name, $rating, $release_date, $genres);
        }
    }
}
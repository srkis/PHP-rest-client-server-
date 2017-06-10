<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/rest/server/config/config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/rest/server/javascript_helper.php");

class Server extends Backend

{


    public function get($id = NULL, $limit = NULL)

    {


        $headers = getallheaders();


      if(isset($headers['Authorization'])){


             list($client_licence) = explode(":", base64_decode(str_ireplace("Basic", "", $headers['Authorization'])));

             $this->_licence_auth($client_licence);

            if(isset($_GET['id']) && $_GET['id'] !== NULL){

                $movie_id = $_GET['id'];

                $data = array();

                $getMovies = $this->product->getSingleProduct($movie_id);
                {

                    while ($movies = $getMovies->fetch_object())
                    {
                        $data['movies'][] = $movies;
                    }

                     parse_json($data);


                }

            }else if(isset($_GET['limit']) && $_GET['limit'] !== NULL){

                $limit = $_GET['limit'];


                $data = array();

                $getMovies = $this->product->getLimitProduct($limit);
                {

                    while ($movies = $getMovies->fetch_object())
                    {
                        $data['movies'][] = $movies;
                    }

                    parse_json($data);


                }

            }else{

                $getMovies = $this->product->getMovies();

                $data = array();

                while ($movies = $getMovies->fetch_object())
                {
                    $data['movies'][] = $movies;
                }

                parse_json($data);


            }



      }

    }





}

$server = new Server();
$server->get();

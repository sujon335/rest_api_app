<?php

class Qa extends CI_Controller {

    function index() {
        if (isset($_GET['q'])) {

            $data = array();
            $q = $_GET['q'];
            $question = urlencode($q);
            $data = json_decode(file_get_contents("http://quepy.machinalis.com/engine/get_query?question=$question"));

            $sparqlQuery = $data->queries[0]->query;

            $sparqlQuery = substr($sparqlQuery, strpos($sparqlQuery, 'SELECT'), strpos($sparqlQuery, '}'));



            $sparqlQuery = urlencode($sparqlQuery);

            $data = json_decode(file_get_contents("http://dbpedia.org/sparql?query=$sparqlQuery&format=json"));

            $xxx = $data->head->vars[0];
            $array = $data->results->bindings;

            $a = "xml:lang";


            for ($i = 0; $i < sizeof($array); $i++) {
                $temp = $array["$i"]->$xxx->$a;
                if ($temp == "en")
                    echo $array["$i"]->$xxx->value;
                echo "  ";
            }
        }
        else {
            echo show_404();
        }
    }

}

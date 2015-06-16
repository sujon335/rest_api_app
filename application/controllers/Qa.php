<?php

class Qa extends CI_Controller {

    function index() {
        if (isset($_GET['q'])) {

            $da= array();
            $q = $_GET['q'];
            $question = urlencode($q);
            $data = json_decode(file_get_contents("http://quepy.machinalis.com/engine/get_query?question=$question"));

            $sparqlQuery = $data->queries[0]->query;

            $sparqlQuery = substr($sparqlQuery, strpos($sparqlQuery, 'SELECT'), strpos($sparqlQuery, '}'));



            $sparqlQuery = urlencode($sparqlQuery);

            $data = json_decode(file_get_contents("http://dbpedia.org/sparql?query=$sparqlQuery&format=json"));

            $xxx = $data->head->vars[0];
            $array = $data->results->bindings;

            if(sizeof($array)==0)
            {
                header('Content-Type: application/json');
                echo '{"answer":"Your majesty! Jon Snow knows nothing! So do I!"}';
                //$da['answer']='Your majesty! Jon Snow knows nothing! So do I!';
                return;
            }
            
            $type=$array[0]->$xxx->type;
            if($type=="typed-literal")
            {
                $da['answer']=$array[0]->$xxx->value;
            }
            else if($type=="literal")
            {
                $a = "xml:lang";



                    for ($i = 0; $i < sizeof($array); $i++) {
                        $temp = $array["$i"]->$xxx->$a;
                        if ($temp == "en")
                        {
                            $da['answer']=$array["$i"]->$xxx->value;
                            break;
                        }

                    }
            }

            $result=json_encode($da);
            echo $result;
        }
        else {
            echo show_404();
        }
    }

}

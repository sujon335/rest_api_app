<?php

class Weather extends CI_Controller {

    function index() {
        if (($_GET['q'])) {

            $data = array();
            $q = $_GET['q'];

        $ww = json_decode(
            file_get_contents('http://api.openweathermap.org/data/2.5/weather?q=chittagong')
        );

        $data['answer']=$ww->weather;

            $result = json_encode($data);
            echo $result;
        } else {
            echo show_404();
        }
    }

}
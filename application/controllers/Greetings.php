<?php

class Greetings extends CI_Controller {

    function index() {
        if (isset($_GET['q'])) {

            $data = array();
            $q = $_GET['q'];

            if ((strpos($q, 'Hi!') !== false) || (strpos($q, 'Hello') !== false) || (strpos($q, 'Good morning!') !== false) || (strpos($q, 'Good evening!') !== false) || (strpos($q, 'Good night!') !== false)) {

                $data['answer'] = 'Hello, Kitty! I am busy with screening test';
            } else {
                $data['answer'] = 'Invalid Question';
            }
            $result = json_encode($data);
            echo $result;
        } else {
            echo show_404();
        }
    }

}
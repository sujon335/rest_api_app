<?php

require(APPPATH . '/libraries/REST_Controller.php');

class Greetings extends REST_Controller {

    function answer_get() {
        $data = array();
        if (!$this->get('q')) {
            $this->response(NULL, 400);
        }

        $q = urldecode($this->get('q'));

        if ((strpos($q, 'Hi!') !== false) || (strpos($q, 'Hello!') !== false) || (strpos($q, 'Good morning!') !== false)||(strpos($q, 'Good evening!') !== false)||(strpos($q, 'Good night!') !== false)) {

            $data['status'] = 'Hello, Kitty! I am busy with screening test';
        } else {
            $data['status'] = 'Invalid Question';
        }
        $this->response($data);
    }

}
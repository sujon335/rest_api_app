<?php

class Qa extends CI_Controller {

    function index() {
            $data=array();
            $data['answer']="Your majesty! Jon Snow knows nothing! So do I!";

            $result = json_encode($data);
            echo $result;
    }
    
}

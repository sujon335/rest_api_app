<?php

require(APPPATH . '/libraries/REST_Controller.php');

class Rest_app extends REST_Controller {

    function index() {
        $this->response(array('name' => 'magi'));
    }

    function user_get() {
        if (!$this->get('id')) {
            $this->response(NULL, 400);
        }

        $this->db->where('employee_id', $this->get('id'));
        $q = $this->db->get('employees');
        $data = array();
        if ($q->num_rows()) {
            $data['status'] = 'success';
            $data['data'] = $q->result();
        } else {
            $data['status'] = 'failed';
        }
        $this->response($data);
    }

}


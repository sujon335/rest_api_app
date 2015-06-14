<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Rest_api extends REST_Controller
{
    function user_get()
    {
        if(!$this->get('id'))
        {
            $this->response(NULL, 400);
        }

        $this->db->where('employee_id',$this->get('id'));
        $query=$this->db->get('employees');
        $user = $query->result();
        if($user)
        {
            $this->response($user, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(NULL, 404);
        }
    }

}

?>
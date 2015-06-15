<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {


	public function index()
	{
		echo "heloo welcome";
		echo '<br/>';
		$query=$this->db->get('employees');
		foreach($query->result() as $row )
		{

                        echo $row->employee_id;
                        echo " ";
			echo $row->first_name;
			echo " ";
		}
		$this->load->view('welcome_message');
	}
}

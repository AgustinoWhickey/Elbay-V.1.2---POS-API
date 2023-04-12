<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Login extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
    }

    public function index_post()
	{
		$aksi = $this->login_model->ceklogin($this->post('email'));
        if(password_verify( $this->post('password'),$aksi[0]["password"])){
			$data = [
				'id' => $aksi[0]['id'],
				'email' => $aksi[0]['email'],
				'role' => $aksi[0]['role_id'],
				'logged_in' => TRUE
			];
			$this->session->userdata = $data;
			$this->response( [
                'status' => true,
                'data' => $data
            ], RestController::HTTP_OK );
		} else {
			$this->response( [
                'status' => false,
                'message' => 'Data not found!'
            ], RestController::HTTP_NOT_FOUND );
		}
    }

    public function index_get()
	{
        $ci = get_instance();
		if(!$ci->session->userdata('email')){
			$this->response( [
                'status' => true,
                'data' => 'Logged In'
            ], RestController::HTTP_OK );
		} else{
			$this->response( [
                'status' => false,
                'message' => 'Logged Out'
            ], RestController::HTTP_NOT_FOUND );
		}
	
	}
}

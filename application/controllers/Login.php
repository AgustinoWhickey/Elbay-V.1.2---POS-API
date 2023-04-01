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

    // public function index()
    // {
	// 	if(isset($_SESSION['logged_in'])){
	// 		redirect('home');
	// 	} else {
	// 		$this->load->view("login");
	// 	}
    // }

    public function index_post()
	{
		$aksi = $this->login_model->ceklogin($_POST['email']);
        if(password_verify($_POST['password'],$aksi[0]["password"])){
			$data = [
				'id' => $aksi[0]['id'],
				'email' => $aksi[0]['email'],
				'role' => $aksi[0]['role_id'],
				'logged_in' => TRUE
			];
			$this->session->set_userdata($data);
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

    public function logout()
    {
        unset($_SESSION);
		$this->session->sess_destroy();
		redirect('login');	
    }
}

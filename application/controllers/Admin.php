<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Admin extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("admin_model");
        $this->load->model("login_model");
    }

    public function index_get()
	{
        $status = $this->get('status');
        $detail['sales'] = $this->admin_model->detailSales($status);
        $detail['user'] = $this->login_model->ceklogin($this->get('email'));

		if($detail){
			$this->response( [
                'status' => true,
                'data' => $detail
            ], RestController::HTTP_OK );
		} else{
			$this->response( [
                'status' => false,
                'message' => 'Data not found!'
            ], RestController::HTTP_NOT_FOUND );
		}
	
	}
}

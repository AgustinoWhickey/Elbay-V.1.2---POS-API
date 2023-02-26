<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Maindashboard extends CI_Controller
{

    public function index()
    {
        if($_SESSION['role']=='Admin'){
			redirect('dashboard/users');
		} else {
			redirect('dashboard/transaksipeminjaman');
		}
    }

}

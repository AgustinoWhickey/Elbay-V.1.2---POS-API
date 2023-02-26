<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("user_model","user");
        $this->load->model("masterbuku_model","masterbuku");
        $this->load->model("transaksipeminjaman_model","transaksi");
        $this->load->model("laporanpeminjaman_model","laporan");
        $this->load->library('form_validation');
		$this->load->library("Nusoap_lib");
		$this->nusoap_server = new soap_server();
		$this->nusoap_server->configureWSDL('nusoap_server','urn:nusoap_server');
    }

    public function users() {
        $data["users"] = $this->user->getUsers();
        $this->load->view("admin/users/list", $data);
    } 

    public function adduser() {
        $this->load->view("admin/users/new_form");
    }
	
	public function insertuser() {
		$password = password_hash($_POST['password'],PASSWORD_DEFAULT);
		$data = array(
            'password' => $password,
            'nama_user' => $_POST['username'],
            'role' => $_POST['role'],
        );
        $aksi = $this->user->insertuser($data);
		echo $aksi;
    }
	
	public function deleteuser() {
        $aksi = $this->user->deleteuser($_POST['iduser']);
		echo $aksi;
    }
	
	public function updateuser() {
        $aksi = $this->user->updateuser($_POST);
		echo $aksi;
    }

    public function edit($id) {
        $data["user"] = $this->user->getUser($id);
        
        $this->load->view("admin/users/edit_form", $data);
    }
	
	public function masterbuku() {
        $data["bukus"] = $this->masterbuku->getBukus();
        $this->load->view("admin/masterbuku/list", $data);
    }
	
	public function addmasterbuku() {
        $this->load->view("admin/masterbuku/new_form");
    }
	
	public function insertmasterbuku() {
		$data = array(
            'judul_buku' => $_POST['judulbuku'],
            'pengarang' => $_POST['pengarang'],
            'jenis_buku' => $_POST['jenisbuku'],
            'harga_sewa_perhari' => $_POST['hargasewa']
        );
        $aksi = $this->masterbuku->insertmasterbuku($data);
		echo $aksi;
    }
	
	public function deletemasterbuku() {
        $aksi = $this->masterbuku->deletemasterbuku($_POST['idbuku']);
		echo $aksi;
    }
	
	public function editmasterbuku($id) {
        $data["buku"] = $this->masterbuku->getBuku($id);
        
        $this->load->view("admin/masterbuku/edit_form", $data);
    }
	
	public function getmasterbuku() {
        $aksi = $this->masterbuku->getBuku($_POST['idbuku']);
		
		echo json_encode($aksi);
    }
	
	public function updatemasterbuku() {
        $aksi = $this->masterbuku->updatemasterbuku($_POST);
		echo $aksi;
    }
	
	public function transaksipeminjaman() {
        $data["transaksis"] = $this->transaksi->getUserTrans($_SESSION['id']);
        $this->load->view("admin/transaksi/list", $data);
    }
	
	public function addtransaksi() {
		
		$data["bukus"] = $this->masterbuku->getBukus();
        $this->load->view("admin/transaksi/new_form",$data);
    }
	
	public function inserttransaksi() {
		$tglmulai = date('Y-m-d', strtotime($_POST['tglmulai']));
		$tglselesai = date('Y-m-d', strtotime($_POST['tglselesai']));
		
		$mulai = new DateTime($_POST['tglmulai']); 
		$selesai = new DateTime($_POST['tglselesai']);
		$difference = $mulai->diff($selesai);
		
		$xml_array['intA'] = (int)$difference->d;
		$xml_array['intB'] = (int)$_POST['hargasewa'];
		$client = new SoapClient('http://www.dneonline.com/calculator.asmx?WSDL','wsdl');
		$response = $client->call('Multiply',$xml_array);
		
		$data = array(
            'id_user' => $_SESSION['id'],
            'id_book' => $_POST['idbuku'],
            'tgl_pinjam' => $tglmulai,
            'tgl_selesai' => $tglselesai,
            'jml_hari_sewa' => $difference->d,
            'total_sewa' => $response['MultiplyResult']
        );
        $aksi = $this->transaksi->inserttransaksi($data);
		echo $aksi;
		
    }
	
	public function deletetransaksi() {
        $aksi = $this->transaksi->deletetransaksi($_POST['idtrans']);
		echo $aksi;
    }
	
	public function edittransaksi($id) {
        $data["transaksi"] = $this->transaksi->getTrans($id);
		$data["bukus"] = $this->masterbuku->getBukus();
        
        $this->load->view("admin/transaksi/edit_form", $data);
    }
	
	public function updatetransaksi() {
        $aksi = $this->transaksi->updatetransaksi($_POST);
		echo $aksi;
    }
	
	public function laporanpeminjaman() {
		if($_SESSION['role']=='Admin'){
			$data["laporans"] = $this->laporan->getLaporanAdmin();
        }else{
			$data["laporans"] = $this->laporan->getLaporanPenyewa($_SESSION['id']);
		}
		$this->load->view("admin/laporan/list", $data);
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Kandang_pintar_model'); // load model di constructor
    }

    public function index() {
        $this->load->helper('url');
        $this->load->model('Kandang_pintar_model');
        $data['suhu'] = [
            "status" => true,
            "message" => "Suhu Berhasil Ditemukan",
            "data" => $this->Kandang_pintar_model->getSuhu()
        ];
        $this->load->view('suhu/dashboard', $data);
    }

    public function get_realtime()
    {
        $this->load->helper('url');
        $this->load->model('Kandang_pintar_model');
        $result = [
            "status" => true,
            "data" => $this->Kandang_pintar_model->getSuhu()
        ];
        echo json_encode($result);
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Kandang_pintar extends RestController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Kandang_pintar_model'); // load model di constructor
    }

    // GET /api/banner
    public function suhu_get() {
        try {
            $suhu = $this->Kandang_pintar_model->getSuhu();

            // IF suhu not found
            if (empty($suhu)) {
                $this->response([
                    'status'  => FALSE,
                    'message' => 'Suhu Tidak Ditemukan',
                    'data'    => []
                ], RestController::HTTP_NOT_FOUND);
                return;
            } else {
                $this->response([
                    'status'  => TRUE,
                    'message' => 'Suhu Berhasil Ditemukan',
                    'data'    => $suhu
                ], RestController::HTTP_OK);
            }
        } catch (\Throwable $th) {
            $this->response([
                'status'     => FALSE,
                'message'    => 'Error retrieving suhu: ' . $th->getMessage()
            ], RestController::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // POST /api/suhu
    public function suhu_post($suhu) {
        try {

            if ($suhu === NULL) {
                $this->response([
                    'status'  => FALSE,
                    'message' => 'suhu is required'
                ], RestController::HTTP_BAD_REQUEST);
                return;
            }

            $inserted = $this->Kandang_pintar_model->insertSuhu($suhu);

            if ($inserted) {
                $this->response([
                    'status'  => TRUE,
                    'message' => 'Suhu berhasil ditambahkan'
                ], RestController::HTTP_CREATED);
            } else {
                $this->response([
                    'status'  => FALSE,
                    'message' => 'Failed to add suhu'
                ], RestController::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (\Throwable $th) {
            $this->response([
                'status'     => FALSE,
                'message'    => 'Error adding suhu: ' . $th->getMessage()
            ], RestController::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

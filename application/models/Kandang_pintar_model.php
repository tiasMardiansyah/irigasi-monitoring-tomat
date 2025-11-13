<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kandang_pintar_model extends CI_Model
{

    private $table = 'suhu';

    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // penting agar $this->db tersedia
    }


    public function getSuhu()
    {
        $this->db->order_by('updated_Date', 'ASC'); // urutkan dari yang paling awal
        $this->db->limit(10); // ambil 10 data terakhir
        $query = $this->db->get($this->table);

        $suhu = [];
        foreach ($query->result() as $row) {
            $suhu[] = [
                'id'            => $row->id,
                'suhu'          => $row->suhu,
                'updated_Date'  => $row->updated_Date
            ];
        }

        return $suhu;
    }


    // insert suhu baru
    public function insertSuhu($suhu)
    {
        $data = [
            'suhu'         => $suhu,
            'updated_Date' => date('Y-m-d H:i:s')
        ];
        return $this->db->insert($this->table, $data);
    }
}

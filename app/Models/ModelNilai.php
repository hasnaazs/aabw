<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelNilai extends Model
{
    protected $table            = 'tbl_nilai';
    protected $primaryKey       = 'id_nilai';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_transaksi',
        'kode_akun3',
        'debit',
        'kredit',
        'id_status',
    ];

    // Dates
    protected $useTimestamps    = false;

    // Method untuk mengambil rincian nilai transaksi beserta nama akun3 dan statusnya
    public function ambilrelasiid($id)
    {
        $builder = $this->db->table('tbl_nilai')
            ->where('id_transaksi', $id)
            ->join('akun3s', 'akun3s.kode_akun3 = tbl_nilai.kode_akun3')
            ->join('tbl_status', 'tbl_status.id_status = tbl_nilai.id_status');

        $query = $builder->get();
        return $query->getResultObject();
    }
}

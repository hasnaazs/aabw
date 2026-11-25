<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAkun3 extends Model
{
    protected $table            = 'akun3s';
    protected $primaryKey       = 'id_akun3';
    protected $returnType       = 'object';
    protected $allowedFields    = ['kode_akun1', 'kode_akun2', 'kode_akun3', 'nama_akun3'];

    public function ambil_relasi()
    {
        $builder = $this->db->table('akun3s');
        $builder->join('akun1s', 'akun1s.kode_akun1 = akun3s.kode_akun1');
        $builder->join('akun2s', 'akun2s.kode_akun2 = akun3s.kode_akun2');
        $query = $builder->get();
        return $query->getResult();
    }
}

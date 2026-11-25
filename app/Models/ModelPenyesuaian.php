<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPenyesuaian extends Model
{
    protected $table         = 'tbl_penyesuaian';
    protected $primaryKey    = 'id_penyesuaian';
    protected $returnType    = 'object';
    protected $allowedFields = ['tanggal', 'deskripsi', 'nilai', 'waktu', 'jumlah'];

    // Dates
    protected $useTimestamps = true;
}

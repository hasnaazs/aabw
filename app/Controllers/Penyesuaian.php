<?php

namespace App\Controllers;

use App\Models\ModelPenyesuaian;
use App\Models\ModelStatus;
use App\Models\ModelAkun3;
use App\Models\ModelNilaiPenyesuaian;
use CodeIgniter\RESTful\ResourceController;

class Penyesuaian extends ResourceController
{
    protected $db;
    protected $objPenyesuaian;
    protected $objNilaiPenyesuaian;
    protected $objStatus;
    protected $objAkun3;

    public function __construct()
    {
        $this->db                  = \Config\Database::connect();
        $this->objPenyesuaian      = new ModelPenyesuaian();
        $this->objNilaiPenyesuaian = new ModelNilaiPenyesuaian();
        $this->objStatus           = new ModelStatus();
        $this->objAkun3            = new ModelAkun3();
    }

    public function index()
    {
        $data['dtpenyesuaian'] = $this->objPenyesuaian->findAll();
        return view('penyesuaian/index', $data);
    }

    public function show($id = null)
    {
        $penyesuaian = $this->objPenyesuaian->find($id);
        $akun3       = $this->objAkun3->findAll();
        $status      = $this->objStatus->findAll();
        $nilai       = $this->objNilaiPenyesuaian->ambilrelasiid($id);

        if (is_object($penyesuaian)) {
            $data['dtakun3']            = $akun3;
            $data['dtstatus']           = $status;
            $data['dtpenyesuaian']      = $penyesuaian;
            $data['dtnilaipenyesuaian'] = $nilai;

            return view('penyesuaian/show', $data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function new()
    {
        return view('penyesuaian/new');
    }

    // Method AJAX untuk dropdown Kode Akun 3
    public function akun3()
    {
        $data = $this->objAkun3->findAll();
        return $this->response->setJSON($data);
    }

    // Method AJAX untuk dropdown Status
    public function status()
    {
        $data = $this->objStatus->findAll();
        return $this->response->setJSON($data);
    }

    public function create()
    {
        $data1 = [
            'tanggal'   => $this->request->getVar('tanggal'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'nilai'     => $this->request->getVar('nilai'),
            'waktu'     => $this->request->getVar('waktu'),
            'jumlah'    => $this->request->getVar('jumlah'),
        ];

        // Simpan data ke tbl_penyesuaian
        $this->db->table('tbl_penyesuaian')->insert($data1);

        // Ambil ID dari tbl_penyesuaian
        $id_penyesuaian = $this->objPenyesuaian->insertID();
        $kode_akun3     = $this->request->getVar('kode_akun3');
        $debit          = $this->request->getVar('debit');
        $kredit         = $this->request->getVar('kredit');
        $id_status      = $this->request->getVar('id_status');

        $data2 = [];
        for ($i = 0; $i < count($kode_akun3); $i++) {
            $data2[] = [
                'id_penyesuaian' => $id_penyesuaian,
                'kode_akun3'     => $kode_akun3[$i],
                'debit'          => $debit[$i],
                'kredit'         => $kredit[$i],
                'id_status'      => $id_status[$i],
            ];
        }

        $this->objNilaiPenyesuaian->insertBatch($data2);
        return redirect()->to(site_url('penyesuaian'))->with('success', 'Data Berhasil Disimpan');
    }

    public function edit($id = null)
    {
        $penyesuaian = $this->objPenyesuaian->find($id);
        $akun3       = $this->objAkun3->findAll();
        $status      = $this->objStatus->findAll();
        $nilai       = $this->objNilaiPenyesuaian->ambilrelasiid($id);

        if (is_object($penyesuaian)) {
            $data['dtakun3']            = $akun3;
            $data['dtstatus']           = $status;
            $data['dtpenyesuaian']      = $penyesuaian;
            $data['dtnilaipenyesuaian'] = $nilai;

            return view('penyesuaian/edit', $data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function update($id = null)
    {
        $data1 = [
            'tanggal'   => $this->request->getVar('tanggal'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'nilai'     => $this->request->getVar('nilai'),
            'waktu'     => $this->request->getVar('waktu'),
            'jumlah'    => $this->request->getVar('jumlah'),
        ];

        // Update data di tbl_penyesuaian
        $this->db->table('tbl_penyesuaian')->where(['id_penyesuaian' => $id])->update($data1);

        $ids        = $this->request->getVar('id');
        $kode_akun3 = $this->request->getVar('kode_akun3');
        $debit      = $this->request->getVar('debit');
        $kredit     = $this->request->getVar('kredit');
        $id_status  = $this->request->getVar('id_status');

        $result = [];
        foreach ($ids as $key => $value) {
            $result[] = [
                'id'         => $ids[$key],
                'kode_akun3' => $kode_akun3[$key],
                'debit'      => $debit[$key],
                'kredit'     => $kredit[$key],
                'id_status'  => $id_status[$key],
            ];
        }

        $this->objNilaiPenyesuaian->updateBatch($result, 'id');
        return redirect()->to(site_url('penyesuaian'))->with('success', 'Data Berhasil Diupdate');
    }

    public function delete($id = null)
    {
        $this->objPenyesuaian->where(['id_penyesuaian' => $id])->delete();
        return redirect()->to(site_url('penyesuaian'))->with('success', 'Data berhasil dihapus');
    }
}

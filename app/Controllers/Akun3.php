<?php

namespace App\Controllers;

use App\Models\ModelAkun3;
use App\Models\ModelAkun2;

class Akun3 extends BaseController
{
    protected $objAkun3;
    protected $objAkun2;

    public function __construct()
    {
        $this->objAkun3 = new ModelAkun3();
        $this->objAkun2 = new ModelAkun2();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data['title']   = 'Data Akun 3';
        $data['dtakun3'] = $this->objAkun3->ambil_relasi();
        return view('akun3/index', $data);
    }

    public function new()
    {
        $builder_akun1  = $this->db->table('akun1s');
        $query_akun1    = $builder_akun1->get();

        $data['title']   = 'Tambah Akun 3';
        $data['dtakun1'] = $query_akun1->getResult();
        $data['dtakun2'] = $this->objAkun2->findAll();

        return view('akun3/new', $data);
    }

    public function create()
    {
        $data = [
            'kode_akun1' => $this->request->getVar('kode_akun1'),
            'kode_akun2' => $this->request->getVar('kode_akun2'),
            'kode_akun3' => $this->request->getVar('kode_akun3'),
            'nama_akun3' => $this->request->getVar('nama_akun3'),
        ];

        $this->db->table('akun3s')->insert($data);
        return redirect()->to(site_url('akun3'))->with('success', 'Data Berhasil Disimpan');
    }

    public function edit($id = null)
    {
        if ($id != null) {
            $query = $this->objAkun3->find($id);
            if ($query) {
                $builder_akun1  = $this->db->table('akun1s');
                $query_akun1    = $builder_akun1->get();

                $data['title']   = 'Edit Akun 3';
                $data['dtakun3'] = $query;
                $data['dtakun1'] = $query_akun1->getResult();
                $data['dtakun2'] = $this->objAkun2->findAll();

                return view('akun3/edit', $data);
            } else {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function update($id = null)
    {
        $data = [
            'kode_akun1' => $this->request->getVar('kode_akun1'),
            'kode_akun2' => $this->request->getVar('kode_akun2'),
            'kode_akun3' => $this->request->getVar('kode_akun3'),
            'nama_akun3' => $this->request->getVar('nama_akun3'),
        ];

        $this->db->table('akun3s')->where('id_akun3', $id)->update($data);
        return redirect()->to(site_url('akun3'))->with('success', 'Data Berhasil Diupdate');
    }

    public function delete($id = null)
    {
        $this->db->table('akun3s')->where('id_akun3', $id)->delete();
        return redirect()->to(site_url('akun3'))->with('success', 'Data Berhasil Dihapus');
    }
}

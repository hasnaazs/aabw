<?php

namespace App\Controllers;

use App\Models\ModelTransaksi;
use App\Models\ModelNilai;
use App\Models\ModelStatus;
use App\Models\ModelAkun3;

class Transaksi extends BaseController
{
    protected $objTransaksi;
    protected $objNilai;
    protected $objStatus;
    protected $objAkun3;
    protected $db;

    public function __construct()
    {
        $this->db           = \Config\Database::connect();
        $this->objTransaksi = new ModelTransaksi();
        $this->objNilai     = new ModelNilai();
        $this->objStatus    = new ModelStatus();
        $this->objAkun3     = new ModelAkun3();
    }

    public function index()
    {
        $data['title']       = 'Data Transaksi';
        $data['dttransaksi'] = $this->objTransaksi->findAll();

        return view('transaksi/index', $data);
    }

    public function show($id = null)
    {
        if ($id != null) {
            $transaksi = $this->objTransaksi->find($id);

            if (is_object($transaksi)) {
                $data['title']       = 'Detail Transaksi';
                $data['dttransaksi'] = $transaksi;
                $data['dtakun3']     = $this->objAkun3->findAll();
                $data['dtstatus']    = $this->objStatus->findAll();
                $data['dtnilai']     = $this->objNilai->ambilrelasiid($id);

                return view('transaksi/show', $data);
            }
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    public function new()
    {
        $data['title'] = 'Tambah Transaksi';

        return view('transaksi/new', $data);
    }

    public function akun3()
    {
        $data = $this->objAkun3->findAll();

        return $this->response->setJSON($data);
    }

    public function status()
    {
        $data = $this->objStatus->findAll();

        return $this->response->setJSON($data);
    }

    public function create()
    {
        $data1 = [
            'kwitansi'   => $this->request->getVar('kwitansi'),
            'tanggal'    => $this->request->getVar('tanggal'),
            'deskripsi'  => $this->request->getVar('deskripsi'),
            'ket_jurnal' => $this->request->getVar('ket_jurnal'),
        ];

        $this->db->table('tbl_transaksi')->insert($data1);
        $id_transaksi = $this->db->insertID();

        $kode_akun3 = $this->request->getVar('kode_akun3');
        $debit      = $this->request->getVar('debit');
        $kredit     = $this->request->getVar('kredit');
        $id_status  = $this->request->getVar('id_status');

        $data2 = [];
        if ($kode_akun3 && is_array($kode_akun3)) {
            for ($i = 0; $i < count($kode_akun3); $i++) {
                $data2[] = [
                    'id_transaksi' => $id_transaksi,
                    'kode_akun3'   => $kode_akun3[$i],
                    'debit'        => $debit[$i],
                    'kredit'       => $kredit[$i],
                    'id_status'    => $id_status[$i],
                ];
            }
            $this->objNilai->insertBatch($data2);
        }

        return redirect()->to(site_url('transaksi'))->with('success', 'Data Berhasil Disimpan');
    }

    public function edit($id = null)
    {
        if ($id != null) {
            $transaksi = $this->objTransaksi->find($id);

            if (is_object($transaksi)) {
                $data['title']       = 'Edit Transaksi';
                $data['dttransaksi'] = $transaksi;
                $data['dtakun3']     = $this->objAkun3->findAll();
                $data['dtstatus']    = $this->objStatus->findAll();
                $data['dtnilai']     = $this->objNilai->ambilrelasiid($id);

                return view('transaksi/edit', $data);
            }
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    public function update($id = null)
    {
        $data1 = [
            'kwitansi'   => $this->request->getVar('kwitansi'),
            'tanggal'    => $this->request->getVar('tanggal'),
            'deskripsi'  => $this->request->getVar('deskripsi'),
            'ket_jurnal' => $this->request->getVar('ket_jurnal'),
        ];

        $this->db->table('tbl_transaksi')->where('id_transaksi', $id)->update($data1);

        $ids        = $this->request->getVar('id_nilai');
        $kode_akun3 = $this->request->getVar('kode_akun3');
        $debit      = $this->request->getVar('debit');
        $kredit     = $this->request->getVar('kredit');
        $id_status  = $this->request->getVar('id_status');

        if ($ids && is_array($ids)) {
            $result = [];
            foreach ($ids as $key => $value) {
                $result[] = [
                    'id_nilai'   => $ids[$key],
                    'kode_akun3' => $kode_akun3[$key],
                    'debit'      => $debit[$key],
                    'kredit'     => $kredit[$key],
                    'id_status'  => $id_status[$key],
                ];
            }
            $this->objNilai->updateBatch($result, 'id_nilai');
        }

        return redirect()->to(site_url('transaksi'))->with('success', 'Data Berhasil Diupdate');
    }

    public function delete($id = null)
    {
        $this->db->table('tbl_transaksi')->where('id_transaksi', $id)->delete();

        return redirect()->to(site_url('transaksi'))->with('success', 'Data Berhasil Dihapus');
    }
}

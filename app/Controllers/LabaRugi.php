<?php

namespace App\Controllers;

use App\Models\ModelNilai;
use App\Models\ModelStatus;
use App\Models\ModelAkun3;
use App\Models\ModelTransaksi;
use App\Controllers\BaseController;
use TCPDF;

class LabaRugi extends BaseController
{
    protected $db;
    protected $objTransaksi;
    protected $objNilai;
    protected $objStatus;
    protected $objAkun3;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->objTransaksi = new ModelTransaksi();
        $this->objNilai = new ModelNilai();
        $this->objStatus = new ModelStatus();
        $this->objAkun3 = new ModelAkun3();
    }

    public function index()
    {
        $tglawal = $this->request->getVar('tglawal') ? $this->request->getVar('tglawal') : "";
        $tglakhir = $this->request->getVar('tglakhir') ? $this->request->getVar('tglakhir') : "";

        // Jika di ModelTransaksi methodnya getNeracaLajur, bisa pakai getNeracaLajur($tglawal, $tglakhir)
        if (method_exists($this->objTransaksi, 'get_labarugi')) {
            $rowdata = $this->objTransaksi->get_labarugi($tglawal, $tglakhir);
        } else {
            $rowdata = $this->objTransaksi->getNeracaLajur($tglawal, $tglakhir);
        }

        $data['dttransaksi'] = $rowdata;
        $data['tglawal'] = $tglawal;
        $data['tglakhir'] = $tglakhir;
        return view('labarugi/index', $data);
    }

    public function labarugipdf()
    {
        $tglawal = $this->request->getVar('tglawal') ? $this->request->getVar('tglawal') : "";
        $tglakhir = $this->request->getVar('tglakhir') ? $this->request->getVar('tglakhir') : "";

        if (method_exists($this->objTransaksi, 'get_labarugi')) {
            $rowdata = $this->objTransaksi->get_labarugi($tglawal, $tglakhir);
        } else {
            $rowdata = $this->objTransaksi->getNeracaLajur($tglawal, $tglakhir);
        }

        $data['dttransaksi'] = $rowdata;
        $data['tglawal'] = $tglawal;
        $data['tglakhir'] = $tglakhir;

        $html = view('labarugi/labarugipdf', $data);

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(15, 15, 15);
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');
        $this->response->setContentType('application/pdf');
        $pdf->Output('laporan_laba_rugi.pdf', 'I');
    }
}

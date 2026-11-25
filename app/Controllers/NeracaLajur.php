<?php

namespace App\Controllers;

use App\Models\ModelNilai;
use App\Models\ModelStatus;
use App\Models\ModelAkun3;
use App\Models\ModelTransaksi;
use App\Controllers\BaseController;
use TCPDF;

class NeracaLajur extends BaseController
{
    protected $db;
    protected $objTransaksi;
    protected $objNilai;
    protected $objStatus;
    protected $objAkun3;

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
        $tglawal  = $this->request->getVar('tglawal') ? $this->request->getVar('tglawal') : "";
        $tglakhir = $this->request->getVar('tglakhir') ? $this->request->getVar('tglakhir') : "";

        $rowdata = $this->objTransaksi->get_neracalajur($tglawal, $tglakhir);

        $data = [
            'title'       => 'Laporan Neraca Lajur',
            'dttransaksi' => $rowdata,
            'tglawal'     => $tglawal,
            'tglakhir'    => $tglakhir,
        ];

        return view('neracalajur/index', $data);
    }

    public function neracalajurpdf()
    {
        $tglawal  = $this->request->getVar('tglawal') ? $this->request->getVar('tglawal') : "";
        $tglakhir = $this->request->getVar('tglakhir') ? $this->request->getVar('tglakhir') : "";

        $rowdata = $this->objTransaksi->get_neracalajur($tglawal, $tglakhir);

        $data = [
            'title'       => 'Laporan Neraca Lajur',
            'dttransaksi' => $rowdata,
            'tglawal'     => $tglawal,
            'tglakhir'    => $tglakhir,
        ];

        $html = view('neracalajur/neracalajurpdf', $data);

        // Orientasi Landscape 'L' untuk tabel 10 kolom
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');

        $this->response->setContentType('application/pdf');
        $pdf->Output('neracalajur.pdf', 'I');
    }
}

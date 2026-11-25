<?php

namespace App\Controllers;

use App\Models\ModelTransaksi;
use App\Models\ModelNilai;
use App\Models\ModelStatus;
use App\Models\ModelAkun3;
use App\Controllers\BaseController;
use TCPDF;

class JurnalUmum extends BaseController
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
        $tglawal  = $this->request->getVar('tglawal') ?? "";
        $tglakhir = $this->request->getVar('tglakhir') ?? "";

        $rowdata = $this->objTransaksi->get_jurnalumum($tglawal, $tglakhir);
        $i       = 0;
        $temp1   = '';
        $temp2   = '';

        if (!empty($rowdata)) {
            foreach ($rowdata as $row) {
                $tgl                  = ($temp1 == $row->tanggal && $temp2 == $row->kwitansi) ? '' : $row->tanggal;
                $temp1                = $row->tanggal;
                $temp2                = $row->kwitansi;
                $rowdata[$i]->tanggal = $tgl;
                $i++;
            }
        }

        $data['dttransaksi'] = $rowdata;
        $data['tglawal']     = $tglawal;
        $data['tglakhir']    = $tglakhir;

        return view('jurnalumum/index', $data);
    }

    public function cetakjupdf()
    {
        $tglawal  = $this->request->getVar('tglawal') ?? "";
        $tglakhir = $this->request->getVar('tglakhir') ?? "";

        $rowdata = $this->objTransaksi->get_jurnalumum($tglawal, $tglakhir);
        $i       = 0;
        $temp1   = '';
        $temp2   = '';

        if (!empty($rowdata)) {
            foreach ($rowdata as $row) {
                $tgl                  = ($temp1 == $row->tanggal && $temp2 == $row->kwitansi) ? '' : $row->tanggal;
                $temp1                = $row->tanggal;
                $temp2                = $row->kwitansi;
                $rowdata[$i]->tanggal = $tgl;
                $i++;
            }
        }

        $data = [
            'dttransaksi' => $rowdata,
            'tglawal'     => $tglawal,
            'tglakhir'    => $tglakhir,
        ];

        $html = view('jurnalumum/cetakjupdf', $data);

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetFont('helvetica', '', 9);
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');

        $this->response->setContentType('application/pdf');
        $pdf->Output('laporan_jurnal_umum.pdf', 'I');
    }
}

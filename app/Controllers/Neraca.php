<?php

namespace App\Controllers;

use App\Models\ModelAkun3;
use App\Models\ModelNilai;
use App\Models\ModelStatus;
use App\Models\ModelTransaksi;
use App\Controllers\BaseController;
use TCPDF;

class Neraca extends BaseController
{
    protected $objTransaksi;
    protected $objStatus;
    protected $objAkun3;
    protected $objNilai;
    protected $db;

    public function __construct()
    {
        $this->objTransaksi = new ModelTransaksi();
        $this->objNilai = new ModelNilai();
        $this->objAkun3 = new ModelAkun3();
        $this->objStatus = new ModelStatus();
        $this->db = \Config\Database::connect();
    }

    private function getProcessedData($tglawal, $tglakhir)
    {
        if (method_exists($this->objTransaksi, 'get_neraca')) {
            $dttransaksi = $this->objTransaksi->get_neraca($tglawal, $tglakhir);
        } else {
            $dttransaksi = $this->objTransaksi->getNeracaLajur($tglawal, $tglakhir);
        }

        $modal_awal = 0;
        $pendapatan = 0;
        $prive = 0;
        $jumdebit = 0;
        $jumdebits = 0;

        foreach ($dttransaksi as $row) {
            if ($row->kode_akun3 == 3101) {
                $modal_awal = $row->jumkredit;
            }
            if ($row->kode_akun3 == 4101) {
                $pendapatan = $row->jumkredit + ($row->jumkredits ?? 0);
            }
            if ($row->kode_akun3 == 3201) {
                $prive = $row->jumdebit;
            }
            if (substr($row->kode_akun3, 0, 1) == '5') {
                $jumdebit += $row->jumdebit;
                $jumdebits += ($row->jumdebits ?? 0);
            }
        }

        $beban = $jumdebit + $jumdebits;
        $laba_rugi = $pendapatan - $beban;
        $laba_ditahan = $laba_rugi - $prive;
        $total_ekuitas = $modal_awal + $laba_ditahan;

        return [
            'dttransaksi'   => $dttransaksi,
            'modal_awal'    => $modal_awal,
            'pendapatan'    => $pendapatan,
            'prive'         => $prive,
            'beban'         => $beban,
            'laba_rugi'     => $laba_rugi,
            'laba_ditahan'  => $laba_ditahan,
            'total_ekuitas' => $total_ekuitas,
        ];
    }

    public function index()
    {
        $tglawal = $this->request->getVar('tglawal') ? $this->request->getVar('tglawal') : '';
        $tglakhir = $this->request->getVar('tglakhir') ? $this->request->getVar('tglakhir') : '';

        $processed = $this->getProcessedData($tglawal, $tglakhir);

        $data = array_merge($processed, [
            'tglawal'  => $tglawal,
            'tglakhir' => $tglakhir,
        ]);

        return view('neraca/index', $data);
    }

    public function neracapdf()
    {
        $tglawal = $this->request->getVar('tglawal') ? $this->request->getVar('tglawal') : '';
        $tglakhir = $this->request->getVar('tglakhir') ? $this->request->getVar('tglakhir') : '';

        $processed = $this->getProcessedData($tglawal, $tglakhir);

        $data = array_merge($processed, [
            'tglawal'  => $tglawal,
            'tglakhir' => $tglakhir,
        ]);

        $html = view('neraca/neracapdf', $data);

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(15, 20, 15);
        $pdf->SetAutoPageBreak(TRUE, 20);
        $pdf->SetFont('helvetica', '', 9);

        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        $pdf->Output('Laporan_Posisi_Keuangan.pdf', 'I');
        exit();
    }
}

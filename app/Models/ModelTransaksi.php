<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTransaksi extends Model
{
    protected $table         = 'tbl_transaksi';
    protected $primaryKey    = 'id_transaksi';
    protected $returnType    = 'object';
    protected $allowedFields = ['kwitansi', 'tanggal', 'deskripsi', 'ketjurnal', 'ket_jurnal'];
    protected $useTimestamps = true;

    // Menghasilkan nomor kwitansi otomatis
    public function noKwitansi()
    {
        $number = $this->db->table('tbl_transaksi')->select('RIGHT(tbl_transaksi.kwitansi,4) as kwitansi', FALSE)
            ->orderBy('kwitansi', 'DESC')->limit(1)->get()->getRowArray();

        if ($number == null) {
            $no = 1;
        } else {
            $no = intval($number['kwitansi']) + 1;
        }
        $nomor_kwitansi = str_pad($no, 4, "0", STR_PAD_LEFT);
        return $nomor_kwitansi;
    }

    public function no_kwitansi()
    {
        return $this->noKwitansi();
    }

    // Query Laporan Jurnal Umum
    public function get_jurnalumum($tglawal = null, $tglakhir = null)
    {
        $sql = $this->db->table('tbl_nilai')
            ->join('tbl_transaksi', 'tbl_transaksi.id_transaksi=tbl_nilai.id_transaksi')
            ->join('akun3s', 'akun3s.kode_akun3=tbl_nilai.kode_akun3')
            ->orderBy('id_nilai');
        if ($tglawal && $tglakhir) {
            $sql->where('tanggal >=', $tglawal)->where('tanggal <=', $tglakhir);
        }
        return $sql->get()->getResultObject();
    }

    public function getJurnalUmum($tglawal = null, $tglakhir = null)
    {
        return $this->get_jurnalumum($tglawal, $tglakhir);
    }

    // Query Laporan Posting Buku Besar
    public function get_posting($tglawal = null, $tglakhir = null, $kode_akun3 = null)
    {
        $sql = $this->db->table('tbl_nilai')
            ->join('tbl_transaksi', 'tbl_transaksi.id_transaksi=tbl_nilai.id_transaksi')
            ->join('akun3s', 'akun3s.kode_akun3=tbl_nilai.kode_akun3')
            ->orderBy('akun3s.kode_akun3');
        if ($tglawal && $tglakhir) {
            $sql->where('tanggal >=', $tglawal)->where('tanggal <=', $tglakhir)->where('tbl_nilai.kode_akun3=', $kode_akun3);
        }
        return $sql->get()->getResultObject();
    }

    public function getPosting($tglawal = null, $tglakhir = null, $kode_akun3 = null)
    {
        return $this->get_posting($tglawal, $tglakhir, $kode_akun3);
    }

    // Query Laporan Jurnal Penyesuaian
    public function get_jpenyesuaian($tglawal = null, $tglakhir = null)
    {
        $sql = $this->db->table('tbl_nilaipenyesuaian')
            ->join('tbl_penyesuaian', 'tbl_penyesuaian.id_penyesuaian=tbl_nilaipenyesuaian.id_penyesuaian')
            ->join('akun3s', 'akun3s.kode_akun3=tbl_nilaipenyesuaian.kode_akun3')
            ->selectSum('debit', 'jumdebit')
            ->selectSum('kredit', 'jumkredit')
            ->select('akun3s.kode_akun3, akun3s.nama_akun3, tbl_penyesuaian.tanggal')
            ->groupBy('akun3s.kode_akun3');
        if ($tglawal && $tglakhir) {
            $sql->where('tanggal >=', $tglawal)->where('tanggal <=', $tglakhir);
        }
        return $sql->get()->getResultObject();
    }

    // Query Laporan Neraca Saldo (Video #15)
    public function get_neracasaldo($tglawal = null, $tglakhir = null)
    {
        $sql = $this->db->table('tbl_nilai')
            ->join('tbl_transaksi', 'tbl_transaksi.id_transaksi=tbl_nilai.id_transaksi')
            ->join('akun3s', 'akun3s.kode_akun3=tbl_nilai.kode_akun3')
            ->selectSum('debit', 'jumdebit')
            ->selectSum('kredit', 'jumkredit')
            ->select('akun3s.kode_akun3, akun3s.nama_akun3, tbl_transaksi.tanggal, debit, kredit')
            ->groupBy('akun3s.kode_akun3');

        if ($tglawal && $tglakhir) {
            $sql->where('tanggal >=', $tglawal)->where('tanggal <=', $tglakhir);
        }
        return $sql->get()->getResultObject();
    }

    public function getNeracaSaldo($tglawal = null, $tglakhir = null)
    {
        return $this->get_neracasaldo($tglawal, $tglakhir);
    }

    // Query Laporan Neraca Lajur
    public function get_neracalajur($tglawal = null, $tglakhir = null)
    {
        $where1 = "";
        $where2 = "";

        if ($tglawal && $tglakhir) {
            $where1 = "where tb3.tanggal >= '" . $tglawal . "' and tb3.tanggal <= '" . $tglakhir . "' ";
            $where2 = "where tb4.tanggal >= '" . $tglawal . "' and tb4.tanggal <= '" . $tglakhir . "' ";
        }

        $sql = $this->db->query('SELECT * FROM (
        SELECT tbak.nama_akun3, tb1.kode_akun3, tb3.tanggal as tanggal,
        sum(tb1.debit) as jumdebit,
        sum(tb1.kredit) as jumkredit,
        tb2.debit as jumdebits,
        tb2.kredit as jumkredits
        FROM tbl_nilai as tb1 
            join tbl_transaksi as tb3 on tb3.id_transaksi = tb1.id_transaksi left join tbl_nilaipenyesuaian as tb2 on tb1.kode_akun3 = tb2.kode_akun3 
            join akun3s as tbak on tb1.kode_akun3=tbak.kode_akun3
            ' . $where1 . '
            group by tb1.kode_akun3
        
        UNION
        
        SELECT tbak.nama_akun3, tb2.kode_akun3, tb4.tanggal as tanggal,
            sum(tb1.debit) as jumdebit,
            sum(tb1.kredit) as jumkredit,
            tb2.debit as jumdebits,
            tb2.kredit as jumkredits
        FROM tbl_nilai as tb1
        
        right join tbl_nilaipenyesuaian as tb2 on tb1.kode_akun3=tb2.kode_akun3
        join akun3s as tbak on tb2.kode_akun3=tbak.kode_akun3
        join tbl_penyesuaian as tb4 on tb4.id_penyesuaian=tb2.id_penyesuaian
        ' . $where2 . '
        group by tb2.kode_akun3) as tbl_new
        group by tbl_new.kode_akun3');

        return $sql->getResultObject();
    }

    // Query Laporan Laba Rugi
    public function get_labarugi($tglawal = null, $tglakhir = null)
    {
        $where1 = "";
        $where2 = "";

        if ($tglawal && $tglakhir) {
            $where1 = "where tb3.tanggal >= '" . $tglawal . "' and tb3.tanggal <= '" . $tglakhir . "' ";
            $where2 = "where tb4.tanggal >= '" . $tglawal . "' and tb4.tanggal <= '" . $tglakhir . "' ";
        }

        $sql = $this->db->query('SELECT * FROM (
        SELECT tbak.nama_akun3, tbak.kode_akun1, tb1.kode_akun3, tb3.tanggal as tanggal,
        sum(tb1.debit) as jumdebit,
        sum(tb1.kredit) as jumkredit,
        tb2.debit as jumdebits,
        tb2.kredit as jumkredits
        FROM tbl_nilai as tb1 
            join tbl_transaksi as tb3 on tb3.id_transaksi = tb1.id_transaksi left join tbl_nilaipenyesuaian as tb2 on tb1.kode_akun3 = tb2.kode_akun3 
            join akun3s as tbak on tb1.kode_akun3=tbak.kode_akun3
            ' . $where1 . '
            group by tb1.kode_akun3
        
        UNION
        
        SELECT tbak.nama_akun3, tbak.kode_akun1, tb2.kode_akun3, tb4.tanggal as tanggal,
            sum(tb1.debit) as jumdebit,
            sum(tb1.kredit) as jumkredit,
            tb2.debit as jumdebits,
            tb2.kredit as jumkredits
        FROM tbl_nilai as tb1
        
        right join tbl_nilaipenyesuaian as tb2 on tb1.kode_akun3=tb2.kode_akun3
        join akun3s as tbak on tb2.kode_akun3=tbak.kode_akun3
        join tbl_penyesuaian as tb4 on tb4.id_penyesuaian=tb2.id_penyesuaian
        ' . $where2 . '
        group by tb2.kode_akun3) as tbl_new
        group by tbl_new.kode_akun3');

        return $sql->getResultObject();
    }

    // Query Laporan Perubahan Modal
    public function get_pmodal($tglawal = null, $tglakhir = null)
    {
        $where1 = '';
        $where2 = '';

        if ($tglawal && $tglakhir) {
            $where1 = "where tb3.tanggal >= '" . $tglawal . "' and tb3.tanggal <= '" . $tglakhir . "' ";
            $where2 = "where tb4.tanggal >= '" . $tglawal . "' and tb4.tanggal <= '" . $tglakhir . "' ";
        }
        $sql = $this->db->query("
        SELECT * FROM (
            SELECT 
                tbak.nama_akun3, tbak.kode_akun2, tbak.kode_akun1,
                tbl.kode_akun3,
                tb3.tanggal AS tanggal,
                SUM(tbl.debit) AS jumdebit,
                SUM(tbl.kredit) AS jumkredit,
                COALESCE(tb2.debit, 0) AS jumdebits,
                COALESCE(tb2.kredit, 0) AS jumkredits
            FROM tbl_nilai AS tbl
            JOIN tbl_transaksi AS tb3 ON tb3.id_transaksi = tbl.id_transaksi
            LEFT JOIN tbl_nilaipenyesuaian AS tb2 ON tbl.kode_akun3 = tb2.kode_akun3
            JOIN akun3s AS tbak ON tbl.kode_akun3 = tbak.kode_akun3
            " . $where1 . "
            GROUP BY tbl.kode_akun3

            UNION

            SELECT 
                tbak.nama_akun3, tbak.kode_akun2, tbak.kode_akun1,
                tb2.kode_akun3,
                tb4.tanggal AS tanggal,
                SUM(COALESCE(tbl.debit, 0)) AS jumdebit,
                SUM(COALESCE(tbl.kredit, 0)) AS jumkredit,
                tb2.debit AS jumdebits,
                tb2.kredit AS jumkredits
            FROM tbl_nilai AS tbl
            RIGHT JOIN tbl_nilaipenyesuaian AS tb2 ON tbl.kode_akun3 = tb2.kode_akun3
            JOIN akun3s AS tbak ON tb2.kode_akun3 = tbak.kode_akun3
            JOIN tbl_penyesuaian AS tb4 ON tb4.id_penyesuaian = tb2.id_penyesuaian
            " . $where2 . "
            GROUP BY tb2.kode_akun3
        ) AS tbl_new
        GROUP BY tbl_new.kode_akun3
    ");

        return $sql->getResultObject();
    }

    // Query Laporan Neraca
    public function get_neraca($tglawal = null, $tglakhir = null)
    {
        $where1 = '';
        $where2 = '';

        if ($tglawal && $tglakhir) {
            $where1 = "where tb3.tanggal >= '" . $tglawal . "' and tb3.tanggal <= '" . $tglakhir . "' ";
            $where2 = "where tb4.tanggal >= '" . $tglawal . "' and tb4.tanggal <= '" . $tglakhir . "' ";
        }
        $sql = $this->db->query("
        SELECT * FROM (
            SELECT 
                tbak.nama_akun3, tbak.kode_akun2, tbak.kode_akun1,
                tbl.kode_akun3,
                tb3.tanggal AS tanggal,
                SUM(tbl.debit) AS jumdebit,
                SUM(tbl.kredit) AS jumkredit,
                COALESCE(tb2.debit, 0) AS jumdebits,
                COALESCE(tb2.kredit, 0) AS jumkredits
            FROM tbl_nilai AS tbl
            JOIN tbl_transaksi AS tb3 ON tb3.id_transaksi = tbl.id_transaksi
            LEFT JOIN tbl_nilaipenyesuaian AS tb2 ON tbl.kode_akun3 = tb2.kode_akun3
            JOIN akun3s AS tbak ON tbl.kode_akun3 = tbak.kode_akun3
            " . $where1 . "
            GROUP BY tbl.kode_akun3

            UNION

            SELECT 
                tbak.nama_akun3, tbak.kode_akun2, tbak.kode_akun1,
                tb2.kode_akun3,
                tb4.tanggal AS tanggal,
                SUM(COALESCE(tbl.debit, 0)) AS jumdebit,
                SUM(COALESCE(tbl.kredit, 0)) AS jumkredit,
                tb2.debit AS jumdebits,
                tb2.kredit AS jumkredits
            FROM tbl_nilai AS tbl
            RIGHT JOIN tbl_nilaipenyesuaian AS tb2 ON tbl.kode_akun3 = tb2.kode_akun3
            JOIN akun3s AS tbak ON tb2.kode_akun3 = tbak.kode_akun3
            JOIN tbl_penyesuaian AS tb4 ON tb4.id_penyesuaian = tb2.id_penyesuaian
            " . $where2 . "
            GROUP BY tb2.kode_akun3
        ) AS tbl_new where tbl_new.kode_akun1 <=7
        GROUP BY tbl_new.kode_akun3
    ");

        return $sql->getResultObject();
    }

    // Query Laporan Arus Kas
    public function get_aruskas($tglawal = null, $tglakhir = null)
    {
        $sql = $this->db->table('tbl_nilai')
            ->join('tbl_transaksi', 'tbl_transaksi.id_transaksi = tbl_nilai.id_transaksi')
            ->join('akun3s', 'akun3s.kode_akun3 = tbl_nilai.kode_akun3')
            ->select('tbl_nilai.*, akun3s.kode_akun3, akun3s.nama_akun3, tbl_transaksi.tanggal, tbl_transaksi.kwitansi, tbl_transaksi.deskripsi, tbl_transaksi.ket_jurnal')
            ->whereIn('tbl_nilai.id_status', [1, 2, 3, 4, 5]);

        if ($tglawal && $tglakhir) {
            $sql->where('tbl_transaksi.tanggal >=', $tglawal)->where('tbl_transaksi.tanggal <=', $tglakhir);
        } elseif ($tglawal) {
            $sql->where('tbl_transaksi.tanggal >=', $tglawal);
        } elseif ($tglakhir) {
            $sql->where('tbl_transaksi.tanggal <=', $tglakhir);
        }

        $sql->orderBy('tbl_transaksi.tanggal', 'ASC')->orderBy('tbl_nilai.id_transaksi', 'ASC');

        return $sql->get()->getResultObject();
    }

    public function get_saldo_kas_awal($tglawal = null)
    {
        if (!$tglawal) {
            return 0;
        }

        $sql = "
        SELECT 
            COALESCE(SUM(tbl_nilai.debit), 0) AS total_debit,
            COALESCE(SUM(tbl_nilai.kredit), 0) AS total_kredit
        FROM tbl_nilai
        JOIN tbl_transaksi ON tbl_transaksi.id_transaksi = tbl_nilai.id_transaksi
        WHERE tbl_transaksi.tanggal < ?
        AND tbl_nilai.kode_akun3 = 1101
    ";

        $query = $this->db->query($sql, [$tglawal]);
        $result = $query->getRow();

        if ($result) {
            return (float) ($result->total_debit ?? 0) - (float) ($result->total_kredit ?? 0);
        }

        return 0;
    }
}

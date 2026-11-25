<!DOCTYPE html>
<html>

<head>
    <style type="text/css">
        .aturkiri {
            text-align: left;
        }

        .aturkanan {
            text-align: right;
        }

        .aturtengah {
            text-align: center;
        }

        .judul {
            font-weight: bold;
            font-size: 15px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000000;
            padding: 4px 2px;
            font-size: 7.5pt;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="aturtengah">
        <div class="judul">Laporan Neraca Lajur</div>
        <div style="font-size: 10px; margin-bottom: 12px;">
            Periode: <?= (!empty($tglawal) && !empty($tglakhir)) ? date('d F Y', strtotime($tglawal)) . " s/d " . date('d F Y', strtotime($tglakhir)) : 'Semua Periode' ?>
        </div>
    </div>

    <table border="1" cellspacing="0" cellpadding="3">
        <thead>
            <tr>
                <th class="aturtengah" rowspan="2" style="width: 6%; vertical-align: middle;">Kode</th>
                <th class="aturkiri" rowspan="2" style="width: 18%; vertical-align: middle;">Deskripsi / Nama Akun</th>
                <th class="aturtengah" colspan="2" style="width: 15.2%;">Neraca Saldo</th>
                <th class="aturtengah" colspan="2" style="width: 15.2%;">Penyesuaian</th>
                <th class="aturtengah" colspan="2" style="width: 15.2%;">NS Disesuaikan</th>
                <th class="aturtengah" colspan="2" style="width: 15.2%;">Laba Rugi</th>
                <th class="aturtengah" colspan="2" style="width: 15.2%;">Neraca</th>
            </tr>
            <tr>
                <th class="aturtengah" style="width: 7.6%;">Debit</th>
                <th class="aturtengah" style="width: 7.6%;">Kredit</th>
                <th class="aturtengah" style="width: 7.6%;">Debit</th>
                <th class="aturtengah" style="width: 7.6%;">Kredit</th>
                <th class="aturtengah" style="width: 7.6%;">Debit</th>
                <th class="aturtengah" style="width: 7.6%;">Kredit</th>
                <th class="aturtengah" style="width: 7.6%;">Debit</th>
                <th class="aturtengah" style="width: 7.6%;">Kredit</th>
                <th class="aturtengah" style="width: 7.6%;">Debit</th>
                <th class="aturtengah" style="width: 7.6%;">Kredit</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $td = 0;
            $tk = 0;
            $tdjp = 0;
            $tkjp = 0;
            $totk = 0;
            $totd = 0;
            $lb_td = 0;
            $lb_tk = 0;
            $totns = 0;
            $totkd = 0;
            ?>
            <?php foreach ($dttransaksi as $key => $value): ?>
                <?php
                $d = $value->jumdebit;
                $k = $value->jumkredit;
                $neraca = $d - $k;

                // Jurnal Penyesuaian
                $djp = $value->jumdebits;
                $kjp = $value->jumkredits;
                $neracajp = $djp - $kjp;

                if ($neracajp < 0) {
                    $kreditnewjp = abs($neracajp);
                    $tkjp = $tkjp + $kreditnewjp;
                } else {
                    $kreditnewjp = 0;
                }

                if ($neracajp > 0) {
                    $debitnewjp = $neracajp;
                    $tdjp = $tdjp + $debitnewjp;
                } else {
                    $debitnewjp = 0;
                }

                if ($neraca < 0) {
                    $kreditnew = abs($neraca);
                    $tk = $tk + $kreditnew;
                } else {
                    $kreditnew = 0;
                }

                if ($neraca > 0) {
                    $debitnew = $neraca;
                    $td = $td + $debitnew;
                } else {
                    $debitnew = 0;
                }

                // NS Disesuaikan
                $ns = $debitnew - $kreditnew + $value->jumdebits - $value->jumkredits;

                if ($ns > 0) {
                    $debs = $ns;
                    $totd = $totd + $debs;
                } else {
                    $debs = 0;
                }

                if ($ns < 0) {
                    $kres = abs($ns);
                    $totk = $totk + $kres;
                } else {
                    $kres = 0;
                }

                // Laba Rugi
                $kode_akun = $value->kode_akun3;
                $kode = substr($kode_akun, 0, 1);

                if ($kode == 4) {
                    $lb_db = $kres;
                    $lb_td = $lb_td + $lb_db;
                } else {
                    $lb_db = 0;
                }

                if ($kode == 5) {
                    $lb_kr = $debs;
                    $lb_tk = $lb_tk + $lb_kr;
                } else {
                    $lb_kr = 0;
                }

                // Neraca
                if ($kode <= 3 and $ns > 0) {
                    $nrbs = $debs;
                    $totns = $totns + $nrbs;
                } else {
                    $nrbs = 0;
                }

                if ($kode <= 3 and $ns < 0) {
                    $nrkd = abs($ns);
                    $totkd = $totkd + $nrkd;
                } else {
                    $nrkd = 0;
                }
                ?>
                <tr>
                    <td class="aturtengah" style="width: 6%;"><?= $value->kode_akun3 ?></td>
                    <td class="aturkiri" style="width: 18%;"><?= $value->nama_akun3 ?></td>
                    <td class="aturkanan" style="width: 7.6%;"><?= number_format($debitnew, 0, ',', '.') ?></td>
                    <td class="aturkanan" style="width: 7.6%;"><?= number_format($kreditnew, 0, ',', '.') ?></td>
                    <td class="aturkanan" style="width: 7.6%;"><?= number_format($debitnewjp, 0, ',', '.') ?></td>
                    <td class="aturkanan" style="width: 7.6%;"><?= number_format($kreditnewjp, 0, ',', '.') ?></td>
                    <td class="aturkanan" style="width: 7.6%;"><?= number_format($debs, 0, ',', '.') ?></td>
                    <td class="aturkanan" style="width: 7.6%;"><?= number_format($kres, 0, ',', '.') ?></td>
                    <td class="aturkanan" style="width: 7.6%;"><?= number_format($lb_db, 0, ',', '.') ?></td>
                    <td class="aturkanan" style="width: 7.6%;"><?= number_format($lb_kr, 0, ',', '.') ?></td>
                    <td class="aturkanan" style="width: 7.6%;"><?= number_format($nrbs, 0, ',', '.') ?></td>
                    <td class="aturkanan" style="width: 7.6%;"><?= number_format($nrkd, 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2" class="aturtengah" style="width: 24%;">JUMLAH</th>
                <th class="aturkanan" style="width: 7.6%;"><?= number_format($td, 0, ',', '.') ?></th>
                <th class="aturkanan" style="width: 7.6%;"><?= number_format($tk, 0, ',', '.') ?></th>
                <th class="aturkanan" style="width: 7.6%;"><?= number_format($tdjp, 0, ',', '.') ?></th>
                <th class="aturkanan" style="width: 7.6%;"><?= number_format($tkjp, 0, ',', '.') ?></th>
                <th class="aturkanan" style="width: 7.6%;"><?= number_format($totd, 0, ',', '.') ?></th>
                <th class="aturkanan" style="width: 7.6%;"><?= number_format($totk, 0, ',', '.') ?></th>
                <th class="aturkanan" style="width: 7.6%;"><?= number_format($lb_td, 0, ',', '.') ?></th>
                <th class="aturkanan" style="width: 7.6%;"><?= number_format($lb_tk, 0, ',', '.') ?></th>
                <th class="aturkanan" style="width: 7.6%;"><?= number_format($totns, 0, ',', '.') ?></th>
                <th class="aturkanan" style="width: 7.6%;"><?= number_format($totkd, 0, ',', '.') ?></th>
            </tr>
        </tfoot>
    </table>

    <br><br><br>

    <table border="0" style="width: 100%; border: none;">
        <tr>
            <td style="border: none; width: 70%;"></td>
            <td style="border: none; width: 30%; text-align: center;">
                <?= date('l, d F Y') ?><br><br><br><br><br>
                <strong>Pimpinan AKN</strong>
            </td>
        </tr>
    </table>
</body>

</html>
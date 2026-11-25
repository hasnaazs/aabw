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

        .kop {
            text-align: center;
            margin-bottom: 15px;
        }

        .judul {
            font-weight: bold;
            font-size: 16px;
            margin: 0;
        }

        .instansi {
            font-size: 12px;
            font-weight: bold;
            margin-top: 2px;
        }

        .periode {
            font-size: 11px;
            margin-top: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000000;
            padding: 5px;
            font-size: 8.5pt;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="kop">
        <div class="judul">Laporan Laba Rugi</div>
        <div class="instansi">AKN IPB</div>
        <div class="periode">
            Periode: <?= (!empty($tglawal) && !empty($tglakhir)) ? date('d F Y', strtotime($tglawal)) . " s/d " . date('d F Y', strtotime($tglakhir)) : 'Semua Periode' ?>
        </div>
    </div>

    <table border="1" cellspacing="0" cellpadding="4">
        <thead>
            <tr>
                <th class="aturtengah" style="width: 30%;">Nama Akun Pendapatan</th>
                <th class="aturtengah" style="width: 20%;">Pendapatan</th>
                <th class="aturtengah" style="width: 30%;">Nama Akun Beban</th>
                <th class="aturtengah" style="width: 20%;">Beban</th>
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

                $kode_akun = $value->kode_akun3;
                $kode = substr($kode_akun, 0, 1);
                $kode_akun1 = $value->kode_akun1 ?? $kode;

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
                ?>

                <?php if ($kode_akun1 == 4 || $kode_akun1 == 5): ?>
                    <tr>
                        <?php if ($kode_akun1 == 4): ?>
                            <td class="aturkiri" style="width: 30%;"><?= $value->nama_akun3 ?></td>
                            <td class="aturkanan" style="width: 20%;"><?= number_format($lb_db, 0, ',', '.') ?></td>
                            <td style="width: 30%;"></td>
                            <td style="width: 20%;"></td>
                        <?php endif; ?>

                        <?php if ($kode_akun1 == 5): ?>
                            <td style="width: 30%;"></td>
                            <td style="width: 20%;"></td>
                            <td class="aturkiri" style="width: 30%;"><?= $value->nama_akun3 ?></td>
                            <td class="aturkanan" style="width: 20%;"><?= number_format($lb_kr, 0, ',', '.') ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th class="aturtengah" style="width: 30%;">JUMLAH PENDAPATAN & BEBAN</th>
                <th class="aturkanan" style="width: 20%;"><?= number_format($lb_td, 0, ',', '.') ?></th>
                <th class="aturtengah" style="width: 30%;"></th>
                <th class="aturkanan" style="width: 20%;"><?= number_format($lb_tk, 0, ',', '.') ?></th>
            </tr>
            <tr>
                <th class="aturtengah" colspan="2" style="width: 50%; font-weight: bold;">
                    <?= ($lb_td - $lb_tk) >= 0 ? 'LABA BERSIH' : 'RUGI BERSIH' ?>
                </th>
                <th class="aturkanan" colspan="2" style="width: 50%; font-weight: bold;">
                    <?= number_format(abs($lb_td - $lb_tk), 0, ',', '.') ?>
                </th>
            </tr>
        </tfoot>
    </table>

    <br><br><br>

    <table border="0" style="width: 100%; border: none;">
        <tr>
            <td style="border: none; width: 60%;"></td>
            <td style="border: none; width: 40%; text-align: center;">
                <?= date('l, d F Y') ?><br><br><br><br><br>
                <strong>Pimpinan AKN</strong>
            </td>
        </tr>
    </table>
</body>

</html>
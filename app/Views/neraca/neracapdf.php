<!DOCTYPE html>
<html>

<head>
    <style type="text/css">
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 9pt;
            color: #000;
        }

        .kop {
            text-align: center;
            margin-bottom: 15px;
        }

        .kop h3 {
            margin: 0;
            font-size: 13pt;
            font-weight: bold;
        }

        .kop .instansi {
            font-size: 10.5pt;
            font-weight: bold;
            margin-top: 2px;
        }

        .kop .periode {
            font-size: 9.5pt;
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
            vertical-align: middle;
        }

        td.text-right {
            text-align: right;
        }

        td.text-center {
            text-align: center;
        }

        td.text-left {
            text-align: left;
        }

        tr.total {
            font-weight: bold;
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <div class="kop">
        <h3>Laporan Posisi Keuangan</h3>
        <div class="instansi">AKN IPB</div>
        <div class="periode">
            Periode: <?= (!empty($tglawal) && !empty($tglakhir)) ? date('d/m/Y', strtotime($tglawal)) . ' s.d ' . date('d/m/Y', strtotime($tglakhir)) : '-' ?>
        </div>
    </div>

    <?php
    $total_aktiva_lancar    = $total_aktiva_lancar    ?? 0;
    $total_aktiva_tetap     = $total_aktiva_tetap     ?? 0;
    $total_kewajiban_pendek = $total_kewajiban_pendek ?? 0;
    $total_kewajiban_panjang = $total_kewajiban_panjang ?? 0;

    $modal_pemilik = $modal_awal    ?? 0;
    $laba_rugi_v   = $laba_rugi     ?? 0;
    $prive_v       = $prive         ?? 0;
    $laba_ditahan  = $laba_rugi_v - $prive_v;
    $total_ekuitas = $modal_pemilik + $laba_ditahan;
    ?>

    <table border="1" cellspacing="0" cellpadding="4">
        <tbody>
            <!-- ASET -->
            <tr class="total" style="background-color: #e9ecef;">
                <td colspan="3" class="text-center" style="width: 100%;"><b>ASET</b></td>
            </tr>

            <!-- ASET LANCAR -->
            <tr>
                <td colspan="3" class="text-left" style="width: 100%;"><b>Aset Lancar</b></td>
            </tr>
            <?php foreach ($dttransaksi as $value): ?>
                <?php if ((int)$value->kode_akun2 === 11): ?>
                    <?php
                    $debit  = (float)$value->jumdebit  + (float)($value->jumdebits ?? 0);
                    $kredit = (float)$value->jumkredit + (float)($value->jumkredits ?? 0);
                    $saldo  = $debit - $kredit;
                    $total_aktiva_lancar += $saldo;
                    ?>
                    <tr>
                        <td class="text-left" style="width: 50%;">&nbsp;&nbsp;&nbsp;&nbsp;<?= $value->nama_akun3 ?></td>
                        <td class="text-right" style="width: 25%;"><?= number_format($saldo, 0, ",", ".") ?></td>
                        <td style="width: 25%;"></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            <tr class="total">
                <td class="text-left" style="width: 50%;">&nbsp;&nbsp;&nbsp;&nbsp;Total Aset Lancar</td>
                <td style="width: 25%;"></td>
                <td class="text-right" style="width: 25%;"><?= number_format($total_aktiva_lancar, 0, ",", ".") ?></td>
            </tr>

            <!-- ASET TETAP -->
            <tr>
                <td colspan="3" class="text-left" style="width: 100%;"><b>Aset Tetap</b></td>
            </tr>
            <?php foreach ($dttransaksi as $value): ?>
                <?php if ((int)$value->kode_akun2 === 12): ?>
                    <?php
                    $debit  = (float)$value->jumdebit  + (float)($value->jumdebits ?? 0);
                    $kredit = (float)$value->jumkredit + (float)($value->jumkredits ?? 0);
                    $saldo  = $debit - $kredit;
                    $total_aktiva_tetap += $saldo;
                    ?>
                    <tr>
                        <td class="text-left" style="width: 50%;">&nbsp;&nbsp;&nbsp;&nbsp;<?= $value->nama_akun3 ?></td>
                        <td class="text-right" style="width: 25%;"><?= number_format(abs($saldo), 0, ",", ".") ?></td>
                        <td style="width: 25%;"></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            <tr class="total">
                <td class="text-left" style="width: 50%;">&nbsp;&nbsp;&nbsp;&nbsp;Total Aset Tetap</td>
                <td style="width: 25%;"></td>
                <td class="text-right" style="width: 25%;"><?= number_format($total_aktiva_tetap, 0, ",", ".") ?></td>
            </tr>

            <tr class="total" style="background-color: #d4edda;">
                <td colspan="2" class="text-left" style="width: 75%;">JUMLAH ASET</td>
                <td class="text-right" style="width: 25%;"><?= number_format($total_aktiva_lancar + $total_aktiva_tetap, 0, ",", ".") ?></td>
            </tr>

            <!-- LIABILITAS & EKUITAS -->
            <tr class="total" style="background-color: #e9ecef;">
                <td colspan="3" class="text-center" style="width: 100%;"><b>LIABILITAS & EKUITAS</b></td>
            </tr>

            <!-- LIABILITAS JANGKA PENDEK -->
            <tr>
                <td colspan="3" class="text-left" style="width: 100%;"><b>Liabilitas Jangka Pendek</b></td>
            </tr>
            <?php foreach ($dttransaksi as $value): ?>
                <?php if ((int)$value->kode_akun2 === 21): ?>
                    <?php
                    $debit  = (float)$value->jumdebit  + (float)($value->jumdebits ?? 0);
                    $kredit = (float)$value->jumkredit + (float)($value->jumkredits ?? 0);
                    $saldo  = $debit - $kredit;
                    $total_kewajiban_pendek += $saldo;
                    ?>
                    <tr>
                        <td class="text-left" style="width: 50%;">&nbsp;&nbsp;&nbsp;&nbsp;<?= $value->nama_akun3 ?></td>
                        <td class="text-right" style="width: 25%;"><?= number_format(abs($saldo), 0, ",", ".") ?></td>
                        <td style="width: 25%;"></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            <tr class="total">
                <td class="text-left" style="width: 50%;">&nbsp;&nbsp;&nbsp;&nbsp;Total Liabilitas Jangka Pendek</td>
                <td style="width: 25%;"></td>
                <td class="text-right" style="width: 25%;"><?= number_format(abs($total_kewajiban_pendek), 0, ",", ".") ?></td>
            </tr>

            <!-- LIABILITAS JANGKA PANJANG -->
            <tr>
                <td colspan="3" class="text-left" style="width: 100%;"><b>Liabilitas Jangka Panjang</b></td>
            </tr>
            <?php foreach ($dttransaksi as $value): ?>
                <?php if ((int)$value->kode_akun2 === 22): ?>
                    <?php
                    $debit  = (float)$value->jumdebit  + (float)($value->jumdebits ?? 0);
                    $kredit = (float)$value->jumkredit + (float)($value->jumkredits ?? 0);
                    $saldo  = $debit - $kredit;
                    $total_kewajiban_panjang += $saldo;
                    ?>
                    <tr>
                        <td class="text-left" style="width: 50%;">&nbsp;&nbsp;&nbsp;&nbsp;<?= $value->nama_akun3 ?></td>
                        <td class="text-right" style="width: 25%;"><?= number_format(abs($saldo), 0, ",", ".") ?></td>
                        <td style="width: 25%;"></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            <tr class="total">
                <td class="text-left" style="width: 50%;">&nbsp;&nbsp;&nbsp;&nbsp;Total Liabilitas Jangka Panjang</td>
                <td style="width: 25%;"></td>
                <td class="text-right" style="width: 25%;"><?= number_format($total_kewajiban_panjang, 0, ",", ".") ?></td>
            </tr>

            <!-- EKUITAS -->
            <tr>
                <td colspan="3" class="text-left" style="width: 100%;"><b>Ekuitas</b></td>
            </tr>
            <tr>
                <td class="text-left" style="width: 50%;">&nbsp;&nbsp;&nbsp;&nbsp;Modal Pemilik</td>
                <td class="text-right" style="width: 25%;"><?= number_format($modal_pemilik, 0, ",", ".") ?></td>
                <td style="width: 25%;"></td>
            </tr>
            <tr>
                <td class="text-left" style="width: 50%;">&nbsp;&nbsp;&nbsp;&nbsp;Laba Ditahan</td>
                <td class="text-right" style="width: 25%;"><?= number_format($laba_ditahan, 0, ",", ".") ?></td>
                <td style="width: 25%;"></td>
            </tr>
            <tr class="total">
                <td class="text-left" style="width: 50%;">&nbsp;&nbsp;&nbsp;&nbsp;Total Ekuitas</td>
                <td style="width: 25%;"></td>
                <td class="text-right" style="width: 25%;"><?= number_format($total_ekuitas, 0, ",", ".") ?></td>
            </tr>

            <tr class="total" style="background-color: #d4edda;">
                <td colspan="2" class="text-left" style="width: 75%;">JUMLAH LIABILITAS & EKUITAS</td>
                <td class="text-right" style="width: 25%;"><?= number_format(abs($total_kewajiban_pendek) + abs($total_kewajiban_panjang) + $total_ekuitas, 0, ",", ".") ?></td>
            </tr>
        </tbody>
    </table>

    <br><br><br>

    <table border="0" style="width: 100%; border: none;">
        <tr>
            <td style="border: none; width: 65%;"></td>
            <td style="border: none; width: 35%; text-align: center; font-size: 8.5pt;">
                Dicetak pada: <?= date('d/m/Y') ?><br><br>
                Mengetahui,<br><br><br><br>
                _________________________<br>
                <i>Bagian Akuntansi</i>
            </td>
        </tr>
    </table>
</body>

</html>
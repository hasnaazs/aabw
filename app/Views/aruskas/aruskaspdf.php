<style>
    body {
        font-family: Helvetica, Arial, sans-serif;
        font-size: 9pt;
        color: #000;
        margin: 35px;
    }

    .kop {
        text-align: center;
        margin-bottom: 15px;
    }

    .kop h3 {
        margin: 0;
        font-size: 13pt;
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
        border-collapse: collapse;
        width: 90%;
        margin: 15px auto;
    }

    th,
    td {
        border: 1px solid #444;
        padding: 5px 6px;
        font-size: 9pt;
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
    }

    .footer {
        text-align: right;
        margin-top: 20px;
        font-size: 8pt;
        font-style: italic;
    }

    .signature-container {
        width: 90%;
        margin: 50px auto 0 auto;
        display: flex;
        justify-content: flex-end;
    }

    .signature {
        width: 220px;
        text-align: right;
    }
</style>

<?php
function fmt_kas_pdf($angka)
{
    if ($angka < 0) {
        return '(' . number_format(abs($angka), 0, ",", ".") . ')';
    }
    return number_format($angka, 0, ",", ".");
}

$totpenerimaan = 0;
$totpengeluaran = 0;
$tinvestasi = 0;
$modal = 0;
$tprive = 0;
$saldo_awal = $saldo_awal ?? 0;

foreach ($dttransaksi as $value) {
    if ($value->id_status == 1 && (float) $value->debit > 0) {
        $totpenerimaan += (float) $value->debit;
    }
}
?>

<div class="kop">
    <h3>Laporan Arus Kas</h3>
    <div class="instansi">AKN IPB</div>
    <div class="periode">Periode:
        <?= ($tglawal && $tglakhir) ? date('d/m/Y', strtotime($tglawal)) . ' s.d ' . date('d/m/Y', strtotime($tglakhir)) : 'Semua Periode' ?>
    </div>
</div>

<table cellspacing="0" cellpadding="3">
    <tbody>
        <tr class="total">
            <td colspan="3" class="text-center" width="110%"><b>ARUS KAS DARI AKTIVITAS OPERASI</b></td>
        </tr>
        <tr>
            <td width="50%" class="text-left" style="font-weight:bold;">Penerimaan Kas dari Pelanggan</td>
            <td width="30%" class="text-right"><?= fmt_kas_pdf($totpenerimaan) ?></td>
            <td width="30%"></td>
        </tr>
        <tr>
            <td colspan="3" class="text-left"><b>Pengeluaran Kas</b></td>
        </tr>
        <?php foreach ($dttransaksi as $value): ?>
            <?php if ($value->id_status == 2 && (float) $value->kredit > 0): ?>
                <?php
                $pengeluaran = (float) $value->kredit;
                $totpengeluaran += $pengeluaran;
                ?>
                <tr>
                    <td width="50%" class="text-left" style="text-indent:10px;"><?= esc($value->ket_jurnal ?? $value->ketjurnal ?? '-') ?></td>
                    <td width="30%" class="text-right"><?= fmt_kas_pdf(-$pengeluaran) ?></td>
                    <td width="30%"></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        <tr class="total">
            <td width="50%" class="text-left" style="text-indent:15px;">Total Pengeluaran Kas</td>
            <td width="30%"></td>
            <td width="30%" class="text-right"><?= fmt_kas_pdf(-$totpengeluaran) ?></td>
        </tr>
        <tr class="total" style="border-top:2px solid #000;">
            <td colspan="2" class="text-left">Kas Bersih dari Aktivitas Operasi</td>
            <td width="30%" class="text-right"><?= fmt_kas_pdf($totpenerimaan - $totpengeluaran) ?></td>
        </tr>

        <tr class="total">
            <td colspan="3" class="text-center"><b>ARUS KAS DARI AKTIVITAS INVESTASI</b></td>
        </tr>
        <tr class="total">
            <td colspan="2" class="text-left">Kas Bersih dari Aktivitas Investasi</td>
            <td width="30%" class="text-right">-</td>
        </tr>

        <tr class="total">
            <td colspan="3" class="text-center"><b>ARUS KAS DARI AKTIVITAS PENDANAAN</b></td>
        </tr>
        <?php foreach ($dttransaksi as $value): ?>
            <?php if ($value->id_status == 3 && (float) $value->debit > 0 && (int) $value->debit == 30000000): ?>
                <?php
                $setor = (float) $value->debit;
                $modal += $setor;
                ?>
                <tr>
                    <td width="50%" class="text-left" style="text-indent:10px;"><?= esc($value->ket_jurnal ?? $value->ketjurnal ?? 'Setoran Modal Tunai') ?></td>
                    <td width="30%" class="text-right"><?= fmt_kas_pdf($setor) ?></td>
                    <td width="30%"></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php foreach ($dttransaksi as $value): ?>
            <?php if ($value->id_status == 4 && (float) $value->kredit > 0): ?>
                <?php
                $prive = (float) $value->kredit;
                $tprive += $prive;
                ?>
                <tr>
                    <td width="50%" class="text-left" style="text-indent:10px;"><?= esc($value->ket_jurnal ?? $value->ketjurnal ?? 'Prive') ?></td>
                    <td width="30%" class="text-right"><?= fmt_kas_pdf(-$prive) ?></td>
                    <td width="30%"></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php $tpendanaan = $modal - $tprive; ?>
        <tr class="total">
            <td colspan="2" class="text-left">Kas Bersih dari Aktivitas Pendanaan</td>
            <td width="30%" class="text-right"><?= fmt_kas_pdf($tpendanaan) ?></td>
        </tr>

        <?php
        $kas_bersih_periode = ($totpenerimaan - $totpengeluaran) + $tinvestasi + $tpendanaan;
        $saldo_akhir = $saldo_awal + $kas_bersih_periode;
        ?>
        <tr class="total" style="border-top:2px solid #000;">
            <td colspan="2" class="text-left">Kenaikan / Penurunan Kas Bersih</td>
            <td width="30%" class="text-right"><?= fmt_kas_pdf($kas_bersih_periode) ?></td>
        </tr>
        <tr class="total">
            <td colspan="2" class="text-left">Saldo Awal Kas</td>
            <td width="30%" class="text-right"><?= fmt_kas_pdf($saldo_awal) ?></td>
        </tr>
        <tr class="total" style="border-top:1px solid #000;">
            <td colspan="2" class="text-left"><b>Saldo Akhir Kas</b></td>
            <td width="30%" class="text-right"><b><?= fmt_kas_pdf($saldo_akhir) ?></b></td>
        </tr>
    </tbody>
</table>

<div class="signature-container">
    <div class="signature">
        Mengetahui,<br><br><br>
        _________________________<br>
        <i>Bagian Akuntansi</i>
    </div>
</div>

<p class="footer">Dicetak pada: <?= date('d/m/Y') ?></p>
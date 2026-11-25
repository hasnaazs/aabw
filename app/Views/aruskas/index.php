<?= $this->extend('layout/backend') ?>

<?= $this->section('title') ?>
SIA-IPB &mdash; Arus Kas
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="section">
<div class="section-header">
    <h1>Laporan Arus Kas</h1>
</div>

<div class="section-body">
    <div class="card">
        <div class="card-body">
            <form action="<?= site_url('aruskas') ?>" method="GET">
                <div class="row g-3">
                    <div class="col">
                        <input type="date" class="form-control" name="tglawal" value="<?= esc($tglawal) ?>">
                    </div>
                    <div class="col">
                        <input type="date" class="form-control" name="tglakhir" value="<?= esc($tglakhir) ?>">
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-list"></i> Tampilkan</button>
                        <button type="submit" class="btn btn-danger" formtarget="_blank" formaction="<?= site_url('aruskas/aruskaspdf') ?>">Cetak PDF</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-striped table-md">
                    <?php
                    function fmt_kas_web($angka)
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

                    <tr>
                        <td><b>Arus Kas dari Aktivitas Operasi</b></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="text-left" style="padding-left:3em">Penerimaan Kas</td>
                        <td></td>
                        <td class="text-right"><?= fmt_kas_web($totpenerimaan) ?></td>
                    </tr>
                    <tr>
                        <td class="text-left" style="padding-left:2em"><b>Dikurangi:</b></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php foreach ($dttransaksi as $value) : ?>
                        <?php if ($value->id_status == 2 && (float) $value->kredit > 0) : ?>
                            <?php
                            $pengeluaran = (float) $value->kredit;
                            $totpengeluaran += $pengeluaran;
                            ?>
                            <tr>
                                <td class="text-left" style="padding-left:3em"><?= esc($value->ket_jurnal ?? $value->ketjurnal ?? '-') ?></td>
                                <td class="text-right"><?= fmt_kas_web(-$pengeluaran) ?></td>
                                <td></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <tr>
                        <td><b>Kas Bersih dari Aktivitas Operasi</b></td>
                        <td></td>
                        <td class="text-right"><b><?= fmt_kas_web($totpenerimaan - $totpengeluaran) ?></b></td>
                    </tr>

                    <tr>
                        <td><b>Arus Kas dari Aktivitas Investasi</b></td>
                        <td></td>
                        <td class="text-right">-</td>
                    </tr>

                    <tr>
                        <td><b>Arus Kas dari Aktivitas Pendanaan</b></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php foreach ($dttransaksi as $value) : ?>
                        <?php if ($value->id_status == 3 && (float) $value->debit > 0 && (int) $value->debit == 30000000) : ?>
                            <?php
                            $setor = (float) $value->debit;
                            $modal += $setor;
                            ?>
                            <tr>
                                <td class="text-left" style="padding-left:3em"><?= esc($value->ket_jurnal ?? $value->ketjurnal ?? 'Setoran Modal Tunai') ?></td>
                                <td class="text-right"><?= fmt_kas_web($setor) ?></td>
                                <td></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <?php foreach ($dttransaksi as $value) : ?>
                        <?php if ($value->id_status == 4 && (float) $value->kredit > 0) : ?>
                            <?php
                            $prive = (float) $value->kredit;
                            $tprive += $prive;
                            ?>
                            <tr>
                                <td class="text-left" style="padding-left:3em"><?= esc($value->ket_jurnal ?? $value->ketjurnal ?? 'Prive') ?></td>
                                <td class="text-right"><?= fmt_kas_web(-$prive) ?></td>
                                <td></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <?php $tpendanaan = $modal - $tprive; ?>
                    <tr>
                        <td><b>Kas Bersih dari Aktivitas Pendanaan</b></td>
                        <td></td>
                        <td class="text-right"><b><?= fmt_kas_web($tpendanaan) ?></b></td>
                    </tr>

                    <?php
                    $kas_bersih_periode = ($totpenerimaan - $totpengeluaran) + $tinvestasi + $tpendanaan;
                    $saldo_akhir = $saldo_awal + $kas_bersih_periode;
                    ?>
                    <tr>
                        <td><b>Kenaikan / Penurunan Kas Bersih</b></td>
                        <td></td>
                        <td class="text-right"><b><?= fmt_kas_web($kas_bersih_periode) ?></b></td>
                    </tr>
                    <tr>
                        <td><b>Saldo Awal Kas</b></td>
                        <td></td>
                        <td class="text-right"><?= fmt_kas_web($saldo_awal) ?></td>
                    </tr>
                    <tr>
                        <td><b>Saldo Akhir Kas</b></td>
                        <td></td>
                        <td class="text-right"><b><?= fmt_kas_web($saldo_akhir) ?></b></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
</section>
<?= $this->endSection() ?>
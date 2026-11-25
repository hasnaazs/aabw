<?= $this->extend('layout/backend') ?>

<?= $this->section('content') ?>
<title>SIA-IPB &mdash; Neraca Lajur</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Neraca Lajur</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <form action="<?= site_url('neracalajur') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4 mb-2">
                            <input type="date" name="tglawal" class="form-control" value="<?= $tglawal ?>">
                        </div>
                        <div class="col-md-4 mb-2">
                            <input type="date" name="tglakhir" class="form-control" value="<?= $tglakhir ?>">
                        </div>
                        <div class="col-md-4 mb-2">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-list"></i> Tampilkan</button>
                            <input type="submit" formtarget="_blank" class="btn btn-success"
                                formaction="<?= site_url('neracalajur/neracalajurpdf') ?>" value="Cetak PDF">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-md">
                        <thead style="background-color: #6777ef; color: white;">
                            <tr>
                                <th class="text-center text-white" rowspan="2" style="vertical-align: middle;">Kode</th>
                                <th class="text-center text-white" rowspan="2" style="vertical-align: middle;">Nama Akun</th>
                                <th class="text-center text-white" colspan="2">Neraca Saldo</th>
                                <th class="text-center text-white" colspan="2">Jurnal Penyesuaian</th>
                                <th class="text-center text-white" colspan="2">NS yang Disesuaikan</th>
                                <th class="text-center text-white" colspan="2">Laba Rugi</th>
                                <th class="text-center text-white" colspan="2">Neraca</th>
                            </tr>
                            <tr>
                                <th class="text-center text-white">Debit</th>
                                <th class="text-center text-white">Kredit</th>
                                <th class="text-center text-white">Debit</th>
                                <th class="text-center text-white">Kredit</th>
                                <th class="text-center text-white">Debit</th>
                                <th class="text-center text-white">Kredit</th>
                                <th class="text-center text-white">Debit</th>
                                <th class="text-center text-white">Kredit</th>
                                <th class="text-center text-white">Debit</th>
                                <th class="text-center text-white">Kredit</th>
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
                                    <td class="text-center"><?= $value->kode_akun3 ?></td>
                                    <td><?= $value->nama_akun3 ?></td>
                                    <td class="text-right"><?= number_format($debitnew, 0, ',', '.') ?></td>
                                    <td class="text-right"><?= number_format($kreditnew, 0, ',', '.') ?></td>
                                    <td class="text-right"><?= number_format($debitnewjp, 0, ',', '.') ?></td>
                                    <td class="text-right"><?= number_format($kreditnewjp, 0, ',', '.') ?></td>
                                    <td class="text-right"><?= number_format($debs, 0, ',', '.') ?></td>
                                    <td class="text-right"><?= number_format($kres, 0, ',', '.') ?></td>
                                    <td class="text-right"><?= number_format($lb_db, 0, ',', '.') ?></td>
                                    <td class="text-right"><?= number_format($lb_kr, 0, ',', '.') ?></td>
                                    <td class="text-right"><?= number_format($nrbs, 0, ',', '.') ?></td>
                                    <td class="text-right"><?= number_format($nrkd, 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="font-weight-bold" style="background-color: #f8f9fa;">
                                <td colspan="2" class="text-center">JUMLAH</td>
                                <td class="text-right"><?= number_format($td, 0, ',', '.') ?></td>
                                <td class="text-right"><?= number_format($tk, 0, ',', '.') ?></td>
                                <td class="text-right"><?= number_format($tdjp, 0, ',', '.') ?></td>
                                <td class="text-right"><?= number_format($tkjp, 0, ',', '.') ?></td>
                                <td class="text-right"><?= number_format($totd, 0, ',', '.') ?></td>
                                <td class="text-right"><?= number_format($totk, 0, ',', '.') ?></td>
                                <td class="text-right"><?= number_format($lb_td, 0, ',', '.') ?></td>
                                <td class="text-right"><?= number_format($lb_tk, 0, ',', '.') ?></td>
                                <td class="text-right"><?= number_format($totns, 0, ',', '.') ?></td>
                                <td class="text-right"><?= number_format($totkd, 0, ',', '.') ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
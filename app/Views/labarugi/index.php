<?= $this->extend('layout/backend') ?>

<?= $this->section('content') ?>
<title>SIA-IPB &mdash; Laba Rugi</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Laporan Laba Rugi</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Filter Laporan Laba Rugi</h4>
            </div>
            <div class="card-body">
                <form action="<?= site_url('labarugi') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="row align-items-center">
                        <div class="col-md-3 mb-2">
                            <label>Tanggal Awal</label>
                            <input type="date" name="tglawal" class="form-control" value="<?= $tglawal ?>">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>Tanggal Akhir</label>
                            <input type="date" name="tglakhir" class="form-control" value="<?= $tglakhir ?>">
                        </div>
                        <div class="col-md-6 mb-2 mt-4 pt-1">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-list"></i> Tampilkan</button>
                            <input type="submit" formtarget="_blank" class="btn btn-success ml-2"
                                formaction="<?= site_url('labarugi/labarugipdf') ?>" value="Cetak PDF">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Laporan Laba Rugi</h4>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead style="background-color: #6777ef; color: white;">
                            <tr>
                                <th class="text-center text-white" style="vertical-align: middle;">Nama Akun Pendapatan</th>
                                <th class="text-right text-white" style="vertical-align: middle;">Pendapatan</th>
                                <th class="text-center text-white" style="vertical-align: middle;">Nama Akun Beban</th>
                                <th class="text-right text-white" style="vertical-align: middle;">Beban</th>
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

                                // Tambahan Jurnal Penyesuaian
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

                                <?php if ($kode_akun1 == 4 || $kode_akun1 == 5): ?>
                                    <tr>
                                        <?php if ($kode_akun1 == 4): ?>
                                            <td><?= $value->nama_akun3 ?></td>
                                            <td class="text-right"><?= number_format($lb_db, 0, ',', '.') ?></td>
                                            <td></td>
                                            <td class="text-right"></td>
                                        <?php endif; ?>

                                        <?php if ($kode_akun1 == 5): ?>
                                            <td></td>
                                            <td class="text-right"></td>
                                            <td><?= $value->nama_akun3 ?></td>
                                            <td class="text-right"><?= number_format($lb_kr, 0, ',', '.') ?></td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="font-weight-bold">
                            <tr style="background-color: #f8f9fa;">
                                <td class="text-center">JUMLAH PENDAPATAN & BEBAN</td>
                                <td class="text-right"><?= number_format($lb_td, 0, ',', '.') ?></td>
                                <td class="text-center"></td>
                                <td class="text-right"><?= number_format($lb_tk, 0, ',', '.') ?></td>
                            </tr>
                            <tr style="background-color: #d4edda; color: #155724; font-size: 11pt;">
                                <td class="text-center" colspan="2">
                                    <?= ($lb_td - $lb_tk) >= 0 ? 'LABA BERSIH' : 'RUGI BERSIH' ?>
                                </td>
                                <td class="text-right" colspan="2">
                                    <?= number_format(abs($lb_td - $lb_tk), 0, ',', '.') ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
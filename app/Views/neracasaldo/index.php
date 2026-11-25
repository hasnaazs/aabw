<?= $this->extend('layout/backend') ?>

<?= $this->section('content') ?>
<title>SIA-IPB &mdash; Neraca Saldo</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Laporan Neraca Saldo</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <form action="<?= site_url('neracasaldo') ?>" method="POST">
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
                                formaction="<?= site_url('neracasaldo/neracasaldopdf') ?>" value="Cetak PDF">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-md">
                        <thead>
                            <tr>
                                <th class="text-center" rowspan="2" style="vertical-align: middle; width: 15%">Kode Akun</th>
                                <th class="text-center" rowspan="2" style="vertical-align: middle;">Keterangan / Nama Akun</th>
                                <th class="text-center" colspan="2" style="width: 40%">Saldo</th>
                            </tr>
                            <tr>
                                <th class="text-right" style="width: 20%">Debit</th>
                                <th class="text-right" style="width: 20%">Kredit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $td = 0;
                            $tk = 0;
                            ?>
                            <?php foreach ($dttransaksi as $key => $value): ?>
                                <?php
                                $d = $value->jumdebit;
                                $k = $value->jumkredit;
                                $neraca = $d - $k;

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
                                ?>
                                <tr>
                                    <td class="text-center"><?= $value->kode_akun3 ?></td>
                                    <td><?= $value->nama_akun3 ?></td>
                                    <td class="text-right"><?= number_format($debitnew, 0, ',', '.') ?></td>
                                    <td class="text-right"><?= number_format($kreditnew, 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="font-weight-bold" style="background-color: #f8f9fa;">
                                <td colspan="2" class="text-center">JUMLAH</td>
                                <td class="text-right"><?= number_format($td, 0, ',', '.') ?></td>
                                <td class="text-right"><?= number_format($tk, 0, ',', '.') ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
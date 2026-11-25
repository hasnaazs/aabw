<?= $this->extend('layout/backend') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Laporan Posting</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <form action="<?= site_url('posting') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="row g-3 align-items-center">
                        <div class="col-md-3 mb-2">
                            <input type="date" name="tglawal" class="form-control" value="<?= $tglawal ?>">
                        </div>
                        <div class="col-md-3 mb-2">
                            <input type="date" name="tglakhir" class="form-control" value="<?= $tglakhir ?>">
                        </div>
                        <div class="col-md-3 mb-2">
                            <select name="kode_akun3" class="form-control">
                                <option value="">Pilih Kode Akun</option>
                                <?php foreach ($dtakun3 as $key => $value): ?>
                                    <option value="<?= $value->kode_akun3 ?>" <?= $kode_akun3 == $value->kode_akun3 ? 'selected' : '' ?>>
                                        <?= $value->kode_akun3 ?> | <?= $value->nama_akun3 ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-list"></i> Tampilkan</button>
                            <input type="submit" formtarget="_blank" class="btn btn-success" formaction="<?= site_url('posting/postingpdf') ?>" value="Cetak PDF">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-striped table-md table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" rowspan="2" style="vertical-align: middle;">Tanggal</th>
                                <th class="text-center" rowspan="2" style="vertical-align: middle;">Keterangan</th>
                                <th class="text-center" rowspan="2" style="vertical-align: middle;">Ref</th>
                                <th class="text-center" rowspan="2" style="vertical-align: middle;">Debit</th>
                                <th class="text-center" rowspan="2" style="vertical-align: middle;">Kredit</th>
                                <th class="text-center" colspan="2">Saldo</th>
                            </tr>
                            <tr>
                                <th class="text-center">Debit</th>
                                <th class="text-center">Kredit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $dbt = 0; ?>
                            <?php foreach ($dttransaksi as $key => $value): ?>
                                <?php
                                if ($value->debit) {
                                    $dbt = $dbt + $value->debit;
                                } else {
                                    $dbt = $dbt - $value->kredit;
                                }

                                $ndbt1 = $dbt >= 0 ? $dbt : 0;
                                $ndbt2 = $dbt < 0 ? $dbt : 0;
                                $ket   = $value->ket_jurnal ?? $value->ketjurnal ?? '';
                                ?>
                                <tr>
                                    <td class="text-center"><?= $value->tanggal ?></td>
                                    <td><?= $ket ?></td>
                                    <td class="text-center"><?= $value->kode_akun3 ?></td>
                                    <td class="text-right"><?= number_format($value->debit, 0, ',', '.') ?></td>
                                    <td class="text-right"><?= number_format($value->kredit, 0, ',', '.') ?></td>
                                    <td class="text-right"><?= number_format($ndbt1, 0, ',', '.') ?></td>
                                    <td class="text-right"><?= number_format(abs($ndbt2), 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
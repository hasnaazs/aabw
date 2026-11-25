<?= $this->extend('layout/backend') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Laporan Jurnal Umum</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Filter Jurnal Umum</h4>
            </div>
            <div class="card-body">
                <form action="<?= site_url('jurnalumum') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="row align-items-center">
                        <div class="col-md-4 mb-2">
                            <label>Tanggal Awal</label>
                            <input type="date" name="tglawal" class="form-control" value="<?= $tglawal ?>">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label>Tanggal Akhir</label>
                            <input type="date" name="tglakhir" class="form-control" value="<?= $tglakhir ?>">
                        </div>
                        <div class="col-md-4 mb-2 mt-md-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-list"></i> Tampilkan
                            </button>
                            <button type="submit" formaction="<?= site_url('jurnalumum/cetakjupdf') ?>" formtarget="_blank" class="btn btn-success">
                                <i class="fas fa-file-pdf"></i> Cetak PDF
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Data Jurnal Umum</h4>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 15%">Tanggal</th>
                                <th>Keterangan / Nama Akun</th>
                                <th class="text-center" style="width: 12%">Ref</th>
                                <th class="text-right" style="width: 18%">Debit</th>
                                <th class="text-right" style="width: 18%">Kredit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dttransaksi as $key => $value): ?>
                                <tr>
                                    <td class="text-center"><?= $value->tanggal ?></td>
                                    <td>
                                        <?php if ($value->debit != 0): ?>
                                            <?= $value->nama_akun3 ?>
                                        <?php else: ?>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><?= $value->nama_akun3 ?></em>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center"><?= $value->kode_akun3 ?></td>
                                    <td class="text-right"><?= number_format($value->debit, 0, ',', '.') ?></td>
                                    <td class="text-right"><?= number_format($value->kredit, 0, ',', '.') ?></td>
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
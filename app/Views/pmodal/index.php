<?= $this->extend('layout/backend') ?>

<?= $this->section('content') ?>
<title>SIA-IPB &mdash; Perubahan Modal</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Laporan Perubahan Modal</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Filter Laporan Perubahan Modal</h4>
            </div>
            <div class="card-body">
                <form action="<?= site_url('pmodal') ?>" method="GET">
                    <?= csrf_field() ?>
                    <div class="row align-items-center">
                        <div class="col-md-3 mb-2">
                            <label>Tanggal Awal</label>
                            <input type="date" class="form-control" name="tglawal" value="<?= $tglawal ?>">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>Tanggal Akhir</label>
                            <input type="date" class="form-control" name="tglakhir" value="<?= $tglakhir ?>">
                        </div>
                        <div class="col-md-6 mb-2 mt-4 pt-1">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-list"></i> Tampilkan</button>
                            <input type="submit" class="btn btn-danger ml-2" formtarget="_blank"
                                formaction="<?= site_url('pmodal/pmodalpdf') ?>" value="Cetak PDF">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Laporan Perubahan Modal</h4>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead style="background-color: #6777ef; color: white;">
                            <tr>
                                <th class="text-white">Keterangan</th>
                                <th class="text-right text-white" style="width: 30%;">Jumlah (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="font-weight-bold">Modal Awal</td>
                                <td class="text-right font-weight-bold"><?= number_format($dttransaksi['modal_awal'], 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td style="padding-left: 3em;">Laba / Rugi Bersih</td>
                                <td class="text-right"><?= number_format($dttransaksi['laba_rugi'], 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td style="padding-left: 3em;">Prive (Pengambilan Pribadi)</td>
                                <td class="text-right"><?= number_format($dttransaksi['prive'], 0, ',', '.') ?></td>
                            </tr>
                            <tr style="background-color: #f8f9fa;" class="font-weight-bold">
                                <td>Penambahan / (Pengurangan) Modal</td>
                                <td class="text-right"><?= number_format($dttransaksi['penambahan_modal'], 0, ',', '.') ?></td>
                            </tr>
                            <tr style="background-color: #d4edda; color: #155724; font-size: 11pt;" class="font-weight-bold">
                                <td>Modal Akhir</td>
                                <td class="text-right"><?= number_format($dttransaksi['modal_akhir'], 0, ',', '.') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
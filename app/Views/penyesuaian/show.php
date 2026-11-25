<?= $this->extend('layout/backend') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Detail Penyesuaian</h1>
        <div class="section-header-button">
            <a href="<?= site_url('penyesuaian') ?>" class="btn btn-primary">Back</a>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Detail Penyesuaian</h4>
            </div>
            <div class="card-body p-4">
                <table class="table table-borderless style-table mb-4">
                    <tr>
                        <td style="width: 15%">Tanggal</td>
                        <td style="width: 2%">:</td>
                        <td><?= $dtpenyesuaian->tanggal ?></td>
                    </tr>
                    <tr>
                        <td>Deskripsi</td>
                        <td>:</td>
                        <td><?= $dtpenyesuaian->deskripsi ?></td>
                    </tr>
                    <tr>
                        <td>Nilai</td>
                        <td>:</td>
                        <td>Rp <?= number_format($dtpenyesuaian->nilai, 0, ",", ".") ?></td>
                    </tr>
                    <tr>
                        <td>Waktu</td>
                        <td>:</td>
                        <td><?= $dtpenyesuaian->waktu ?> Bulan</td>
                    </tr>
                    <tr>
                        <td>Jumlah</td>
                        <td>:</td>
                        <td>Rp <?= number_format($dtpenyesuaian->jumlah, 0, ",", ".") ?> / Bulan</td>
                    </tr>
                </table>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%">No</th>
                            <th>Kode Akun</th>
                            <th>Nama Akun</th>
                            <th class="text-right">Debit</th>
                            <th class="text-right">Kredit</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dtnilaipenyesuaian as $key => $item): ?>
                            <tr>
                                <td class="text-center"><?= $key + 1 ?></td>
                                <td><?= $item->kode_akun3 ?></td>
                                <td><?= $item->nama_akun3 ?></td>
                                <td class="text-right">Rp <?= number_format($item->debit, 0, ",", ".") ?></td>
                                <td class="text-right">Rp <?= number_format($item->kredit, 0, ",", ".") ?></td>
                                <td><?= $item->status ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
<?= $this->extend('layout/backend') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="<?= site_url('transaksi') ?>" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Detail Transaksi</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Informasi Transaksi</h4>
            </div>
            <div class="card-body">
                <!-- Header Informasi Transaksi -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th style="width: 30%">No. Kwitansi</th>
                                <td style="width: 5%">:</td>
                                <td><strong><?= $dttransaksi->kwitansi ?></strong></td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <td>:</td>
                                <td><?= date('d/m/Y', strtotime($dttransaksi->tanggal)) ?></td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>:</td>
                                <td><?= $dttransaksi->deskripsi ?></td>
                            </tr>
                            <tr>
                                <th>Ket. Jurnal</th>
                                <td>:</td>
                                <td><?= $dttransaksi->ket_jurnal ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Tabel Rincian Nilai -->
                <h5 class="mb-3">Rincian Jurnal</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr class="bg-light">
                                <th class="text-center" style="width: 5%">No</th>
                                <th>Kode Akun</th>
                                <th>Nama Akun</th>
                                <th class="text-right">Debit (Rp)</th>
                                <th class="text-right">Kredit (Rp)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dtnilai as $key => $item) : ?>
                                <tr>
                                    <td class="text-center"><?= $key + 1 ?></td>
                                    <td><?= $item->kode_akun3 ?></td>
                                    <td><?= $item->nama_akun3 ?></td>
                                    <td class="text-right"><?= number_format($item->debit, 0, ",", ".") ?></td>
                                    <td class="text-right"><?= number_format($item->kredit, 0, ",", ".") ?></td>
                                    <td>
                                        <span class="badge badge-light"><?= $item->status ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>
<?= $this->extend('layout/backend') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="<?= site_url('transaksi') ?>" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Edit Transaksi</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Form Edit Transaksi</h4>
            </div>
            <div class="card-body">
                <form action="<?= site_url('transaksi/' . $dttransaksi->id_transaksi) ?>" method="post" autocomplete="off">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>No. Kwitansi *</label>
                            <input type="text" name="kwitansi" value="<?= $dttransaksi->kwitansi ?>" class="form-control" maxlength="4" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Tanggal *</label>
                            <input type="date" name="tanggal" value="<?= $dttransaksi->tanggal ?>" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"><?= $dttransaksi->deskripsi ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Keterangan Jurnal</label>
                        <input type="text" name="ket_jurnal" value="<?= $dttransaksi->ket_jurnal ?>" class="form-control">
                    </div>

                    <hr>
                    <h5 class="mb-3">Rincian Nilai Transaksi</h5>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%">No</th>
                                    <th>Kode Akun 3</th>
                                    <th>Status</th>
                                    <th>Debit</th>
                                    <th>Kredit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dtnilai as $key => $item) : ?>
                                    <tr>
                                        <td class="text-center"><?= $key + 1 ?></td>
                                        <!-- Hidden Input ID Nilai untuk Update Batch -->
                                        <input type="hidden" name="id_nilai[]" value="<?= $item->id_nilai ?>">

                                        <td>
                                            <select name="kode_akun3[]" class="form-control" required>
                                                <option value="">-- Pilih Akun 3 --</option>
                                                <?php foreach ($dtakun3 as $valAkun) : ?>
                                                    <option value="<?= $valAkun->kode_akun3 ?>" <?= $item->kode_akun3 == $valAkun->kode_akun3 ? 'selected' : '' ?>>
                                                        <?= $valAkun->kode_akun3 ?> - <?= $valAkun->nama_akun3 ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>

                                        <td>
                                            <select name="id_status[]" class="form-control" required>
                                                <option value="">-- Pilih Status --</option>
                                                <?php foreach ($dtstatus as $valStatus) : ?>
                                                    <option value="<?= $valStatus->id_status ?>" <?= $item->id_status == $valStatus->id_status ? 'selected' : '' ?>>
                                                        <?= $valStatus->status ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>

                                        <td>
                                            <input type="number" step="0.01" name="debit[]" class="form-control" value="<?= $item->debit ?>">
                                        </td>

                                        <td>
                                            <input type="number" step="0.01" name="kredit[]" class="form-control" value="<?= $item->kredit ?>">
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Update Data</button>
                        <a href="<?= site_url('transaksi') ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>
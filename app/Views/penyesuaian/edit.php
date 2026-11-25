<?= $this->extend('layout/backend') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Edit Penyesuaian</h1>
        <div class="section-header-button">
            <a href="<?= site_url('penyesuaian') ?>" class="btn btn-primary">Back</a>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Edit Data Penyesuaian</h4>
            </div>
            <div class="card-body p-4">
                <form method="post" action="<?= site_url('penyesuaian/' . $dtpenyesuaian->id_penyesuaian) ?>" autocomplete="off">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">

                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" required value="<?= $dtpenyesuaian->tanggal ?>">
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <input type="text" class="form-control" name="deskripsi" placeholder="Deskripsi" required value="<?= $dtpenyesuaian->deskripsi ?>">
                    </div>

                    <div class="form-group">
                        <label>Nilai</label>
                        <input type="number" class="form-control" id="nilai" onkeyup="hitung()" name="nilai" placeholder="Nilai" required value="<?= $dtpenyesuaian->nilai ?>">
                    </div>

                    <div class="form-group">
                        <label>Waktu</label>
                        <input type="number" class="form-control" id="waktu" onkeyup="hitung()" name="waktu" placeholder="Waktu" required value="<?= $dtpenyesuaian->waktu ?>">
                    </div>

                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah" readonly required value="<?= $dtpenyesuaian->jumlah ?>">
                    </div>

                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Akun</th>
                                    <th>Debit</th>
                                    <th>Kredit</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0 ?>
                                <?php foreach ($dtnilaipenyesuaian as $item): ?>
                                    <?php $i++ ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td>
                                            <select class="form-control" name="kode_akun3[]" required>
                                                <?php foreach ($dtakun3 as $key => $value): ?>
                                                    <option value="<?= $value->kode_akun3 ?>" <?= $item->kode_akun3 == $value->kode_akun3 ? 'selected' : null ?>>
                                                        <?= $value->kode_akun3 ?> | <?= $value->nama_akun3 ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="debit[]" required value="<?= $item->debit ?>">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="kredit[]" required value="<?= $item->kredit ?>">
                                        </td>
                                        <td>
                                            <select class="form-control" name="id_status[]" required>
                                                <?php foreach ($dtstatus as $key => $value): ?>
                                                    <option value="<?= $value->id_status ?>" <?= $item->id_status == $value->id_status ? 'selected' : null ?>>
                                                        <?= $value->id_status ?> | <?= $value->status ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <input type="hidden" name="id[]" value="<?= $item->id ?>">
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Update</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    function hitung() {
        var nilai = parseFloat($('#nilai').val()) || 0;
        var waktu = parseFloat($('#waktu').val()) || 0;
        var jumlah = 0;

        if (waktu > 0) {
            jumlah = nilai / waktu;
        }

        $('#jumlah').val(jumlah);
    }
</script>
<?= $this->endSection() ?>
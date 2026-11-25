<?= $this->extend('layout/backend') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="section-header">
        <h1>Tambah Akun 3</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Tambah Data Akun 3</h4>
                <div class="card-header-action">
                    <a href="<?= site_url('akun3') ?>" class="btn btn-warning">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="<?= site_url('akun3') ?>" method="post" autocomplete="off">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label>Akun 1</label>
                        <select name="kode_akun1" class="form-control" required>
                            <option value="">- Pilih Akun 1 -</option>
                            <?php foreach ($dtakun1 as $key => $value) : ?>
                                <option value="<?= $value->kode_akun1 ?>"><?= $value->nama_akun1 ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Akun 2</label>
                        <select name="kode_akun2" class="form-control" required>
                            <option value="">- Pilih Akun 2 -</option>
                            <?php foreach ($dtakun2 as $key => $value) : ?>
                                <option value="<?= $value->kode_akun2 ?>"><?= $value->nama_akun2 ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Kode Akun 3</label>
                        <input type="number" name="kode_akun3" class="form-control" placeholder="Masukkan kode akun" required>
                    </div>

                    <div class="form-group">
                        <label>Nama Akun 3</label>
                        <input type="text" name="nama_akun3" class="form-control" placeholder="Masukkan nama akun" required>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-paper-plane"></i> Save
                        </button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>
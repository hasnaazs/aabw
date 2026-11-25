<?= $this->extend('layout/backend') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Data Penyesuaian</h1>
        <div class="section-header-button">
            <a href="<?= site_url('penyesuaian/new') ?>" class="btn btn-primary">Add New</a>
        </div>
    </div>

    <!-- Alert Success -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                <?= session()->getFlashdata('success') ?>
            </div>
        </div>
    <?php endif ?>

    <!-- Alert Error -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                <?= session()->getFlashdata('error') ?>
            </div>
        </div>
    <?php endif ?>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Data Penyesuaian</h4>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-striped table-md" id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Deskripsi</th>
                                <th>Nilai</th>
                                <th>Waktu</th>
                                <th class="text-center text-nowrap" style="width: 20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dtpenyesuaian as $key => $value): ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $value->tanggal ?></td>
                                    <td><?= $value->deskripsi ?></td>
                                    <td><?= number_format($value->nilai, 0, ',', '.') ?></td>
                                    <td><?= $value->waktu ?> Bulan</td>
                                    <td class="text-center text-nowrap">
                                        <a href="<?= site_url('penyesuaian/' . $value->id_penyesuaian) ?>" class="btn btn-info btn-sm">
                                            <i class="fas fa-bars"></i> Detail
                                        </a>
                                        <a href="<?= site_url('penyesuaian/' . $value->id_penyesuaian . '/edit') ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-pencil-alt"></i> Edit
                                        </a>
                                        <form action="<?= site_url('penyesuaian/' . $value->id_penyesuaian) ?>" method="post" id="del-<?= $value->id_penyesuaian ?>" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="btn btn-danger btn-sm" data-confirm="Hapus data?|Apakah anda yakin? Karena data tabel relasi akan terhapus semua." data-confirm-yes="hapus(<?= $value->id_penyesuaian ?>)">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
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

<script>
    function hapus(id) {
        $('#del-' + id).submit();
    }
</script>
<?= $this->endSection() ?>
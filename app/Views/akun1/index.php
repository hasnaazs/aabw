<?= $this->extend('layout/backend') ?>

<?= $this->section('content') ?>

<section class="section">
    <!-- 1. Header Utama: Berisi Judul & Tombol Add New di Atas Card -->
    <div class="section-header">
        <h1>Data Akun 1</h1>
        <div class="section-header-button">
            <a href="<?= site_url('akun1/new') ?>" class="btn btn-primary">Add New</a>
        </div>
    </div>

    <!-- Flashdata Success -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">X</button>
                <?= session()->getFlashdata('success'); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Flashdata Error -->
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">X</button>
                <?= session()->getFlashdata('error'); ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="section-body">
        <div class="card">
            <!-- 2. Header Card: Hanya berisi judul Data Akun 1 -->
            <div class="card-header">
                <h4>Data Akun 1</h4>
            </div>

            <!-- 3. Body Card: Berisi Tabel DataTables -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-md" id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Akun 1</th>
                                <th>Nama Akun</th>
                                <th class="text-center" style="width: 20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dtakun1 as $key => $value) : ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $value->kode_akun1 ?></td>
                                    <td><?= $value->nama_akun1 ?></td>
                                    <td class="text-center" style="width:15%">
                                        <a href="<?= site_url('akun1/edit/' . $value->id_akun1) ?>" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i> Edit</a>
                                        <form action="<?= site_url('akun1/' . $value->id_akun1) ?>" method="post" id="del-<?= $value->id_akun1 ?>" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="button" class="btn btn-danger btn-sm" data-confirm="Hapus Data....?|Apakah anda yakin akan menghapus data ini?" data-confirm-yes="hapus(<?= $value->id_akun1 ?>)">
                                                <i class="fas fa-trash"></i> Del
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

<?= $this->endSection(); ?>
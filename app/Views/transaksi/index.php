<?= $this->extend('layout/backend') ?>

<?= $this->section('content') ?>

<section class="section">
    <!-- Header Utama -->
    <div class="section-header">
        <h1>Data Transaksi</h1>
        <div class="section-header-button">
            <a href="<?= site_url('transaksi/new') ?>" class="btn btn-primary">Add New</a>
        </div>
    </div>

    <!-- Flashdata Success -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                <?= session()->getFlashdata('success'); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Flashdata Error -->
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                <?= session()->getFlashdata('error'); ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Data Transaksi</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-md" id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kwitansi</th>
                                <th>Tanggal</th>
                                <th>Deskripsi</th>
                                <th>Ket. Jurnal</th>
                                <th class="text-center" style="width: 25%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dttransaksi as $key => $value) : ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $value->kwitansi ?></td>
                                    <td><?= $value->tanggal ?></td>
                                    <td><?= $value->deskripsi ?></td>
                                    <td><?= $value->ket_jurnal ?></td>
                                    <td class="text-center">
                                        <!-- Tombol Detail (Fitur Tambahan Asdos) -->
                                        <a href="<?= site_url('transaksi/' . $value->id_transaksi) ?>" class="btn btn-info btn-sm">
                                            <i class="fas fa-bars"></i> Detail
                                        </a>

                                        <!-- Tombol Edit -->
                                        <a href="<?= site_url('transaksi/' . $value->id_transaksi . '/edit') ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-pencil-alt"></i> Edit
                                        </a>

                                        <!-- Tombol Delete -->
                                        <form action="<?= site_url('transaksi/' . $value->id_transaksi) ?>" method="post" id="del-<?= $value->id_transaksi ?>" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="button" class="btn btn-danger btn-sm" data-confirm="Hapus Data....?|Apakah anda yakin akan menghapus data ini?" data-confirm-yes="hapus(<?= $value->id_transaksi ?>)">
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
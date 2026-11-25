<?= $this->extend('layout/backend') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>User List</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Daftar Pengguna Sistem</h4>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">#</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th class="text-center" style="width: 15%">Role / Group</th>
                                <th class="text-center" style="width: 15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $index => $user): ?>
                                <tr>
                                    <td class="text-center"><?= $index + 1 ?></td>
                                    <td><?= $user->username ?></td>
                                    <td><?= $user->email ?></td>
                                    <td class="text-center">
                                        <span class="badge badge-<?= $user->name == 'admin' ? 'success' : 'info' ?>">
                                            <?= $user->name ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= site_url('admin/detail/' . $user->userid) ?>" class="btn btn-info btn-sm">
                                            <i class="fas fa-info-circle"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>
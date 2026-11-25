<?= $this->extend('layout/backend') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>User Detail</h1>
    </div>

    <div class="section-body">
        <div class="card mb-3 col-lg-8">
            <div class="row no-gutters">
                <div class="col-md-4 p-3 text-center">
                    <img src="<?= base_url('img/files/' . (!empty($user->user_image) ? $user->user_image : 'default.png')) ?>" class="card-img rounded-circle img-thumbnail" alt="<?= $user->username ?>">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h4><?= $user->username ?></h4>
                            </li>
                            <?php if ($user->fullname): ?>
                                <li class="list-group-item">
                                    <strong>Nama Lengkap:</strong> <?= $user->fullname ?>
                                </li>
                            <?php endif ?>
                            <li class="list-group-item">
                                <strong>Email:</strong> <?= $user->email ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Role / Group:</strong>
                                <span class="badge badge-<?= $user->name == 'admin' ? 'success' : 'info' ?>">
                                    <?= $user->name ?>
                                </span>
                            </li>
                            <li class="list-group-item">
                                <a href="<?= site_url('admin') ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-arrow-left"></i> Kembali ke User List
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>SIA-AABW | Sistem Informasi Akuntansi</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/@fortawesome/fontawesome-free/css/all.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>/template/assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>/template/assets/css/components.css">
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <div class="login-brand text-center">
                            <img src="<?= base_url() ?>/template/assets/img/stisla-fill.svg" alt="logo" width="90" class="shadow-light rounded-circle mb-3">
                            <h4>Sistem Informasi Akuntansi (SIA-AABW)</h4>
                        </div>

                        <div class="card card-primary shadow">
                            <div class="card-header justify-content-center">
                                <h4>Selamat Datang</h4>
                            </div>
                            <div class="card-body text-center">
                                <p class="text-muted mb-4">
                                    Aplikasi pencatatan transaksi, jurnal umum, buku besar, neraca lajur, dan laporan keuangan berbasis web.
                                </p>

                                <?php if (logged_in()) : ?>
                                    <div class="alert alert-light border mb-4">
                                        Halo, <strong><?= user()->username ?></strong>! Kamu sudah login.
                                    </div>
                                    <a href="<?= site_url('akun1') ?>" class="btn btn-primary btn-lg btn-block mb-2">
                                        <i class="fas fa-tachometer-alt mr-1"></i> Masuk ke Aplikasi
                                    </a>
                                    <a href="<?= site_url('logout') ?>" class="btn btn-outline-danger btn-block">
                                        <i class="fas fa-sign-out-alt mr-1"></i> Logout
                                    </a>
                                <?php else : ?>
                                    <a href="<?= site_url('login') ?>" class="btn btn-primary btn-lg btn-block mb-2">
                                        <i class="fas fa-sign-in-alt mr-1"></i> Login
                                    </a>
                                    <a href="<?= site_url('register') ?>" class="btn btn-outline-primary btn-lg btn-block">
                                        <i class="fas fa-user-plus mr-1"></i> Register Akun Baru
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="simple-footer text-center text-muted mt-4">
                            Copyright &copy; 2026 &bull; Hasna Zalfa Salsabil
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="<?= base_url() ?>/template/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url() ?>/template/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>
<li class="menu-header">Dashboard</li>
<li><a class="nav-link" href="<?= site_url('home') ?>"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>

<?php if (in_groups('admin')): ?>
    <li class="menu-header">User Management</li>
    <li><a class="nav-link" href="<?= site_url('admin') ?>"><i class="fas fa-users"></i> <span>User List</span></a></li>
<?php endif; ?>

<li class="menu-header">Sistem Akuntansi</li>
<li class="nav-item dropdown">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Kode Akun</span></a>
    <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?= site_url('akun1') ?>">Akun - 1</a></li>
        <li><a class="nav-link" href="<?= site_url('akun2') ?>">Akun - 2</a></li>
        <li><a class="nav-link" href="<?= site_url('akun3') ?>">Akun - 3</a></li>
    </ul>
</li>

<li class="menu-header">Aktivitas</li>
<li><a class="nav-link" href="<?= site_url('jurnalumum') ?>"><i class="fas fa-calendar-alt"></i> <span>Jurnal Umum</span></a></li>
<li><a class="nav-link" href="<?= site_url('posting') ?>"><i class="fas fa-book"></i> <span>Posting</span></a></li>
<li><a class="nav-link" href="<?= site_url('neracasaldo') ?>"><i class="fas fa-balance-scale"></i> <span>Neraca Saldo</span></a></li>
<li><a class="nav-link" href="<?= site_url('neracalajur') ?>"><i class="fas fa-square"></i> <span>Neraca Lajur</span></a></li>

<li class="nav-item dropdown">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-credit-card"></i> <span>Transaksi</span></a>
    <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?= site_url('transaksi') ?>">Transaksi Jurnal</a></li>
        <li><a class="nav-link" href="<?= site_url('penyesuaian') ?>">Transaksi Penyesuaian</a></li>
    </ul>
</li>

<li class="nav-item dropdown">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-th"></i> <span>Laporan Keuangan</span></a>
    <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?= site_url('labarugi') ?>">Laba Rugi</a></li>
        <li><a class="nav-link" href="<?= site_url('pmodal') ?>">Perubahan Modal</a></li>
        <li><a class="nav-link" href="<?= site_url('neraca') ?>">Neraca</a></li>
        <li><a class="nav-link" href="<?= site_url('aruskas') ?>">Arus Kas</a></li>
    </ul>
</li>
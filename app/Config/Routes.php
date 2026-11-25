<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// Modul Akun 1
$routes->get('/akun1', 'Akun1::index');
$routes->get('/akun1/new', 'Akun1::new');
$routes->post('/akun1', 'Akun1::store');
$routes->get('/akun1/edit/(:any)', 'Akun1::edit/$1');
$routes->put('/akun1/edit/(:any)', 'Akun1::update/$1');
$routes->delete('/akun1/(:any)', 'Akun1::destroy/$1');

// Modul Akun 2
$routes->get('/akun2/new', 'Akun2::new');
$routes->put('/akun2/(:segment)', 'Akun2::update/$1');
$routes->post('/akun2/(:any)', 'Akun2::delete/$1');
$routes->resource('akun2');

// Modul Akun 3
$routes->get('/akun3/new', 'Akun3::new');
$routes->get('/akun3/(:segment)/edit', 'Akun3::edit/$1');
$routes->post('/akun3/new', 'Akun3::create');
$routes->resource('akun3');

// Modul Transaksi (Urutan AJAX di atas (:any) agar tidak terbaca sebagai ID)
$routes->get('/transaksi/status', 'Transaksi::status');
$routes->get('/transaksi/akun3', 'Transaksi::akun3');
$routes->get('/transaksi/new', 'Transaksi::new');
$routes->get('/transaksi/(:segment)/edit', 'Transaksi::edit/$1');
$routes->get('/transaksi/(:any)', 'Transaksi::show/$1');
$routes->post('/transaksi', 'Transaksi::create');
$routes->get('/transaksi', 'Transaksi::index');
$routes->resource('transaksi');

// Modul Penyesuaian (Ditambahkan status, akun3, & new di atas (:any) agar dropdown AJAX tidak error)
$routes->get('/penyesuaian/status', 'Penyesuaian::status');
$routes->get('/penyesuaian/akun3', 'Penyesuaian::akun3');
$routes->get('/penyesuaian/new', 'Penyesuaian::new');
$routes->get('/penyesuaian/(:segment)/edit', 'Penyesuaian::edit/$1');
$routes->get('/penyesuaian/(:any)', 'Penyesuaian::show/$1');
$routes->post('/penyesuaian', 'Penyesuaian::create');
$routes->put('/penyesuaian/(:segment)', 'Penyesuaian::update/$1');
$routes->post('/penyesuaian/(:any)', 'Penyesuaian::delete/$1');
$routes->resource('penyesuaian');

// Modul Jurnal Umum
$routes->post('/jurnalumum/cetakjupdf', 'JurnalUmum::cetakjupdf');
$routes->post('/jurnalumum', 'JurnalUmum::index');
$routes->resource('jurnalumum');

// Modul Posting
$routes->post('/posting/postingpdf', 'Posting::postingpdf');
$routes->post('/posting', 'Posting::index');
$routes->resource('posting');

// Modul Jurnal Penyesuaian
$routes->post('/jurnalpenyesuaian/cetak_jppdf', 'JurnalPenyesuaian::cetak_jppdf');
$routes->post('/jurnalpenyesuaian', 'JurnalPenyesuaian::index');
$routes->resource('jurnalpenyesuaian');

// Modul Neraca Saldo
$routes->post('/neracasaldo/neracasaldopdf', 'NeracaSaldo::neracasaldopdf');
$routes->post('/neracasaldo', 'NeracaSaldo::index');
$routes->resource('neracasaldo');

// Modul Neraca Lajur
$routes->post('/neracalajur/neracalajurpdf', 'NeracaLajur::neracalajurpdf');
$routes->post('/neracalajur', 'NeracaLajur::index');
$routes->resource('neracalajur');

// Rute Management User (Admin Only Filter)
$routes->get('/admin', 'Admin::index', ['filter' => 'role:admin']);
$routes->get('/admin/index', 'Admin::index', ['filter' => 'role:admin']);
$routes->get('/admin/detail/(:num)', 'Admin::detail/$1', ['filter' => 'role:admin']);

// Modul Laporan Laba Rugi
$routes->get('labarugi/labarugipdf', 'Labarugi::labarugipdf');
$routes->post('labarugi/labarugipdf', 'Labarugi::labarugipdf');
$routes->get('labarugi', 'Labarugi::index');
$routes->post('labarugi', 'Labarugi::index');

// Modul Laporan Perubahan Modal
$routes->get('pmodal/pmodalpdf', 'Pmodal::pmodalpdf');
$routes->post('pmodal/pmodalpdf', 'Pmodal::pmodalpdf');
$routes->get('pmodal', 'Pmodal::index');
$routes->post('pmodal', 'Pmodal::index');

// Modul Laporan Neraca
$routes->get('neraca/neracapdf', 'Neraca::neracapdf');
$routes->post('neraca/neracapdf', 'Neraca::neracapdf');
$routes->get('neraca', 'Neraca::index');
$routes->post('neraca', 'Neraca::index');

// Modul Laporan Arus Kas
$routes->get('aruskas/aruskaspdf', 'Aruskas::aruskaspdf');
$routes->post('aruskas/aruskaspdf', 'Aruskas::aruskaspdf');
$routes->get('aruskas', 'Aruskas::index');
$routes->post('aruskas', 'Aruskas::index');

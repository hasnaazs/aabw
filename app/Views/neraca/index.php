<?= $this->extend('layout/backend') ?>

<?= $this->section('content') ?>
<title>SIA-IPB &mdash; Posisi Keuangan</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Laporan Posisi Keuangan</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Filter Laporan Posisi Keuangan</h4>
            </div>
            <div class="card-body">
                <form action="<?= site_url('neraca') ?>" method="GET">
                    <?= csrf_field() ?>
                    <div class="row align-items-center">
                        <div class="col-md-3 mb-2">
                            <label>Tanggal Awal</label>
                            <input type="date" class="form-control" name="tglawal" value="<?= $tglawal ?>">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>Tanggal Akhir</label>
                            <input type="date" class="form-control" name="tglakhir" value="<?= $tglakhir ?>">
                        </div>
                        <div class="col-md-6 mb-2 mt-4 pt-1">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-list"></i> Tampilkan</button>
                            <input type="submit" class="btn btn-danger ml-2" formtarget="_blank"
                                formaction="<?= site_url('neraca/neracapdf') ?>" value="Cetak PDF">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Laporan Posisi Keuangan (Neraca)</h4>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead style="background-color: #6777ef; color: white;">
                            <tr>
                                <th class="text-white">Deskripsi / Nama Akun</th>
                                <th class="text-right text-white" style="width: 25%;">Rincian (Rp)</th>
                                <th class="text-right text-white" style="width: 25%;">Total (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- ASET -->
                            <tr class="font-weight-bold bg-light">
                                <td colspan="3" class="text-center">ASET</td>
                            </tr>
                            <?php
                            $aktiva_lancar = 0;
                            $total_aktiva_lancar = 0;
                            $aktiva_tetap = 0;
                            $total_aktiva_tetap = 0;
                            $total_kewajiban = 0;
                            $kewajiban = 0;
                            $total_kewajiban_tetap = 0;
                            ?>

                            <!-- ASET LANCAR -->
                            <tr class="font-weight-bold">
                                <td class="text-left">ASET LANCAR</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php foreach ($dttransaksi as $key => $value) : ?>
                                <?php if ($value->kode_akun2 == 11) : ?>
                                    <?php
                                    $debit = $value->jumdebit + ($value->jumdebits ?? 0);
                                    $kredit = $value->jumkredit + ($value->jumkredits ?? 0);
                                    $aktiva_lancar = $debit - $kredit;
                                    $total_aktiva_lancar += $aktiva_lancar;
                                    ?>
                                    <tr>
                                        <td class="text-left" style="padding-left: 3em;"><?= $value->nama_akun3 ?></td>
                                        <td class="text-right"><?= number_format($aktiva_lancar, 0, ",", ".") ?></td>
                                        <td></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <tr class="font-weight-bold" style="background-color: #f8f9fa;">
                                <td style="padding-left: 2em;">TOTAL ASET LANCAR</td>
                                <td></td>
                                <td class="text-right"><?= number_format($total_aktiva_lancar, 0, ",", ".") ?></td>
                            </tr>

                            <!-- ASET TETAP -->
                            <tr class="font-weight-bold">
                                <td class="text-left">ASET TETAP</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php foreach ($dttransaksi as $key => $value) : ?>
                                <?php if ($value->kode_akun2 == 12) : ?>
                                    <?php
                                    $debit = $value->jumdebit + ($value->jumdebits ?? 0);
                                    $kredit = $value->jumkredit + ($value->jumkredits ?? 0);
                                    $aktiva_tetap = $debit - $kredit;
                                    $total_aktiva_tetap += $aktiva_tetap;
                                    ?>
                                    <tr>
                                        <td class="text-left" style="padding-left: 3em;"><?= $value->nama_akun3 ?></td>
                                        <td class="text-right"><?= number_format(abs($aktiva_tetap), 0, ",", ".") ?></td>
                                        <td></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <tr class="font-weight-bold" style="background-color: #f8f9fa;">
                                <td style="padding-left: 2em;">TOTAL ASET TETAP</td>
                                <td></td>
                                <td class="text-right"><?= number_format($total_aktiva_tetap, 0, ",", ".") ?></td>
                            </tr>

                            <!-- JUMLAH ASET -->
                            <tr class="font-weight-bold" style="background-color: #d4edda; color: #155724;">
                                <td class="text-left">JUMLAH ASET</td>
                                <td></td>
                                <td class="text-right"><?= number_format($total_aktiva_tetap + $total_aktiva_lancar, 0, ",", ".") ?></td>
                            </tr>

                            <!-- LIABILITAS & EKUITAS -->
                            <tr class="font-weight-bold bg-light">
                                <td colspan="3" class="text-center">LIABILITAS & EKUITAS</td>
                            </tr>

                            <!-- LIABILITAS JANGKA PENDEK -->
                            <tr class="font-weight-bold">
                                <td class="text-left">LIABILITAS JANGKA PENDEK</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php foreach ($dttransaksi as $key => $value) : ?>
                                <?php if ($value->kode_akun2 == 21) : ?>
                                    <?php
                                    $debit = $value->jumdebit + ($value->jumdebits ?? 0);
                                    $kredit = $value->jumkredit + ($value->jumkredits ?? 0);
                                    $kewajiban = $debit - $kredit;
                                    $total_kewajiban += $kewajiban;
                                    ?>
                                    <tr>
                                        <td class="text-left" style="padding-left: 3em;"><?= $value->nama_akun3 ?></td>
                                        <td class="text-right"><?= number_format(abs($kewajiban), 0, ",", ".") ?></td>
                                        <td></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <tr class="font-weight-bold" style="background-color: #f8f9fa;">
                                <td style="padding-left: 2em;">TOTAL LIABILITAS JANGKA PENDEK</td>
                                <td></td>
                                <td class="text-right"><?= number_format(abs($total_kewajiban), 0, ",", ".") ?></td>
                            </tr>

                            <!-- LIABILITAS JANGKA PANJANG -->
                            <tr class="font-weight-bold">
                                <td class="text-left">LIABILITAS JANGKA PANJANG</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php foreach ($dttransaksi as $key => $value) : ?>
                                <?php if ($value->kode_akun2 == 22) : ?>
                                    <?php
                                    $debit = $value->jumdebit + ($value->jumdebits ?? 0);
                                    $kredit = $value->jumkredit + ($value->jumkredits ?? 0);
                                    $kewajiban_tetap = $debit - $kredit;
                                    $total_kewajiban_tetap += $kewajiban_tetap;
                                    ?>
                                    <tr>
                                        <td class="text-left" style="padding-left: 3em;"><?= $value->nama_akun3 ?></td>
                                        <td class="text-right"><?= number_format(abs($kewajiban_tetap), 0, ",", ".") ?></td>
                                        <td></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <tr class="font-weight-bold" style="background-color: #f8f9fa;">
                                <td style="padding-left: 2em;">TOTAL LIABILITAS JANGKA PANJANG</td>
                                <td></td>
                                <td class="text-right"><?= number_format($total_kewajiban_tetap, 0, ",", ".") ?></td>
                            </tr>

                            <!-- EKUITAS -->
                            <tr class="font-weight-bold">
                                <td class="text-left">EKUITAS</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php
                            $modal_pemilik = isset($modal_awal) ? $modal_awal : 0;
                            $laba_rugi_val = isset($laba_rugi) ? $laba_rugi : 0;
                            $prive_val = isset($prive) ? $prive : 0;
                            $laba_ditahan_val = $laba_rugi_val - $prive_val;
                            $total_ekuitas_val = $modal_pemilik + $laba_ditahan_val;
                            ?>
                            <tr>
                                <td class="text-left" style="padding-left: 3em;">Modal Pemilik</td>
                                <td class="text-right"><?= number_format($modal_pemilik, 0, ",", ".") ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="text-left" style="padding-left: 3em;">Laba Ditahan</td>
                                <td class="text-right"><?= number_format($laba_ditahan_val, 0, ",", ".") ?></td>
                                <td></td>
                            </tr>
                            <tr class="font-weight-bold" style="background-color: #f8f9fa;">
                                <td style="padding-left: 2em;">TOTAL EKUITAS</td>
                                <td></td>
                                <td class="text-right"><?= number_format($total_ekuitas_val, 0, ",", ".") ?></td>
                            </tr>

                            <!-- JUMLAH LIABILITAS & EKUITAS -->
                            <tr class="font-weight-bold" style="background-color: #d4edda; color: #155724;">
                                <td class="text-left">JUMLAH LIABILITAS & EKUITAS</td>
                                <td></td>
                                <td class="text-right"><?= number_format(abs($total_kewajiban + $total_kewajiban_tetap - $total_ekuitas_val), 0, ",", ".") ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
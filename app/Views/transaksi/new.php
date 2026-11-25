<?= $this->extend('layout/backend') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="<?= site_url('transaksi') ?>" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Tambah Data Transaksi</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Form Transaksi Baru</h4>
            </div>
            <div class="card-body">
                <form action="<?= site_url('transaksi') ?>" method="post" autocomplete="off">
                    <?= csrf_field() ?>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>No. Kwitansi *</label>
                            <input type="text" name="kwitansi" class="form-control" maxlength="4" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Tanggal *</label>
                            <input type="date" name="tanggal" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Keterangan Jurnal</label>
                        <input type="text" name="ket_jurnal" class="form-control">
                    </div>

                    <hr>
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Detail Transaksi Jurnal</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tableLoop">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 5%">No</th>
                                            <th style="width: 25%">Kode Akun</th>
                                            <th style="width: 20%">Debit</th>
                                            <th style="width: 20%">Kredit</th>
                                            <th style="width: 20%">Status</th>
                                            <th class="text-center" style="width: 10%">
                                                <button type="button" class="btn btn-primary btn-sm" id="barisBaru">
                                                    <i class="fas fa-plus"></i> Add Baris
                                                </button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Baris dinamis di-load lewat JS setelah AJAX selesai -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Simpan Data</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let optAkun3 = '';
        let optStatus = '';

        // Tunggu KEDUA data AJAX (Akun3 & Status) selesai di-load
        $.when(
            $.ajax({
                url: "<?= site_url('transaksi/akun3') ?>",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $.each(data, function(key, val) {
                        optAkun3 += `<option value="${val.kode_akun3}">${val.kode_akun3} | ${val.nama_akun3}</option>`;
                    });
                }
            }),
            $.ajax({
                url: "<?= site_url('transaksi/status') ?>",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $.each(data, function(key, val) {
                        optStatus += `<option value="${val.id_status}">${val.status}</option>`;
                    });
                }
            })
        ).then(function() {
            // Setelah KEDUA AJAX siap, baru buat baris awal
            tambahBaris();
            tambahBaris();
        });

        function updateNomor() {
            $('#tableLoop tbody tr').each(function(index) {
                $(this).find('.no-baris').text(index + 1);
            });
        }

        function tambahBaris() {
            let row = `
                <tr>
                    <td class="text-center no-baris"></td>
                    <td>
                        <select name="kode_akun3[]" class="form-control" required>
                            <option value="">- Pilih Akun -</option>
                            ${optAkun3}
                        </select>
                    </td>
                    <td>
                        <input type="number" step="0.01" name="debit[]" class="form-control" value="0" required>
                    </td>
                    <td>
                        <input type="number" step="0.01" name="kredit[]" class="form-control" value="0" required>
                    </td>
                    <td>
                        <select name="id_status[]" class="form-control" required>
                            <option value="">- Pilih Status -</option>
                            ${optStatus}
                        </select>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm hapusBaris"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `;
            $('#tableLoop tbody').append(row);
            updateNomor();
        }

        $('#barisBaru').click(function() {
            tambahBaris();
        });

        $(document).on('click', '.hapusBaris', function() {
            if ($('#tableLoop tbody tr').length > 1) {
                $(this).closest('tr').remove();
                updateNomor();
            } else {
                alert('Minimal harus ada 1 baris rincian transaksi.');
            }
        });
    });
</script>

<?= $this->endSection(); ?>
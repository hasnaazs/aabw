<?= $this->extend('layout/backend') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Tambah Penyesuaian</h1>
        <div class="section-header-button">
            <a href="<?= site_url('penyesuaian') ?>" class="btn btn-primary">Back</a>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Tambah Data Penyesuaian</h4>
            </div>
            <div class="card-body p-4">
                <form method="post" action="<?= site_url('penyesuaian') ?>" autocomplete="off">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" required>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <input type="text" class="form-control" name="deskripsi" placeholder="Deskripsi" required>
                    </div>

                    <div class="form-group">
                        <label>Nilai yang Disesuaikan</label>
                        <input type="number" class="form-control" id="nilai" onkeyup="hitung()" name="nilai" placeholder="Nilai" required>
                    </div>

                    <div class="form-group">
                        <label>Waktu Disesuaikan (Bulan)</label>
                        <input type="number" class="form-control" id="waktu" onkeyup="hitung()" name="waktu" placeholder="Waktu" required>
                    </div>

                    <div class="form-group">
                        <label>Jumlah Disesuaikan</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah" required readonly>
                    </div>

                    <div class="box-body">
                        <table class="table table-bordered" id="tableLoop">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%">No</th>
                                    <th>Kode Akun</th>
                                    <th>Debit</th>
                                    <th>Kredit</th>
                                    <th>Status</th>
                                    <th class="text-center" style="width: 10%">
                                        <button type="button" class="btn btn-primary btn-sm btn-block" id="Barisbaru">
                                            <i class="fa fa-plus"></i> Add Row
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dinamis via jQuery -->
                            </tbody>
                        </table>
                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Save</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    function hitung() {
        var nilai = parseFloat(document.getElementById('nilai').value) || 0;
        var waktu = parseFloat(document.getElementById('waktu').value) || 0;
        var jumlah = 0;

        if (waktu > 0) {
            jumlah = nilai / waktu;
        }

        document.getElementById('jumlah').value = Math.round(jumlah);
    }

    window.addEventListener('load', function() {
        var i = 0;

        function addRow() {
            i++;
            var current_i = i;

            var html = '<tr id="row' + current_i + '">';
            html += '<td class="text-center">' + current_i + '</td>';

            html += '<td>';
            html += '<select name="kode_akun3[]" class="form-control" id="akun3_' + current_i + '" required>';
            html += '<option value="">- Pilih Akun -</option>';
            html += '</select>';
            html += '</td>';

            html += '<td>';
            html += '<input type="number" name="debit[]" class="form-control" value="0" required>';
            html += '</td>';

            html += '<td>';
            html += '<input type="number" name="kredit[]" class="form-control" value="0" required>';
            html += '</td>';

            html += '<td>';
            html += '<select name="id_status[]" class="form-control" id="status_' + current_i + '" required>';
            html += '<option value="">- Pilih Status -</option>';
            html += '</select>';
            html += '</td>';

            html += '<td class="text-center">';
            html += '<button type="button" name="remove" id="' + current_i + '" class="btn btn-danger btn-sm hapusBaris"><i class="fas fa-minus"></i></button>';
            html += '</td>';
            html += '</tr>';

            $('#tableLoop tbody').append(html);

            // Fetch Dropdown Akun 3
            $.ajax({
                url: "<?= site_url('penyesuaian/akun3') ?>",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $.each(data, function(key, value) {
                        $('#akun3_' + current_i).append('<option value="' + value.kode_akun3 + '">' + value.kode_akun3 + ' | ' + value.nama_akun3 + '</option>');
                    });
                }
            });

            // Fetch Dropdown Status
            $.ajax({
                url: "<?= site_url('penyesuaian/status') ?>",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $.each(data, function(key, value) {
                        $('#status_' + current_i).append('<option value="' + value.id_status + '">' + value.id_status + ' | ' + value.status + '</option>');
                    });
                }
            });
        }

        // Generate 2 baris awal secara otomatis
        addRow();
        addRow();

        $('#Barisbaru').click(function(e) {
            e.preventDefault();
            addRow();
        });

        $(document).on('click', '.hapusBaris', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id).remove();
        });
    });
</script>
<?= $this->endSection() ?>
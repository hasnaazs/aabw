<!DOCTYPE html>
<html>

<head>
    <style type="text/css">
        .aturkiri {
            text-align: left;
        }

        .aturkanan {
            text-align: right;
        }

        .aturtengah {
            text-align: center;
        }

        .spesifik {
            font-style: italic;
            word-spacing: 30px;
        }

        .judul {
            font-style: italic;
            font-size: 18px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 0.1px solid #000;
            padding: 4px;
            font-size: 8.5pt;
        }
    </style>
</head>

<body>
    <p class="judul">Neraca Saldo</p>
    Periode : <?= (!empty($tglawal) && !empty($tglakhir)) ? date('d F Y', strtotime($tglawal)) . " s/d " . date('d F Y', strtotime($tglakhir)) : 'Semua Periode' ?>
    <br><br>

    <table border="0.1" class="table table-bordered">
        <thead>
            <tr class="judul">
                <td class="aturtengah" rowspan="2" style="width: 20%; vertical-align: middle;">Kode Akun</td>
                <td class="aturkiri" rowspan="2" style="width: 40%; vertical-align: middle;">Keterangan</td>
                <td class="aturtengah" colspan="2" style="width: 40%;">Saldo</td>
            </tr>
            <tr class="judul">
                <td class="aturtengah" style="width: 20%;">Debit</td>
                <td class="aturtengah" style="width: 20%;">Kredit</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $td = 0;
            $tk = 0;
            ?>
            <?php foreach ($dttransaksi as $key => $value): ?>
                <?php
                $d = $value->jumdebit;
                $k = $value->jumkredit;
                $neraca = $d - $k;

                if ($neraca < 0) {
                    $kreditnew = abs($neraca);
                    $tk = $tk + $kreditnew;
                } else {
                    $kreditnew = 0;
                }
                if ($neraca > 0) {
                    $debitnew = $neraca;
                    $td = $td + $debitnew;
                } else {
                    $debitnew = 0;
                }
                ?>
                <tr>
                    <td class="aturtengah" style="width: 20%;">
                        <?= $value->kode_akun3 ?>
                    </td>
                    <td class="aturkiri" style="width: 40%;">
                        <?= $value->nama_akun3 ?>
                    </td>
                    <td class="aturkanan" style="width: 20%;">
                        <?= number_format($debitnew, 0, ',', '.') ?>
                    </td>
                    <td class="aturkanan" style="width: 20%;">
                        <?= number_format($kreditnew, 0, ',', '.') ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="judul">
                <td class="aturtengah" style="width: 20%;"></td>
                <td class="aturtengah" style="width: 40%;">JUMLAH</td>
                <td class="aturkanan" style="width: 20%;">
                    <?= number_format($td, 0, ',', '.') ?>
                </td>
                <td class="aturkanan" style="width: 20%;">
                    <?= number_format($tk, 0, ',', '.') ?>
                </td>
            </tr>
        </tfoot>
    </table>

    <br><br><br><br><br>

    <?php
    $tgl = date('l, d-m-Y');
    echo $tgl;
    ?>

    <br><br><br><br>
    Pimpinan AKN

</body>

</html>
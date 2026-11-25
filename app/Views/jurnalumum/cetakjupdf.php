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

        .judul {
            font-weight: bold;
            font-size: 16px;
            text-transform: uppercase;
        }

        .subtitle {
            font-size: 11px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 0.1px solid #000;
            padding: 5px;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="aturtengah">
        <div class="judul">Jurnal Umum</div>
        <div class="subtitle">
            Periode: <?= (!empty($tglawal) && !empty($tglakhir)) ? date('d F Y', strtotime($tglawal)) . " s/d " . date('d F Y', strtotime($tglakhir)) : 'Semua Periode' ?>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="aturtengah" style="width: 15%">Tanggal</th>
                <th class="aturkiri" style="width: 41%">Keterangan</th>
                <th class="aturtengah" style="width: 14%">Ref</th>
                <th class="aturkanan" style="width: 15%">Debit</th>
                <th class="aturkanan" style="width: 15%">Kredit</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dttransaksi as $key => $value): ?>
                <tr>
                    <td class="aturtengah"><?= $value->tanggal ?></td>
                    <td class="aturkiri">
                        <?php if ($value->debit != 0): ?>
                            <?= $value->nama_akun3 ?>
                        <?php else: ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><?= $value->nama_akun3 ?></em>
                        <?php endif; ?>
                    </td>
                    <td class="aturtengah"><?= $value->kode_akun3 ?></td>
                    <td class="aturkanan"><?= number_format($value->debit, 0, ',', '.') ?></td>
                    <td class="aturkanan"><?= number_format($value->kredit, 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br><br><br>

    <table border="0" style="width: 100%; border: none;">
        <tr>
            <td style="border: none; width: 60%;"></td>
            <td style="border: none; width: 40%; text-align: center;">
                <?= date('l, d F Y') ?><br><br><br><br><br>
                <strong>Pimpinan AKN</strong>
            </td>
        </tr>
    </table>
</body>

</html>
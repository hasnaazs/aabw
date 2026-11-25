<!DOCTYPE html>
<html>

<head>
    <style type="text/css">
        .aturangka {
            text-align: right;
        }

        .judul {
            font-weight: bold;
            font-size: 16px;
            text-transform: uppercase;
        }

        .aturkiri {
            text-align: left;
        }

        .aturtengah {
            text-align: center;
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

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="aturtengah">
        <div class="judul">Posting Buku Besar</div>
        <div style="font-size: 11px; margin-bottom: 15px;">
            Periode: <?= (!empty($tglawal) && !empty($tglakhir)) ? date('d F Y', strtotime($tglawal)) . " s/d " . date('d F Y', strtotime($tglakhir)) : 'Semua Periode' ?>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="aturtengah" rowspan="2" style="width: 11%; vertical-align: middle;">Tanggal</th>
                <th class="aturtengah" rowspan="2" style="width: 23%; vertical-align: middle;">Keterangan</th>
                <th class="aturtengah" rowspan="2" style="width: 8%; vertical-align: middle;">Ref</th>
                <th class="aturtengah" rowspan="2" style="width: 14%; vertical-align: middle;">Debit</th>
                <th class="aturtengah" rowspan="2" style="width: 14%; vertical-align: middle;">Kredit</th>
                <th class="aturtengah" colspan="2" style="width: 30%;">Saldo</th>
            </tr>
            <tr>
                <th class="aturtengah" style="width: 15%;">Debit</th>
                <th class="aturtengah" style="width: 15%;">Kredit</th>
            </tr>
        </thead>
        <tbody>
            <?php $dbt = 0; ?>
            <?php foreach ($dttransaksi as $key => $value): ?>
                <?php
                if ($value->debit) {
                    $dbt = $dbt + $value->debit;
                } else {
                    $dbt = $dbt - $value->kredit;
                }

                $ndbt1 = $dbt >= 0 ? $dbt : 0;
                $ndbt2 = $dbt < 0 ? $dbt : 0;
                $ket   = $value->ket_jurnal ?? $value->ketjurnal ?? '';
                ?>
                <tr>
                    <td class="aturtengah" style="width: 11%;"><?= $value->tanggal ?></td>
                    <td class="aturkiri" style="width: 23%;"><?= $ket ?></td>
                    <td class="aturtengah" style="width: 8%;"><?= $value->kode_akun3 ?></td>
                    <td class="aturangka" style="width: 14%;"><?= number_format($value->debit, 0, ',', '.') ?></td>
                    <td class="aturangka" style="width: 14%;"><?= number_format($value->kredit, 0, ',', '.') ?></td>
                    <td class="aturangka" style="width: 15%;"><?= number_format($ndbt1, 0, ',', '.') ?></td>
                    <td class="aturangka" style="width: 15%;"><?= number_format(abs($ndbt2), 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br><br><br>

    <table style="width: 100%; border: none;">
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
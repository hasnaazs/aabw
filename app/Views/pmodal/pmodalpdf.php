<!DOCTYPE html>
<html>

<head>
    <style type="text/css">
        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .kop {
            text-align: center;
            margin-bottom: 15px;
        }

        .kop h3 {
            margin: 0;
            font-size: 14pt;
            font-weight: bold;
        }

        .kop .instansi {
            font-size: 11pt;
            font-weight: bold;
            margin-top: 2px;
        }

        .kop .periode {
            font-size: 10pt;
            margin-top: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000000;
            padding: 5px;
            font-size: 9pt;
            vertical-align: middle;
        }

        .total {
            background-color: #f8f9fa;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="kop">
        <h3>Laporan Perubahan Modal</h3>
        <div class="instansi">AKN IPB</div>
        <div class="periode">
            Periode: <?= (!empty($tglawal) && !empty($tglakhir)) ? date('d/m/Y', strtotime($tglawal)) . ' s/d ' . date('d/m/Y', strtotime($tglakhir)) : 'Semua Periode' ?>
        </div>
    </div>

    <br>

    <table border="1" cellspacing="0" cellpadding="4">
        <tbody>
            <tr>
                <td colspan="2" class="text-left" style="width: 75%; font-weight: bold;">Modal Awal</td>
                <td class="text-right" style="width: 25%; font-weight: bold;"><?= number_format($dttransaksi['modal_awal'] ?? 0, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td class="text-left" style="width: 50%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Laba (Rugi) Bersih</td>
                <td class="text-right" style="width: 25%;"><?= number_format($dttransaksi['laba_rugi'] ?? 0, 0, ',', '.') ?></td>
                <td style="width: 25%;"></td>
            </tr>
            <tr>
                <td class="text-left" style="width: 50%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Prive</td>
                <td class="text-right" style="width: 25%;"><?= number_format($dttransaksi['prive'] ?? 0, 0, ',', '.') ?></td>
                <td style="width: 25%;"></td>
            </tr>
            <tr class="total">
                <td colspan="2" class="text-left" style="width: 75%;">Penambahan / (Pengurangan) Modal</td>
                <td class="text-right" style="width: 25%;"><?= number_format($dttransaksi['penambahan_modal'] ?? 0, 0, ',', '.') ?></td>
            </tr>
            <tr class="total" style="background-color: #d4edda;">
                <td colspan="2" class="text-left" style="width: 75%;">Modal Akhir</td>
                <td class="text-right" style="width: 25%;"><?= number_format($dttransaksi['modal_akhir'] ?? 0, 0, ',', '.') ?></td>
            </tr>
        </tbody>
    </table>

    <br><br><br>

    <table border="0" style="width: 100%; border: none;">
        <tr>
            <td style="border: none; width: 65%;"></td>
            <td style="border: none; width: 35%; text-align: center; font-size: 9pt;">
                Dicetak pada: <?= date('d/m/Y') ?><br><br>
                Mengetahui,<br><br><br><br>
                _________________________<br>
                <i>Bagian Akuntansi</i>
            </td>
        </tr>
    </table>
</body>

</html>
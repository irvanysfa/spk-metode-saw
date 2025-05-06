<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Perangkingan Siswa</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }

        h2,
        h3 {
            text-align: center;
        }
    </style>
</head>

<body>

    <h2>Hasil Perangkingan Lulusan Berprestasi</h2>
    <h3>SMP N 1 Ambal Tahun <?= $tahunAngkatanTerpilih; ?></h3> <!-- Menampilkan Tahun Angkatan -->

    <table>
        <thead>
            <tr>
                <th>Ranking</th>
                <th>Nama Siswa</th>
                <th>Kelas</th> <!-- Tambahkan kolom Kelas -->
                <th>Nilai Utama</th>
                <th>Nilai Tambahan</th>
                <th>Total Nilai</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($hasil as $row): ?>
                <tr>
                    <td class="text-center"><?= $row['ranking'] ?></td>
                    <td><?= $row['nama_siswa'] ?></td>
                    <td class="text-center"><?= $row['kelas'] ?></td> <!-- Tampilkan kelas -->
                    <td class="text-center"><?= round($row['nilai_utama'], 4) ?></td>
                    <td class="text-center"><?= round($row['nilai_tambahan'], 4) ?></td>
                    <td class="text-center"><?= round($row['total_nilai'], 4) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>
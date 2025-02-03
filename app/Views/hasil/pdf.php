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
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        h2, h3 {
            text-align: center;
        }
    </style>
</head>
<body>

<h2>Hasil Perangkingan Siswa</h2>
<h3>Kelas: <?= $kelasTerpilih; ?></h3> <!-- Tambahkan keterangan kelas -->

<table>
    <thead>
        <tr>
            <th>Ranking</th>
            <th>Nama Siswa</th>
            <th>Total Nilai</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($hasil as $row): ?>
            <tr>
                <td><?= $row['ranking'] ?></td>
                <td><?= $row['nama_siswa'] ?></td>
                <td><?= round($row['total_nilai'], 4) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>

document.addEventListener('DOMContentLoaded', function () {
    const inputSearch = document.getElementById('search-nama');

    if (inputSearch) {
        inputSearch.addEventListener('input', function () {
            const keyword = this.value;
            const kriteria = document.getElementById('kriteria')?.value;
            const kelas = document.getElementById('kelas')?.value;
            const angkatan = document.getElementById('angkatan')?.value;

            fetch(`/nilai/search?keyword=${keyword}&kriteria=${kriteria}&kelas=${kelas}&angkatan=${angkatan}`)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('table tbody');
                    tbody.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach((item, index) => {
                            const row = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.nama_siswa}</td>
                                    <td>${item.nama_kriteria}</td>
                                    <td>${item.nilai}</td>
                                    <td>
                                        <a href="/nilai/edit/${item.id_nilai}" class="btn btn-warning">Edit</a>
                                        <a href="/nilai/delete/${item.id_nilai}" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                    </td>
                                </tr>`;
                            tbody.innerHTML += row;
                        });
                    } else {
                        tbody.innerHTML = '<tr><td colspan="5">Tidak ada data ditemukan</td></tr>';
                    }
                });
        });
    }
});

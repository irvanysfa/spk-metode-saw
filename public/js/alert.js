document.addEventListener("DOMContentLoaded", function() {
    // Notifikasi sukses & error dari session Flashdata (dijalankan jika ada)
    if (typeof flashSuccess !== "undefined" && flashSuccess !== "") {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: flashSuccess,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    }

    if (typeof flashError !== "undefined" && flashError !== "") {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: flashError,
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK'
        });
    }

    // Konfirmasi hapus menggunakan SweetAlert2
    const hapusButtons = document.querySelectorAll(".btn-hapus");

    hapusButtons.forEach(button => {
        button.addEventListener("click", function() {
            let idKriteria = this.getAttribute("data-id");

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin menghapus kriteria ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = baseUrl + "/kriteria/delete/" + idKriteria;
                }
            });
        });
    });
});

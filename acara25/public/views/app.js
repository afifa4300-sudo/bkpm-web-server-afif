const BASE_URL = 'http://localhost/bkpm-web-server-afif/acara24/public';

async function muatDataMahasiswa() {
    const tbody = document.querySelector('#tabel-mahasiswa tbody');
    const loading = document.getElementById('loading-indicator');
    const emptyState = document.getElementById('empty-state');

    // Tugas Praktik Mandiri 1: Tampilkan teks 'Memuat data...'
    if (loading) loading.style.display = 'block';
    if (emptyState) emptyState.style.display = 'none';
    tbody.innerHTML = '';

    try {
        const response = await fetch(`${BASE_URL}/mahasiswa`);
        const hasil = await response.json();

        if (loading) loading.style.display = 'none';

        // Tugas Praktik Mandiri 2: Penanganan kondisi data kosong
        if (!hasil.data || hasil.data.length === 0) {
            if (emptyState) emptyState.style.display = 'block';
            tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">Belum ada data</td></tr>';
            return;
        }

        tbody.innerHTML = '';
        hasil.data.forEach((mhs, index) => {
            tbody.innerHTML += `
                <tr>
                    <td>${index + 1}</td>
                    <td><strong>${mhs.nim}</strong></td>
                    <td>${mhs.nama}</td>
                    <td><span class="badge bg-primary">${mhs.prodi}</span></td>
                </tr>
            `;
        });
    } catch (error) {
        if (loading) loading.style.display = 'none';
        console.error('Gagal memuat data:', error);
        tbody.innerHTML = `<tr><td colspan="4" class="text-center text-danger">Gagal memuat data dari server: ${error.message}</td></tr>`;
    }
}

document.addEventListener('DOMContentLoaded', muatDataMahasiswa);

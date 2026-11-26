const BASE_URL = 'http://localhost/bkpm-web-server-afif/acara25/public';

document.querySelector('#form-login').addEventListener('submit', async (e) => {
    e.preventDefault();
    const btnSubmit = document.querySelector('#btn-login');
    const alertBox = document.querySelector('#alert-box');

    const usernameInput = document.querySelector('#username').value.trim();
    const passwordInput = document.querySelector('#password').value.trim();

    if (!usernameInput || !passwordInput) {
        tampilkanPesan('Username dan password wajib diisi', 'danger');
        return;
    }

    btnSubmit.disabled = true;
    btnSubmit.innerText = 'Memproses login...';

    try {
        const res = await fetch(`${BASE_URL}/login`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ username: usernameInput, password: passwordInput })
        });
        const hasil = await res.json();

        if (hasil.success) {
            localStorage.setItem('token', hasil.data.token);
            localStorage.setItem('role', hasil.data.role);
            localStorage.setItem('username', hasil.data.user.username);
            window.location.href = 'dashboard.html';
        } else {
            tampilkanPesan(hasil.message || 'Login gagal, periksa kredensial Anda', 'danger');
        }
    } catch (err) {
        console.error(err);
        tampilkanPesan('Terjadi kesalahan koneksi ke server', 'danger');
    } finally {
        btnSubmit.disabled = false;
        btnSubmit.innerText = 'Masuk Sekarang';
    }
});

function tampilkanPesan(pesan, tipe) {
    const alertBox = document.querySelector('#alert-box');
    alertBox.className = `alert alert-${tipe}`;
    alertBox.innerText = pesan;
    alertBox.style.display = 'block';
}

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
  <div>
    <p class="text-primary fw-semibold mb-1">DASHBOARD SISTEM INFORMASI AKADEMIK</p>
    <h1 class="h2 mb-1">Selamat datang, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Pengguna', ENT_QUOTES, 'UTF-8') ?></h1>
    <p class="text-secondary mb-0">Kelola data akademik Politeknik Negeri Jember melalui menu yang tersedia.</p>
  </div>
  <div class="d-flex gap-2">
    <a href="<?= BASE_URL ?>/mahasiswa" class="btn btn-primary"><i class="bi bi-people"></i> Mahasiswa</a>
    <a href="<?= BASE_URL ?>/prodi" class="btn btn-outline-primary">Prodi</a>
    <a href="<?= BASE_URL ?>/matakuliah" class="btn btn-outline-primary">Mata Kuliah</a>
  </div>
</div>

<!-- Informasi Status Sistem & Version Control Acara 11 -->
<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card shadow-sm border-0 bg-primary text-white p-3 rounded-3">
      <h6 class="text-white-50 text-uppercase mb-1">Status Version Control</h6>
      <h4 class="mb-0">Git & GitHub Terhubung</h4>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card shadow-sm border-0 bg-success text-white p-3 rounded-3">
      <h6 class="text-white-50 text-uppercase mb-1">Branch Aktif</h6>
      <h4 class="mb-0">main (Produksi)</h4>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card shadow-sm border-0 bg-info text-white p-3 rounded-3">
      <h6 class="text-white-50 text-uppercase mb-1">Repository</h6>
      <h4 class="mb-0">si-akademik</h4>
    </div>
  </div>
</div>


# Evolusi Perangkat Lunak - Praktikum 02: Manajemen GitHub & Prinsip CI

[![CI Status](https://github.com/el-kocan/evolusi-pl-24-544540-sv-25445/actions/workflows/ci.yml/badge.svg)](https://github.com/el-kocan/evolusi-pl-24-544540-sv-25445/actions)
![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=flat&logo=php&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-8.x-646CFF?style=flat&logo=vite&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-v4-06B6D4?style=flat&logo=tailwindcss&logoColor=white)

Repository ini dibangun untuk memenuhi tugas **Praktikum Pertemuan 02** mata kuliah **Konstruksi & Evolusi Perangkat Lunak**, Program Studi Sarjana Terapan, Sekolah Vokasi, Universitas Gadjah Mada.

---

## 👤 Identitas Mahasiswa

* **NIM:** `24/544540/SV/25445`
* **Mata Kuliah:** Konstruksi & Evolusi Perangkat Lunak
* **Dosen Pengampu:** Galih Malela Damaraji, S.Pd., M.Eng.
* **Tahun Ajaran:** Gasal 2025/2026

---

## 🌿 Model Percabangan (Branching Strategy)

Repository ini menerapkan kaidah Git Flow dengan perlindungan cabang (*Branch Protection Rules*):

```text
main (Production Ready & Protected)
  ▲
  └── dev (Integration Branch & Protected)
        ▲
        └── feature/setup-vite-ui (Feature Work)
```

1. **`main`**: Cabang utama yang selalu dalam kondisi rilis stabil. Tidak boleh di-push langsung (*branch protected*).
2. **`dev`**: Cabang integrasi pengembangan tim. Perubahan digabungkan melalui Pull Request dari cabang fitur (*branch protected*).
3. **`feature/*`**: Cabang kerja spesifik untuk pengembangan fitur atau perbaikan.

### Alur Pull Request:
1. `feature/setup-vite-ui` ➔ `dev` (Pull Request #1)
2. `dev` ➔ `main` (Pull Request #2)

---

## ⚙️ Pipeline CI/CD 4 Tahap (GitHub Actions)

Pipeline otomatis dikonfigurasi pada `.github/workflows/deploy.yml` dengan **4 tahap berantai** menggunakan dependensi `needs:`:

$$\text{build} \longrightarrow \text{test} \longrightarrow \text{staging} \longrightarrow \text{production (khusus branch main)}$$

1. **Job 1: `build`**
   * Mengunduh dependensi Composer (`composer install --no-dev`).
   * Mengompilasi aset antarmuka menggunakan Vite (`npm run build`).
   * Menyimpan artefak `vendor/` dan `public/build/` (*build artifact*).

2. **Job 2: `test`**
   * Bergantung pada job `build` (`needs: build`).
   * Menyiapkan basis data pengujian sementara di memori (SQLite `:memory:`).
   * Menjalankan seluruh pengujian unit dan fitur (`php artisan test`). Jika pengujian gagal di sini, job berikutnya otomatis dibatalkan.

3. **Job 3: `staging`**
   * Bergantung pada job `test` (`needs: test`).
   * Melakukan simulasi deployment otomatis ke server tiruan (*mock staging*) tanpa risiko.

4. **Job 4: `production`**
   * Bergantung pada job `staging` (`needs: staging`).
   * **Dilindungi:** Hanya dieksekusi pada cabang **`main`** (`if: github.ref == 'refs/heads/main'`) dan menggunakan GitHub Environment `production` dengan *required reviewer*.
   * Mensimulasikan 7 langkah berurutan dari skrip [`deploy.sh`](file:///deploy.sh).

---

## 📜 Skrip Deployment (`deploy.sh`)

Berkas [`deploy.sh`](file:///deploy.sh) dilengkapi `set -e` agar proses berhenti jika terjadi kesalahan, dengan urutan 7 langkah wajib:
1. `php artisan down --retry=60` (Kunci pintu - mode pemeliharaan)
2. `git pull origin main` (Ambil kode terbaru)
3. `composer install --no-dev --optimize-autoloader` (Pasang dependensi produksi)
4. `php artisan migrate --force` (Ubah skema basis data)
5. `php artisan config:cache && php artisan route:cache && php artisan view:cache` (Bangun ulang cache)
6. `php artisan queue:restart` (Muat ulang pekerja antrean)
7. `php artisan up` (Buka pintu kembali - rilis)

---

## 📝 Format Pesan Commit (Conventional Commits)

Seluruh riwayat commit ditulis menggunakan standar **Conventional Commits**:
* `feat:` penambahan fitur baru (misal tampilan antarmuka, aset baru).
* `test:` penambahan atau penyesuaian pengujian unit/fitur.
* `ci:` konfigurasi alur kerja otomasi dan pipeline pengujian.
* `docs:` pembaruan dokumentasi README atau panduan proyek.
* `chore:` konfigurasi build dasar atau pemeliharaan dependensi.

---

## 🚀 Panduan Menjalankan Proyek di Lingkungan Lokal

### Prasyarat:
* PHP >= 8.3
* Composer >= 2.x
* Node.js >= 20.x & npm

### Langkah Instalasi:
```bash
# 1. Clone repository
git clone https://github.com/el-kocan/evolusi-pl-24-544540-sv-25445.git
cd evolusi-pl-24-544540-sv-25445

# 2. Pasang dependensi PHP & salin konfigurasi env
composer install
cp .env.example .env
php artisan key:generate

# 3. Pasang dependensi Node.js dan build aset
npm install
npm run build

# 4. Jalankan pengujian otomatis
php artisan test

# 5. Jalankan server lokal
php artisan serve
```

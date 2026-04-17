CampTools - Dokumentasi Sistem

Apa itu CampTools?

CampTools adalah aplikasi web untuk mengelola peminjaman alat camping. Sistem ini memudahkan pecinta outdoor untuk meminjam peralatan camping yang dibutuhkan, serta membantu petugas dan admin dalam mengelola proses peminjaman secara efisien.

Fitur Utama

Untuk Peminjam

- Melihat Daftar Alat: Lihat semua alat camping yang tersedia beserta gambar dan deskripsinya
- Mengajukan Peminjaman: Ajukan pinjaman alat camping dengan mudah
- Melihat Riwayat: Pantau status peminjaman dan pengembalian Anda
- Notifikasi Denda: Dapatkan informasi jika ada denda keterlambatan

Untuk Petugas

- Validasi Peminjaman: Setujui atau tolak permintaan peminjaman
- Proses Pengembalian: Catat pengembalian alat dari peminjam
- Kelola Denda: Tetapkan denda untuk peminjaman yang terlambat
- Laporan: Buat laporan aktivitas peminjaman

Untuk Admin

- Kelola User: Tambah, edit, hapus akun pengguna
- Kelola Alat: Tambah, edit, hapus data alat
- Kelola Kategori: Atur kategori alat
- Pantau Semua Aktivitas: Lihat semua peminjaman dan pengembalian
- Log Aktivitas: Catat semua aktivitas sistem



# Antarmuka Sistem

Dashboard Peminjam
- Daftar alat yang tersedia
- Ajukan peminjaman alat camping
- Status peminjaman aktif
- Riwayat peminjaman sebelumnya
- Notifikasi denda keterlambatan

Dashboard Petugas
- Validasi permintaan peminjaman alat camping
- Proses persetujuan atau penolakan peminjaman
- Pantau alat camping yang sedang dipinjam
- Catat pengembalian alat camping dari peminjam
- Kelola denda keterlambatan
- Buat laporan aktivitas peminjaman

Dashboard Admin
- Statistik keseluruhan sistem peminjaman alat camping
- Kelola data pengguna (tambah, edit, hapus)
- Kelola data alat camping (tambah, edit, hapus)
- Kelola kategori alat camping
- Pantau semua transaksi peminjaman
- Pantau semua transaksi pengembalian
- Lihat log aktivitas sistem



# Cara Menggunakan Sistem

Login ke Sistem
- Buka browser dan kunjungi alamat website
- Klik tombol Login
- Masukkan email dan password Anda

Untuk Peminjam Baru
Jika belum punya akun:
- Klik Daftar di sini di halaman login
- Isi formulir pendaftaran
- Login dengan akun baru Anda

Memilih dan Meminjam Alat
- Login sebagai peminjam
- Klik menu Daftar Alat
- Pilih alat camping yang ingin dipinjam (tenda, sleeping bag, kompor, dll)
- Klik tombol Ajukan Peminjaman
- Tunggu persetujuan dari petugas

Proses Persetujuan (Petugas)
- Login sebagai petugas
- Klik menu Validasi Peminjaman
- Lihat daftar permintaan yang menunggu
- Klik Setujui atau Tolak sesuai kebijakan

Pengembalian Alat Camping
- Kembalikan alat camping ke petugas
- Petugas catat pengembalian di sistem
- Jika terlambat, petugas bisa tetapkan denda
- Peminjam akan lihat informasi denda di Riwayat

Teknologi yang Digunakan
- Backend: Laravel versi 12.0 (PHP Framework)
- Database: MySQL
- Frontend: HTML, CSS, JavaScript, Tailwind CSS
- Authentication: Laravel Built-in Auth
- File Storage: Laravel Storage (untuk gambar alat dan QRIS)

Kebijakan Peminjaman

Syarat Peminjaman

- Harus memiliki akun terdaftar
- Alat camping harus tersedia (stok lebih dari 0)
- Maksimal peminjaman sesuai kebijakan penyedia layanan

Denda Keterlambatan

- Denda dihitung per hari keterlambatan
- Nominal denda ditentukan petugas atau admin
- Pembayaran via transfer ke rekening yang ditentukan
- Wajib upload bukti QRIS untuk denda

Proses Pengembalian

1. Kembalikan alat camping ke petugas
2. Petugas catat pengembalian di sistem
3. Jika terlambat, akan dihitung denda
4. Stok alat camping akan bertambah otomatis

Panduan Instalasi (untuk Developer)

Persyaratan Sistem

- PHP 8.1 atau lebih baru
- Composer
- MySQL 5.7 atau lebih baru
- Node.js dan NPM (untuk asset compilation)

Langkah Instalasi

1. Clone repository ini
2. Jalankan composer install
3. Copy .env.example ke .env
4. Konfigurasi database di .env
5. Jalankan php artisan migrate
6. Jalankan php artisan db:seed (jika ada seeder)
7. Jalankan php artisan serve

Konfigurasi Awal

- Buat akun admin pertama melalui database
- Upload gambar alat camping ke folder storage/app/public
- Konfigurasi email untuk notifikasi (opsional)

Bantuan dan Dukungan

Jika Anda mengalami kesulitan:
1. Periksa panduan penggunaan di atas
2. Hubungi petugas penyedia layanan camping
3. Untuk masalah teknis, hubungi admin sistem

Catatan Penting

- Backup Data: Selalu backup database secara berkala
- Keamanan: Jaga kerahasiaan password Anda
- Pelaporan: Laporkan kerusakan alat camping segera ke petugas
- Denda: Bayar denda tepat waktu untuk menghindari sanksi

CampTools - Memudahkan Peminjaman Alat Camping untuk Petualangan Outdoor Anda
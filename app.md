🎯 Deskripsi Umum Aplikasi

JerseyDall adalah aplikasi web berbasis Laravel + Bootstrap yang dirancang untuk memudahkan proses jual beli jersey antara pelanggan dan pihak pengelola (admin).
Sistem ini menggabungkan kemudahan transaksi online dengan verifikasi manual melalui upload bukti pembayaran, tanpa integrasi ke sistem pembayaran otomatis seperti Midtrans.

Aplikasi ini memiliki dua peran utama pengguna: Admin dan Pelanggan, dengan dashboard dan hak akses yang berbeda.
Seluruh tampilan dibuat menggunakan Bootstrap agar ringan, modern, dan mudah digunakan di perangkat apa pun.

👥 Peran Pengguna (User Roles)
🧑‍💼 1. Admin

Admin bertugas mengelola seluruh data dalam aplikasi, baik data jersey, data pengguna, maupun transaksi.

Fungsi dan tanggung jawab admin mencakup:

Melihat daftar jersey yang dijual oleh pelanggan.

Menyetujui atau menolak penjualan jersey pelanggan.

Melakukan CRUD jersey (Create, Read, Update, Delete) — menambah, mengedit, dan menghapus jersey milik sistem.

Melihat daftar transaksi pembelian jersey dari pelanggan.

Mengonfirmasi atau menolak pembayaran yang diunggah pelanggan.

Menghubungi pelanggan melalui nomor telepon atau WhatsApp.

Melihat statistik ringkas: total jersey aktif, total transaksi, total pelanggan, dsb.

👕 2. Pelanggan

Pelanggan adalah pengguna umum yang dapat membeli maupun menjual jersey mereka sendiri melalui platform.

Fungsi dan kemampuan pelanggan:

Melihat daftar jersey yang tersedia (yang disetujui admin).

Melakukan pembelian jersey dengan mengisi alamat, nomor telepon, dan mengunggah bukti pembayaran.

Mengajukan penjualan jersey dengan detail lengkap (nama, harga, ukuran, kondisi, foto, alamat, dan nomor telepon).

Melihat riwayat transaksi (jual & beli).

Memantau status setiap transaksi: pending, disetujui, ditolak, atau selesai.

🧩 Fitur Utama JerseyDall
🔐 1. Autentikasi Manual

Login dan registrasi dibuat tanpa Blade Auth bawaan Laravel (tanpa Breeze/Jetstream).

Form login dan register didesain secara manual menggunakan Bootstrap.

Pengguna baru otomatis memiliki role pelanggan.

Admin utama dibuat secara manual saat setup awal sistem.

🧭 2. Dashboard Terpisah

Terdapat dua dashboard dengan tampilan berbeda:

a. Dashboard Admin

Menampilkan data ringkasan seperti:

Total jersey aktif

Total pelanggan

Total transaksi

Status penjualan

Menu CRUD Jersey, Transaksi, dan Pelanggan

b. Dashboard Pelanggan

Menampilkan menu:

Daftar Jersey

Jual Jersey

Transaksi Saya (riwayat pembelian & penjualan)

👕 3. Fitur CRUD Jersey (Admin)

Admin memiliki kontrol penuh terhadap data jersey.

Fungsinya mencakup:

➕ Tambah Jersey Baru — dengan input nama, harga, ukuran, kondisi, foto, dan deskripsi.

📝 Edit Jersey — memperbarui data jersey yang sudah ada.

❌ Hapus Jersey — menghapus jersey yang sudah tidak dijual.

👁️ Lihat Detail Jersey — menampilkan informasi lengkap jersey.

Admin juga bisa menandai apakah jersey milik sistem sendiri atau dari pelanggan.

💰 4. Penjualan Jersey oleh Pelanggan

Pelanggan dapat menjual jersey mereka melalui form:

Nama Jersey

Harga

Ukuran (S, M, L, XL)

Kondisi (Baru/Bekas)

Foto Jersey

Alamat

Nomor Telepon

Setelah dikirim:

Status awal: “Menunggu Review”

Admin memeriksa data dan foto.

Jika disetujui → status berubah jadi “Aktif”, jersey tampil di halaman publik.

Jika ditolak → status “Ditolak” dan tidak tampil ke publik.

🛒 5. Pembelian Jersey oleh Pelanggan

Saat pelanggan ingin membeli jersey:

Klik tombol “Beli Sekarang”

Isi form:

Alamat pengiriman

Nomor telepon

Upload bukti pembayaran (gambar/struk transfer)

Setelah dikirim, transaksi berstatus Pending

Admin memverifikasi:

✅ Jika valid → status “Selesai”

❌ Jika tidak valid → status “Ditolak”

Admin dapat langsung menghubungi pembeli via WhatsApp untuk konfirmasi cepat.

📦 6. Manajemen Transaksi (Admin)

Admin memiliki halaman khusus untuk melihat dan memproses transaksi.

Fitur yang tersedia:

Melihat daftar transaksi beserta detail pembeli (alamat, no HP, bukti pembayaran).

Mengubah status transaksi: “Pending”, “Selesai”, atau “Ditolak”.

Tombol Hubungi via WhatsApp untuk komunikasi langsung dengan pelanggan.

🧾 7. Riwayat Transaksi (Pelanggan)

Pelanggan bisa melihat:

Riwayat pembelian jersey.

Riwayat penjualan jersey.

Status transaksi dengan label warna:

🟡 Pending

🟢 Selesai

🔴 Ditolak

☎️ 8. Komunikasi Admin–Pelanggan

Setiap transaksi memiliki kolom nomor telepon pelanggan.
Admin bisa langsung menekan tombol “Hubungi via WhatsApp” → otomatis membuka chat di browser/WhatsApp Desktop.

🔄 Alur Aplikasi JerseyDall
🧱 A. Registrasi dan Login

Pengguna membuka halaman utama.

Jika belum punya akun → daftar melalui form manual.

Setelah login:

Role Admin → diarahkan ke Dashboard Admin.

Role Pelanggan → diarahkan ke Dashboard Pelanggan.

🏷️ B. Penjualan Jersey oleh Pelanggan

Pelanggan klik menu “Jual Jersey”.

Isi form data lengkap jersey + kontak.

Submit → data masuk ke database dengan status pending_review.

Admin melakukan review:

Jika disetujui → tampil di daftar publik.

Jika ditolak → pelanggan mendapat notifikasi.

💳 C. Pembelian Jersey oleh Pelanggan

Pelanggan melihat jersey yang aktif.

Klik “Beli Sekarang”.

Isi form pembelian (alamat, nomor telepon, upload bukti pembayaran).

Transaksi masuk sebagai pending.

Admin verifikasi:

Jika sah → status “Selesai”.

Jika tidak valid → status “Ditolak”.

📞 D. Komunikasi Manual

Admin dapat langsung menghubungi pelanggan dari halaman transaksi.
Nomor telepon digunakan untuk memastikan validitas data dan mempercepat proses konfirmasi.

🧠 Keunggulan Aplikasi JerseyDall

✅ Login & register manual (tanpa paket auth bawaan).

✅ Desain Bootstrap modern dan responsif.

✅ Sistem verifikasi manual bukti pembayaran (lebih fleksibel).

✅ Admin punya kontrol penuh (CRUD jersey, transaksi, user).

✅ Fitur jual–beli dua arah (pelanggan bisa jual ke admin).

✅ Nomor telepon & alamat terintegrasi di setiap transaksi.

✅ Status transaksi jelas & transparan.

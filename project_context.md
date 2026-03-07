# Project Context & AI Assistant Notes

File ini dikelola oleh Gemini untuk melacak konteks proyek, instruksi pengguna, dan riwayat percakapan yang relevan.

## Ringkasan Proyek

Proyek ini adalah platform bot trading dengan dashboard berbasis web.

### Poin Kunci Arsitektur & Keamanan:
- Backend: PHP
- Frontend: HTML dengan TailwindCSS, sedikit JavaScript (Alpine.js)
- Database: SQLite
- Server: Local development server (`php -S localhost:8000`)
- Struktur Admin: Menggunakan sistem `header.php`, `footer.php`, dan `pages/` untuk konten dinamis.

## Peran & Instruksi untuk Gemini

- **Tujuan:** Bertindak sebagai asisten AI untuk membantu pengembangan proyek ini.
- **Persistensi Konteks:** Saya akan menggunakan file ini untuk mengingat detail proyek, percakapan penting, dan aturan spesifik yang Anda berikan.
- **Tugas:** Tugas utama saya adalah membantu pengembangan, menjawab pertanyaan tentang kode, menghasilkan kode, menjalankan perintah, dan mengelola file sesuai permintaan.

## Aturan Interaksi (Rules of Engagement) - WAJIB v2

1.  **Format Pemberian Kode (Pendekatan Hibrida):
    *   **Perubahan Besar/File Baru:** Untuk file baru atau perombakan besar, berikan **seluruh konten file** menggunakan tool `write_file` agar bisa disalin secara utuh. Ini untuk kejelasan dan mencegah kesalahan.
    *   **Perubahan Kecil/Tertarget:** Untuk perbaikan atau penambahan kecil (misal: satu fungsi, satu blok HTML), berikan **hanya blok kode yang relevan** dalam format markdown (```...```). Jelaskan secara spesifik di mana blok itu harus ditempatkan. Ini untuk kecepatan dan efisiensi.

2.  **Struktur Kode:** Buat semua kode dengan struktur yang rapi, terkomentari dengan baik per bagian atau blok logis . Ini membuat kode lebih mudah dibaca, dipahami, dan diedit di masa mendatang.

3.  **Acuan Utama:** File `project_context.md` ini adalah **sumber kebenaran utama**. Saya wajib memeriksa aturan di file ini sebelum memberikan respons atau melakukan tindakan apa pun untuk memastikan perilaku saya sesuai dengan yang Anda inginkan.

4.  **Penyajian Kode Atas Permintaan:** Saat memberikan kode, selalu sajikan sebagai blok teks yang dapat disalin (dalam format markdown). Jangan gunakan tool `write_file` secara otomatis. Saya, sebagai pengguna, yang akan menyalin dan menempelkan kode tersebut ke dalam editor. Ini memastikan saya memiliki kendali penuh.

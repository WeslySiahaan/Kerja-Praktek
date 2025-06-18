@extends('layouts.app')

@section('styles')
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f5f5f5;
      padding: 0px;
      margin: 0;
    }

    h2 {
      font-family: 'Poppins', sans-serif;
      font-size: 28px;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .faq-section {
      background: white;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
      width: 100%;
      max-width: 100vw;
    }

    .faq-title {
      font-size: 30px;
      font-family: 'Poppins', sans-serif;
      display: flex;
      align-items: center;
      font-weight: bold;
      font-size: 24px;
      margin-bottom: 15px;
    }

    .faq-title i {
      margin-right: 10px;
    }

    .faq-item {
      font-size: 28px;
      border-top: 1px solid #eee;
      padding: 12px 0;
    }

    .faq-item:first-of-type {
      border-top: none;
    }

    .faq-question {
      font-size: 18px;
      font-family: 'Poppins', sans-serif;
      font-weight: bold;
      color: #4A90E2;
      display: flex;
      justify-content: space-between;
      align-items: center;
      cursor: pointer;
    }

    .faq-icon {
      color: #888;
      font-size: 14px;
    }

    .faq-answer {
      display: none;
      font-family: 'Poppins', sans-serif;
      font-size: 16px;
      color: #666666;
      margin-top: 8px;
      padding-left: 20px;
    }

    .faq-item.open .faq-answer {
      display: block;
    }

    .faq-item.open .faq-icon i::before {
      content: "\f068"; /* Font Awesome minus icon */
    }

    h1 {
      font-family: 'Poppins', sans-serif;
      font-size: 28px;
      font-weight: bold;
      margin-bottom: 20px;
    }
  </style>
@endsection

@section('content')
  <h1 class="fw-bold" style="font-size: 28px;">Pertanyaan Umum</h1>

  {{-- Profil & Akun --}}
  <div class="faq-section">
    <div class="faq-title">
      <span style="font-size: 28px; margin-right: 10px;">👤</span>
      <span><strong>Profil & Akun</strong></span>
    </div>

    <div class="faq-item">
      <div class="faq-question">
        Bagaimana cara update profil?
        <span class="faq-icon"><i class="fas fa-plus"></i></span>
      </div>
      <div class="faq-answer">Anda bisa memperbarui Foto, Nama, dan Email Anda melalui menu <strong>Profil > Update Profil</strong>.</div>
    </div>

    <div class="faq-item">
      <div class="faq-question">
        Bagaimana cara mengubah kata sandi?
        <span class="faq-icon"><i class="fas fa-plus"></i></span>
      </div>
      <div class="faq-answer">Untuk mengubah kata sandi, silakan masuk ke menu <strong>Pengaturan</strong>. Anda akan menemukan opsi untuk memperbarui kata sandi di sana.</div>
    </div>
  </div>

  {{-- Menonton & Konten --}}
  <div class="faq-section">
    <div class="faq-title">
      <span style="font-size: 28px; margin-right: 10px;">▶️</span>
      <span><strong>Menonton & Konten</strong></span>
    </div>

    <div class="faq-item">
      <div class="faq-question">
        Mengapa video tidak bisa diputar?
        <span class="faq-icon"><i class="fas fa-plus"></i></span>
      </div>
      <div class="faq-answer">Pastikan koneksi internet Anda stabil. Coba segarkan (refresh) halaman atau mulai ulang aplikasi. Jika masih bermasalah, kemungkinan konten tidak tersedia di wilayah Anda atau telah dihapus.</div>
    </div>

    <div class="faq-item">
      <div class="faq-question">
        Bagaimana cara melihat riwayat tontonan?
        <span class="faq-icon"><i class="fas fa-plus"></i></span>
      </div>
      <div class="faq-answer">Anda dapat menemukan semua video yang pernah Anda tonton di menu <strong>Profil > Riwayat Tontonan</strong>.</div>
    </div>

    <div class="faq-item">
      <div class="faq-question">
        Apa itu fitur Koleksi?
        <span class="faq-icon"><i class="fas fa-plus"></i></span>
      </div>
      <div class="faq-answer">Fitur <strong>Koleksi</strong> memungkinkan Anda menyimpan dan mengelompokkan video-video favorit Anda agar mudah ditemukan kembali di kemudian hari.</div>
    </div>

    <div class="faq-item">
      <div class="faq-question">
        Bagaimana cara mencari video tertentu?
        <span class="faq-icon"><i class="fas fa-plus"></i></span>
      </div>
      <div class="faq-answer">Gunakan fitur pencarian di bagian atas aplikasi atau situs untuk mencari video berdasarkan kata kunci.</div>
    </div>
  </div>

  {{-- Pengaturan --}}
  <div class="faq-section">
    <div class="faq-title">
      <span style="font-size: 28px; margin-right: 10px;">⚙️</span>
      <span><strong>Pengaturan</strong></span>
    </div>

    <div class="faq-item">
      <div class="faq-question">
        Bagaimana cara mengubah bahasa?
        <span class="faq-icon"><i class="fas fa-plus"></i></span>
      </div>
      <div class="faq-answer">Masuk ke menu <strong>Pengaturan</strong>, lalu pilih bahasa yang diinginkan dari daftar bahasa yang tersedia.</div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
      const question = item.querySelector('.faq-question');
      question.addEventListener('click', () => {
        item.classList.toggle('open');
      });
    });
  });
</script>
@endpush

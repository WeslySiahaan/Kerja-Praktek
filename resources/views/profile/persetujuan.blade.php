@extends('layouts.app')

@section('styles')
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: #f5f5f5;
    padding: 0;
    margin: 0;
  }

  .terms-container {
    max-width: 1300px;
    margin: 10px auto;
    background: #fff;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  h1 {
    font-family: 'Poppins', sans-serif;
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
    color: #000;
    text-align: left;
  }

  p {
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    line-height: 1.6;
    color: #333;
    text-align: justify;
    margin-bottom: 15px;
  }

  .terms-list {
    margin-top: 20px;
    margin-bottom: 20px;
  }

  .terms-item {
    margin-bottom: 15px;
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    color: #333;
    text-align: justify;
  }

  .terms-item strong {
    display: block;
    margin-bottom: 5px;
    color: #000;
  }
</style>
@endsection

@section('content')
<div class="terms-container">
  <h1>Persetujuan Pengguna</h1>
  <p>Terima kasih telah menggunakan layanan CineMora. Dengan mengakses atau menggunakan platform kami, Anda menyatakan bahwa Anda telah membaca, memahami, dan menyetujui untuk terikat oleh ketentuan berikut:</p>

  <div class="terms-list">
    <div class="terms-item">
      <strong>1. Ketentuan Umum</strong>
      Anda setuju untuk menggunakan layanan sesuai dengan hukum dan peraturan yang berlaku di wilayah hukum Anda.
    </div>

    <div class="terms-item">
      <strong>2. Hak Kekayaan Intelektual</strong>
      Seluruh konten, desain, logo, dan fitur yang terdapat dalam platform ini adalah milik CineMora atau pihak ketiga yang bekerja sama, dan dilindungi oleh hukum hak cipta serta kekayaan intelektual.
    </div>

    <div class="terms-item">
      <strong>3. Akun Pengguna</strong>
      Anda bertanggung jawab untuk menjaga kerahasiaan informasi akun dan kata sandi Anda. MoraClips tidak bertanggung jawab atas kerugian yang mungkin timbul akibat kelalaian Anda dalam menjaga keamanan akun.
    </div>

    <div class="terms-item">
      <strong>4. Pembatasan Tanggung Jawab</strong>
      Kami berusaha memberikan layanan terbaik, tetapi kami tidak menjamin bahwa layanan akan selalu bebas dari gangguan, kesalahan, atau virus.<br>
      Kami tidak bertanggung jawab atas kerugian langsung atau tidak langsung yang timbul akibat penggunaan atau ketidakmampuan penggunaan layanan.
    </div>

    <div class="terms-item">
      <strong>5. Penghentian Layanan</strong>
      Kami berhak menghentikan atau menangguhkan akses Anda ke layanan jika Anda terbukti melanggar ketentuan ini.
    </div>

    <div class="terms-item">
      <strong>6. Kontak</strong>
      Jika Anda memiliki pertanyaan mengenai Persetujuan Pengguna ini, silakan hubungi kami melalui halaman "Hubungi Kami" di platform.
    </div>
  </div>
</div>
@endsection
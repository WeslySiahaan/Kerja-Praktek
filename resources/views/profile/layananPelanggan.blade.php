@extends('layouts.app')

@section('styles')
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: #f5f5f5;
    padding: 0;
    margin: 0;
  }

  .section-box {
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
  }

  h1 {
    font-family: 'Poppins', sans-serif;
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 20px;
  }

.section-title {
  border-bottom: 2px solid #007bff;
  margin-top: 60px;
  margin-bottom: 30px;
  padding-bottom: 10px;
}



  .section-title h2 {
    font-family: 'Poppins', sans-serif;
    font-size: 20px;
    font-weight: bold;
    margin: 0;
    padding-bottom: 6px;
  }

  .item-list {
    font-family: 'Poppins', sans-serif;
    list-style: none;
    padding: 0;
  }

  .item-list li {
    margin-bottom: 8px;
    font-size: 15px;
    padding-bottom: 10px;
  }

  .item-list li::before {
    content: "✓";
    color: #007bff;
    margin-right: 8px;
  }

  .icon-label {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    font-size: 16px;
  }

  .icon-label span {
    margin-left: 10px;
    font-weight: bold;
  }

  .blue-link {
    color: #007bff;
    text-decoration: underline;
  }

  p {
    font-family: 'Poppins', sans-serif;
    padding-bottom: 10px;
  }
</style>
@endsection

@section('content')
<div class="section-box">
  <h1>Layanan Pelanggan</h1>
  <p style="font-size: 18px;"><strong>Selamat Datang di Layanan Pelanggan</strong></p>
  <p>Kami siap membantu Anda dengan pertanyaan atau masalah apa pun. Silakan pilih opsi di bawah ini:</p>


  {{-- Kontak Kami --}}
  <div class="section-title">
    <h2>KONTAK KAMI</h2>
  </div>
  <ul class="item-list">
    <li>EMAIL: <a href="mailto:support@marceltips.com" class="blue-link">support@marceltips.com</a></li>
    <li>Telepon: +62 123 456 789</li>
    <li>Jam Operasional: Senin - Jumat, 09:00 - 17:00 WIB</li>
  </ul>

  {{-- Pertanyaan Umum --}}
  <div class="section-title">
    <h2>PERTANYAAN UMUM</h2>
  </div>
  <ul class="item-list">
    <li>Pengelolaan Akun</li>
    <li>Menonton & Konten</li>
    <li>Pengaturan</li>
  </ul>

  {{-- Bantuan Teknis --}}
  <div class="section-title">
    <h2>BANTUAN TEKNIS</h2>
  </div>
  <ul class="item-list">
    <li>Masalah Login</li>
    <li>Kesalahan Aplikasi</li>
    <li>Panduan Penggunaan</li>
  </ul>

  {{-- Kirim Saran --}}
  <div class="section-title">
    <h2>KIRIM SARAN DAN KELUHAN</h2>
  </div>
  <p><a href="#" class="blue-link">Klik di sini</a> untuk mengirimkan feedback Anda.</p>
</div>
@endsection
@extends('layouts.app')

@section('styles')
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: #f5f5f5;
    padding: 0;
    margin: 0;
  }

  .privacy-container {
    max-width: 1300px;
    margin: 10px auto;
    background: #fff;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  h1 {
    font-family: 'Poppins', sans-serif;
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 25px;
    color: #333;
    text-align: left;
  }

  p {
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    line-height: 1.8;
    color: #555;
    text-align: justify;
    margin-bottom: 15px;
  }

  ul {
    padding-left: 20px;
    margin-bottom: 20px;
  }

  li {
    margin-bottom: 10px;
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    color: #555;
    text-align: justify;
  }

  strong {
    color: #000;
  }
</style>
@endsection

@section('content')
<div class="privacy-container">
  <h1>Kebijakan Privasi</h1>
  <p>CineMora menghargai privasi Anda. Kebijakan ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi data pribadi Anda saat menggunakan layanan kami.</p>

  <p><strong>1. Informasi yang Kami Kumpulkan</strong></p>
  <p>Kami dapat mengumpulkan informasi pribadi yang mencakup, tetapi tidak terbatas pada:</p>
  <ul>
    <li>Nama dan alamat email</li>
    <li>Riwayat tontonan</li>
  </ul>

  <p><strong>2. Penggunaan Informasi</strong></p>
  <p>Informasi yang kami kumpulkan digunakan untuk:</p>
  <ul>
    <li>Menyediakan dan meningkatkan layanan kami</li>
    <li>Menyesuaikan konten sesuai preferensi Anda</li>
    <li>Mengirimkan pembaruan dan pemberitahuan penting</li>
    <li>Menganalisis perilaku pengguna untuk meningkatkan pengalaman aplikasi</li>
  </ul>

  <p><strong>3. Penyimpanan dan Keamanan Data</strong></p>
  <ul>
    <li>Data disimpan secara aman menggunakan sistem terenkripsi.</li>
    <li>Kami mengambil langkah-langkah teknis dan organisasi untuk melindungi data dari akses yang tidak sah, kehilangan, atau penyalahgunaan.</li>
  </ul>

  <p><strong>4. Hak Anda</strong></p>
  <p>Sebagai pengguna, Anda memiliki hak untuk:</p>
  <ul>
    <li>Mengakses dan memperbarui informasi pribadi Anda</li>
    <li>Meminta penghapusan akun dan data</li>
    <li>Menarik persetujuan untuk penggunaan data sewaktu-waktu</li>
  </ul>

  <p><strong>5. Penggunaan Cookie</strong></p>
  <p>Kami menggunakan cookie untuk meningkatkan pengalaman pengguna, seperti menyimpan preferensi bahasa dan pengaturan tampilan.</p>

  <p><strong>6. Perubahan Kebijakan</strong></p>
  <p>Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu. Perubahan akan diberitahukan melalui aplikasi atau situs web resmi kami.</p>
</div>
@endsection

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

  .form-group {
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 20px;
  }

  label {
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
  }

  input,
  textarea {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #E0E0E0;
    font-family: 'Poppins', sans-serif;
    font-weight: bold;
    background-color: #E0E0E0;
  }

  textarea {
    height: 120px;
    resize: none;
  }

  button {
    background-color: #4A90E2;
    font-family: 'Poppins', sans-serif;
    font-weight: bold;
    color: white;
    border: none;
    padding: 2px 26px;
    border-radius: 10px;
    cursor: pointer;
  }

  .section-title {
    margin-top: 0px;
    margin-bottom: 20px;
    font-size: 20px;
    font-weight: bold;
    color: #007bff;
  }

  .black-title {
    font-family: 'Poppins', sans-serif;
    font-weight: bold;
    color: #000000;
    font-size: 20px;
  }

  .contact-info {
    margin-bottom: 20px;
    font-size: 15px;
    font-style: italic;
    font-family: 'Poppins', sans-serif;
  }

  .blue-link {
    color: #007bff;
    text-decoration: underline;
  }
</style>
@endsection

@section('content')
<div class="container mt-4">

  <h1>Hubungi & Saran</h1>

  {{-- Formulir Kontak --}}
  <div class="section-box">
    <div class="section-title">Formulir Kontak</div>
    <form action="#" method="POST">
      @csrf
      <div class="form-group">
        <label>Nama Lengkap</label>
        <input type="text" name="nama" required>
      </div>
      <div class="form-group">
        <label>Alamat Email</label>
        <input type="email" name="email" required>
      </div>
      <div class="form-group">
        <label>Nomor Telepon (Opsional)</label>
        <input type="text" name="telepon">
      </div>
      <div class="form-group">
        <label>Subjek Pesan</label>
        <input type="text" name="subjek" required>
      </div>
      <div class="form-group">
        <label>Pesan</label>
        <textarea name="pesan" required></textarea>
      </div>
      <button type="submit">Kirim</button>
    </form>
  </div>

  {{-- Opsi Kontak Lain --}}
  <div class="section-box">
    <div class="section-title black-title">Opsi Kontak Lain</div>
    <div class="contact-info">
      <p>Email: support@domain.com</p>
      <p>Telepon: 0719 1419</p>
      <p>Jam Operasional: Senin - Jumat, 08:00 - 17:00 WIB</p>
      <p>Respons akan diberikan dalam 1x24 jam.</p>
    </div>
  </div>

  {{-- Form Saran --}}
  <div class="section-box">
    <div class="section-title">Saran</div>
    <form action="#" method="POST">
      @csrf
      <div class="form-group">
        <label>Bagaimana pengalaman Anda dengan layanan kami?</label>
        <label>Skala Kepuasan (1-5)</label>
        <input type="number" name="skala" min="1" max="5" required>
      </div>
      <div class="form-group">
        <label>Komentar atau Saran</label>
        <textarea name="komentar" required></textarea>
      </div>
      <button type="submit">Kirim Saran</button>
    </form>
  </div>

</div>
@endsection
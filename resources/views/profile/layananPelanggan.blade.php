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

  p {
    font-size: 15px;
    padding-bottom: 10px;
  }
</style>
@endsection

@section('content')
<div class="container mt-5">
  <h1>Layanan Pelanggan</h1>
  <p>Terima kasih telah menggunakan layanan CineMora.</p>

  <h5>1. Kontak Kami</h5>
  @if ($layanan && $layanan->kontak)
      <p>{!! nl2br(e($layanan->kontak)) !!}</p>
  @else
      <p class="text-muted">Tunggu informasi dari admin.</p>
  @endif

  <h5>2. Pertanyaan Umum</h5>
  @if ($layanan && $layanan->pertanyaan)
      <p>{!! nl2br(e($layanan->pertanyaan)) !!}</p>
  @else
      <p class="text-muted">Tunggu informasi dari admin.</p>
  @endif

  <h5>3. Bantuan</h5>
  @if ($layanan && $layanan->bantuan)
      <p>{!! nl2br(e($layanan->bantuan)) !!}</p>
  @else
      <p class="text-muted">Tunggu informasi dari admin.</p>
  @endif
</div>
@endsection


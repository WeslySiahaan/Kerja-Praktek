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

  h1, h2, h5 {
    font-family: 'Poppins', sans-serif;
    font-weight: bold;
    color: #333;
    text-align: left;
  }

  h1 {
    font-size: 28px;
    margin-bottom: 25px;
  }

  h2 {
    font-size: 24px;
    margin-bottom: 20px;
  }

  h5 {
    font-size: 20px;
    margin-top: 25px;
    margin-bottom: 10px;
  }

  p, li {
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
  }

  strong {
    color: #000;
  }

  .table-responsive {
    margin-top: 20px;
  }
</style>
@endsection

@section('content')
<div class="privacy-container">
  <h1>Persetujuan Pengguna</h1>
  <p>Terima kasih telah menggunakan layanan CineMora.</p>
    <p>Dengan mengakses atau menggunakan platform kami, Anda menyatakan bahwa Anda telah membaca, memahami, dan menyetujui untuk terikat oleh ketentuan berikut:</p>

  <div class="p-4">
    @if($policies->isEmpty())
      <div class="list-group-item text-center">
        No policies found.
      </div>
    @else
      @foreach($policies as $policy)
        <h5>1. Ketentuan Umum</h5>
        <div class="list-group">
          <div class="list-group-item">
            <p class="mb-1">{!! nl2br(e($policy->ketentuan_umum ?? '')) !!}</p>
          </div>
        </div>

        <h5>2. Hak Kekayaan Intelektual</h5>
        <div class="list-group">
          <div class="list-group-item">
            <p class="mb-1">{!! nl2br(e($policy->hak_kekayaan_intelektual ?? '')) !!}</p>
          </div>
        </div>

        <h5>3. Akun Pengguna</h5>
        <div class="list-group">
          <div class="list-group-item">
            <p class="mb-1">{!! nl2br(e($policy->akun_pengguna ?? '')) !!}</p>
          </div>
        </div>

        <h5>4. Pembatasan Tanggung Jawab</h5>
        <div class="list-group">
          <div class="list-group-item">
            <p class="mb-1">{!! nl2br(e($policy->pembatasan_tanggung_jawab ?? '')) !!}</p>
          </div>
        </div>

        <h5>5. Penghentian Layanan</h5>
        <div class="list-group">
          <div class="list-group-item">
            <p class="mb-1">{!! nl2br(e($policy->penghentian_layanan ?? '')) !!}</p>
          </div>
        </div>

        <h5>6. Kontak</h5>
        <div class="list-group">
          <div class="list-group-item">
            <p class="mb-1">{!! nl2br(e($policy->kontak ?? '')) !!}</p>
          </div>
        </div>
      @endforeach
    @endif
  </div>
</div>
@endsection
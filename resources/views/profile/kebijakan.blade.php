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
  <h1>Kebijakan Privasi</h1>
  <p>CineMora menghargai privasi Anda. Kebijakan ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi data pribadi Anda saat menggunakan layanan kami.</p>

  <div class="p-4">
    @if($policies->isEmpty())
      <div class="list-group-item text-center">
        No policies found.
      </div>
    @else
      @foreach($policies as $policy)
        {{-- History --}}
        <h5>1. Informasi yang Kami Kumpulkan</h5>
        <div class="list-group">
          <div class="list-group-item">
            <p class="mb-1">{!! nl2br(e($policy->history ?? 'N/A')) !!}</p>
          </div>
        </div>

        {{-- Usage --}}
        <h5>2. Penggunaan Informasi</h5>
        <div class="list-group">
          <div class="list-group-item">
            <p class="mb-1">{!! nl2br(e($policy->usage ?? 'N/A')) !!}</p>
          </div>
        </div>

        {{-- Security --}}
        <h5>3. Penyimpanan dan Keamanan Data</h5>
        <div class="list-group">
          <div class="list-group-item">
            <p class="mb-1">{!! nl2br(e($policy->security ?? 'N/A')) !!}</p>
          </div>
        </div>

        {{-- Rights --}}
        <h5>4. Hak Anda</h5>
        <div class="list-group">
          <div class="list-group-item">
            <p class="mb-1">{!! nl2br(e($policy->rights ?? 'N/A')) !!}</p>
          </div>
        </div>

        {{-- Cookies --}}
        <h5>5. Penggunaan Cookie</h5>
        <div class="list-group">
          <div class="list-group-item">
            <p class="mb-1">{!! nl2br(e($policy->cookies ?? 'N/A')) !!}</p>
          </div>
        </div>

        {{-- Changes --}}
        <h5>6. Perubahan Kebijakan</h5>
        <div class="list-group">
          <div class="list-group-item">
            <p class="mb-1">{!! nl2br(e($policy->changes ?? 'N/A')) !!}</p>
          </div>
        </div>
      @endforeach
    @endif
  </div>
</div>
@endsection

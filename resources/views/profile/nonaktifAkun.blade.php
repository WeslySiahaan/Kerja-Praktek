@extends('layouts.app')

@section('styles')
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: #f5f5f5;
    padding: 0;
    margin: 0;
  }

  .deactivate-container {
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

  label {
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    color: #333;
    display: block;
    margin-top: 15px;
    margin-bottom: 5px;
  }

  input[type="email"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-family: 'Poppins', sans-serif;
    margin-bottom: 15px;
  }

  .checkbox-container {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
  }

  .checkbox-container input[type="checkbox"] {
    width: 18px;
    height: 18px;
    margin-right: 10px;
  }

  .checkbox-container label {
    margin: 0;
    font-size: 16px;
    color: #333;
  }

  .button-group {
    display: flex;
    justify-content: space-between;
  }

  .btn-cancel {
    background-color: #e74c3c;
    color: white;
    border: none;
    padding: 10px 25px;
    border-radius: 6px;
    font-family: 'Poppins', sans-serif;
    cursor: pointer;
  }

  .btn-confirm {
    background-color: #3498db;
    color: white;
    border: none;
    padding: 10px 25px;
    border-radius: 6px;
    font-family: 'Poppins', sans-serif;
    cursor: pointer;
  }
</style>
@endsection

@section('content')
<div class="deactivate-container">
  <h1>Nonaktifkan Akun</h1>
  <p>Apakah Anda yakin ingin menonaktifkan akun Anda? Menonaktifkan akun Anda bersifat sementara, dan itu berarti profil Anda akan disembunyikan di CineMora sampai Anda mengaktifkannya kembali melalui nonaktif akun atau dengan masuk ke akun CineMora Anda.</p>

  <form action="{{ route('profile.nonaktifAkun') }}" method="POST">
    @csrf
    <label for="email">Masukkan kembali email anda :</label>
    <input type="email" id="email" name="email" required>

    <div class="checkbox-container">
      <input type="checkbox" id="agree" name="agree" required>
      <label for="agree">Saya setuju untuk menonaktifkan akun saya</label>
    </div>

    <div class="button-group">
      <button type="button" class="btn-cancel" onclick="window.history.back()">Batal</button>
      <button type="submit" class="btn-confirm">Ya</button>
    </div>
  </form>
</div>
@endsection

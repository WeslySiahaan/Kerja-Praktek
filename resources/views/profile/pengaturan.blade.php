@extends('layouts.app')

@section('styles')
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: #f5f5f5;
    padding: 0;
    margin: 0;
  }

  .settings-container {
    max-width: 500px;
    margin: 40px auto;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }

  h1 {
    font-family: 'Poppins', sans-serif;
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 30px;
  }

  .settings-option {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    margin-bottom: 15px;
    cursor: pointer;
    transition: background 0.3s;
    text-decoration: none;
    color: inherit;
  }

  .settings-option:hover {
    background: #f0f0f0;
  }

  .settings-option i {
    font-size: 20px;
    margin-right: 10px;
  }

  .settings-label {
    display: flex;
    align-items: center;
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    color: #333;
    text-decoration: none;
  }

  .language-button {
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 6px;
    padding: 5px 15px;
    font-family: 'Poppins', sans-serif;
    cursor: pointer;
  }
</style>
@endsection

@section('content')
  <h1>Pengaturan</h1>

  <a href="{{ route('profile.persetujuan') }}" class="settings-option">
    <div class="settings-label">
      <i class="fas fa-file-alt"></i> Persetujuan Pengguna
    </div>
  </a>

  <a href="{{ route('profile.kebijakan') }}" class="settings-option">
    <div class="settings-label">
      <i class="fas fa-shield-alt"></i> Kebijakan Privasi
    </div>
  </a>

@endsection

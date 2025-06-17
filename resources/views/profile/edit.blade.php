{{--
  File: resources/views/profile/edit.blade.php
  Tujuan: Memperbaiki validasi dengan menambahkan hidden input dan pesan error spesifik.
--}}

@extends('layouts.app')

@section('styles')
<style>
    /* Styling Tampilan Utama */
    .info-box { background-color: #E9F4FF; color: #000000; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; font-weight: 500; }
    .profile-card { background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #dee2e6; }
    .profile-field { display: flex; justify-content: space-between; align-items: center; padding: 1.25rem 1.5rem; border-bottom: 1px solid #e9ecef; }
    .profile-field:last-child { border-bottom: none; }
    .profile-label-group { display: flex; flex-direction: column; }
    .profile-label-group .label { font-size: 0.9rem; color: #6c757d; margin-bottom: 0.25rem; }
    .profile-label-group .value, .profile-label-group .password-dots { font-size: 1rem; font-weight: 500; color: #212529; }
    .profile-label-group .profile-photo { display: flex; align-items: center; }
    .profile-label-group .profile-photo .bi-person-circle { font-size: 2.5rem; color: #6c757d; }
    .profile-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
    .btn-edit { background-color: #fff; color: #495057; border: 1px solid #dee2e6; padding: 8px 20px; border-radius: 8px; text-decoration: none; font-weight: 500; transition: background-color 0.2s; }
    .btn-edit:hover { background-color: #f1f3f5; }

    /* Styling untuk Modal (Pop-up) */
    .modal-header { border-bottom: none; padding: 1.5rem 1.5rem 0.5rem; }
    .modal-title { font-weight: 700; font-size: 1.5rem; }
    .modal-body { padding: 1rem 1.5rem; }
    .modal-footer { border-top: none; padding: 0.5rem 1.5rem 1.5rem; }
    .form-group-modal { margin-bottom: 1rem; }
    .form-label-modal { font-weight: 600; color: #495057; margin-bottom: 0.5rem; display: block; }
    .form-control-modal { width: 100%; padding: 0.75rem 1rem; border: 1px solid #ced4da; border-radius: 8px; font-size: 1rem; box-sizing: border-box; }
    .form-control-modal:read-only { background-color: #e9ecef; }
    .btn-cancel { background-color: #dc3545; color: white; padding: 0.6rem 1.2rem; border: none; border-radius: 8px; }
    .btn-submit { background-color: #0d6efd; color: white; padding: 0.6rem 1.2rem; border: none; border-radius: 8px; }
    .invalid-feedback { color: #dc3545; font-size: 0.875em; margin-top: 0.25rem; } /* Styling untuk pesan error */
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="content-header" style="margin-bottom: 2rem;">
        <h1 style="font-size: 28px; font-weight: 700;">Update Profile</h1>
    </div>

    {{-- Notifikasi jika ada error atau sukses --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            Terdapat kesalahan pada input Anda. Silakan periksa pesan di bawah setiap form.
        </div>
    @endif
    @if (session('status'))
        <div class="alert alert-success">
            Data berhasil diperbarui!
        </div>
    @endif

    <div class="info-box">
        Perbaharui Informasi Umum akun Anda
    </div>

    <div class="profile-card">
        {{-- Tampilan utama tidak berubah --}}
        <!-- Baris Foto Profile -->
        <div class="profile-field">
            <div class="profile-label-group">
                <span class="label">Foto Profile</span>
                <div class="profile-photo">
                    @if ($user->profile_photo_path)
                <img src="{{ route('profile.image', ['filename' => basename($user->profile_photo_path)]) }}" alt="Avatar" class="profile-avatar">
                    @else
                        <i class="bi bi-person-circle"></i>
                    @endif
                </div>
            </div>
            <button type="button" class="btn-edit" data-bs-toggle="modal" data-bs-target="#editPhotoModal">Ubah</button>
        </div>
        <!-- Baris Nama -->
        <div class="profile-field">
            <div class="profile-label-group">
                <span class="label">Nama</span>
                <span class="value">{{ $user->name }}</span>
            </div>
            <button type="button" class="btn-edit" data-bs-toggle="modal" data-bs-target="#editNameModal">Ubah</button>
        </div>
        <!-- Baris Email -->
        <div class="profile-field">
            <div class="profile-label-group">
                <span class="label">Email</span>
                <span class="value">{{ $user->email }}</span>
            </div>
            <button type="button" class="btn-edit" data-bs-toggle="modal" data-bs-target="#editEmailModal">Ubah</button>
        </div>
        <!-- Baris Kata Sandi -->
        <div class="profile-field">
            <div class="profile-label-group">
                <span class="label">Kata Sandi</span>
                <span class="password-dots">••••••••••</span>
            </div>
             <button type="button" class="btn-edit" data-bs-toggle="modal" data-bs-target="#editPasswordModal">Ubah</button>
        </div>
    </div>
</div>

<!-- =================================================================== -->
<!-- MODALS DENGAN PERBAIKAN VALIDASI -->
<!-- =================================================================== -->

<!-- Modal untuk Ubah Foto Profil -->
<div class="modal fade" id="editPhotoModal" tabindex="-1" aria-labelledby="editPhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('patch')
                {{-- DITAMBAHKAN: Input tersembunyi untuk nama dan email agar validasi tidak gagal --}}
                <input type="hidden" name="name" value="{{ $user->name }}">
                <input type="hidden" name="email" value="{{ $user->email }}">

                <div class="modal-header">
                    <h5 class="modal-title" id="editPhotoModalLabel">Ubah Foto Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group-modal">
                        <label for="profile_photo" class="form-label-modal">Pilih Gambar Anda</label>
                        <input type="file" name="profile_photo" class="form-control-modal" required>
                        {{-- DITAMBAHKAN: Menampilkan pesan error spesifik --}}
                        @error('profile_photo')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal untuk Ubah Nama -->
<div class="modal fade" id="editNameModal" tabindex="-1" aria-labelledby="editNameModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('patch')
                {{-- DITAMBAHKAN: Input tersembunyi untuk email agar validasi tidak gagal --}}
                <input type="hidden" name="email" value="{{ $user->email }}">

                <div class="modal-header">
                    <h5 class="modal-title" id="editNameModalLabel">Ubah Nama Anda</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group-modal">
                        <label class="form-label-modal">Nama saat ini</label>
                        <input type="text" class="form-control-modal" value="{{ $user->name }}" readonly>
                    </div>
                    <div class="form-group-modal">
                        <label for="name" class="form-label-modal">Nama Baru</label>
                        <input type="text" id="name" name="name" class="form-control-modal" placeholder="Ketik nama baru" required>
                        {{-- DITAMBAHKAN: Menampilkan pesan error spesifik --}}
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal untuk Ubah Email -->
<div class="modal fade" id="editEmailModal" tabindex="-1" aria-labelledby="editEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('patch')
                {{-- DITAMBAHKAN: Input tersembunyi untuk nama agar validasi tidak gagal --}}
                <input type="hidden" name="name" value="{{ $user->name }}">

                <div class="modal-header">
                    <h5 class="modal-title" id="editEmailModalLabel">Ubah Email Anda</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group-modal">
                        <label class="form-label-modal">Email saat ini</label>
                        <input type="email" class="form-control-modal" value="{{ $user->email }}" readonly>
                    </div>
                    <div class="form-group-modal">
                        <label for="email" class="form-label-modal">Email Baru</label>
                        <input type="email" id="email" name="email" class="form-control-modal" placeholder="Ketik email baru" required>
                        {{-- DITAMBAHKAN: Menampilkan pesan error spesifik --}}
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal untuk Ubah Password (Tidak perlu hidden input karena route dan validasinya terpisah) -->
<div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="editPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                @method('put')
                <div class="modal-header">
                    <h5 class="modal-title" id="editPasswordModalLabel">Ubah Kata Sandi</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group-modal">
                        <label for="current_password" class="form-label-modal">Password Saat Ini</label>
                        <input type="password" id="current_password" name="current_password" class="form-control-modal" required>
                         @error('current_password', 'updatePassword')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group-modal">
                        <label for="password" class="form-label-modal">Password Baru</label>
                        <input type="password" id="password" name="password" class="form-control-modal" required>
                         @error('password', 'updatePassword')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group-modal">
                        <label for="password_confirmation" class="form-label-modal">Konfirmasi Password Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control-modal" required>
                    </div>
                </div>
                <div class.modal-footer>
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

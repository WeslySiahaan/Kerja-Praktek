@extends('layouts.app')

@section('styles')
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Poppins', sans-serif;
    }
    .content-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: #000000;
    }
    .info-box {
        background-color: #E9F4FF;
        color: #333;
        padding: 1.25rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
        font-size: 1rem;
        font-weight: bold;
    }
    .profile-fields-container {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .profile-card {
        background-color: #ffffff;
        border: 2px solid #60A5FA;
        border-radius: 0.75rem;
        overflow: hidden;
    }
    .profile-card-header {
        padding: 0.85rem 1.5rem;
        border-bottom: 2px solid #60A5FA;
    }
    .profile-card-header .label {
        font-size: 0.875rem;
        color: #212529;
        font-weight: 600;
    }
    .profile-card-body {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
    }
    .profile-card-body .value {
        font-size: 1rem;
        color: #495057;
        font-weight: 600;
    }
    .profile-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }
    .profile-photo-icon .bi-person {
        font-size: 2.5rem;
        color: #6c757d;
        line-height: 1;
    }
    .btn-edit {
        background-color: #ffffff;
        color: #000000;
        border: 2px solid #60A5FA;
        padding: 0.5rem 1.25rem;
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 500;
        transition: background-color 0.2s, border-color 0.2s, color 0.2s;
    }
    .btn-edit:hover {
        background-color: #3B82F6;
        color: white;
        border-color: #3B82F6;
    }

    input[type="password"]::-ms-reveal,
input[type="password"]::-webkit-reveal {
    display: none;
}

    .modal-header { border-bottom: none; padding: 1.5rem 1.5rem 0.5rem; }
    .modal-title { font-weight: 700; font-size: 1.5rem; }
    .modal-body { padding: 1rem 1.5rem; }
    .modal-footer { border-top: none; padding: 1rem 1.5rem 1.5rem; }
    .form-group-modal { margin-bottom: 1.5rem; }
    .form-label-modal { font-weight: 600; color: #495057; margin-bottom: 0.5rem; display: block; }
    .form-control-modal {
        display: block;
        width: 100%;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.5rem;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        box-sizing: border-box;
    }
    .form-control-modal:read-only { background-color: #e9ecef; }
    .btn-cancel { background-color: #dc3545; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.5rem; cursor: pointer; font-weight: 500; }
    .btn-cancel:hover { background-color: #c82333; }
    .btn-submit { background-color: #007bff; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.5rem; cursor: pointer; font-weight: 500; }
    .btn-submit:hover { background-color: #0056b3; }
    .invalid-feedback { color: #dc3545; font-size: 0.875em; margin-top: 0.25rem; }
    .custom-file-upload { border: 2px dashed #60A5FA; border-radius: 0.5rem; display: block; padding: 2rem 1rem; text-align: center; cursor: pointer; background-color: #f8f9fa; margin-top: 0.5rem; }
    .custom-file-upload:hover { background-color: #f1f3f5; }
    .custom-file-upload .upload-icon { font-size: 2rem; color: #60A5FA; margin-bottom: 0.5rem; }
    .custom-file-upload .upload-text { font-weight: 600; color: #0d6efd; }
    .custom-file-upload .upload-hint { font-size: 0.875rem; color: #6c757d; }
    input[type="file"].original-file-input { display: none; }
    .file-cancel-btn { background-color: #dc3545; color: white; border: none; border-radius: 0.5rem; padding: 0.25rem 0.75rem; font-size: 0.8rem; cursor: pointer; margin-left: 1rem; display: none; }
    .password-wrapper { position: relative; }
    .password-wrapper .toggle-password { position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); cursor: pointer; color: #6c757d; }
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
@endsection

@section('content')
<div class="container py-5">
    <div class="content-header" style="margin-bottom: 1.5rem;">
        <h1>Update Profile</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            Terdapat kesalahan pada input Anda. Silakan periksa kembali form yang Anda isi.
        </div>
    @endif
    @if (session('status'))
        <div class="alert alert-success">
            Data berhasil diperbarui!
        </div>
    @endif

    <div class="info-box">
        Perbaharui informasi Umum akun Anda
    </div>

    <div class="profile-fields-container">
        <div class="profile-card">
            <div class="profile-card-header"><span class="label">Foto Profile</span></div>
            <div class="profile-card-body">
                <div class="value">
                    @if ($user->profile_photo_path)
                        <img src="{{ route('profile.image', ['filename' => basename($user->profile_photo_path)]) }}" alt="Avatar" class="profile-avatar">
                    @else
                        <div class="profile-photo-icon"><i class="bi bi-person"></i></div>
                    @endif
                </div>
                <button type="button" class="btn-edit" data-bs-toggle="modal" data-bs-target="#editPhotoModal">Ubah</button>
            </div>
        </div>
        <div class="profile-card">
            <div class="profile-card-header"><span class="label">Nama</span></div>
            <div class="profile-card-body">
                <span class="value">{{ $user->name }}</span>
                <button type="button" class="btn-edit" data-bs-toggle="modal" data-bs-target="#editNameModal">Ubah</button>
            </div>
        </div>
        <div class="profile-card">
            <div class="profile-card-header"><span class="label">Email</span></div>
            <div class="profile-card-body">
                <span class="value">{{ $user->email }}</span>
                <button type="button" class="btn-edit" data-bs-toggle="modal" data-bs-target="#editEmailModal">Ubah</button>
            </div>
        </div>
        <div class="profile-card">
            <div class="profile-card-header"><span class="label">Kata Sandi</span></div>
            <div class="profile-card-body">
                <span class="value">••••••••••</span>
                <button type="button" class="btn-edit" data-bs-toggle="modal" data-bs-target="#editPasswordModal">Ubah</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editPhotoModal" tabindex="-1" aria-labelledby="editPhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 0.75rem;">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf @method('patch')
                <input type="hidden" name="name" value="{{ $user->name }}">
                <input type="hidden" name="email" value="{{ $user->email }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPhotoModalLabel">Ubah Foto Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group-modal">
                        <label class="form-label-modal">Pilih Gambar Anda</label>
                        <input type="file" name="profile_photo" id="profile_photo" class="original-file-input @error('profile_photo') is-invalid @enderror">
                        <label for="profile_photo" class="custom-file-upload">
                            <div class="upload-icon"><i class="bi bi-cloud-arrow-up-fill"></i></div>
                            <div>
                                <span class="upload-text" id="file-chosen-text">Pilih file</span>
                                <button type="button" class="file-cancel-btn" id="cancel-file-btn">Batal</button>
                            </div>
                            <div class="upload-hint" id="upload-hint-text">atau seret & jatuhkan file di sini</div>
                        </label>
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

{{-- DIUBAH: Modal Nama disederhanakan, tanpa konfirmasi --}}
<div class="modal fade" id="editNameModal" tabindex="-1" aria-labelledby="editNameModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 0.75rem;">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf @method('patch')
                <input type="hidden" name="email" value="{{ $user->email }}">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="editNameModalLabel">Ubah Nama Anda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                     <div class="form-group-modal">
                         <label class="form-label-modal">Nama saat ini</label>
                         <input type="text" class="form-control-modal" value="{{ $user->name }}" readonly>
                     </div>
                     <div class="form-group-modal">
                         <label for="name" class="form-label-modal">Nama Baru</label>
                         <input type="text" id="name" name="name" class="form-control-modal @error('name', 'updateProfileInformation') is-invalid @enderror" required>
                         @error('name', 'updateProfileInformation')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                     </div>
                     {{-- Kolom konfirmasi nama dihapus --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- DIUBAH: Modal Email disederhanakan, tanpa konfirmasi --}}
<div class="modal fade" id="editEmailModal" tabindex="-1" aria-labelledby="editEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 0.75rem;">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf @method('patch')
                <input type="hidden" name="name" value="{{ $user->name }}">

                <div class="modal-header">
                    <h5 class="modal-title" id="editEmailModalLabel">Ubah Email Anda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                     <div class="form-group-modal">
                         <label class="form-label-modal">Email saat ini</label>
                         <input type="email" class="form-control-modal" value="{{ $user->email }}" readonly>
                     </div>
                     <div class="form-group-modal">
                         <label for="email" class="form-label-modal">Email Baru</label>
                         <input type="email" id="email" name="email" class="form-control-modal @error('email', 'updateProfileInformation') is-invalid @enderror" required>
                         @error('email', 'updateProfileInformation')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                     </div>
                     {{-- Kolom konfirmasi email dihapus --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Password tidak berubah, strukturnya sudah benar dan aman --}}
<div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="editPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 0.75rem;">
            <form action="{{ route('password.update') }}" method="POST" id="form-edit-password">
                @csrf
                @method('put')
                <div class="modal-header">
                    <h5 class="modal-title" id="editPasswordModalLabel">Ubah Kata Sandi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- DIHAPUS: Kolom "Password Saat Ini" dihapus dari sini --}}

                    <div class="form-group-modal">
                        <label for="password" class="form-label-modal">Password Baru</label>
                         <div class="password-wrapper">
                            <input type="password" id="password" name="password" class="form-control-modal @error('password', 'updatePassword') is-invalid @enderror" required>
                            <i class="bi bi-eye-slash toggle-password"></i>
                        </div>
                         @error('password', 'updatePassword')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group-modal">
                        <label for="password_confirmation" class="form-label-modal">Konfirmasi Password Baru</label>
                         <div class="password-wrapper">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control-modal" required>
                            <i class="bi bi-eye-slash toggle-password"></i>
                        </div>
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
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Skrip untuk lihat/sembunyikan password ---
        const togglePasswordIcons = document.querySelectorAll('.toggle-password');
        togglePasswordIcons.forEach(icon => {
            icon.addEventListener('click', function () {
                const passwordField = this.previousElementSibling;
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                this.classList.toggle('bi-eye');
                this.classList.toggle('bi-eye-slash');
            });
        });

        // --- Skrip untuk validasi konfirmasi ---
        function addConfirmationValidation(formId, fieldName, fieldLabel) {
            const form = document.getElementById(formId);
            if (form) {
                form.addEventListener('submit', function(event) {
                    const newField = form.querySelector(`[name="${fieldName}"]`);
                    const confirmationField = form.querySelector(`[name="${fieldName}_confirmation"]`);
                    
                    if (newField && confirmationField && newField.value !== confirmationField.value) {
                        event.preventDefault(); // Hentikan pengiriman form
                        alert(`Error: Konfirmasi ${fieldLabel} tidak cocok!`);
                        confirmationField.focus();
                    }
                });
            }
        }

        // DIUBAH: Validasi untuk nama dan email dihapus dari frontend
        addConfirmationValidation('form-edit-password', 'password', 'Password Baru');
    });
</script>
@endsection
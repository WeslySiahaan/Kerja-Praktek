@extends('layouts.app1')

@section('styles')
<style>
    /* Penyesuaian untuk Judul Halaman dan Tombol Edit */
    .page-title {
        font-size: 28px;
        font-weight: 600;
        color: #fff;
        margin: 0;
        padding-right: 120px; /* Nilai ini bisa disesuaikan lebih lanjut */
        flex-grow: 1;
        flex-shrink: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .edit-buttons {
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        gap: 10px;
        align-items: center;
        z-index: 10;
        height: 100%;
        align-items: center;
    }
    .edit-buttons button {
        background: none;
        border: none;
        color: #DBB941;
        font-size: 18px;
        cursor: pointer;
        transition: color 0.3s ease;
        padding: 5px 10px;
    }
    .edit-buttons button:hover {
        color: #c9a732;
    }

    .edit-buttons .delete-selected-btn,
    .edit-buttons .cancel-edit-btn {
        background: none;
        border: none;
        color: #fff;
        font-size: 16px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
        transition: color 0.3s ease, background-color 0.3s ease;
        padding: 8px 12px;
        border-radius: 5px;
    }
    .edit-buttons .delete-selected-btn:hover,
    .edit-buttons .cancel-edit-btn:hover {
        color: #DBB941;
    }

    .movie-grid {
        display: grid;
        grid-template-columns: repeat(4, 233px);
        gap: 20px;
        padding: 0 20px 40px;
        max-width: 972px;
        margin: 0 auto;
        justify-content: center;
    }

    .movie-card {
        background-color: #1a1a1a;
        border-radius: 5px;
        overflow: hidden;
        text-align: center;
        position: relative;
        width: 233px;
        height: 377px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.2s ease-in-out;
    }
    .movie-card:hover {
        transform: translateY(-5px);
    }

    .movie-poster {
        width: 211.91px;
        height: 305px;
        object-fit: cover;
        margin: 10px auto 0;
        display: block;
        border-radius: 5px;
    }
    .movie-info {
        padding: 5px;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        height: calc(377px - 305px - 10px);
        min-height: 50px;
    }
    .movie-title {
        font-size: 14px;
        font-weight: 600;
        color: #fff;
        margin: 5px 0 2px 0;
        padding: 0 5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.2;
    }
    .movie-episode {
        font-size: 12px;
        color: #ccc;
        margin: 0 0 5px 0;
        padding: 0 5px;
        line-height: 1.2;
    }

    .movie-select {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 24px;
        height: 24px;
        border: 2px solid #fff;
        border-radius: 50%;
        background-color: rgba(0,0,0,0.5);
        cursor: pointer;
        display: none;
        z-index: 2;
        transition: background-color 0.2s ease, border-color 0.2s ease;
    }
    .movie-card.edit-mode .movie-select { display: block; }
    .movie-card.edit-mode .movie-select.active {
        background-color: #DBB941;
        border-color: #DBB941;
    }

    /* --- GAYA MODAL YANG LEBIH MENARIK --- */
    .modal-backdrop.fade.show {
        backdrop-filter: blur(5px); /* Efek blur pada background di belakang modal */
        -webkit-backdrop-filter: blur(5px); /* Untuk kompatibilitas Safari */
        background-color: rgba(0, 0, 0, 0.6); /* Sedikit lebih gelap */
    }

    .modal-dialog {
        animation-duration: 0.4s; /* Durasi animasi masuk/keluar modal */
    }

    /* Animasi Scale-in untuk modal */
    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.7) translateY(-50px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }
    /* Animasi Scale-out untuk modal */
    @keyframes scaleOut {
        from {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
        to {
            opacity: 0;
            transform: scale(0.7) translateY(-50px);
        }
    }

    .modal.fade .modal-dialog {
        animation-name: scaleOut; /* Animasi saat modal keluar */
        animation-fill-mode: forwards; /* Pertahankan gaya terakhir dari animasi */
    }
    .modal.fade.show .modal-dialog {
        animation-name: scaleIn; /* Animasi saat modal masuk */
    }

    /* Gaya konten modal */
    .modal-content.custom-modal {
        background: linear-gradient(145deg, #2a2a2a, #1a1a1a); /* Gradasi background */
        border: 1px solid #444;
        border-radius: 15px; /* Sudut lebih membulat */
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4); /* Bayangan lebih kuat */
        animation-duration: 0.4s; /* Sama dengan modal-dialog */
    }

    .modal-header.custom-header {
        border-bottom: none; /* Hilangkan border default header */
        padding: 1.5rem 2rem 0.5rem 2rem;
        position: relative;
    }
    .modal-header.custom-header .modal-title {
        color: #DBB941; /* Warna judul modal kuning */
        font-weight: bold;
        font-size: 1.8rem;
        text-align: center;
        width: 100%; /* Pusatkan judul */
    }
    .modal-header.custom-header .btn-close {
        color: #fff; /* Pastikan tombol close terlihat */
        font-size: 1.2rem;
        opacity: 0.8;
        transition: opacity 0.2s ease;
        position: absolute;
        right: 15px;
        top: 15px;
        /* Untuk memastikan ikon X putih pada background gelap */
        background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
        border: 0;
        border-radius: 0.375rem;
        padding: 0.5rem;
    }
    .modal-header.custom-header .btn-close:hover {
        opacity: 1;
    }

    .modal-body.custom-body {
        padding: 1rem 2rem 1.5rem 2rem;
        color: #e0e0e0;
        text-align: center;
        font-size: 1.1em;
        line-height: 1.5;
    }

    .modal-footer.custom-footer {
        border-top: none; /* Hilangkan border default footer */
        padding: 0.5rem 2rem 1.5rem 2rem;
        justify-content: center; /* Pusatkan tombol */
        gap: 15px; /* Jarak antar tombol */
    }
    .modal-footer.custom-footer .btn {
        min-width: 100px; /* Tombol lebih lebar */
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 8px; /* Sudut lebih membulat */
        transition: all 0.3s ease;
    }
    .modal-footer.custom-footer .btn-secondary {
        background-color: #444;
        border-color: #444;
        color: #fff;
    }
    .modal-footer.custom-footer .btn-secondary:hover {
        background-color: #555;
        border-color: #555;
    }
    .modal-footer.custom-footer .btn-danger {
        background-color: #dc3545; /* Merah standar Bootstrap */
        border-color: #dc3545;
        color: #fff;
    }
    .modal-footer.custom-footer .btn-danger:hover {
        background-color: #c82333; /* Merah lebih gelap */
        border-color: #bd2130;
    }
    .modal-footer.custom-footer .btn-primary { /* Untuk tombol OK di modal peringatan */
        background-color: #DBB941;
        border-color: #DBB941;
        color: #1a1a1a; /* Teks gelap pada tombol kuning */
    }
    .modal-footer.custom-footer .btn-primary:hover {
        background-color: #c9a732;
        border-color: #c9a732;
    }


    /* Media Queries for Responsiveness */
    @media (max-width: 992px) {
        .movie-grid {
            grid-template-columns: repeat(3, 233px);
            max-width: 729px;
        }
        .page-title {
            padding-right: 80px;
        }
    }
    @media (max-width: 768px) {
        .movie-grid {
            grid-template-columns: repeat(2, 233px);
            max-width: 486px;
        }
        .page-title {
            padding-right: 70px;
            font-size: 26px;
        }
        .edit-buttons {
            right: 10px;
        }
        .modal-dialog {
            margin: 1.75rem auto; /* Sedikit margin untuk modal di mobile */
            max-width: 90%;
        }
        .modal-header.custom-header,
        .modal-body.custom-body,
        .modal-footer.custom-footer {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
    @media (max-width: 500px) {
        .movie-grid {
            grid-template-columns: repeat(1, 233px);
            max-width: 233px;
        }
        .page-title {
            font-size: 22px;
            padding-right: 60px;
        }
        .edit-buttons {
            right: 5px;
        }
        .modal-footer.custom-footer .btn {
            min-width: unset; /* Hapus min-width agar tombol bisa menyesuaikan konten */
            width: 48%; /* Bagi dua lebar untuk tombol */
        }
    }
</style>
@endsection

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4" style="max-width: 972px; margin: 2rem auto 1rem; position: relative;">
        <h1 class="page-title m-0">DAFTAR KOLEKSI</h1>

        <div class="edit-buttons">
            <button class="edit-title-btn"><i class="bi bi-pencil"></i> EDIT</button>
        </div>
    </div>

    <div class="movie-grid">
        @php
            $judulFilm = [
                'Blackout', 'Chronos', 'Chucotean', 'Operasi Fajar Merah',
                'Final Shot', 'Comedy', 'Flash Marriage', 'Venom',
                'Kengauu Merantau', 'Renegade', 'The Commando', 'Hantu Juara',
                'The Blackwood', 'Broken Homes', 'Kisah Pilu Kejamnya Hidup', 'The Holy Joy King',
                'The Silent Whisper', 'Echoes of Yesterday', 'Crimson Skies', 'Moonlit Shadows',
                'The Lost Letter', 'Whispers in Time', 'Starlight Dreams', 'The Forgotten Truth',
                'Midnight Melody', 'Fragments of Us', 'Beneath the Surface', 'A Song for Her'
            ];
            shuffle($judulFilm);
        @endphp
        @foreach ($judulFilm as $judul)
            <div class="movie-card">
                <span class="movie-select"></span>
                <img class="movie-poster" src="{{ asset('Drama__box.png') }}" alt="Poster {{ $judul }}">
                <div class="movie-info">
                    <div class="movie-title">{{ $judul }}</div>
                    <div class="movie-episode">Ep {{ rand(1,10) }} / Ep 20</div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- MODAL KONFIRMASI HAPUS (dengan kelas kustom) --}}
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header custom-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> {{-- Hilangkan btn-close-white di sini --}}
                </div>
                <div class="modal-body custom-body">
                    Apakah Anda yakin ingin menghapus <span id="selectedCount" style="color: #DBB941; font-weight: bold;">0</span> film yang dipilih?
                </div>
                <div class="modal-footer custom-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL PERINGATAN (dengan kelas kustom) --}}
    <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header custom-header">
                    <h5 class="modal-title" id="warningModalLabel">Peringatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> {{-- Hilangkan btn-close-white di sini --}}
                </div>
                <div class="modal-body custom-body">
                    Pilih film yang ingin dihapus terlebih dahulu.
                </div>
                <div class="modal-footer custom-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const editBtn = document.querySelector('.edit-title-btn');
        const editButtonsContainer = document.querySelector('.edit-buttons');
        let isEditing = false;

        const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
        const warningModal = new bootstrap.Modal(document.getElementById('warningModal'));
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const selectedCountSpan = document.getElementById('selectedCount');

        function activateEditMode() {
            isEditing = true;
            document.querySelectorAll('.movie-card').forEach(card => card.classList.add('edit-mode'));
            editButtonsContainer.innerHTML = `
                <button class="delete-selected-btn"><i class="bi bi-trash"></i> HAPUS</button>
                <button class="cancel-edit-btn"><i class="bi bi-x-circle"></i> BATAL</button>
            `;
            attachActionListeners();
        }

        function deactivateEditMode() {
            isEditing = false;
            document.querySelectorAll('.movie-card').forEach(card => {
                card.classList.remove('edit-mode');
                const circle = card.querySelector('.movie-select');
                if (circle) circle.classList.remove('active');
            });
            editButtonsContainer.innerHTML = `<button class="edit-title-btn"><i class="bi bi-pencil"></i> EDIT</button>`;
            const newEditBtn = document.querySelector('.edit-title-btn');
            if (newEditBtn) {
                newEditBtn.addEventListener('click', activateEditMode);
            }
        }

        function attachActionListeners() {
            const cancelBtn = document.querySelector('.cancel-edit-btn');
            if (cancelBtn) {
                cancelBtn.addEventListener('click', deactivateEditMode);
            }

            const deleteBtn = document.querySelector('.delete-selected-btn');
            if (deleteBtn) {
                deleteBtn.addEventListener('click', () => {
                    const selected = document.querySelectorAll('.movie-select.active');
                    if (selected.length === 0) {
                        warningModal.show();
                        return;
                    }

                    selectedCountSpan.textContent = selected.length;
                    deleteConfirmationModal.show();
                });
            }

            if (confirmDeleteBtn) {
                confirmDeleteBtn.removeEventListener('click', handleConfirmDelete);
                confirmDeleteBtn.addEventListener('click', handleConfirmDelete);
            }
        }

        function handleConfirmDelete() {
            const selected = document.querySelectorAll('.movie-select.active');
            selected.forEach(el => {
                const card = el.closest('.movie-card');
                if (card) {
                    card.classList.add('fade-out');
                    card.addEventListener('transitionend', () => {
                        card.remove();
                    }, { once: true });
                }
            });
            deleteConfirmationModal.hide();
            deactivateEditMode();
        }

        if(editBtn) {
            editBtn.addEventListener('click', activateEditMode);
        }

        const movieGrid = document.querySelector('.movie-grid');
        if (movieGrid) {
            movieGrid.addEventListener('click', e => {
                if (isEditing && e.target.classList.contains('movie-select')) {
                    e.target.classList.toggle('active');
                }
            });
        }
    });
</script>
@endsection
@extends('layouts.app')

@section('content')
  <div class="container py-4">
    <h2 class="fw-semibold fs-4 text-dark mb-4">
      {{ __('Profile') }}
    </h2>

    <div class="row gy-4">

      {{-- Form Update Informasi Profil --}}
      <div class="col-12 col-md-10 col-lg-8 bg-white shadow-sm rounded p-4">
        <h3 class="fs-5 fw-bold text-dark mb-3">
        </h3>
        @include('profile.partials.update-profile-information-form')
      </div>

      {{-- Form Update Password --}}
      <div class="col-12 col-md-10 col-lg-8 bg-white shadow-sm rounded p-4">
        <h3 class="fs-5 fw-bold text-dark mb-3">
        </h3>
        @include('profile.partials.update-password-form')
      </div>

      {{-- Form Hapus Akun --}}
      <div class="col-12 col-md-10 col-lg-8 bg-white shadow-sm rounded p-4 border border-danger">
        <h3 class="fs-5 fw-bold text-danger mb-3">
          {{ __('Hapus Akun') }}
        </h3>
        @include('profile.partials.delete-user-form')
      </div>

    </div>
  </div>
@endsection
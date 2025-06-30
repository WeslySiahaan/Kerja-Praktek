@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <h1 class="mb-4">Persetujuan Pengguna</h1>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
  @endif

  <form action="{{ route('user_agreements.update', $agreement->id) }}" method="POST" class="mb-4 p-4 bg-light rounded">
    @csrf
    @method('PUT')

    <div class="row">
      <div class="col-12">
        <div class="form-group">
          <label for="ketentuan_umum">1. Ketentuan Umum</label>
          <textarea name="ketentuan_umum" class="form-control" id="ketentuan_umum" rows="5" style="min-height: 150px;">{{ old('ketentuan_umum', $agreement->ketentuan_umum) }}</textarea>
          @error('ketentuan_umum')
            <div class="text-danger mt-1">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <div class="col-12">
        <div class="form-group">
          <label for="hak_kekayaan_intelektual">2. Hak Kekayaan Intelektual</label>
          <textarea name="hak_kekayaan_intelektual" class="form-control" id="hak_kekayaan_intelektual" rows="5" style="min-height: 150px;">{{ old('hak_kekayaan_intelektual', $agreement->hak_kekayaan_intelektual) }}</textarea>
          @error('hak_kekayaan_intelektual')
            <div class="text-danger mt-1">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <div class="col-12">
        <div class="form-group">
          <label for="akun_pengguna">3. Akun Pengguna</label>
          <textarea name="akun_pengguna" class="form-control" id="akun_pengguna" rows="5" style="min-height: 150px;">{{ old('akun_pengguna', $agreement->akun_pengguna) }}</textarea>
          @error('akun_pengguna')
            <div class="text-danger mt-1">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <div class="col-12">
        <div class="form-group">
          <label for="pembatasan_tanggung_jawab">4. Pembatasan Tanggung Jawab</label>
          <textarea name="pembatasan_tanggung_jawab" class="form-control" id="pembatasan_tanggung_jawab" rows="5" style="min-height: 150px;">{{ old('pembatasan_tanggung_jawab', $agreement->pembatasan_tanggung_jawab) }}</textarea>
          @error('pembatasan_tanggung_jawab')
            <div class="text-danger mt-1">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <div class="col-12">
        <div class="form-group">
          <label for="penghentian_layanan">5. Penghentian Layanan</label>
          <textarea name="penghentian_layanan" class="form-control" id="penghentian_layanan" rows="5" style="min-height: 150px;">{{ old('penghentian_layanan', $agreement->penghentian_layanan) }}</textarea>
          @error('penghentian_layanan')
            <div class="text-danger mt-1">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <div class="col-12">
        <div class="form-group">
          <label for="kontak">6. Kontak</label>
          <textarea name="kontak" class="form-control" id="kontak" rows="5" style="min-height: 150px;">{{ old('kontak', $agreement->kontak) }}</textarea>
          @error('kontak')
            <div class="text-danger mt-1">{{ $message }}</div>
          @enderror
        </div>
      </div>
    </div>

    <div>
      <button type="submit" class="btn btn-primary">Update Persetujuan</button>
    </div>
  </form>
</div>
@endsection


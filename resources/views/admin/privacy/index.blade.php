@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <h1 class="mb-4">Privacy Policy</h1>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif

  <form action="{{ route('privacy_policies.update', $policy->id) }}" method="POST" class="mb-4 p-4 bg-light rounded">
  @csrf
  @method('PUT')

  <div class="row">
    <div class="col-12">
      <div class="form-group">
        <label for="history">1. Informasi yang Kami Kumpulkan</label>
        <textarea name="history" class="form-control" id="history" rows="5" style="min-height: 150px;">{{ old('history', $policy->history) }}</textarea>
        @error('history')
          <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
      </div>
    </div>

    <div class="col-12">
      <div class="form-group">
        <label for="usage">2. Penggunaan Informasi</label>
        <textarea name="usage" class="form-control" id="usage" rows="5" style="min-height: 150px;">{{ old('usage', $policy->usage) }}</textarea>
        @error('usage')
          <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
      </div>
    </div>

    <div class="col-12">
      <div class="form-group">
        <label for="security">3. Penyimpanan dan Keamanan Data</label>
        <textarea name="security" class="form-control" id="security" rows="5" style="min-height: 150px;">{{ old('security', $policy->security) }}</textarea>
        @error('security')
          <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
      </div>
    </div>

    <div class="col-12">
      <div class="form-group">
        <label for="rights">4. Hak Anda</label>
        <textarea name="rights" class="form-control" id="rights" rows="5" style="min-height: 150px;">{{ old('rights', $policy->rights) }}</textarea>
        @error('rights')
          <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
      </div>
    </div>

    <div class="col-12">
      <div class="form-group">
        <label for="cookies">5. Penggunaan Cookie</label>
        <textarea name="cookies" class="form-control" id="cookies" rows="5" style="min-height: 150px;">{{ old('cookies', $policy->cookies) }}</textarea>
        @error('cookies')
          <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
      </div>
    </div>

    <div class="col-12">
      <div class="form-group">
        <label for="changes">6. Perubahan Kebijakan</label>
        <textarea name="changes" class="form-control" id="changes" rows="5" style="min-height: 150px;">{{ old('changes', $policy->changes) }}</textarea>
        @error('changes')
          <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
      </div>
    </div>
  </div>

  <div>
  <button type="submit" class="btn btn-primary">Update Policy</button>
  </div>

</form>


</div>
@endsection

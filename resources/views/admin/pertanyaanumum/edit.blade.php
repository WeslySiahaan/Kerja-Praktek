@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <h1 class="mb-4">Pertanyaan Umum</h1>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <form action="{{ route('faq.updateAll') }}" method="POST" class="bg-light p-4 rounded shadow-sm">
    @csrf
    @method('PUT')

    @foreach ($faqs as $index => $faq)
      <div class="mb-4">
        <label class="form-label"><strong>{{ $index + 1 }}. {{ $faq->pertanyaan }}</strong></label>
        <textarea name="faq[{{ $faq->id }}]" class="form-control" rows="3" required>{{ old("faq.$faq->id", $faq->jawaban) }}</textarea>
      </div>
    @endforeach

    <button type="submit" class="btn btn-primary">Update</button>
  </form>
</div>
@endsection

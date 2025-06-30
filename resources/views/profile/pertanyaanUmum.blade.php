@extends('layouts.app')

@section('styles')
<style>
  .faq-section {
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
  }

  .faq-title {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 10px;
  }

  .faq-item {
    border-top: 1px solid #eee;
    padding: 10px 0;
  }

  .faq-question {
    font-weight: bold;
    cursor: pointer;
    color: #007bff;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .faq-answer {
    display: none;
    margin-top: 8px;
    color: #555;
  }

  .faq-item.open .faq-answer {
    display: block;
  }
</style>
@endsection

@section('content')
<div class="container mt-4">
  <h1 class="mb-4 fw-bold">Pertanyaan Umum</h1>

  @forelse ($faqs as $kategori => $faqList)
  <div class="faq-section">
    <div class="faq-title">{{ $kategori }}</div>
    @foreach ($faqList as $faq)
    <div class="faq-item">
      <div class="faq-question">
        {{ $faq->pertanyaan }}
        <span>+</span>
      </div>
      <div class="faq-answer">{!! $faq->jawaban !!}</div>
    </div>
    @endforeach
  </div>
  @empty
  <p>Tidak ada pertanyaan umum tersedia.</p>
  @endforelse
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const items = document.querySelectorAll('.faq-question');
    items.forEach(q => {
      q.addEventListener('click', () => {
        q.parentElement.classList.toggle('open');
      });
    });
  });
</script>
@endpush
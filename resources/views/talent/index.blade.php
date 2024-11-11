@extends('layouts.app')

@section('title', 'TALENT - COSPLATFORM')

@section('content')
<main>
    <section class="subpage-hero">
        <h1>TALENT</h1>
    </section>
    <div class="container">
        <div class="container-box">
            <section class="talent-page">
                <div class="talent-grid">
                    @foreach($talentImg as $talent)
                        <div class="talent-item">
                            <form action="{{ route('talent.show') }}" method="POST">
                                <input type="hidden" name="id" value="{{ $talent->TALENT_ID }}">
                                @csrf
                                <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;">
                                    <img style="background: linear-gradient(to right, #ffd1dc, #e6e6fa); padding:10px;"
                                        src="{{ asset($talent->FILE_PATH1 . $talent->FILE_NAME1) }}"
                                        data-hover="{{ asset($talent->FILE_PATH2 . $talent->FILE_NAME2) }}"
                                        alt="{{ $talent->ALT1 }}">
                                </button>
                            </form>
                            <h2>{{ $talent->LAYER_NAME }}</h2>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</main>
@endsection

@push('styles')
<style>
    body {
        background-image: url("{{ asset($backImg->FILE_PATH . $backImg->FILE_NAME) }}");
    }
    .subpage-hero {
        background-image: url("{{ asset($topImg->FILE_PATH . $topImg->FILE_NAME) }}");
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('.talent-item img');
        images.forEach(img => {
            const originalSrc = img.src;
            const hoverSrc = img.dataset.hover;
            img.addEventListener('mouseover', function() {
                this.src = hoverSrc;
            });
            img.addEventListener('mouseout', function() {
                this.src = originalSrc;
            });
        });
    });
</script>
@endpush
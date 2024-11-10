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
                            <a href="{{ route('talent.show', $talent->TALENT_ID) }}">
                                <img style="background: linear-gradient(to right, #ffd1dc, #e6e6fa); padding:10px;"
                                    src="{{ $talent->FILE_PATH1 . $talent->FILE_NAME1 }}"
                                    data-hover="{{ $talent->FILE_NAME2 . $talent->FILE_NAME2 }}"
                                    alt="{{ $talent->LAYER_NAME }}">
                            </a>
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
        background-image: url("{{ $backImg->FILE_PATH . $backImg->FILE_NAME }}");
    }
    .subpage-hero {
        background-image: url("{{ $topImg->FILE_PATH . $topImg->FILE_NAME }}");
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const talentItems = document.querySelectorAll('.talent-item img');
        talentItems.forEach(item => {
            const originalSrc = item.src;
            const hoverSrc = item.dataset.hover;
            item.addEventListener('mouseover', () => item.src = hoverSrc);
            item.addEventListener('mouseout', () => item.src = originalSrc);
        });
    });
</script>
@endpush
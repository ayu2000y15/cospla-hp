@extends('layouts.app')

@section('title', 'ホーム - COSPLATFORM')

@section('content')
<main>
    <div id="back">
        <section class="hero">
            <div class="slideshow-container">
                @foreach($slides as $slide)
                    <div class="slide fade">
                        <div class="slide-image-container">
                            <img src="{{ $slide->FILE_PATH . $slide->FILE_NAME }}" alt="{{ $slide->ALT }}">
                        </div>
                    </div>
                @endforeach
                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
            </div>
            <div class="dot-container">
                @for($i = 0; $i < $slidesCnt; $i++)
                    <span class="dot" onclick="currentSlide({{ $i + 1 }})"></span>
                @endfor
            </div>
        </section>

        <section class="connect-image">
            @foreach($topImg as $img)
                <img src="{{ $img->FILE_PATH . $img->FILE_NAME }}" alt="{{ $img->ALT }}" class="full-width-image">
            @endforeach
        </section>

        <section id="talent" class="container-box talent">
            <h2>TALENT</h2>
            <div class="section-content">
                <div class="talent-list">
                    <div class="talent-grid-main">
                        @foreach($talent as $t)
                            <div class="talent-item-main">
                                <img style="background: linear-gradient(180deg, rgba(255, 255, 255, 1), rgba(216, 236, 255, 1) 100%, rgba(149, 233, 243, 1)); border-radius: 10px; padding:10px;" src="{{ $t->FILE_PATH . $t->FILE_NAME }}" alt="タレント {{ $t->ALT }}">
                                <p>{{ $t->LAYER_NAME }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="see-more">
                    <a href="{{ route('talent') }}" class="arrow-button" aria-label="タレント一覧をもっと見る">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    </div>
    <div id="top" class="container">
        <h2>COSPLAY</h2>
        <section id="cosplay" class="container-box cosplay">
            <div class="section-content">
                <div class="cosplay-list">
                    <div class="cosplay-grid">
                        @foreach($cosplay as $c)
                            <img src="{{ $c->FILE_PATH . $c->FILE_NAME }}" alt="コスプレ {{ $c->ALT }}">
                        @endforeach
                    </div>
                    <p>コスプレイベントの様子や、撮影会の写真などがご覧いただけます。</p>
                </div>
                <div class="see-more">
                    <a href="{{ route('cosplay') }}" class="arrow-button" aria-label="コスプレ一覧をもっと見る">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <h2>NEWS</h2>
        <section id="news" class="container-box news">
            <div class="section-content">
                <div class="news-list">
                    @foreach($newsTitle as $item)
                        <a href="{{ route('news.show', $item->NEWS_ID) }}">
                            <div class="news-item">
                                <div class="news-content">
                                    <p class="date">{{ $item->POST_DATE }}</p>
                                    <p class="title">{{ $item->TITLE }}</p>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</main>
@endsection

@push('styles')
<style>
    body {
        background-image: url("{{ $backImg->FILE_PATH . $backImg->FILE_NAME }}");
    }

</style>
@endpush
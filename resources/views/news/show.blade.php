@extends('layouts.app')

@section('title', 'NEWS - コスプラットフォーム株式会社')

@section('content')
<main>
    <section class="subpage-hero">
        <h1>NEWS</h1>
    </section>
    <div class="container">
        <div class="container-box news-page">
            <div class="news-page-header">
                <h2>{{ $newsItem->TITLE }}</h2>
                <div class="news-page-date">
                    <p>{{ $newsItem->POST_DATE }}</p>
                </div>
            </div>
            <hr class="hr-line">
            <p>{!! nl2br(e($newsItem->CONTENT)) !!}</p>
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

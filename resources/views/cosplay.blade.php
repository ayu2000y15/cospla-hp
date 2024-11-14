@extends('layouts.app')

@section('title', 'COSPLAY - COSPLATFORM')

@section('content')
<main>
    <section class="subpage-hero">
        <h1>COSPLAY</h1>
    </section>
    <div class="container">
        <div class="container-box">
            <section class="cosplay-page">
                <div class="cosplay-content">
                    <h2>オーダーメイド衣装製作</h2>
                    <div class="cosplay-content-box">
                        <p>コスプレやアイドルの衣装、カフェの制服などオーダーメイドでの衣装製作を承っております。</p>
                        <a href="{{ route('contact') }}">制作のご相談はこちら</a>
                    </div>
                </div>
                <div class="cosplay-grid">
                    @foreach($cosplayImg1 as $img)
                        <div class="cosplay-item">
                            <img src="{{ $img->FILE_PATH . $img->FILE_NAME }}" alt="{{ $img->ALT }}">
                        </div>
                    @endforeach
                </div>

                <hr class="hr-line">
                <div class="cosplay-content2">
                    <h2>コスプレ衣装の販売・レンタル、買取</h2>
                    <div class="cosplay-content-box2">
                        <p>弊社で製作したコスプレ衣装の販売・レンタル、買取を行っております。</p>
                    </div>
                </div>
                <div class="cosplay-grid">
                    @foreach($cosplayImg2 as $img)
                        <div class="cosplay-item">
                            <img src="{{ $img->FILE_PATH . $img->FILE_NAME }}" alt="{{ $img->ALT }}">
                        </div>
                    @endforeach
                </div>
                <hr class="hr-line">
                <img src="{{ asset('storage/img/hp/logo1.png') }}" alt="ロゴ" style="width:200px; height:200px; margin-left:4rem;">
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
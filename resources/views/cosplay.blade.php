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
                    <h2>コスプレ衣装の販売・買取・レンタル</h2>
                    <div class="cosplay-content-box">
                        <p>弊社で製作しましたコスプレ衣装の販売・買取・レンタルを行っております。</p>
                        <p>あああああああああああああああああああああああああああ</p>
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
                    <h2>コスプレ・衣装の制作</h2>
                    <div class="cosplay-content-box2">
                        <p>コスプレやアイドルの衣装やカフェなどのコスチューム制作</p>
                        <p>あああああああああああああああああああああああああああ</p>
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
                <img src="{{ asset('img/hp/logo1.png') }}" alt="ロゴ" style="width:200px; height:200px; margin-left:4rem;">
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
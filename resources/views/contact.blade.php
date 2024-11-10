@extends('layouts.app')

@section('title', 'CONTACT - COSPLATFORM')

@section('content')
<main>
    <section class="subpage-hero">
        <h1>CONTACT</h1>
    </section>
    <div class="container">
        <div class="container-box contact">
            <h2>お問い合わせフォーム</h2>
            <form class="contact-form" action="{{ route('contact.submit') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="question-title">問い合わせ項目<span class="required"></span></label>
                    <div class="radio-options">
                        <div class="radio-option">
                            <input type="radio" id="question" value="問い合わせ" name="inquiry_type" checked />
                            <label for="question">問い合わせ</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="apply" value="タレント応募" name="inquiry_type" />
                            <label for="apply">タレント応募</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">氏名<span class="required">必須</span></label>
                    <input type="text" id="name" name="name" placeholder="山田太郎" required />
                </div>
                <div class="form-group">
                    <label for="email">メールアドレス<span class="required">必須</span></label>
                    <input type="email" id="email" name="email" placeholder="example@gmail.com" required />
                </div>
                <div class="form-group">
                    <label for="tel">電話番号<span class="required"></span></label>
                    <input type="tel" id="tel" pattern="[0-9]{3}-[0-9]{4}-[0-9]{4}" name="tel" placeholder="080-1234-5678" />
                </div>
                <div class="form-group">
                    <label for="subject">件名<span class="required">必須</span></label>
                    <input type="text" id="subject" name="subject" placeholder="例、衣装制作について" required />
                </div>
                <div class="form-group">
                    <label for="content">質問内容 または 自己PR等<span class="required">必須</span></label>
                    <textarea id="content" name="content" rows="5" placeholder="問い合わせ内容をここに記載してください" required></textarea>
                </div>
                <button type="submit" class="submit-button">送信する</button>
            </form>
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
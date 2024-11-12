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
            @if (session('message'))
            <div class="success-message">{{ session('message') }}</div>
            @endif

            <iframe name="hidden_iframe" id="hidden_iframe" style="display:none;"
                onload="if(submitted) {window.location='{{ route('contact.ok') }}'}"></iframe>
            <form class="contact-form"
                action="https://docs.google.com/forms/u/0/d/e/1FAIpQLSflqYHJxkyXDqxy0Z4fUTN6LXL44nxYm1-cWQKOmOsRYv4-xw/formResponse"
                method="POST" target="hidden_iframe" onsubmit="checkSubmit(); submitted=true;">
                @csrf
                <div class="form-group">
                    <label for="question-title">問い合わせ項目<span class="required"></span></label>
                    <div class="radio-options">
                        <div class="radio-option">
                            <input type="radio" id="question" value="問い合わせ" name="entry.634067999" checked />
                            <label for="question">問い合わせ</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="apply" value="タレント応募" name="entry.634067999" />
                            <label for="apply">タレント応募</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">氏名<span class="required">必須</span></label>
                    <input type="text" id="name" name="entry.783831543" placeholder="山田太郎" required />
                </div>
                <div class="form-group">
                    <label for="email">メールアドレス<span class="required">必須</span></label>
                    <input type="email" id="email" name="entry.2031892057" placeholder="example@gmail.com" required />
                </div>
                <div class="form-group">
                    <label for="tel">電話番号<span class="required"></span></label>
                    <input type="tel" id="tel" pattern="[0-9]{3}-[0-9]{4}-[0-9]{4}" name="entry.2108915669"
                        placeholder="080-1234-5678" />
                </div>
                <div class="form-group">
                    <label for="subject">件名<span class="required">必須</span></label>
                    <input type="text" id="subject" name="entry.1414443987" placeholder="例、衣装制作について" required />
                </div>
                <div class="form-group">
                    <label for="content">質問内容 または 自己PR等<span class="required">必須</span></label>
                    <textarea id="content" name="entry.1111380753" rows="5" placeholder="問い合わせ内容をここに記載してください"
                        required></textarea>
                </div>
                <!-- <div class="form-group checkbox-group">
                        <input type="checkbox" id="privacy-policy" name="privacy-policy" required />
                        <label for="privacy-policy">プライバシーポリシーに同意する</label>
                    </div> -->
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
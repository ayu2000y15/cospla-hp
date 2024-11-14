@extends('layouts.app')

@section('title', 'お問い合わせ内容確認 - COSPLATFORM')

@section('content')
<main>
    <section class="subpage-hero">
        <h1>お問い合わせ内容確認</h1>
    </section>
    <div class="container">
        <div class="container-box contact">
            <h2>入力内容をご確認ください</h2>
            @if (session('message'))
            <div class="success-message">{{ session('message') }}</div>
            @endif

            <form class="contact-form" action="{{ route('contact.send') }}" method="POST"
                onsubmit="return checkSubmit();">
                @csrf
                @foreach(['CATEGORY', 'NAME', 'MAIL', 'TEL', 'SUBJECT', 'CONTENT'] as $field)
                <input type="hidden" name="{{ $field }}" value="{{ $contact[$field] }}">
                @endforeach

                <div class="confirm-group">
                    <label>問い合わせ項目</label>
                    <p style="font-size:1.3rem; margin-left: 3rem;">{{ $contact['CATEGORY'] }}</p>
                </div>
                <div class="confirm-group">
                    <label>氏名</label>
                    <p style="font-size:1.3rem; margin-left: 3rem;">{{ $contact['NAME'] }}</p>
                </div>
                <div class="confirm-group">
                    <label>メールアドレス</label>
                    <p style="font-size:1.3rem; margin-left: 3rem;">{{ $contact['MAIL'] }}</p>
                </div>
                <div class="confirm-group">
                    <label>電話番号</label>
                    <p style="font-size:1.3rem; margin-left: 3rem;">{{ $contact['TEL'] ?: '未入力' }}</p>
                </div>
                <div class="confirm-group">
                    <label>件名</label>
                    <p style="font-size:1.3rem; margin-left: 3rem;">{{ $contact['SUBJECT'] }}</p>
                </div>
                <div class="confirm-group">
                    <label>質問内容 または 自己PR等</label>
                    <p style="font-size:1.3rem; margin-left: 3rem;">{!! nl2br(e($contact['CONTENT'])) !!}</p>
                </div>

                <div class="button-group">
                    <button type="button" class="submit-button" onclick="history.back();">修正する</button>
                    <button type="submit" class="submit-button">送信する</button>
                </div>
            </form>
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

.confirm-group {
    padding-bottom: 0.1rem;
    border-bottom: 1px solid #e0e0e0;
}

.confirm-group label {
    margin-top: -1rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
    display: block;
    font-size: 0.9rem;
}

.confirm-group p {
    color:black;
    margin: 0;
    line-height: 1;
    display: inline-block
}

.button-group {
    text-align: center;
}

</style>
@endpush

@push('scripts')
<script>
function checkSubmit() {
    return confirm('送信してもよろしいですか？');
}
</script>
@endpush
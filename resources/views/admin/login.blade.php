@extends('layouts.admin')

@section('content')
<main>
    <section class="subpage-hero">
        <h1>ログイン</h1>
    </section>
    <div class="container">
        <div class="container-box">
            <div class="form-area">
                <h3>管理者ページへアクセスするにはログインが必要です。</h3>
                <h3>IDとパスワードを入力してください</h3>
                @if (session('error'))
                    <br>
                    <div class="error-message">{{ session('error') }}</div>
                @endif
                <form action="{{ route('login.access') }}" onsubmit="return checkSubmit('ログイン');" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">ID<span class="required">※必須</span></label>
                        <input type="text" id="name" name="name" required />
                    </div>
                    <div class="form-group">
                        <label for="password">パスワード<span class="required">※必須</span></label>
                        <input type="password" id="password" name="password" required />
                    </div>
                    <button type="submit" class="submit-button">ログイン</button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="{{ asset('js/admin-script.js') }}"></script>
@endpush
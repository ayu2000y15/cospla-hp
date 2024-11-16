@extends('layouts.admin')

@section('content')
<a id="top"></a>
<main>
    <section class="subpage-hero">
        <h1>ゲスト</h1>
    </section>
    <a href="#top" class="back-to-top">トップへ戻る</a>
    <div class="container">
        <div class="container-box">
            <section class="admin">
                <h3>ここではタレント登録のみ行えます。</h3>
                @if (session('message'))
                <div class="success-message">{{ session('message') }}</div>
                @endif
                @if (session('error'))
                <div class="error-message">{{ session('error') }}</div>
                @endif

                <div class="tabs">
                    <div class="tab-buttons">
                        <button class="tab-button active"
                            data-tab="talent-entry">タレント登録</button>
                    </div>
                </div>


                <div class="tab-content active"
                    id="talent-entry">
                    @include('admin.talent-entry')
                </div>
        </div>
        </section>
    </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="{{ asset('js/admin-script.js') }}"></script>
@endpush
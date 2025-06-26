@extends('layouts.admin')

@section('content')
<a id="top"></a>
<main>
    <section class="subpage-hero">
        <h1>ACメーラー</h1>
    </section>
    <a href="#top" class="back-to-top">トップへ戻る</a>
    <div class="container">
        <div class="container-box">
            <section class="admin">
                @if (session('message'))
                    <div class="success-message">{{ session('message') }}</div>
                @endif
                @if (session('error'))
                    <div class="error-message">{{ session('error') }}</div>
                @endif

                <div class="tabs">
                    <div class="tab-buttons">
                        <button class="tab-button {{ session('activeTabAc') === 'ac-entry' ? 'active' : '' }}" data-tab="ac-entry">ACメーラーリスト登録</button>
                        <button class="tab-button {{ session('activeTabAc') === 'ac-list' ? 'active' : '' }}" data-tab="ac-list">ACメーラーリスト一覧</button>
                    </div>

                    <div class="tab-content {{ session('activeTabAc') === 'ac-entry' ? 'active' : '' }}" id="ac-entry">
                        @include('admin.ac.ac-entry')
                    </div>
                    <div class="tab-content {{ session('activeTabAc') === 'ac-list' ? 'active' : '' }}" id="ac-list">
                        @include('admin.ac.ac-list')
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

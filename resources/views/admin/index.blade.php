@extends('layouts.admin')

@section('content')
<a id="top"></a>
<main>
    <section class="subpage-hero">
        <h1>全体管理</h1>
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
                        <button class="tab-button {{ session('activeTab') === 'talent-list' ? 'active' : '' }}" data-tab="talent-list">タレント一覧</button>
                        <button class="tab-button {{ session('activeTab') === 'talent-entry' ? 'active' : '' }}" data-tab="talent-entry">タレント登録</button>
                        <button class="tab-button {{ session('activeTab') === 'career-entry' ? 'active' : '' }}" data-tab="career-entry">経歴カテゴリ登録・削除</button>
                        <button class="tab-button {{ session('activeTab') === 'tag-entry' ? 'active' : '' }}" data-tab="tag-entry">ハッシュタグ登録・削除</button>
                        <button class="tab-button {{ session('activeTab') === 'news-entry' ? 'active' : '' }}" data-tab="news-entry">ニュース登録・変更</button>
                        <button class="tab-button {{ session('activeTab') === 'photos-entry' ? 'active' : '' }}" data-tab="photos-entry">HP画像登録・変更</button>
                        <button class="tab-button {{ session('activeTab') === 'company-info' ? 'active' : '' }}" data-tab="company-info">会社情報変更<br>・問い合わせメール登録</button>
                    </div>

                    <div class="tab-content {{ session('activeTab') === 'talent-list' ? 'active' : '' }}" id="talent-list">
                        @include('admin.talent-list')
                    </div>

                    <div class="tab-content {{ session('activeTab') === 'talent-entry' ? 'active' : '' }}" id="talent-entry">
                        @include('admin.talent-entry')
                    </div>

                    <div class="tab-content {{ session('activeTab') === 'career-entry' ? 'active' : '' }}" id="career-entry">
                        @include('admin.career-entry')
                    </div>

                    <div class="tab-content {{ session('activeTab') === 'tag-entry' ? 'active' : '' }}" id="tag-entry">
                        @include('admin.tag-entry')
                    </div>

                    <div class="tab-content {{ session('activeTab') === 'news-entry' ? 'active' : '' }}" id="news-entry">
                        @include('admin.news-entry')
                    </div>

                    <div class="tab-content {{ session('activeTab') === 'photos-entry' ? 'active' : '' }}" id="photos-entry">
                        @include('admin.photos-entry')
                    </div>

                    <div class="tab-content {{ session('activeTab') === 'company-info' ? 'active' : '' }}" id="company-info">
                        @include('admin.company-info')
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
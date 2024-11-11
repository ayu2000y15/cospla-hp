@extends('layouts.admin')

@section('content')
<a id="top"></a>
<main>
    <section class="subpage-hero">
        <h1>タレント管理</h1>
    </section>
    <a href="#top" class="back-to-top">トップへ戻る</a>
    <div class="container">
        <div class="container-box">
            <div class="talent-header">
                <a href="{{ route('admin.index') }}">管理画面トップに戻る</a>
                <h3>タレントID：{{ $talent->TALENT_ID }}</h3>
                <h3>レイヤーネーム：{{ $talent->LAYER_NAME }}</h3>
            </div>

            @if (session('message'))
                <div class="success-message">{{ session('message') }}</div>
            @endif
            @if (session('error'))
                <div class="error-message">{{ session('error') }}</div>
            @endif

            <div class="tabs">
                <div class="tab-buttons">
                    <button class="tab-button {{ $activeTab === 'talent-edit' ? 'active' : '' }}" data-tab="talent-edit">タレント情報変更</button>
                    <button class="tab-button {{ $activeTab === 'talent-photos' ? 'active' : '' }}" data-tab="talent-photos">タレント写真登録・変更</button>
                    <button class="tab-button {{ $activeTab === 'talent-career' ? 'active' : '' }}" data-tab="talent-career">タレント経歴登録・変更</button>
                    <button class="tab-button {{ $activeTab === 'talent-tag' ? 'active' : '' }}" data-tab="talent-tag">ハッシュタグ登録・変更</button>
                    <button class="tab-button {{ $activeTab === 'talent-retire' ? 'active' : '' }}" data-tab="talent-retire">タレント退職</button>
                </div>

                <div class="tab-content {{ $activeTab === 'talent-edit' ? 'active' : '' }}" id="talent-edit">
                    @include('admin.talent.edit')
                </div>

                <div class="tab-content {{ $activeTab === 'talent-photos' ? 'active' : '' }}" id="talent-photos">
                    @include('admin.talent.photos')
                </div>

                <div class="tab-content {{ $activeTab === 'talent-career' ? 'active' : '' }}" id="talent-career">
                    @include('admin.talent.career')
                </div>

                <div class="tab-content {{ $activeTab === 'talent-tag' ? 'active' : '' }}" id="talent-tag">
                    @include('admin.talent.tag')
                </div>

                <div class="tab-content {{ $activeTab === 'talent-retire' ? 'active' : '' }}" id="talent-retire">
                    @include('admin.talent.retire')
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script src="{{ asset('js/admin-script.js') }}"></script>
@endsection
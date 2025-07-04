@extends('layouts.admin')

@section('content')

    @php
        $tab = request()->query('tab', 'talent-list'); // デフォルトはタレント管理
    @endphp

    @if (session('message'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            {{ session('message') }}
        </div>
    @endif
    @if (session('error'))
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded-lg shadow">
        @if ($tab === 'talent-list')
            <h1 class="text-2xl font-semibold text-gray-900 mb-4">タレント管理</h1>
            @include('admin.talent-entry')
            <div class="mt-8"></div>
            @include('admin.talent-list')
        @elseif ($tab === 'news-entry')
            <h1 class="text-2xl font-semibold text-gray-900 mb-4">ニュース管理</h1>
            @include('admin.news-entry')
        @elseif ($tab === 'photos-entry')
            <h1 class="text-2xl font-semibold text-gray-900 mb-4">HP画像管理</h1>
            @include('admin.photos-entry')
        @elseif ($tab === 'company-info')
            <h1 class="text-2xl font-semibold text-gray-900 mb-4">会社情報</h1>
            @include('admin.company-info')
        @elseif (in_array($tab, ['categories', 'tag-entry', 'career-entry', 'contact-entry']))
            <h1 class="text-2xl font-semibold text-gray-900 mb-4">各種設定</h1>
            {{-- 縦並びのレイアウトに変更 --}}
            <div class="space-y-8">
                @include('admin.career-entry')
                @include('admin.contact-entry')
                @include('admin.tag-entry')
            </div>
        @endif
    </div>
@endsection
@extends('layouts.admin')

@section('content')
    {{--
    Alpine.jsのx-dataで、セッションから 'activeTabT' の値を取得します。
    セッションに値がなければ、デフォルトで 'edit' タブを開きます。
    --}}
    <div x-data="{ activeTab: '{{ session('activeTabT', 'edit') }}' }">
        <div class="sm:flex sm:items-center sm:justify-between pb-6 border-b border-gray-200">
            <div>
                <h2 class="text-2xl font-semibold text-gray-900">タレント詳細設定</h2>
                <p class="mt-1 text-sm text-gray-500">タレントID: {{ $talent->TALENT_ID }} / レイヤーネーム: {{ $talent->LAYER_NAME }}
                </p>
            </div>
            <div class="mt-3 sm:mt-0 sm:ml-4">
                <a href="{{ route('admin') }}?tab=talent-list"
                    class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                    タレント一覧に戻る
                </a>
            </div>
        </div>

        @if (session('message'))
            <div class="p-4 my-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">{{ session('message') }}</div>
        @endif
        @if (session('error'))
            <div class="p-4 my-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">{{ session('error') }}</div>
        @endif

        {{-- Tab Navigation --}}
        <div class="mt-4 border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <a href="#" @click.prevent="activeTab = 'edit'"
                    :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'edit', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'edit' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">情報編集</a>
                <a href="#" @click.prevent="activeTab = 'photos'"
                    :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'photos', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'photos' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">写真</a>
                <a href="#" @click.prevent="activeTab = 'career'"
                    :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'career', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'career' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">経歴</a>
                <a href="#" @click.prevent="activeTab = 'tag'"
                    :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'tag', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'tag' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">タグ</a>
                <a href="#" @click.prevent="activeTab = 'retire'"
                    :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'retire', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'retire' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">退職処理</a>
            </nav>
        </div>

        {{-- Tab Content (x-cloakを削除しました) --}}
        <div class="mt-6">
            <div x-show="activeTab === 'edit'"> @include('admin.talent.talent-edit') </div>
            <div x-show="activeTab === 'photos'"> @include('admin.talent.talent-photos') </div>
            <div x-show="activeTab === 'career'"> @include('admin.talent.talent-career') </div>
            <div x-show="activeTab === 'tag'"> @include('admin.talent.talent-tag') </div>
            <div x-show="activeTab === 'retire'"> @include('admin.talent.talent-retire') </div>
        </div>
    </div>
@endsection
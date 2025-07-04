<div class="flex flex-1 flex-col overflow-y-auto pt-5 pb-4">
    <div class="flex flex-shrink-0 items-center px-4">
        <a href="{{ route('home') }}">
            @if(isset($logoImg) && $logoImg)
                <img class="h-8 w-auto" src="{{ asset($logoImg->FILE_PATH . $logoImg->FILE_NAME) }}" alt="COSPLATFORM">
            @else
                <span class="text-white font-bold text-lg">COSPLATFORM</span>
            @endif
        </a>
    </div>
    <nav class="mt-5 flex-1 space-y-1 px-2">
        <a href="{{ route('admin') }}?tab=talent-list"
            class="{{ request()->query('tab', 'talent-list') == 'talent-list' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">タレント管理</a>
        <a href="{{ route('admin') }}?tab=news-entry"
            class="{{ request()->query('tab') == 'news-entry' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">ニュース管理</a>
        <a href="{{ route('admin') }}?tab=photos-entry"
            class="{{ request()->query('tab') == 'photos-entry' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">HP画像管理</a>
        <a href="{{ route('admin') }}?tab=company-info"
            class="{{ request()->query('tab') == 'company-info' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">会社情報</a>
        <a href="{{ route('admin.order.index') }}"
            class="{{ request()->routeIs('admin.order.*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">ORDER管理</a>
        {{-- タグ、経歴、問合せのカテゴリ設定を一つにまとめます --}}
        <a href="{{ route('admin') }}?tab=categories"
            class="{{ in_array(request()->query('tab'), ['categories', 'tag-entry', 'career-entry', 'contact-entry']) ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">各種設定</a>
    </nav>
</div>
<div class="flex flex-shrink-0 bg-gray-700 p-4">
    <a href="{{ route('home') }}" class="group block w-full flex-shrink-0">
        <div class="flex items-center">
            <div>
                <svg class="inline-block h-6 w-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-4.5 0V6.75A2.25 2.25 0 0115.75 4.5h1.5a2.25 2.25 0 012.25 2.25v1.5m-4.5 0h4.5m-4.5 0l-4.5 4.5m4.5-4.5l-4.5-4.5" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-white">サイトを確認</p>
                <p class="text-xs font-medium text-gray-300 group-hover:text-gray-200">ホームページへ</p>
            </div>
        </div>
    </a>
</div>
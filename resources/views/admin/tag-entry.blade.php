<details class="bg-white rounded-lg shadow group">
    <summary class="flex items-center justify-between p-4 font-medium list-none cursor-pointer">
        <h3 class="text-lg leading-6 text-gray-900">タグ管理</h3>
        <svg class="w-5 h-5 transition-transform duration-300 transform group-open:rotate-180" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </summary>
    <div class="p-6 border-t border-gray-200">
        <div class="space-y-8">
            <div>
                <h4 class="text-base font-medium leading-6 text-gray-900">タグ新規登録</h4>
                <form action="{{ route('admin.tag.store') }}" method="POST"
                    class="mt-4 space-y-4 sm:flex sm:items-end sm:space-y-0 sm:space-x-3">
                    @csrf
                    <div class="flex-grow">
                        <label for="TAG_NAME" class="block text-sm font-medium text-gray-700">タグ名</label>
                        <div class="mt-1">
                            <input type="text" name="TAG_NAME" id="TAG_NAME" required placeholder="例: Vtuber"
                                class="block w-full p-2 bg-white border border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <label for="TAG_COLOR" class="block text-sm font-medium text-gray-700">色</label>
                        <div class="mt-1">
                            <input type="color" name="TAG_COLOR" id="TAG_COLOR" value="#8b5cf6"
                                class="w-full p-1 bg-white border border-gray-300 rounded-md shadow-sm h-10 sm:w-16">
                        </div>
                    </div>
                    <button type="submit"
                        class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm sm:w-auto hover:bg-indigo-700">作成</button>
                </form>
            </div>

            <div class="pt-8 border-t border-gray-200">
                <h4 class="text-base font-medium leading-6 text-gray-900">登録済みタグ一覧</h4>
                <div class="flex flex-wrap gap-3 mt-4">
                    @forelse ($tagList as $tag)
                        <div class="flex items-center gap-2 px-3 py-1 text-sm font-medium text-white rounded-full shadow"
                            style="background-color: {{ $tag->TAG_COLOR }};">
                            <span>#{{ $tag->TAG_NAME }}</span>
                            <form action="{{ route('admin.tag.delete', $tag->TAG_ID) }}" method="POST"
                                onsubmit="return confirm('このタグを削除しますか？');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="ml-1 text-white transition-opacity opacity-70 hover:opacity-100">&times;</button>
                            </form>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">まだタグは登録されていません。</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</details>
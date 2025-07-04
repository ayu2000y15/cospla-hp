<div class="space-y-10">

    <div class="p-6 bg-white rounded-lg shadow">
        <h3 class="text-lg font-medium leading-6 text-gray-900">登録済みハッシュタグ</h3>
        <div class="flex flex-wrap gap-3 mt-4">
            @forelse ($tagList as $tag)
                <div class="flex items-center gap-2 px-3 py-1 text-sm font-medium text-white rounded-full shadow"
                    style="background-color: {{ $tag->TAG_COLOR }};">
                    <span>#{{ $tag->TAG_NAME }}</span>
                    <form action="{{ route('admin.talent.tag.delete') }}" method="POST"
                        onsubmit="return confirm('このタレントからタグを削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="TALENT_ID" value="{{ $talent->TALENT_ID }}">
                        <input type="hidden" name="TAG_ID" value="{{ $tag->TAG_ID }}">
                        <button type="submit"
                            class="ml-1 text-white transition-opacity opacity-70 hover:opacity-100">&times;</button>
                    </form>
                </div>
            @empty
                <p class="text-sm text-gray-500">このタレントにはタグが登録されていません。</p>
            @endforelse
        </div>
    </div>

    <div class="p-6 bg-white rounded-lg shadow">
        <h3 class="text-lg font-medium leading-6 text-gray-900">既存のタグから追加</h3>
        @if($tagNotList->isNotEmpty())
            <form action="{{ route('admin.talent.tag.add') }}" method="POST" class="mt-4 sm:flex sm:items-end sm:space-x-3">
                @csrf
                <input type="hidden" name="TALENT_ID" value="{{ $talent->TALENT_ID }}">
                <div class="flex-grow">
                    <label for="TAG_ID" class="sr-only">タグを選択</label>
                    <select id="TAG_ID" name="TAG_ID"
                        class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                        @foreach ($tagNotList as $tag)
                            <option value="{{ $tag->TAG_ID }}">#{{ $tag->TAG_NAME }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                    class="inline-flex items-center justify-center w-full px-4 py-2 mt-4 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm sm:mt-0 sm:w-auto hover:bg-indigo-700">追加</button>
            </form>
        @else
            <p class="mt-4 text-sm text-gray-500">追加できる既存のタグはありません。</p>
        @endif
    </div>
</div>
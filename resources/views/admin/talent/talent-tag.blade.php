<div class="space-y-10">

    {{-- 1. タグ編集フォーム --}}
    <div class="p-6 bg-white rounded-lg shadow">
        <h3 class="text-lg font-medium leading-6 text-gray-900">タグの編集</h3>
        <p class="mt-1 text-sm text-gray-500">
            複数のタグをカンマ（,）で区切って入力してください。存在しないタグは自動で作成されます。<br>
            新しく作成されるタグカラーはランダムで設定されます。<br>
            各種設定のタグ管理より、タグカラーの変更が可能です。
        </p>

        {{-- 現在のタグを表示 --}}
        @if ($tagList->isNotEmpty())
            <div class="flex flex-wrap gap-2 mt-4">
                @foreach ($tagList as $tag)
                    <div class="flex items-center gap-2 px-3 py-1 text-sm font-medium text-white rounded-full shadow"
                        style="background-color: {{ $tag->TAG_COLOR }};">
                        <span>#{{ $tag->TAG_NAME }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="mt-4 text-sm text-gray-500">このタレントにはタグが登録されていません。</p>
        @endif

        {{-- タグ入力フォーム --}}
        <form action="{{ route('admin.talent.tags.update') }}" method="POST" class="mt-6">
            @csrf
            <input type="hidden" name="TALENT_ID" value="{{ $talent->TALENT_ID }}">

            <div>
                <label for="tags-input" class="block text-sm font-medium text-gray-700">タグ入力</label>
                <input type="text" name="tags" id="tags-input"
                    class="mt-1 block w-full p-2 bg-white border border-gray-300 rounded-md shadow-sm"
                    placeholder="例: Vtuber, ゲーム, 歌" value="{{ $tagList->pluck('TAG_NAME')->implode(', ') }}">
            </div>

            {{-- ★★★ ここからが追加したセクション ★★★ --}}
            <div class="mt-4">
                <h4 class="text-sm font-medium text-gray-700">既存のタグ一覧</h4>
                <p class="text-xs text-gray-500">クリックしてタグを追加できます。</p>
                <div id="existing-tags-container"
                    class="flex flex-wrap gap-2 mt-2 p-3 bg-gray-50 rounded-md border max-h-32 overflow-y-auto">
                    @forelse ($allTags as $tag)
                        <button type="button"
                            class="existing-tag-btn px-2 py-1 text-xs font-medium text-white rounded-full shadow-sm transition-transform transform hover:scale-105"
                            style="background-color: {{ $tag->TAG_COLOR }};" data-tag-name="{{ $tag->TAG_NAME }}">
                            #{{ $tag->TAG_NAME }}
                        </button>
                    @empty
                        <p class="text-xs text-gray-500">登録済みのタグはありません。</p>
                    @endforelse
                </div>
            </div>
            {{-- ★★★ ここまで ★★★ --}}

            <div class="flex justify-end pt-5 mt-4 border-t border-gray-200">
                <button type="submit"
                    class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700">
                    タグを更新する
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tagsInput = document.getElementById('tags-input');
            const existingTagsContainer = document.getElementById('existing-tags-container');

            if (tagsInput && existingTagsContainer) {
                existingTagsContainer.addEventListener('click', function (e) {
                    // クリックされたのがタグボタンの場合のみ処理
                    if (e.target.classList.contains('existing-tag-btn')) {
                        const tagName = e.target.dataset.tagName;

                        // 現在の入力値を取得し、前後の空白を削除して配列に変換
                        let currentTags = tagsInput.value
                            .split(',')
                            .map(t => t.trim())
                            .filter(t => t.length > 0);

                        // タグが既に追加されていないかチェック
                        if (!currentTags.includes(tagName)) {
                            currentTags.push(tagName);
                            tagsInput.value = currentTags.join(', '); // カンマとスペースで連結して入力欄を更新
                        }
                    }
                });
            }
        });
    </script>
@endpush
<details class="bg-white rounded-lg shadow group" open>
    <summary class="flex items-center justify-between p-4 font-medium list-none cursor-pointer">
        <h3 class="text-lg leading-6 text-gray-900">タグ管理</h3>
        <svg class="w-5 h-5 transition-transform duration-300 transform group-open:rotate-180" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </summary>
    <div class="p-6 border-t border-gray-200">
        <div class="space-y-8">

            {{-- 登録済みタグ一覧セクション --}}
            <div>
                <h4 class="text-base font-medium leading-6 text-gray-900">登録済みタグ一覧</h4>
                <p class="mt-1 text-sm text-gray-500">タグをクリックすると色を変更できます。<br>
                    既に使用されているタグは削除できません。
                </p>
                <div class="flex flex-wrap gap-4 mt-4">
                    @forelse ($tagList as $tag)
                        <div x-data="{}" x-init="
                                    let picker = document.getElementById('color-picker-{{ $tag->TAG_ID }}');
                                    picker.addEventListener('input', (event) => {
                                        // 色が変更されたら、500ms待ってからサーバーに更新リクエストを送信
                                        updateTagColor({{ $tag->TAG_ID }}, event.target.value);
                                        // タグバッジの色をリアルタイムで変更
                                        document.getElementById('tag-badge-{{ $tag->TAG_ID }}').style.backgroundColor = event.target.value;
                                    });
                                "
                            class="flex items-center gap-2 px-3 py-1 text-sm font-medium text-white rounded-full shadow"
                            id="tag-badge-{{ $tag->TAG_ID }}" style="background-color: {{ $tag->TAG_COLOR }};">

                            {{-- 色変更できるタグ名 --}}
                            <span @click="$refs.colorInput.click()" class="cursor-pointer">
                                #{{ $tag->TAG_NAME }}
                            </span>
                            {{-- 見えないカラーピッカー --}}
                            <input type="color" id="color-picker-{{ $tag->TAG_ID }}" x-ref="colorInput"
                                value="{{ $tag->TAG_COLOR }}" class="absolute w-0 h-0 p-0 border-0"
                                style="visibility: hidden;">

                            {{-- 削除フォーム --}}
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

{{-- スクリプトはページ内で一度だけ読み込まれればOKです --}}
@push('scripts')
    <script>
        // サーバーサイドに色情報を更新する関数
        function updateTagColor(tagId, newColor) {
            // 短時間に何度もリクエストが飛ばないように、少し待ってから実行する
            if (window.colorUpdateTimeout) {
                clearTimeout(window.colorUpdateTimeout);
            }
            window.colorUpdateTimeout = setTimeout(() => {
                fetch(`/admin/tags/${tagId}/update-color`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ color: newColor })
                })
                    .then(response => {
                        if (!response.ok) {
                            console.error('色の更新に失敗しました。');
                        }
                    })
                    .catch(error => console.error('通信エラー:', error));
            }, 500);
        }
    </script>
@endpush
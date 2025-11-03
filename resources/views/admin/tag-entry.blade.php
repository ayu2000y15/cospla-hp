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
                <div class="mt-4">
                    {{-- 縦並びのドラッグ可能リスト --}}
                    <ul id="tag-list" class="space-y-2">
                        @forelse ($tagList as $tag)
                            <li data-id="{{ $tag->TAG_ID }}" x-data="{}" x-init="
                                                     let picker = document.getElementById('color-picker-{{ $tag->TAG_ID }}');
                                                     picker.addEventListener('input', (event) => {
                                                         // 色が変更されたら、500ms待ってからサーバーに更新リクエストを送信
                                                         updateTagColor({{ $tag->TAG_ID }}, event.target.value);
                                                         // タグバッジの色をリアルタイムで変更
                                                         document.getElementById('tag-badge-{{ $tag->TAG_ID }}').style.backgroundColor = event.target.value;
                                                     });
                                                 "
                                class="flex items-center justify-between gap-2 px-3 py-2 text-sm font-medium text-white rounded-full shadow"
                                id="tag-badge-{{ $tag->TAG_ID }}" style="background-color: {{ $tag->TAG_COLOR }};"
                                onclick="(function(e){ if(e.target.closest('button')||e.target.closest('form')||e.target.closest('svg')||e.target.closest('input[type=\'color\']')) return; document.getElementById('color-picker-{{ $tag->TAG_ID }}').click(); })(event)">

                                <div class="flex items-center gap-2">
                                    {{-- ドラッグ用ハンドル（左側） --}}
                                    <svg class="w-4 h-4 opacity-90 cursor-move mr-2" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M10 6h.01M14 6h.01M10 12h.01M14 12h.01M10 18h.01M14 18h.01" />
                                    </svg>
                                    {{-- タグ名（行クリックでカラーピッカー） --}}
                                    <span class="cursor-pointer">#{{ $tag->TAG_NAME }}</span>
                                    {{-- 非表示カラーピッカー --}}
                                    <input type="color" id="color-picker-{{ $tag->TAG_ID }}" x-ref="colorInput"
                                        value="{{ $tag->TAG_COLOR }}" class="absolute w-0 h-0 p-0 border-0"
                                        style="visibility: hidden;">
                                </div>

                                <div class="flex items-center gap-2">
                                    {{-- 削除フォーム --}}
                                    <form action="{{ route('admin.tag.delete', $tag->TAG_ID) }}" method="POST"
                                        onsubmit="return confirm('このタグを削除しますか？');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-white transition-opacity opacity-70 hover:opacity-100">&times;</button>
                                    </form>
                                    {{-- ドラッグハンドルは左側に移動しました --}}
                                </div>
                            </li>
                        @empty
                            <p class="text-sm text-gray-500">まだタグは登録されていません。</p>
                        @endforelse
                    </ul>

                    {{-- 並び順を保存ボタン --}}
                    <div class="w-full mt-4">
                        <button id="save-tag-order" type="button"
                            class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700"
                            onclick="saveTagOrder()">順序を保存</button>
                        <span id="tag-order-status" class="ml-3 text-sm text-gray-600"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</details>

{{-- スクリプトはページ内で一度だけ読み込まれればOKです --}}
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
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

        // 現在の並び順をサーバーに送信して保存する
        function saveTagOrder() {
            const list = document.getElementById('tag-list');
            if (!list) return;
            const ids = Array.from(list.querySelectorAll('[data-id]')).map(el => parseInt(el.getAttribute('data-id')));
            const status = document.getElementById('tag-order-status');
            status.textContent = '保存中...';

            fetch('/admin/tags/reorder', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ order: ids })
            })
                .then(res => res.json())
                .then(data => {
                    if (data && data.success) {
                        status.textContent = '並び順を保存しました。';
                        setTimeout(() => status.textContent = '', 2000);
                    } else {
                        status.textContent = '保存に失敗しました。';
                    }
                })
                .catch(err => {
                    console.error(err);
                    status.textContent = '通信エラー';
                });
        }

        // SortableJS を初期化（CDN を読み込んでから）
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Sortable !== 'undefined') {
                new Sortable(document.getElementById('tag-list'), {
                    animation: 150,
                    ghostClass: 'opacity-50',
                    handle: '.cursor-move',
                    direction: 'vertical'
                });
            }
        });
    </script>
@endpush
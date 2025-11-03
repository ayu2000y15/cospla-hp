<div class="space-y-10">

    {{-- 1. タグ編集フォーム --}}
    <div class="p-6 bg-white rounded-lg shadow">
        <h3 class="text-lg font-medium leading-6 text-gray-900">タグの編集</h3>
        <p class="mt-1 text-sm text-gray-500">
            複数のタグをカンマ（,）で区切って入力してください。<br>存在しないタグは自動で作成されます。<br>
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
            <input type="hidden" name="activeTab" :value="activeTab">

            <div>
                <label for="tags-input" class="block text-sm font-medium text-gray-700">タグ入力</label>
                <input type="text" name="tags" id="tags-input"
                    class="mt-1 block w-full p-2 bg-white border border-gray-300 rounded-md shadow-sm"
                    placeholder="例: Vtuber, ゲーム, 歌" value="{{ $tagList->pluck('TAG_NAME')->implode(', ') }}">
            </div>

            {{-- ★★★ ここからが追加したセクション ★★★ --}}
            <div class="mt-4">
                <h4 class="text-sm font-medium text-gray-700">既存のタグ一覧（ドラッグで並べ替え可）</h4>
                <p class="text-xs text-gray-500">クリックしてタグを入力欄に追加できます。<br>ドラッグで順序を変更し、「既存タグの並び順を保存」を押してください。</p>

                <ul id="all-tags-list" class="mt-2 space-y-2 p-3 bg-gray-50 rounded-md border">
                    @forelse ($allTags as $tag)
                        <li data-id="{{ $tag->TAG_ID }}" data-tag-name="{{ $tag->TAG_NAME }}"
                            class="existing-tag-btn flex items-center justify-between gap-2 px-2 py-1 rounded shadow-sm">
                            <span class="drag-handle cursor-move text-gray-500 mr-2" title="ドラッグ">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M7 4a1 1 0 112 0 1 1 0 11-2 0zM7 8a1 1 0 112 0 1 1 0 11-2 0zM7 12a1 1 0 112 0 1 1 0 11-2 0zM11 4a1 1 0 112 0 1 1 0 11-2 0zM11 8a1 1 0 112 0 1 1 0 11-2 0zM11 12a1 1 0 112 0 1 1 0 11-2 0z" />
                                </svg>
                            </span>
                            <div class="flex items-center gap-2 cursor-pointer all-tag-label flex-1">
                                <span class="px-2 py-1 text-xs font-medium text-white rounded-full"
                                    style="background-color: {{ $tag->TAG_COLOR }};">#{{ $tag->TAG_NAME }}</span>
                            </div>
                        </li>
                    @empty
                        <p class="text-xs text-gray-500">登録済みのタグはありません。</p>
                    @endforelse
                </ul>

                <div class="mt-3">
                    <button id="save-all-tags-order" type="button"
                        class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        順序を保存
                    </button>
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
            const allTagsList = document.getElementById('all-tags-list');

            if (tagsInput && allTagsList) {
                // クリックイベントはイベントデリゲーションで処理
                allTagsList.addEventListener('click', function (e) {
                    const li = e.target.closest('.existing-tag-btn');
                    if (!li) return;

                    // ドラッグハンドルをクリックした場合はタグ追加処理を行わない
                    if (e.target.closest('.drag-handle')) return;

                    const tagName = li.dataset.tagName;
                    let currentTags = tagsInput.value
                        .split(',')
                        .map(t => t.trim())
                        .filter(t => t.length > 0);

                    if (!currentTags.includes(tagName)) {
                        currentTags.push(tagName);
                        tagsInput.value = currentTags.join(', ');
                    }
                });
            }
        });
    </script>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 動的に SortableJS を読み込む（既にロード済みなら二重読込しない）
            const loadSortable = () => new Promise((resolve) => {
                if (window.Sortable) return resolve();
                const s = document.createElement('script');
                s.src = 'https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js';
                s.onload = () => resolve();
                document.head.appendChild(s);
            });

            loadSortable().then(() => {
                // talent のタグリスト（タレントに紐づくタグの並び替え）
                const talentList = document.getElementById('talent-tag-list');
                if (talentList) {
                    new Sortable(talentList, { handle: '.drag-handle', animation: 150, dragClass: 'opacity-75' });
                    const saveTalentBtn = document.getElementById('save-talent-tag-order');
                    saveTalentBtn && saveTalentBtn.addEventListener('click', async function () {
                        const items = Array.from(document.querySelectorAll('#talent-tag-list li'));
                        const order = items.map(li => parseInt(li.dataset.id, 10));
                        const talId = document.querySelector('input[name="TALENT_ID"]').value;
                        const tokenMeta = document.querySelector('meta[name="csrf-token"]');
                        const token = tokenMeta ? tokenMeta.getAttribute('content') : '{{ csrf_token() }}';
                        try {
                            const res = await fetch('{{ route('admin.talent.tags.reorder') }}', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
                                body: JSON.stringify({ TALENT_ID: talId, order })
                            });
                            const data = await res.json();
                            if (data && data.status === 'success') alert(data.message || 'タグの並び順を保存しました。');
                            else alert('タグの並び順の保存に失敗しました。');
                        } catch (err) { console.error(err); alert('通信エラーが発生しました。'); }
                    });
                }

                // 既存タグ一覧（全体）の並び替え
                const allTags = document.getElementById('all-tags-list');
                if (allTags) {
                    new Sortable(allTags, { handle: '.drag-handle', animation: 150, dragClass: 'opacity-75' });
                    const saveAllBtn = document.getElementById('save-all-tags-order');
                    saveAllBtn && saveAllBtn.addEventListener('click', async function () {
                        const items = Array.from(document.querySelectorAll('#all-tags-list li'));
                        const order = items.map(li => parseInt(li.dataset.id, 10));
                        const tokenMeta = document.querySelector('meta[name="csrf-token"]');
                        const token = tokenMeta ? tokenMeta.getAttribute('content') : '{{ csrf_token() }}';
                        try {
                            const res = await fetch('{{ route('admin.tags.reorder') }}', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
                                body: JSON.stringify({ order })
                            });
                            const data = await res.json();
                            if (data && data.success) alert(data.message || '既存タグの並び順を保存しました。');
                            else alert('既存タグの並び順の保存に失敗しました。');
                        } catch (err) { console.error(err); alert('通信エラーが発生しました。'); }
                    });
                }
            });
        });
    </script>
@endpush
<div class="space-y-10">

    {{-- 1. 経歴一括登録フォーム --}}
    <div x-data="careerForm()" class="p-6 bg-white rounded-lg shadow">
        <h3 class="text-lg font-medium leading-6 text-gray-900">経歴の一括登録</h3>
        <p class="mt-1 text-sm text-gray-500">カテゴリを選択し、「入力欄を追加」ボタンで項目を増やしてまとめて登録できます。</p>

        <form :action="formAction" method="POST" class="mt-6 space-y-6" onsubmit="return confirm('入力された経歴を登録しますか？');">
            @csrf
            <input type="hidden" name="TALENT_ID" value="{{ $talent->TALENT_ID }}">

            {{-- カテゴリ選択 --}}
            <div>
                <label for="batch_CAREER_CATEGORY_ID" class="block text-sm font-medium text-gray-700">経歴カテゴリ</label>
                <select name="CAREER_CATEGORY_ID" id="batch_CAREER_CATEGORY_ID" required class="block w-full max-w-xs p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                    @foreach ($careerCategories as $select)
                    <option value="{{ $select->CAREER_CATEGORY_ID }}">{{ $select->CAREER_CATEGORY_NAME }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 動的に追加される入力欄 --}}
            <div class="space-y-4">
                <template x-for="(field, index) in fields" :key="index">
                    <div class="p-4 border border-gray-200 rounded-md">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label :for="'active_date_' + index" class="text-sm font-medium text-gray-700">活動日</label>
                                <input :name="'careers[' + index + '][ACTIVE_DATE]'" :id="'active_date_' + index" type="date" class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-700">表示形式</label>
                                <fieldset class="mt-2">
                                    <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
                                        <div class="flex items-center"><input :id="'format_none_' + index" :name="'careers[' + index + '][SPARE2]'" type="radio" value="0" checked class="w-4 h-4"><label :for="'format_none_' + index" class="ml-2 text-sm">指定なし</label></div>
                                        <div class="flex items-center"><input :id="'format_ymd_' + index" :name="'careers[' + index + '][SPARE2]'" type="radio" value="1" class="w-4 h-4"><label :for="'format_ymd_' + index" class="ml-2 text-sm">年月日</label></div>
                                        <div class="flex items-center"><input :id="'format_ym_' + index" :name="'careers[' + index + '][SPARE2]'" type="radio" value="2" class="w-4 h-4"><label :for="'format_ym_' + index" class="ml-2 text-sm">年月</label></div>
                                        <div class="flex items-center"><input :id="'format_y_' + index" :name="'careers[' + index + '][SPARE2]'" type="radio" value="3" class="w-4 h-4"><label :for="'format_y_' + index" class="ml-2 text-sm">年のみ</label></div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label :for="'content_' + index" class="text-sm font-medium text-gray-700">経歴内容 <span class="text-red-500">*</span></label>
                            <textarea :name="'careers[' + index + '][CONTENT]'" :id="'content_' + index" rows="2" required class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm"></textarea>
                        </div>
                        <div class="flex justify-end mt-2">
                            <button type="button" @click="removeField(index)" class="text-sm font-medium text-red-600 hover:text-red-800">入力欄を削除</button>
                        </div>
                    </div>
                </template>
            </div>

            {{-- 操作ボタン --}}
            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                <button type="button" @click="addField()" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                    入力欄を追加
                </button>
                <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700">まとめて登録</button>
            </div>
        </form>
    </div>

    {{-- 2. 経歴 登録・編集フォーム --}}
    <div class="p-6 bg-white rounded-lg shadow">
        <h3 id="career-form-title" class="text-lg font-medium leading-6 text-gray-900">経歴の新規登録</h3>
        <p class="mt-1 text-sm text-gray-500">経歴を1件ずつ登録または編集します。「編集」ボタンを押すと内容がここに読み込まれます。</p>

        <form id="careerAdminForm" action="{{ route('admin.talent.career.store') }}" method="POST" class="mt-6 space-y-6" onsubmit="return confirm('入力内容を保存しますか？');">
            @csrf
            <input type="hidden" name="TALENT_ID" value="{{ $talent->TALENT_ID }}">
            <input type="hidden" id="CAREER_ID" name="CAREER_ID" value="">
            {{-- editCareer関数で 'PUT' メソッドを挿入する場所 --}}

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="CAREER_CATEGORY_ID" class="block text-sm font-medium text-gray-700">経歴カテゴリ</label>
                    <select id="CAREER_CATEGORY_ID" name="CAREER_CATEGORY_ID" required class="block w-full max-w-xs p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                        @foreach ($careerCategories as $select)
                        <option value="{{ $select->CAREER_CATEGORY_ID }}">{{ $select->CAREER_CATEGORY_NAME }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="ACTIVE_DATE" class="text-sm font-medium text-gray-700">活動日</label>
                    <input id="ACTIVE_DATE" name="ACTIVE_DATE" type="date" class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                </div>
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">表示形式</label>
                <fieldset id="SPARE2_container" class="mt-2">
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
                        <div class="flex items-center"><input id="date_format_0" name="SPARE2" type="radio" value="0" checked class="w-4 h-4"><label for="date_format_0" class="ml-2 text-sm">指定なし</label></div>
                        <div class="flex items-center"><input id="date_format_1" name="SPARE2" type="radio" value="1" class="w-4 h-4"><label for="date_format_1" class="ml-2 text-sm">年月日</label></div>
                        <div class="flex items-center"><input id="date_format_2" name="SPARE2" type="radio" value="2" class="w-4 h-4"><label for="date_format_2" class="ml-2 text-sm">年月</label></div>
                        <div class="flex items-center"><input id="date_format_3" name="SPARE2" type="radio" value="3" class="w-4 h-4"><label for="date_format_3" class="ml-2 text-sm">年のみ</label></div>
                    </div>
                </fieldset>
            </div>

            <div>
                <label for="CONTENT" class="text-sm font-medium text-gray-700">経歴内容 <span class="text-red-500">*</span></label>
                <textarea id="CONTENT" name="CONTENT" rows="3" required class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm"></textarea>
            </div>

            <input type="hidden" id="SPARE1" name="SPARE1" value="">

            <div class="flex items-center justify-end pt-4 space-x-4 border-t border-gray-200">
                 <button type="button" id="cancel-edit-btn" style="display: none;" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">キャンセル</button>
                <button type="submit" id="career-submit-btn" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700">経歴を追加</button>
            </div>
        </form>
    </div>


    {{-- 3. 登録済み経歴一覧 (カテゴリ別・アコーディオン) --}}
    <div class="pt-8 space-y-4">
        <h3 class="text-lg font-medium leading-6 text-gray-900">登録済み経歴一覧 (ドラッグ＆ドロップでカテゴリ・経歴の並び替え可能)</h3>

        <div id="category-list" class="space-y-4">
            @forelse($careerCategories as $category)
                @php
                    $careersInCategory = $talentCareer->where('CAREER_CATEGORY_ID', $category->CAREER_CATEGORY_ID)->sortBy('SPARE1');
                @endphp

                @if($careersInCategory->isNotEmpty())
                    <details class="bg-white rounded-lg shadow group" open data-id="{{ $category->CAREER_CATEGORY_ID }}">
                        <summary class="flex items-center justify-between p-4 font-medium list-none cursor-pointer">
                            <h4 class="text-base font-semibold text-purple-800">{{ $category->CAREER_CATEGORY_NAME }}</h4>
                            <svg class="w-5 h-5 transition-transform duration-300 transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </summary>
                        <div class="p-4 border-t border-gray-200">
                            <ul class="space-y-3 sortable-list" id="category-{{ $category->CAREER_CATEGORY_ID }}">
                                @foreach($careersInCategory as $career)
                                    <li class="p-3 bg-gray-50 border border-gray-200 rounded-md cursor-move" data-id="{{ $career->CAREER_ID }}">
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="flex-shrink-0 w-24 text-xs font-semibold text-gray-600">
                                                @if($career->ACTIVE_DATE)
                                                    @switch($career->SPARE2)
                                                        @case('1')
                                                            {{ \Carbon\Carbon::parse($career->ACTIVE_DATE)->format('Y/n/j') }}
                                                            @break
                                                        @case('2')
                                                            {{ \Carbon\Carbon::parse($career->ACTIVE_DATE)->format('Y/n') }}
                                                            @break
                                                        @case('3')
                                                            {{ \Carbon\Carbon::parse($career->ACTIVE_DATE)->format('Y') }}
                                                            @break
                                                        @default
                                                            {{-- 日付指定なしの場合は何も表示しない --}}
                                                    @endswitch
                                                @endif
                                            </div>
                                            <div class="flex-grow text-sm font-medium text-gray-800">
                                                {!! nl2br(e($career->CONTENT)) !!}
                                            </div>
                                            <div class="flex items-center flex-shrink-0 space-x-4">
                                                <button type="button" onclick='editCareer({!! json_encode($career) !!})' class="text-sm font-medium text-indigo-600 hover:text-indigo-800">編集</button>
                                                <form action="{{ route('admin.talent.career.delete') }}" method="POST" onsubmit="return confirm('この経歴を削除しますか？');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="TALENT_ID" value="{{ $talent->TALENT_ID }}">
                                                    <input type="hidden" name="CAREER_ID" value="{{ $career->CAREER_ID }}">
                                                    <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-900">削除</button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </details>
                @endif
            @empty
                 <div class="p-6 text-sm text-center text-gray-500 bg-white rounded-lg shadow">経歴カテゴリが登録されていません。</div>
            @endforelse

            @if($talentCareer->isEmpty() && $careerCategories->isNotEmpty())
                 <div class="p-6 text-sm text-center text-gray-500 bg-white rounded-lg shadow">このタレントの経歴はまだ登録されていません。</div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sortableLists = document.querySelectorAll('.sortable-list');

        sortableLists.forEach(list => {
            new Sortable(list, {
                animation: 150,
                ghostClass: 'bg-indigo-100',
                handle: 'li', // li要素全体をドラッグハンドルにする
                onEnd: function (evt) {
                    const order = Array.from(evt.target.children).map(item => item.dataset.id);

                    fetch('{{ route('admin.talent.career.reorder') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ order: order })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status !== 'success') {
                           alert('並び替えの保存に失敗しました。');
                        }
                    })
                    .catch(() => {
                        alert('並び替えの保存中にエラーが発生しました。');
                    });
                }
            });
        });
    });

    const categoryList = document.getElementById('category-list');
        if (categoryList) {
            new Sortable(categoryList, {
                animation: 150,
                ghostClass: 'bg-blue-100',
                handle: 'summary', // <summary> タグをドラッグハンドルに設定
                onEnd: function (evt) {
                    const order = Array.from(evt.target.children).map(item => item.dataset.id);
                    const talentId = '{{ $talent->TALENT_ID }}';

                    fetch('{{ route("admin.talent.career.categories.reorder") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            order: order,
                            talent_id: talentId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status !== 'success') {
                           alert('カテゴリの並び替え保存に失敗しました。');
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        alert('カテゴリの並び替え保存中にエラーが発生しました。');
                    });
                }
            });
        }

    const form = document.getElementById('careerAdminForm');
    const formTitle = document.getElementById('career-form-title');
    const submitBtn = document.getElementById('career-submit-btn');
    const cancelBtn = document.getElementById('cancel-edit-btn');

    function editCareer(career) {
        form.action = "{{ route('admin.talent.career.update') }}";

        if (!document.getElementById('method_spoof')) {
            form.insertAdjacentHTML('afterbegin', `<input type="hidden" name="_method" id="method_spoof" value="PUT">`);
        }

        document.getElementById('CAREER_ID').value = career.CAREER_ID;
        document.getElementById('CAREER_CATEGORY_ID').value = career.CAREER_CATEGORY_ID;
        document.getElementById('ACTIVE_DATE').value = career.ACTIVE_DATE ? career.ACTIVE_DATE.split(' ')[0] : '';
        document.getElementById('CONTENT').value = career.CONTENT;
        document.getElementById('SPARE1').value = career.SPARE1;

        const radioContainer = document.getElementById('SPARE2_container');
        if(radioContainer.querySelector(`input[value="${career.SPARE2}"]`)) {
             radioContainer.querySelector(`input[value="${career.SPARE2}"]`).checked = true;
        }

        formTitle.textContent = '経歴の編集';
        submitBtn.textContent = '更新する';
        cancelBtn.style.display = 'inline-flex';
        form.scrollIntoView({ behavior: 'smooth' });
    }

    function resetCareerForm() {
        form.reset();
        form.action = "{{ route('admin.talent.career.store') }}";

        const spoof = document.getElementById('method_spoof');
        if(spoof) spoof.remove();

        document.getElementById('CAREER_ID').value = '';
        formTitle.textContent = '経歴の新規登録';
        submitBtn.textContent = '経歴を追加';
        cancelBtn.style.display = 'none';

        document.getElementById('date_format_0').checked = true;
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', resetCareerForm);
    }
</script>
<script>
    // Alpine.jsで動的フォームを管理
    function careerForm() {
        return {
            formAction: "{{ route('admin.talent.career.store-multiple') }}",
            fields: [], // 動的な入力欄の配列
            addField() {
                this.fields.push({});
            },
            removeField(index) {
                this.fields.splice(index, 1);
            }
        }
    }
</script>
@endpush

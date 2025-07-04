{{-- 一括操作フォーム --}}
<form action="{{ route('admin.talent.bulkUpdate') }}" method="POST" id="bulkUpdateTalentForm" class="mb-4">
    @csrf
    @method('PUT')
    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 sm:flex sm:items-center sm:justify-between">
        <div class="flex items-center">
            <input type="checkbox" id="selectAllt"
                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
            <label for="selectAllt" class="ml-2 block text-sm text-gray-900">全選択 / 全解除</label>
        </div>
        <div class="flex items-center gap-x-3 mt-4 sm:mt-0">
            <select name="PUBLIC_FLG"
                class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                <option value="1">公開にする</option>
                <option value="0">非公開にする</option>
            </select>
            <button type="submit"
                class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">一括変更</button>
        </div>
    </div>
</form>

{{-- タレント一覧テーブル --}}
<div class="flow-root mt-8">
    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <table class="min-w-full divide-y divide-gray-300">
                <thead>
                    <tr>
                        <th scope="col" class="relative px-7 sm:w-12 sm:px-6">
                            {{-- This header is for the checkbox column --}}
                        </th>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                            レイヤーネーム</th>
                        <th scope="col"
                            class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell">在籍状況
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">公開ステータス</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0"><span class="sr-only">削除</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse ($talentList as $talent)
                        <tr class="clickable-row cursor-pointer hover:bg-gray-50" data-talent-id="{{ $talent->TALENT_ID }}">
                            <td class="relative px-7 sm:w-12 sm:px-6">
                                <input type="checkbox" name="TALENT_PUBLIC[]" value="{{ $talent->TALENT_ID }}"
                                    class="talent-checkbox absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    form="bulkUpdateTalentForm">
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
                                {{ $talent->LAYER_NAME }}
                                <dl class="font-normal md:hidden">
                                    <dt class="sr-only">在籍状況</dt>
                                    <dd class="mt-1 text-gray-500">
                                        @if($talent->RETIREMENT_DATE <= date('Y-m-d') && $talent->DEL_FLG === '1')
                                            退職済み
                                        @else
                                            在籍
                                        @endif
                                    </dd>
                                </dl>
                            </td>
                            <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-gray-500 md:table-cell">
                                @if($talent->RETIREMENT_DATE <= date('Y-m-d') && $talent->DEL_FLG === '1')
                                    退職済み
                                @else
                                    在籍
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                @if($talent->SPARE1 == '1')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">公開</span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">非公開</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <form onsubmit="return confirm('本当に削除しますか？');" action="{{ route('admin.talent.delete') }}"
                                    method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="TALENT_ID" value="{{ $talent->TALENT_ID }}">
                                    <button type="submit" class="text-red-600 hover:text-red-900">削除</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="whitespace-nowrap px-3 py-4 text-sm text-center text-gray-500">
                                タレントはまだ登録されていません。
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- フォーム送信用の一時的なフォームを作成するためのJavaScript --}}
<form id="detail-page-form" action="{{ route('admin.talent.detail') }}" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="TALENT_ID" id="talent-id-input">
</form>


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAllCheckbox = document.getElementById('selectAllt');
            const talentCheckboxes = document.querySelectorAll('.talent-checkbox');
            const clickableRows = document.querySelectorAll('.clickable-row');
            const bulkUpdateForm = document.getElementById('bulkUpdateTalentForm');

            // 全選択/全解除
            selectAllCheckbox.addEventListener('change', function () {
                talentCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            talentCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    if (!this.checked) {
                        selectAllCheckbox.checked = false;
                    } else {
                        // すべてチェックされたか確認
                        const allChecked = Array.from(talentCheckboxes).every(c => c.checked);
                        selectAllCheckbox.checked = allChecked;
                    }
                });
            });

            // 行クリックで詳細ページへ
            clickableRows.forEach(row => {
                row.addEventListener('click', function (e) {
                    // チェックボックスや削除ボタンのクリックは除外
                    if (e.target.matches('input[type="checkbox"], button, a, form')) {
                        return;
                    }

                    const talentId = this.dataset.talentId;
                    document.getElementById('talent-id-input').value = talentId;
                    document.getElementById('detail-page-form').submit();
                });
            });

            // 一括変更フォームの送信確認
            if (bulkUpdateForm) {
                bulkUpdateForm.addEventListener('submit', function (e) {
                    const selectedCount = document.querySelectorAll('.talent-checkbox:checked').length;
                    if (selectedCount === 0) {
                        alert('変更するタレントを1人以上選択してください。');
                        e.preventDefault();
                        return;
                    }
                    if (!confirm(`${selectedCount}人のタレント情報を一括で変更しますか？`)) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
@endpush
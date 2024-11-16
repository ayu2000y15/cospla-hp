<div class="form-area list">
    <h2>登録済みタレント一覧</h2>
    <p>※タレントの行をクリックすることでタレント詳細ページに遷移します。<br>
        　タレント詳細ページではタレントの写真や経歴、ハッシュタグの情報の更新が行えます。<br></p>
    <br>
    <div class="table-container talent">
        <form action="{{ route('admin.talent.bulkUpdate') }}" method="POST" id="bulkUpdateTalentForm">
            @csrf
            @method('PUT')
            <div class="bulk-update-controls">
                <div class="select-all-wrapper">
                    <input type="checkbox" id="selectAllt" class="select-all-checkbox">
                    <label for="selectAllt">全選択/全解除</label>
                </div>
                <div class="bulk-actions">
                    <select name="PUBLIC_FLG" class="bulk-view-select">
                        <option value="1">公開</option>
                        <option value="0">非公開</option>
                    </select>
                    <button type="submit" class="bulk-update-button-talent">一括変更</button>
                </div>
            </div>
        </form>
        <table>
            <tr>
                <th>選択</th>
                <th>公開フラグ</th>
                <th class="none">タレントID</th>
                <th>レイヤーネーム</th>
                <th class="none">所属日</th>
                <th class="none">退職日</th>
                <th>在籍状況</th>
                <th class="none">操作</th>
            </tr>
            @foreach ($talentList as $talent)
            <!-- 変更: クリック可能な行にクラスを追加 -->
            <tr data-talent-id="{{ $talent->TALENT_ID }}" class="clickable-row">
                <td>
                    <input type="checkbox" name="TALENT_PUBLIC[]" value="{{ $talent->TALENT_ID }}"
                        class="talent-checkbox" form="bulkUpdateTalentForm" id="talent-{{ $talent->TALENT_ID }}">
                    <label for="talent-{{ $talent->TALENT_ID }}" class="talent-checkbox-label"></label>
                </td>
                @if($talent->SPARE1 == '1')
                <td>公開</td>
                @else
                <td>非公開</td>
                @endif
                <!-- 変更: フォームを削除し、データ属性を追加 -->
                <td class="none">{{ $talent->TALENT_ID }}</td>
                <td>{{ $talent->LAYER_NAME }}</td>
                <td class="none">{{ $talent->AFFILIATION_DATE }}</td>
                <td class="none">
                    @if($talent->RETIREMENT_DATE != '2099-01-01')
                    {{ $talent->RETIREMENT_DATE }}
                    @endif
                </td>
                <td>
                    @if($talent->RETIREMENT_DATE <= date('Y-m-d') && $talent->DEL_FLG === '1')
                        退職済み
                        @else
                        在籍
                        @endif
                </td>
                <td class="none">
                    <form onsubmit="return checkSubmit('削除');" action="{{ route('admin.talent.delete') }}"
                        method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="TALENT_ID" value="{{ $talent->TALENT_ID }}">
                        <button type="submit" class="btn btn-delete">削除する</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/admin-script.js') }}"></script>
@endpush
@push('scripts')
<script>
// 一括変更機能の改善
const bulkUpdateForm = document.getElementById('bulkUpdateTalentForm');
const bulkUpdateButton = document.querySelector('.bulk-update-button-talent');
const selectAllCheckbox = document.getElementById('selectAllt');
const photoCheckboxes = document.querySelectorAll('.talent-checkbox');

bulkUpdateButton.addEventListener('click', function(e) {
    e.preventDefault();
    const selectedPhotos = document.querySelectorAll('input[name="TALENT_PUBLIC[]"]:checked');
    if (selectedPhotos.length === 0) {
        alert('一つ以上選択してください。');
        return;
    }
    if (confirm('選択したタレントを一括で変更しますか？')) {
        bulkUpdateForm.submit();
    }
});

// 全選択/全解除機能
selectAllCheckbox.addEventListener('change', function() {
    photoCheckboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// 個別のチェックボックスの状態が変更されたときに全選択チェックボックスの状態を更新
photoCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', updateSelectAllCheckbox);
});

function updateSelectAllCheckbox() {
    selectAllCheckbox.checked = Array.from(photoCheckboxes).every(checkbox => checkbox.checked);
}

// 変更: 行クリックで詳細ページへ遷移する機能を修正
document.querySelectorAll('.clickable-row').forEach(row => {
    row.addEventListener('click', function(e) {
        // チェックボックス、ラベル、ボタンをクリックした場合は遷移しない
        if (e.target.type === 'checkbox' || e.target.tagName === 'LABEL' || e.target.type === 'submit' || e.target.closest('.talent-checkbox-label')) {
            return;
        }
        const talentId = this.dataset.talentId;
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.talent.detail") }}';
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        const talentIdInput = document.createElement('input');
        talentIdInput.type = 'hidden';
        talentIdInput.name = 'TALENT_ID';
        talentIdInput.value = talentId;
        form.appendChild(csrfToken);
        form.appendChild(talentIdInput);
        document.body.appendChild(form);
        form.submit();
    });
});
</script>
@endpush
<link rel="stylesheet" href="{{ asset('css/admin-photos.css') }}">
<main>
    <div class="form-area">
        <h2>ACメーラーリスト一覧</h2>

        <form action="{{ route('admin.ac.csvout') }}" onsubmit="return checkSubmit('CSV出力');" id="csvForm" method="POST">
            @csrf
            @method('PUT')
            <div class="bulk-update-controls">
                <div class="select-all-wrapper">
                    <input type="checkbox" id="selectAll" class="select-all-checkbox">
                    <label for="selectAll">全選択/全解除</label>
                </div>
            </div>
            <button type="submit" class="bulk-update-button">csv出力</button>
        </form>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>出力対象</th>
                        <th>配信フラグ</th>
                        <th>メールアドレス</th>
                        <th>項目１</th>
                        <th>項目２</th>
                        <th>項目３</th>
                        <th>項目４</th>
                        <th>項目５</th>
                        <th>項目６</th>
                        <th>項目７</th>
                        <th>項目８</th>
                        <th>項目９</th>
                        <th>項目１０</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="ac-list">
                    @foreach ($acmail as $list)
                    <tr>
                        <td>
                            <input type="checkbox" name="SELECTED_ITEM[]" value="{{ $list->AC_ID }}"
                                class="photo-checkbox" form="csvForm" id="item-{{ $list->AC_ID }}">
                            <label for="item-{{ $list->AC_ID }}" class="photo-checkbox-label"></label>
                        </td>
                        <td>{{ $list->DELIVERY_FLG }}</td>
                        <td>{{ $list->MAIL }}</td>
                        <td>{{ $list->COL1 }}</td>
                        <td>{{ $list->COL2 }}</td>
                        <td>{{ $list->COL3 }}</td>
                        <td>{{ $list->COL4 }}</td>
                        <td>{{ $list->COL5 }}</td>
                        <td>{{ $list->COL6 }}</td>
                        <td>{{ $list->COL7 }}</td>
                        <td>{{ $list->COL8 }}</td>
                        <td>{{ $list->COL9 }}</td>
                        <td>{{ $list->COL10 }}</td>
                        <td>
                            <button type="button" class="btn btn-edit" data-ac-id="{{ $list->AC_ID }}">編集</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-delete" data-ac-id-del="{{ $list->AC_ID }}">削除</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
    </div>
</main>

@push('scripts')
<script src="{{ asset('js/admin-script.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.photo-checkbox');
    const tableRows = document.querySelectorAll('.ac-list tr');
    const editButtons = document.querySelectorAll('.btn-edit');
    const deleteButtons = document.querySelectorAll('.btn-delete');


    // 全選択/全解除の処理（変更なし）
    selectAllCheckbox.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
    });

    // テーブル行クリック時の処理を修正
    tableRows.forEach(row => {
        row.addEventListener('click', function(e) {
            if (e.target.type !== 'checkbox' && e.target.tagName !== 'LABEL' && !e.target.classList.contains('btn-edit')) {
                const checkbox = this.querySelector('.photo-checkbox');
                checkbox.checked = !checkbox.checked;
                e.preventDefault();
            }
        });
    });

    // チェックボックスとラベルのクリック時の処理（変更なし）
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('click', function(e) {
            e.stopPropagation();
        });
        const label = document.querySelector(`label[for="${checkbox.id}"]`);
        if (label) {
            label.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
    });

    // 編集ボタンのクリックイベントを追加
    editButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            const acId = this.getAttribute('data-ac-id');

            // フォーム送信
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('admin.ac.edit') }}';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';

            const acIdInput = document.createElement('input');
            acIdInput.type = 'hidden';
            acIdInput.name = 'AC_ID';
            acIdInput.value = acId;

            form.appendChild(csrfToken);
            form.appendChild(acIdInput);
            document.body.appendChild(form);
            form.submit();
        });
    });

    // 削除ボタンのクリックイベントを追加
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            const acId = this.getAttribute('data-ac-id-del');
            if (confirm('削除しますか？')) {
                // フォーム送信
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('admin.ac.delete') }}';

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';

                const acIdInput = document.createElement('input');
                acIdInput.type = 'hidden';
                acIdInput.name = 'AC_ID';
                acIdInput.value = acId;

                form.appendChild(csrfToken);
                form.appendChild(acIdInput);
                document.body.appendChild(form);
                form.submit();
            }
        });
    });

});
</script>
@endpush


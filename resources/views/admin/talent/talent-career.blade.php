<link rel="stylesheet" href="{{ asset('css/admin-common.css') }}">

<main>
    <div class="form-area">
        <div class="form-area-common">
            <h2>タレント経歴登録・編集</h2>
            <p>※優先度の数字は小さいほど先に表示される。設定しなかった場合（空欄）は最後に表示。</p>
            <form id="adminForm" onsubmit="return checkSubmit('登録');" action="{{ route('admin.talent.career.store') }}"
                method="POST">
                @csrf
                <input type="hidden" name="TALENT_ID" value="{{ $talent->TALENT_ID }}">
                <input type="hidden" name="CAREER_ID" id="CAREER_ID">

                <div class="form-group">
                    <label for="CAREER_CATEGORY_ID">経歴カテゴリ<span class="required">※必須</span></label>
                    <select name="CAREER_CATEGORY_ID" id="CAREER_CATEGORY_ID" required>
                        @foreach ($careerCategories as $select)
                        <option value="{{ $select['CAREER_CATEGORY_ID'] }}">
                            {{ $select['CAREER_CATEGORY_NAME'] }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="CONTENT">経歴内容<span class="required">※必須</span></label>
                    <textarea id="CONTENT" name="CONTENT" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="ACTIVE_DATE">活動日</label>
                    <div class="check-box">
                        <label class="checkbox-label">
                            <input type="radio" name="SPARE2" value="0" required/>
                            日付指定なし
                        </label>
                        <label class="checkbox-label">
                            <input type="radio" name="SPARE2" value="1" required/>
                            年月日を表示
                        </label>
                        <label class="checkbox-label">
                            <input type="radio" name="SPARE2" value="2" required/>
                            年月を表示
                        </label>
                        <label class="checkbox-label">
                            <input type="radio" name="SPARE2" value="3" required/>
                            年を表示
                        </label>
                    </div>
                    <input type="date" id="ACTIVE_DATE" name="ACTIVE_DATE" >
                </div>
                <div class="form-group">
                    <label for="SPARE1">優先度<span class="required"></span></label>
                    <input type="number" id="SPARE1" name="SPARE1" >
                </div>
                <div class="form-group">
                    <label for="DETAIL">経歴詳細</label>
                    <textarea id="DETAIL" name="DETAIL" rows="5"></textarea>
                </div>
                <div class="btn-area">
                    <button type="submit" class="btn btn-primary" id="submitBtn">登録</button>
                    <button type="button" class="btn btn-secondary" onclick="resetForm()">リセット</button>
                </div>
            </form>
        </div>
        <div class="list-area">
            <h2>経歴一覧</h2>
            <form action="{{ route('admin.talent.career.entry') }}" method="POST">
                @csrf
                <div class="check-box">
                    <div class="form-group">
                        <label for="CAREER_CATEGORY_ID">経歴カテゴリを選択<span class="required"></span></label>
                        <select name="FILTER" id="FILTER" >
                            <option value="ALL">
                                全て
                            </option>
                            @foreach ($careerCategories as $select)
                            <option value="{{ $select['CAREER_CATEGORY_ID'] }}" {{ session('careerFilter') == $select['CAREER_CATEGORY_ID'] ? 'selected' : '' }}>
                                {{ $select['CAREER_CATEGORY_NAME'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="submit-button">フィルター</button>
            </form>
            <br>
            <table class="table-container">
                <thead>
                    <tr>
                        <th>優先度</th>
                        <th>活動日</th>
                        <th>経歴カテゴリ</th>
                        <th>経歴内容</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($talentCareer as $career)
                    <tr>
                        <td>{{ $career->SPARE1 }}</td>
                        <td>{{ $career->ACTIVE_DATE }}</td>
                        <td>{{ $career->CAREER_CATEGORY_NAME }}</td>
                        <td>{!! nl2br(e($career->CONTENT)) !!}</td>
                        <td>
                            <button class="btn btn-edit" onclick='editItem({!! json_encode($career) !!})'>編集</button>
                            <form onsubmit="return checkSubmit('削除');"
                                action="{{ route('admin.talent.career.delete') }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="TALENT_ID" value="{{ $talent->TALENT_ID }}">
                                <input type="hidden" name="CAREER_ID" value="{{ $career->CAREER_ID }}">
                                <button type="submit" class="btn btn-delete">削除</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>

@push('scripts')
<script src="{{ asset('js/admin-script.js') }}"></script>
<script>
var itemName = '経歴';

function editItem(item) {
    document.getElementById('CAREER_ID').value = item.CAREER_ID;
    document.getElementById('CAREER_CATEGORY_ID').value = item.CAREER_CATEGORY_ID;
    document.getElementById('CONTENT').value = item.CONTENT;
    document.getElementById('ACTIVE_DATE').value = item.ACTIVE_DATE;
    document.getElementById('SPARE1').value = item.SPARE1;
    let spare2 = document.querySelectorAll("input[name=SPARE2]");
    for(let element of spare2) {
        if( element.value == item.SPARE2 ) {
            element.checked = true;
        }
    }
    document.getElementById('DETAIL').value = item.DETAIL;
    document.getElementById('adminForm').method = "POST";
    document.getElementById('adminForm').action = "{{ route('admin.talent.career.update') }}";
    document.getElementById('submitBtn').textContent = '更新';

    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

function resetForm() {
    document.getElementById('adminForm').reset();
    document.getElementById('CAREER_ID').value = '';
    document.getElementById('adminForm').action = "{{ route('admin.talent.career.store') }}";
    document.getElementById('submitBtn').textContent = '登録';
}
</script>
@endpush

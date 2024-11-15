<main>
    <div class="form-area">
        <h2>経歴カテゴリ登録・削除</h2>
        <br>
        <h3>◆経歴カテゴリ登録</h3>
        <form action="{{ route('admin.career.entry') }}" onsubmit="return checkSubmit('登録');" method="POST">
            @csrf
            <div class="form-group">
                <label for="CAREER_CATEGORY_NAME">経歴カテゴリ名<span class="required">※必須</span></label>
                <input type="text" id="CAREER_CATEGORY_NAME" name="CAREER_CATEGORY_NAME" required />
            </div>
            <button type="submit" class="submit-button">送信する</button>
        </form>

        <hr class="hr-line">
        <h3>◆経歴カテゴリ一覧</h3>
        <p>※スマホではカテゴリ名の変更ができません。</p><br>
        <table class="table-container edit">
            <thead>
                <th>カテゴリ名</th>
                <th class="btn-none"></th>
                <th></th>
            </thead>
            @foreach ($careerList as $career)
            <tr>
                <td>{{ $career->CAREER_CATEGORY_NAME }}</td>
                <form action="{{ route('admin.career.update', $career->CAREER_CATEGORY_ID) }}"
                    onsubmit="return checkSubmit('変更');" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="CAREER_CATEGORY_ID" value="{{ $career->CAREER_CATEGORY_ID }}">
                    <td class="btn-none">
                        <div class="form-group multi">
                            <input type="text" name="CAREER_CATEGORY_NAME" value="{{ $career->CAREER_CATEGORY_NAME }}">
                        </div>
                    </td>
                    <td class="btn-none">
                        <button type="submit" class="btn btn-edit">変更する</button>
                    </td>
                </form>
                <td>
                    <form action="{{ route('admin.career.delete') }}" onsubmit="return checkSubmit('削除');"
                        method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="CAREER_CATEGORY_ID" value="{{ $career->CAREER_CATEGORY_ID }}">
                        <button type="submit" class="btn btn-delete">削除する</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</main>

@push('scripts')
<script src="{{ asset('js/admin-script.js') }}"></script>
@endpush
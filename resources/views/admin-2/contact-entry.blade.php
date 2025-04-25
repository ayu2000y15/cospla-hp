<main>
    <div class="form-area">
        <h2>問い合わせカテゴリ登録・削除</h2>
        <br>
        <h3>◆問い合わせカテゴリ登録</h3>
        <form action="{{ route('admin.contact.entry') }}" onsubmit="return checkSubmit('登録');" method="POST">
            @csrf
            <div class="form-group">
                <label for="CONTACT_CATEGORY_NAME">問い合わせカテゴリ名<span class="required">※必須</span></label>
                <input type="text" id="CONTACT_CATEGORY_NAME" name="CONTACT_CATEGORY_NAME" required />
            </div>
            <div class="form-group">
                <label for="REFERENCE_CODE">問い合わせコード ※問い合わせ番号の頭の文字列<span class="required">※必須</span></label>
                <input type="text" maxlength="2" id="REFERENCE_CODE" name="REFERENCE_CODE" required />
            </div>
            <button type="submit" class="submit-button">送信する</button>
        </form>

        <hr class="hr-line">
        <h3>◆経歴カテゴリ一覧</h3>
        <p>※スマホではカテゴリ名の変更ができません。</p><br>
        <table class="table-container edit">
            <thead>
                <th>カテゴリ名</th>
                <th>問い合わせコード</th>
                <th class="btn-none"></th>
                <th></th>
            </thead>
            @foreach ($contactList as $contact)
            <tr>
                <td>{{ $contact->CONTACT_CATEGORY_NAME }}</td>
                <form action="{{ route('admin.contact.update', $contact->CONTACT_CATEGORY_ID) }}"
                    onsubmit="return checkSubmit('変更');" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="CONTACT_CATEGORY_ID" value="{{ $contact->CONTACT_CATEGORY_ID }}">
                    <td class="btn-none">
                        <div class="form-group multi">
                            <input type="text" name="CONTACT_CATEGORY_NAME" value="{{ $contact->CONTACT_CATEGORY_NAME }}">
                        </div>
                    </td>
                    <td class="btn-none">
                        <div class="form-group multi">
                            <p>{{ $contact->REFERENCE_CODE }}</p>
                        </div>
                    </td>
                    <td class="btn-none">
                        <button type="submit" class="btn btn-edit">変更する</button>
                    </td>
                </form>
                <td>
                    <form action="{{ route('admin.contact.delete') }}" onsubmit="return checkSubmit('削除');"
                        method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="CONTACT_CATEGORY_ID" value="{{ $contact->CONTACT_CATEGORY_ID }}">
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

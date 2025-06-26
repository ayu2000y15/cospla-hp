<main>
    <div class="form-area">
        <h2>ハッシュタグ登録・削除</h2>

        <p>※タレントに紐つくハッシュタグはタレント編集より行ってください。<br>
            　ここでは新しいハッシュタグの登録や削除が行えます。</p>
        <br>
        <h3>◆タグを新しく作成</h3>
        <form action="{{ route('admin.tag.store') }}" onsubmit="return checkSubmit('登録');" method="POST">
            @csrf
            <div class="form-group">
                <label for="TAG_NAME">タグ名<span class="required"></span></label>
                <input type="text" id="TAG_NAME" name="TAG_NAME" placeholder="Vtuber" required />
            </div>
            <div class="form-group">
                <label for="TAG_COLOR">カラー<span class="required">※HPに表示されるときに使用します</span></label>
                <div class="color-input-wrapper">
                    <input type="color" id="TAG_COLOR" name="TAG_COLOR" value="#999999" required />
                    <div id="colorPreview" class="color-preview">サンプル</div>
                </div>
                <p>※文字色は白になります。</p>
            </div>
            <button type="submit" class="submit-button">送信する</button>
        </form>

        <hr class="hr-line">
        <h3>◆タグ一覧</h3>

        <table class="tag-table">
            <div class="tag-container">
                @foreach ($tagList as $tag)
                <tr>
                    <td>
                        <span class="tag" style="background-color: {{ $tag->TAG_COLOR }}">
                            #{{ $tag->TAG_NAME }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin.tag.delete', $tag->TAG_ID) }}"onsubmit="return checkSubmit('削除');"  method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete">削除する</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </div>
        </table>
    </div>
</main>

@push('scripts')
<script src="{{ asset('js/admin-script.js') }}"></script>
@endpush
@push('scripts')
<script>
document.getElementById('TAG_COLOR').addEventListener('input', function(e) {
    document.getElementById('colorPreview').style.backgroundColor = e.target.value;
});
</script>
@endpush
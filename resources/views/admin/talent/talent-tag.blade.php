<main>
    <div class="form-area">
        <h2>ハッシュタグ登録・変更</h2>

        <h3>◆登録済みのハッシュタグ一覧</h3>

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
                        <form onsubmit="return checkSubmit('削除');" action="{{ route('admin.talent.tag.delete') }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="TALENT_ID" value="{{ $talent->TALENT_ID }}">
                            <input type="hidden" name="TAG_ID" value="{{ $tag->TAG_ID }}">
                            <button type="submit" class="btn btn-delete">削除する</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </div>
        </table>

        <hr class="hr-line">
        <h3>◆既存のタグから選択</h3>
        <form onsubmit="return checkSubmit('登録');" action="{{ route('admin.talent.tag.add') }}" method="POST">
            @csrf
            <input type="hidden" name="TALENT_ID" value="{{ $talent->TALENT_ID }}">
            <div class="form-group">
                <select id="TAG_ID" name="TAG_ID">
                    @foreach ($tagNotList as $tag)

                    <option value="{{ $tag->TAG_ID }}">
                        {{ $tag->TAG_NAME }}
                    </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="submit-button">送信する</button>
        </form>

        <hr class="hr-line">
        <h3>◆タグを新しく作成</h3>
        <p>※タグを作成後、上記から選択して登録してください。</p>
        <form onsubmit="return checkSubmit('登録');" action="{{ route('admin.tag.store') }}" method="POST">
            @csrf
            <input type="hidden" name="TALENT_ID" value="{{ $talent->TALENT_ID }}">
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
    </div>
</main>

@push('scripts')
<script src="{{ asset('js/admin-script.js') }}"></script>
<script>
document.getElementById('TAG_COLOR').addEventListener('input', function(e) {
    document.getElementById('colorPreview').style.backgroundColor = e.target.value;
});
</script>
@endpush
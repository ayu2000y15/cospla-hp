<link rel="stylesheet" href="{{ asset('css/admin-common.css') }}">

<main>
    <div class="form-area">
        <div class="form-area-common">
            <h2>ニュース登録・編集</h2>
            <form id="adminForm" action="{{ route('admin.news.store') }}" onsubmit="return checkSubmit('登録');" method="POST">
                @csrf
                <input type="hidden" name="NEWS_ID" id="NEWS_ID">
                <div class="form-group">
                    <label for="TITLE">タイトル</label>
                    <input type="text" id="TITLE" name="TITLE" required>
                </div>
                <div class="form-group">
                    <label for="POST_DATE">投稿日</label>
                    <input type="date" id="POST_DATE" name="POST_DATE" required>
                </div>
                <div class="form-group">
                    <label for="CONTENT">詳細</label>
                    <textarea id="CONTENT" name="CONTENT" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary" id="submitBtn">登録</button>
                <button type="button" class="btn btn-secondary" onclick="resetForm()">リセット</button>
            </form>
        </div>
        <div class="list-area">
            <h2>ニュース一覧</h2>
            <table class="table-container">
                <thead>
                    <tr>
                        <th>投稿日</th>
                        <th>タイトル</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($newsList as $news)
                    <tr>
                        <td>{{ $news->POST_DATE }}</td>
                        <td>{{ $news->TITLE }}</td>
                        <td>
                            <button class="btn btn-edit" onclick='editItem({!! json_encode($news) !!})'>編集</button>
                            <form action="{{ route('admin.news.delete', $news->NEWS_ID) }}" onsubmit="return checkSubmit('削除');" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
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
@endpush
@push('scripts')
<script>
var itemName = 'ニュース';

function editItem(item) {
    document.getElementById('NEWS_ID').value = item.NEWS_ID;
    document.getElementById('TITLE').value = item.TITLE;
    document.getElementById('POST_DATE').value = item.POST_DATE;
    document.getElementById('CONTENT').value = item.CONTENT;
    document.getElementById('adminForm').action = "{{ route('admin.news.update', '') }}/" + item.NEWS_ID;
    document.getElementById('submitBtn').textContent = '更新';

    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

function resetForm() {
    document.getElementById('adminForm').reset();
    document.getElementById('NEWS_ID').value = '';
    document.getElementById('adminForm').action = "{{ route('admin.news.store') }}";
    document.getElementById('submitBtn').textContent = '登録';
}
</script>
@endpush
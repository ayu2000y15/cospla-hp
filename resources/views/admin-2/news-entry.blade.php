<link rel="stylesheet" href="{{ asset('css/admin-common.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin-photos.css') }}">

<main>
    <div class="form-area">
        <div class="form-area-common">
            <h2>ニュース登録・編集</h2>
            <form id="adminForm" action="{{ route('admin.news.store') }}" enctype="multipart/form-data" onsubmit="return checkSubmit('登録');"
                method="POST">
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
                <div class="form-group">
                    <div class="photo-upload-section">
                        <label for="photo-upload">画像選択</label>
                        <p>※最大5Mまで。それ以上大きいファイルはアップロードできません。</p>
                        <div class="file-upload-wrapper">
                            <input type="file" name="upfile[]" id="photo-upload" class="file-upload-input" multiple
                                accept="image/*" onchange="updateFileNames(this)">
                            <label for="photo-upload" class="file-upload-label">写真を選択</label>
                        </div>
                        <div id="selected-files" class="selected-files"></div>
                    </div>
                </div>
                <div class="form-group" id="current-images-section" style="display: none;">
                    <label>現在の画像</label>
                    <div id="current-images-container" class="news-photos-container">
                        <!-- 現在の画像はJavaScriptで読み込まれます -->
                    </div>
                </div>
                <div class="btn-area">
                    <button type="submit" class="btn btn-primary" id="submitBtn">登録</button>
                    <button type="button" class="btn btn-secondary" onclick="resetForm()">リセット</button>
                </div>
            </form>
        </div>
        <div class="list-area">
            <h2>ニュース一覧</h2>
            <table class="table-container">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>投稿日</th>
                        <th>タイトル</th>
                        <th></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($newsList as $news)
                    <tr>
                        <td>{{ $news->NEWS_ID }}</td>
                        <td>{{ $news->POST_DATE }}</td>
                        <td>{{ $news->TITLE }}</td>
                        <td>
                            <div class="news-photos-container">
                                @foreach ($newsImgList as $img)
                                    @if($news->NEWS_ID == $img->NEWS_ID)
                                    {{-- <form action="{{ route('admin.news.priority') }}" method="post">
                                        @csrf
                                        <div class="form-group-priority">
                                            <label for="PRIORITY">優先度</label>
                                            <input type="hidden" name="FILE_NAME" value="{{ $img->FILE_NAME }}">
                                            <input type="number" id="PRIORITY" style="width: 40px;" name="PRIORITY" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary" id="submitBtn">優先度設定</button>
                                    </form> --}}
                                    <img class="news-photo"
                                        src="{{ asset($img->FILE_PATH . $img->FILE_NAME) }}"
                                        alt="{{ $img->COMMENT }}"
                                        data-img-id="{{ $img->IMG_ID }}"
                                        onclick="openImagePreview(this.src)">
                                    @endif
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-edit" onclick='editItem({!! json_encode($news) !!})'>編集</button>
                            <form action="{{ route('admin.news.delete', $news->NEWS_ID) }}"
                                onsubmit="return checkSubmit('削除');" method="POST" style="display: inline;">
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

<div id="imagePreviewModal">
    <span class="modal-close" onclick="closeImagePreview()">&times;</span>
    <img id="previewImage">
</div>

<script>
    var adminNewsImagesUrl = "{{ route('admin.news.images', ':id') }}";
</script>

@push('scripts')
<script src="{{ asset('js/admin-script.js') }}"></script>
<script>
var itemName = 'ニュース';

function editItem(item) {
    document.getElementById('NEWS_ID').value = item.NEWS_ID;
    document.getElementById('TITLE').value = item.TITLE;
    document.getElementById('POST_DATE').value = item.POST_DATE;
    document.getElementById('CONTENT').value = item.CONTENT;
    //document.getElementById('PRIORITY').value = item.PRIORITY;
    document.getElementById('adminForm').action = "{{ route('admin.news.update', '') }}/" + item.NEWS_ID;
    document.getElementById('submitBtn').textContent = '更新';

    document.getElementById('selected-files').innerHTML = '';

    const currentImagesNote = document.createElement('div');
    currentImagesNote.className = 'current-images-note';
    currentImagesNote.innerHTML = '<p>現在の画像は保持されます。新しい画像を選択すると追加されます。</p>';
    document.getElementById('selected-files').appendChild(currentImagesNote);

    if (!document.getElementById('edit-mode')) {
        const editModeInput = document.createElement('input');
        editModeInput.type = 'hidden';
        editModeInput.id = 'edit-mode';
        editModeInput.name = 'edit_mode';
        editModeInput.value = '1';
        document.getElementById('adminForm').appendChild(editModeInput);
    }

    loadCurrentImages(item.NEWS_ID);

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
    document.getElementById('selected-files').innerHTML = '';

    const editModeInput = document.getElementById('edit-mode');
    if (editModeInput) {
        editModeInput.remove();
    }

    document.getElementById('current-images-section').style.display = 'none';
}

function openImagePreview(imgSrc) {
    const modal = document.getElementById('imagePreviewModal');
    const modalImg = document.getElementById('previewImage');
    modal.style.display = 'block';
    modalImg.src = imgSrc;
}

function closeImagePreview() {
    document.getElementById('imagePreviewModal').style.display = 'none';
}

function updateFileNames(input) {
    const selectedFilesDiv = document.getElementById('selected-files');
    selectedFilesDiv.innerHTML = '';

    if (input.files.length > 0) {
        const fileList = document.createElement('ul');
        fileList.className = 'file-list';

        let totalSize = 0;

        for (let i = 0; i < input.files.length; i++) {
            const file = input.files[i];
            const listItem = document.createElement('li');

            // ファイルサイズを計算
            const fileSize = file.size / 1024; // KBに変換
            let fileSizeStr;
            if (fileSize >= 1024) {
                fileSizeStr = (fileSize / 1024).toFixed(2) + ' MB';
            } else {
                fileSizeStr = fileSize.toFixed(2) + ' KB';
            }

            listItem.innerHTML = `
                <span class="file-name">${file.name}</span>
                <span class="file-size">(${fileSizeStr})</span>
            `;
            fileList.appendChild(listItem);
        }

        selectedFilesDiv.appendChild(fileList);

        // 5MB制限の警告
        if (fileSize > 5 * 1024 * 1024) {
            const warningElement = document.createElement('p');
            warningElement.className = 'size-warning';
            warningElement.textContent = '警告: サイズが5MBを超えています。アップロードできない場合があります。';
            selectedFilesDiv.appendChild(warningElement);
        }
    }

    if (document.getElementById('edit-mode')) {
        const editNote = document.createElement('p');
        editNote.className = 'edit-note';
        editNote.textContent = '※ 選択した画像は既存の画像に追加されます';
        selectedFilesDiv.appendChild(editNote);
    }
}

async function loadCurrentImages(newsId) {
    try {
        const url = adminNewsImagesUrl.replace(':id', newsId);
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error('画像の取得に失敗しました');
        }

        const images = await response.json();
        const container = document.getElementById('current-images-container');
        container.innerHTML = '';

        if (images.length > 0) {
            document.getElementById('current-images-section').style.display = 'block';

            images.forEach(img => {
                const imgWrapper = document.createElement('div');
                imgWrapper.className = 'image-wrapper';

                const imgElement = document.createElement('img');
                imgElement.className = 'news-photo';
                imgElement.src = `{{ asset('') }}${img.FILE_PATH}${img.FILE_NAME}`;
                imgElement.alt = img.COMMENT || '';
                imgElement.dataset.imgId = img.FILE_NAME;
                imgElement.onclick = () => openImagePreview(imgElement.src);

                const deleteBtn = document.createElement('button');
                deleteBtn.type = 'button';
                deleteBtn.className = 'image-delete-btn';
                deleteBtn.innerHTML = '×';
                deleteBtn.onclick = () => confirmDeleteImage(img.FILE_NAME);

                imgWrapper.appendChild(imgElement);
                imgWrapper.appendChild(deleteBtn);
                container.appendChild(imgWrapper);
            });
        } else {
            document.getElementById('current-images-section').style.display = 'none';
        }
    } catch (error) {
        console.error('画像読み込みエラー:', error);
    }
}

function confirmDeleteImage(imgId) {
    if (confirm('この画像を削除してもよろしいですか？')) {
        deleteImage(imgId);
    }
}

async function deleteImage(imgId) {
    try {
        const response = await fetch(`{{ route('admin.news.deleteImage', '') }}/${imgId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
        });

        if (!response.ok) {
            throw new Error('画像の削除に失敗しました');
        }

        const result = await response.json();

        if (result.success) {
            // UIから画像を削除
            const imageElement = document.querySelector(`.news-photo[data-img-id="${imgId}"]`);
            if (imageElement) {
                imageElement.parentElement.remove();
            }

            // 削除用の隠しフィールドを追加（フォーム送信時のバックアップとして）
            const deleteInput = document.createElement('input');
            deleteInput.type = 'hidden';
            deleteInput.name = 'delete_images[]';
            deleteInput.value = imgId;
            document.getElementById('adminForm').appendChild(deleteInput);

            // 全ての画像が削除された場合、セクションを非表示にする
            if (document.getElementById('current-images-container').children.length === 0) {
                document.getElementById('current-images-section').style.display = 'none';
            }

        } else {
            throw new Error(result.message || '画像の削除に失敗しました');
        }
    } catch (error) {
        console.error('画像削除エラー:', error);
        alert(error.message);
    }
}

window.onclick = function(event) {
    const modal = document.getElementById('imagePreviewModal');
    if (event.target == modal) {
        closeImagePreview();
    }
}
</script>
@endpush

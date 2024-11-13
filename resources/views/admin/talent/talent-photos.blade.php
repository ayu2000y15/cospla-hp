<link rel="stylesheet" href="{{ asset('css/admin-photos.css') }}">

<main>
    <div class="form-area">
        <h2 class="section-title">タレント写真登録・変更</h2>

        <!-- 写真登録 -->
        <div class="photo-upload-section">
            <h3 class="subsection-title">◆写真新規登録</h3>
            <p>※最大5Mまで。それ以上大きいファイルはアップロードできません。</p>
            <form onsubmit="return checkSubmit('登録');" action="{{ route('admin.talent.photos.upload') }}" method="POST" enctype="multipart/form-data" class="upload-form">
            @csrf
            <input type="hidden" name="TALENT_ID" value="{{ $talent->TALENT_ID }}">
            <input type="hidden" name="LAYER_NAME" value="{{ $talent->LAYER_NAME }}">

                <div class="file-upload-wrapper">
                    <input type="file" name="photos[]" id="photo-upload" class="file-upload-input" multiple onchange="updateFileNames(this)">
                    <label for="photo-upload" class="file-upload-label">写真を選択</label>
                </div>
                <div id="selected-files" class="selected-files"></div>
                <button type="submit" class="submit-button">アップロード</button>
            </form>
        </div>

        <hr class="hr-line">
        <!-- 写真一覧 -->
        <div class="photo-list-section">
            <h3 class="subsection-title">◆登録済みの写真一覧</h3>
            <div class="photo-grid">
                @foreach ($talentImgList as $img)
                <div class="photo-item">
                    <img class="photo-thumbnail" src="{{ asset($img->FILE_PATH . $img->FILE_NAME) }}" alt="{{ $img->COMMENT }}" onclick="openImagePreview(this.src)">
                    <div class="photo-actions">
                        <form onsubmit="return checkSubmit('変更');" action="{{ route('admin.talent.photos.update') }}" method="POST" class="change-form">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="TALENT_ID" value="{{ $talent->TALENT_ID }}">
                            <input type="hidden" name="FILE_NAME" value="{{ $img->FILE_NAME }}">
                            <div class="select-wrapper">
                                <select name="VIEW_FLG" class="view-select">
                                    @foreach ($viewFlags as $select)
                                    <option value="{{ $select->VIEW_FLG }}" {{ $select->VIEW_FLG == $img->VIEW_FLG ? 'selected' : '' }}>
                                        {{ $select->COMMENT }}
                                    </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="change-button">変更</button>
                            </div>
                        </form>
                        <form onsubmit="return checkSubmit('削除');" action="{{ route('admin.talent.photos.delete') }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="TALENT_ID" value="{{ $talent->TALENT_ID }}">
                            <input type="hidden" name="FILE_NAME" value="{{ $img->FILE_NAME }}">
                            <button type="submit" class="delete-button">削除</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Image Preview Modal -->
    <div id="imagePreviewModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="previewImage">
    </div>
</main>

@push('scripts')
<script src="{{ asset('js/admin-script.js') }}"></script>
<script>
function updateFileNames(input) {
    const filesDiv = document.getElementById('selected-files');
    filesDiv.innerHTML = '';
    if (input.files && input.files.length > 0) {
        const fileList = document.createElement('ul');
        fileList.className = 'file-list';
        for (let i = 0; i < input.files.length; i++) {
            const li = document.createElement('li');
            const file = input.files[i];
            const fileSize = (file.size / 1024 / 1024).toFixed(2); // サイズをMBに変換
            li.textContent = `${file.name} (${fileSize} MB)`;
            fileList.appendChild(li);
        }
        filesDiv.appendChild(fileList);
    }
}

// Image Preview Modal
function openImagePreview(imgSrc) {
    const modal = document.getElementById('imagePreviewModal');
    const modalImg = document.getElementById('previewImage');
    modal.style.display = 'block';
    modalImg.src = imgSrc;
}

const modal = document.getElementById('imagePreviewModal');
const span = document.getElementsByClassName('close')[0];

span.onclick = function() {
    modal.style.display = 'none';
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>
@endpush
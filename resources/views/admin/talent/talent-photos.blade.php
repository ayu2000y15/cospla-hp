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
            <form action="{{ route('admin.talent.photos.bulkUpdate') }}" method="POST" id="bulkUpdateForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="TALENT_ID" value="{{ $talent->TALENT_ID }}">
                <div class="bulk-update-controls">
                    <div class="select-all-wrapper">
                        <input type="checkbox" id="selectAll" class="select-all-checkbox">
                        <label for="selectAll">全選択/全解除</label>
                    </div>
                    <div class="bulk-actions">
                        <select name="BULK_VIEW_FLG" class="bulk-view-select">
                            @foreach ($viewFlags as $flag)
                            <option value="{{ $flag->VIEW_FLG }}">{{ $flag->COMMENT }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bulk-update-button">一括変更</button>
                    </div>
                </div>
                <div class="photo-grid">
                    @foreach ($talentImgList as $img)
                    <div class="photo-item">
                        <div class="photo-checkbox-wrapper">
                            <input type="checkbox" name="SELECTED_PHOTOS[]" value="{{ $img->FILE_NAME }}" class="photo-checkbox" id="photo-{{ $img->FILE_NAME }}">
                            <label for="photo-{{ $img->FILE_NAME }}" class="photo-checkbox-label"></label>
                        </div>
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
            </form>
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

// 一括変更機能
document.addEventListener('DOMContentLoaded', function() {
    const bulkUpdateForm = document.getElementById('bulkUpdateForm');
    const bulkUpdateButton = document.querySelector('.bulk-update-button');
    const selectAllCheckbox = document.getElementById('selectAll');
    const photoCheckboxes = document.querySelectorAll('.photo-checkbox');

    bulkUpdateButton.addEventListener('click', function(e) {
        e.preventDefault();
        const selectedPhotos = document.querySelectorAll('input[name="SELECTED_PHOTOS[]"]:checked');
        if (selectedPhotos.length === 0) {
            alert('変更する写真を選択してください。');
            return;
        }
        if (confirm('選択した写真を一括で変更しますか？')) {
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
});
</script>
@endpush
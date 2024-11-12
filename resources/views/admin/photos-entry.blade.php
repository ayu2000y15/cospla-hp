<link rel="stylesheet" href="{{ asset('css/admin-photos.css') }}">

<main>
    <div class="form-area">
        <h2>HP画像登録・変更</h2>
        <div class="action-buttons">
            <button class="button photos-button active">タレント以外</button>
            <button class="button talent-button">TOPページのタレント</button>
        </div>
        <div class="photos-info">
            <!-- 写真登録 -->
            <div class="photo-upload-section">
                <h3 class="subsection-title">◆写真新規登録</h3>
                <p>※最大5Mまで。それ以上大きいファイルはアップロードできません。</p>
                <form action="{{ route('admin.photos.upload') }}" onsubmit="return checkSubmit('登録');" method="POST" enctype="multipart/form-data"
                    class="upload-form">
                    @csrf
                    <div class="file-upload-wrapper">
                        <input type="file" name="upfile[]" id="photo-upload" class="file-upload-input" multiple
                        accept="image/*" onchange="updateFileNames(this)">
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
                <p>TOPページのCOSPLAYは6枚まで設定可</p>
                <div class="photo-grid">
                    @foreach ($imgList as $img)
                    <div class="photo-item">
                        <img class="photo-thumbnail" src="{{ asset($img->FILE_PATH . $img->FILE_NAME) }}"
                            alt="{{ $img->COMMENT }}" onclick="openImagePreview(this.src)">
                        <div class="photo-actions">
                            <form action="{{ route('admin.photos.update') }}" onsubmit="return checkSubmit('変更');" method="POST" class="change-form">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="FILE_NAME" value="{{ $img->FILE_NAME }}">
                                <input type="hidden" name="VIEW_FLG_BEF" value="{{ $img->VIEW_FLG }}">

                                <div class="select-wrapper">
                                    <label>優先度(数字が若いほど優先度高)
                                        <input type="number" name="PRIORITY" value="{{ $img->PRIORITY }}">
                                    </label>
                                    <select name="VIEW_FLG_AFT" class="view-select">
                                        @foreach ($viewFlags as $flag)
                                        <option value="{{ $flag->VIEW_FLG }}"
                                            {{ $flag->VIEW_FLG == $img->VIEW_FLG ? 'selected' : '' }}>
                                            {{ $flag->COMMENT }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="change-button">変更</button>
                                </div>
                            </form>
                            <form action="{{ route('admin.photos.delete') }}" onsubmit="return checkSubmit('削除');" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="FILE_NAME" value="{{ $img->FILE_NAME }}">
                                <input type="hidden" name="VIEW_FLG" value="{{ $img->VIEW_FLG }}">
                                <button type="submit" class="delete-button">削除</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="talent-info" style="display: none;">
            <h3>TOPページのタレント選択</h3>
            <p>※1~4の数字を入れて登録ボタンを押下してください。</p>
            <div class="photo-grid">
                @foreach ($talentImgList as $img)
                <div class="photo-item">
                    <img class="photo-thumbnail" src="{{ asset($img->FILE_PATH . $img->FILE_NAME) }}"
                        alt="{{ $img->COMMENT }}" onclick="openImagePreview(this.src)">
                    <div class="photo-actions">
                        <form action="{{ route('admin.photos.update') }}" onsubmit="return checkSubmit('変更');" method="POST" class="change-form">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="FILE_NAME" value="{{ $img->FILE_NAME }}">
                            <input type="hidden" name="VIEW_FLG_BEF" value="{{ $img->VIEW_FLG }}">
                            <input type="hidden" name="VIEW_FLG_AFT" value="{{ $img->VIEW_FLG }}">

                            <div class="select-wrapper">
                                <label>{{ $img->LAYER_NAME }}</label>
                                <label>優先度(数字が若いほど優先度高 1~4までのみ)<br>
                                    <input type="number" name="PRIORITY" value="{{ $img->PRIORITY }}">
                                </label>
                                <button type="submit" class="change-button">変更</button>
                            </div>
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
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const talentButton = document.querySelector('.talent-button');
    const photosButton = document.querySelector('.photos-button');
    const talentInfo = document.querySelector('.talent-info');
    const photosInfo = document.querySelector('.photos-info');

    function hideAllSections() {
        talentInfo.style.display = 'none';
        photosInfo.style.display = 'none';
        talentButton.classList.remove('active');
        photosButton.classList.remove('active');
    }

    talentButton.addEventListener('click', function() {
        hideAllSections();
        talentInfo.style.display = 'block';
        talentButton.classList.add('active');
    });

    photosButton.addEventListener('click', function() {
        hideAllSections();
        photosInfo.style.display = 'block';
        photosButton.classList.add('active');
        updateSliderLayout();
    });

    hideAllSections();
    photosInfo.style.display = 'block';
    photosButton.classList.add('active');
});
</script>
@endpush
<link rel="stylesheet" href="{{ asset('css/admin-photos.css') }}">

<main>
    <div class="form-area">
        <h2>HP画像登録・変更</h2>
        <div class="action-buttons">
            <button class="button photos-button active" >タレント以外</button>
            <button class="button talent-button ">タレント</button>
        </div>
        <div class="photos-info">
            <!-- 写真登録 -->
            <div class="photo-upload-section">
                <h3 class="subsection-title">◆写真新規登録</h3>
                <p>※最大5Mまで。それ以上大きいファイルはアップロードできません。</p>
                <form action="{{ route('admin.photos.upload') }}" onsubmit="return checkSubmit('登録');" method="POST"
                    enctype="multipart/form-data" class="upload-form">
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
                <p>※優先度の数字は小さいほど先に表示される。設定しなかった場合（空欄）は最後に表示。</p>
                <p>※TOPページのCOSPLAYは6枚まで設定可</p>
                <br>
                <form action="{{ route('admin.photos.entry') }}" method="POST">
                    @csrf
                    <div class="check-box">
                        <label class="checkbox-label">
                            @if(session('filter') === 'ALL' || session('filter') == null )
                            <input type="radio" name="FILTER" value="ALL" checked />
                            @else
                            <input type="radio" name="FILTER" value="ALL" />
                            @endif
                            全て
                        </label>
                        <label class="checkbox-label">
                            <input type="radio" name="FILTER" value="00"
                                {{ session('filter') === '00' ? 'checked' : '' }} />
                            非公開
                        </label>
                        <label class="checkbox-label">
                            <input type="radio" name="FILTER" value="S201"
                                {{ session('filter') === 'S201' ? 'checked' : '' }} />
                            スライドバナー
                        </label>
                    </div>
                    <div class="check-box">
                        <label class="checkbox-label">
                            <input type="radio" name="FILTER" value="S203"
                                {{ session('filter') === 'S203' ? 'checked' : '' }} />
                            TOPページのCOSPLAY
                        </label>
                        <label class="checkbox-label">
                            <input type="radio" name="FILTER" value="S401"
                                {{ session('filter') === 'S401' ? 'checked' : '' }} />
                            COSPLAY上
                        </label>
                        <label class="checkbox-label">
                            <input type="radio" name="FILTER" value="S402"
                                {{ session('filter') === 'S402' ? 'checked' : '' }} />
                            COSPLAY下
                        </label>
                    </div>
                    <button type="submit" class="submit-button">フィルター</button>
                </form>
                <br>
                <form action="{{ route('admin.photos.bulkUpdate') }}" method="POST" id="bulkUpdateForm">
                    @csrf
                    @method('PUT')
                    <div class="bulk-update-controls">
                        <div class="select-all-wrapper">
                            <input type="checkbox" id="selectAll" class="select-all-checkbox">
                            <label for="selectAll">全選択/全解除</label>
                        </div>
                        <div class="bulk-actions">
                            <select name="BULK_VIEW_FLG" class="bulk-view-select">
                                @foreach ($viewFlagsBulk as $flag)
                                <option value="{{ $flag->VIEW_FLG }}">{{ $flag->COMMENT }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="bulk-update-button">一括変更</button>
                        </div>
                    </div>
                </form>

                <div class="photo-grid">
                    @foreach ($imgList as $img)
                    <div class="photo-item">
                        <div class="photo-checkbox-wrapper">
                            <input type="checkbox" name="SELECTED_PHOTOS[]" value="{{ $img->FILE_NAME }}"
                                class="photo-checkbox" form="bulkUpdateForm" id="photo-{{ $img->FILE_NAME }}">
                            <label for="photo-{{ $img->FILE_NAME }}" class="photo-checkbox-label"></label>
                        </div>
                        <img class="photo-thumbnail" src="{{ asset($img->FILE_PATH . $img->FILE_NAME) }}"
                            alt="{{ $img->COMMENT }}" onclick="openImagePreview(this.src)">
                        <div class="photo-actions">
                            <form action="{{ route('admin.photos.update') }}" onsubmit="return checkSubmit('変更');"
                                method="POST" class="change-form">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="FILE_NAME" value="{{ $img->FILE_NAME }}">
                                <input type="hidden" name="VIEW_FLG_BEF" value="{{ $img->VIEW_FLG }}">

                                <div class="select-wrapper">
                                    <label class="priority-label">
                                        優先度
                                        <input type="number" name="PRIORITY" value="{{ $img->PRIORITY }}"
                                            class="priority-input">
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
                            <form action="{{ route('admin.photos.delete') }}" onsubmit="return checkSubmit('削除');"
                                method="POST" class="delete-form">
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
            <h3>タレント優先度</h3>
            <p>※1以上の数字を入れて登録ボタンを押下してください。</p>
            <div class="photo-grid">
                @foreach ($talentImgList as $img)
                <div class="photo-item">
                    <img class="photo-thumbnail" src="{{ asset($img->FILE_PATH . $img->FILE_NAME) }}"
                        alt="{{ $img->COMMENT }}" onclick="openImagePreview(this.src)">
                    <div class="photo-actions">
                        <form action="{{ route('admin.photos.update') }}" onsubmit="return checkSubmit('変更');"
                            method="POST" class="change-form">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="FILE_NAME" value="{{ $img->FILE_NAME }}">
                            <input type="hidden" name="VIEW_FLG_BEF" value="{{ $img->VIEW_FLG }}">
                            <input type="hidden" name="VIEW_FLG_AFT" value="{{ $img->VIEW_FLG }}">

                            <div class="select-wrapper">
                                <label>{{ $img->LAYER_NAME }}</label>
                                <label class="priority-label">優先度(1~4はTOPページに表示されます）
                                    <input type="number" name="PRIORITY" value="{{ $img->PRIORITY }}" min="1"
                                        class="priority-input">
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
    });

    hideAllSections();
    photosInfo.style.display = 'block';
    photosButton.classList.add('active');

    // 一括変更機能の改善
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

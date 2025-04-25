@extends('layouts.admin')

@section('title', $master->title . ' - データ登録')

@section('content')
    @include('components.admin-page-header', [
        'title' => $master->title . ' - データ登録',
        'backUrl' => route('admin.content-data.master', ['masterId' => $master->master_id])
    ])

    @component('components.admin-card', ['title' => 'データ登録フォーム', 'icon' => 'plus-circle'])
        <form action="{{ route('admin.content-data.store', ['masterId' => $master->master_id]) }}" method="POST" class="data-form" enctype="multipart/form-data">
            @csrf

            @if(isset($master->schema) && is_array($master->schema))
                @php
                    // スキーマを表示順でソート
                    $sortedSchema = collect($master->schema)->sortBy('sort_order')->values()->all();
                @endphp

                <div class="card mb-4 border-primary">
                    <div class="card-header bg-primary bg-opacity-10">
                        <h6 class="mb-0 fw-bold">基本設定</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="sort_order" class="form-label fw-bold">表示順</label>
                                <input type="number" id="sort_order" name="sort_order" class="form-control" min="0" value="0">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">公開状態</label>
                                <div class="d-flex gap-4 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                                type="radio"
                                                name="public_flg"
                                                id="public_yes"
                                                value="1"
                                                checked>
                                        <label class="form-check-label" for="public_yes">
                                            <span class="badge bg-success">公開</span>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input"
                                                type="radio"
                                                name="public_flg"
                                                id="public_no"
                                                value="0">
                                        <label class="form-check-label" for="public_no">
                                            <span class="badge bg-secondary">非公開</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0 fw-bold">コンテンツ詳細</h6>
                    </div>
                    <div class="card-body">
                        @foreach($sortedSchema as $field)
                            @if($field['type'] == 'array')
                                <div class="row mb-4">
                                    <div class="col-md-8">
                                        <label for="{{ $field['col_name'] }}" class="form-label fs-5 mb-3">
                                            {{ $field['view_name'] }}
                                            @if($field['required_flg'] == '1')
                                                <span class="required badge bg-danger ms-2" style="color: white;">必須</span>
                                            @endif
                                        </label>
                                        <div class="array-field-container" data-field="{{ $field['col_name'] }}">
                                            <div class="array-items" id="array-items-{{ $field['col_name'] }}">
                                                <!-- 配列項目はJavaScriptで動的に追加されます -->
                                            </div>
                                            <button type="button" class="btn btn-sm btn-primary mt-2 add-array-item"
                                                    data-field="{{ $field['col_name'] }}"
                                                    data-array-items="{{ json_encode($field['array_items'] ?? []) }}">
                                                <i class="fas fa-plus"></i> 項目を追加
                                            </button>
                                        </div>
                                        @if($errors->has($field['col_name']))
                                            <div class="text-danger mt-1">
                                                {{ $errors->first($field['col_name']) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @elseif($field['type'] == 'file' || $field['type'] == 'files')
                                <div class="row mb-4">
                                    <div class="col-md-8">
                                        <label for="{{ $field['col_name'] }}" class="form-label fs-5 mb-3">
                                            {{ $field['view_name'] }}
                                            @if($field['required_flg'] == '1')
                                                <span class="required badge bg-danger ms-2" style="color: white;">必須</span>
                                            @endif
                                        </label>
                                        <div class="file-upload-container" data-field="{{ $field['col_name'] }}">
                                            <input type="file"
                                                id="{{ $field['col_name'] }}"
                                                name="{{ $field['col_name'] }}{{ $field['type'] == 'files' ? '[]' : '' }}"
                                                class="file-upload-input"
                                                accept="image/*"
                                                {{ $field['type'] == 'files' ? 'multiple' : '' }}
                                                {{ $field['required_flg'] == '1' ? 'required' : '' }}>
                                            <div class="file-upload-area" id="upload-area-{{ $field['col_name'] }}">
                                                <i class="fas fa-cloud-upload-alt fa-3x mb-3"></i>
                                                <p>ここに{{ $field['type'] == 'files' ? '複数の' : '' }}ファイルをドラッグするか、クリックして選択してください</p>
                                                <p class="text-muted small">対応形式: JPG, PNG, GIF (5MB以下)</p>
                                            </div>
                                            <div class="file-preview-container mt-3" id="preview-{{ $field['col_name'] }}"></div>
                                        </div>
                                        @if($errors->has($field['col_name']))
                                            <div class="text-danger mt-1">
                                                {{ $errors->first($field['col_name']) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                @include('components.form-field', [
                                    'name' => $field['col_name'],
                                    'label' => $field['view_name'],
                                    'type' => $field['type'],
                                    'required' => $field['required_flg'] == '1',
                                    'value' => old($field['col_name']),
                                    'options' => $field['options'] ?? [],
                                    'error' => $errors->first($field['col_name']),
                                    'arrayItems' => $field['array_items'] ?? []
                                ])
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.content-data.master', ['masterId' => $master->master_id]) }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i> キャンセル
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> 登録
                </button>
            </div>
        </form>
    @endcomponent
@endsection

@push('scripts')
    <script>
        // 一度だけ実行されるようにIIFEを使用
        (function() {
            // グローバル変数を避けるためにスコープを閉じる
            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOM Content Loaded - Initializing array handlers');

                // ファイルアップロード関連の初期化
                initFileUploads();

                // イベント委任を使用して、すべてのクリックイベントを一元管理
                document.addEventListener('click', handleDocumentClick);
            });

            // ファイルアップロード関連の初期化
            function initFileUploads() {
                const fileInputs = document.querySelectorAll('.file-upload-input');

                fileInputs.forEach(input => {
                    const fieldName = input.id;
                    const uploadArea = document.getElementById('upload-area-' + fieldName);

                    if (uploadArea) {
                        uploadArea.addEventListener('click', (e) => {
                            e.stopPropagation();
                            input.click();
                        });
                    }

                    input.addEventListener('change', function() {
                        if (this.files.length > 0) {
                            const previewContainer = document.getElementById('preview-' + fieldName);
                            if (previewContainer) {
                                previewContainer.innerHTML = `<div class="alert alert-info">
                                    <i class="fas fa-check-circle me-2"></i> ${this.files.length}個のファイルが選択されました
                                </div>`;
                            }
                        }
                    });
                });
            }

            // ドキュメント全体のクリックイベントを処理する関数
            function handleDocumentClick(e) {
                // 項目追加ボタンのクリック処理
                if (e.target.closest('.add-array-item')) {
                    handleAddArrayItem(e.target.closest('.add-array-item'));
                }

                // 項目削除ボタンのクリック処理
                if (e.target.closest('.remove-array-item')) {
                    handleRemoveArrayItem(e.target.closest('.remove-array-item'));
                }

                // ファイル削除ボタンのクリック処理
                if (e.target.closest('.array-file-delete-btn')) {
                    const deleteBtn = e.target.closest('.array-file-delete-btn');
                    const currentFileDiv = deleteBtn.closest('div.mt-2');
                    if (currentFileDiv) {
                        currentFileDiv.remove();
                    }
                }

                // 複数ファイルの個別削除ボタンのクリック処理
                if (e.target.closest('.array-file-item-delete-btn')) {
                    const deleteBtn = e.target.closest('.array-file-item-delete-btn');
                    const fileItem = deleteBtn.closest('.array-file-item');
                    if (fileItem) {
                        fileItem.remove();
                    }
                }
            }

            // 配列項目を追加する処理
            function handleAddArrayItem(button) {
                console.log('Adding array item');
                const fieldName = button.dataset.field;
                const itemsContainer = document.getElementById(`array-items-${fieldName}`);

                if (!itemsContainer) {
                    console.error('Container not found for field:', fieldName);
                    return;
                }

                try {
                    // データ属性からarray_itemsを取得
                    const arrayItems = JSON.parse(button.dataset.arrayItems || '[]');
                    const itemIndex = itemsContainer.querySelectorAll('.array-item').length;

                    if (!arrayItems.length) {
                        console.error('Array items not found for field:', fieldName);
                        return;
                    }

                    // 項目のHTMLを構築
                    let itemHtml = `
                        <div class="array-item card p-3 mb-2">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">項目 #${itemIndex + 1}</h6>
                                <button type="button" class="btn btn-sm btn-danger remove-array-item">
                                    <i class="fas fa-times"></i> 削除
                                </button>
                            </div>
                    `;

                    // 各フィールドのHTMLを追加
                    arrayItems.forEach(arrayItem => {
                        itemHtml += generateArrayItemField(fieldName, itemIndex, arrayItem);
                    });

                    itemHtml += `</div>`;

                    // DOMに追加
                    itemsContainer.insertAdjacentHTML('beforeend', itemHtml);
                    console.log('Array item added successfully');
                } catch (error) {
                    console.error('Error adding array item:', error);
                }
            }

            // 配列項目を削除する処理
            function handleRemoveArrayItem(button) {
                const arrayItem = button.closest('.array-item');
                const container = arrayItem.closest('.array-field-container');

                if (container) {
                    const fieldName = container.dataset.field;
                    arrayItem.remove();
                    updateArrayItemIndexes(fieldName);
                }
            }

            // 配列項目のフィールドHTMLを生成する関数
            function generateArrayItemField(fieldName, itemIndex, arrayItem) {
                let html = `
                    <div class="mb-2">
                        <label class="form-label">${arrayItem.name}</label>
                `;

                switch (arrayItem.type) {
                    case 'text':
                        html += `
                            <input type="text"
                                name="${fieldName}[${itemIndex}][${arrayItem.name}]"
                                class="form-control"
                                value="">
                        `;
                        break;
                    case 'textarea':
                        html += `
                            <textarea
                                name="${fieldName}[${itemIndex}][${arrayItem.name}]"
                                class="form-control"
                                rows="4"></textarea>
                        `;
                        break;
                    case 'number':
                        html += `
                            <input type="number"
                                name="${fieldName}[${itemIndex}][${arrayItem.name}]"
                                class="form-control"
                                value="">
                        `;
                        break;
                    case 'email':
                        html += `
                            <input type="email"
                                name="${fieldName}[${itemIndex}][${arrayItem.name}]"
                                class="form-control"
                                value="">
                        `;
                        break;
                    case 'tel':
                        html += `
                            <input type="tel"
                                name="${fieldName}[${itemIndex}][${arrayItem.name}]"
                                class="form-control"
                                value="">
                        `;
                        break;
                    case 'select':
                        html += `
                            <select name="${fieldName}[${itemIndex}][${arrayItem.name}]" class="form-select">
                                <option value="">選択してください</option>
                        `;

                        if (arrayItem.options && Array.isArray(arrayItem.options)) {
                            arrayItem.options.forEach(option => {
                                html += `
                                    <option value="${option.value}">${option.label}</option>
                                `;
                            });
                        }

                        html += `
                            </select>
                        `;
                        break;
                    case 'radio':
                        html += `<div class="d-flex flex-wrap gap-3">`;

                        if (arrayItem.options && Array.isArray(arrayItem.options)) {
                            arrayItem.options.forEach(option => {
                                html += `
                                    <div class="form-check">
                                        <input type="radio"
                                            class="form-check-input"
                                            id="${fieldName}_${itemIndex}_${arrayItem.name}_${option.value}"
                                            name="${fieldName}[${itemIndex}][${arrayItem.name}]"
                                            value="${option.value}">
                                        <label class="form-check-label" for="${fieldName}_${itemIndex}_${arrayItem.name}_${option.value}">
                                            ${option.label}
                                        </label>
                                    </div>
                                `;
                            });
                        }

                        html += `</div>`;
                        break;
                    case 'boolean':
                        html += `
                            <div class="form-check">
                                <input type="checkbox"
                                    class="form-check-input"
                                    id="${fieldName}_${itemIndex}_${arrayItem.name}"
                                    name="${fieldName}[${itemIndex}][${arrayItem.name}]"
                                    value="1">
                                <label class="form-check-label" for="${fieldName}_${itemIndex}_${arrayItem.name}">
                                    有効
                                </label>
                            </div>
                        `;
                        break;
                    case 'date':
                        html += `
                            <input type="date"
                                name="${fieldName}[${itemIndex}][${arrayItem.name}]"
                                class="form-control"
                                value="">
                        `;
                        break;
                    case 'month':
                        html += `
                            <input type="month"
                                name="${fieldName}[${itemIndex}][${arrayItem.name}]"
                                class="form-control"
                                value="">
                        `;
                        break;
                    case 'file':
                        html += `
                            <div class="array-file-upload-container">
                                <input type="file"
                                    id="${fieldName}_${itemIndex}_${arrayItem.name}"
                                    name="${fieldName}[${itemIndex}][${arrayItem.name}]"
                                    class="form-control array-file-input">
                            </div>
                        `;
                        break;
                    case 'files':
                        html += `
                            <div class="array-files-upload-container">
                                <input type="file"
                                    id="${fieldName}_${itemIndex}_${arrayItem.name}"
                                    name="${fieldName}[${itemIndex}][${arrayItem.name}][]"
                                    class="form-control array-files-input"
                                    multiple>
                            </div>
                        `;
                        break;
                    case 'url':
                        html += `
                            <input type="url"
                                name="${fieldName}[${itemIndex}][${arrayItem.name}]"
                                class="form-control"
                                value=""
                                placeholder="https://example.com">
                        `;
                        break;
                }

                html += `
                    </div>
                `;

                return html;
            }

            // 配列項目のインデックスを更新する関数
            function updateArrayItemIndexes(fieldName) {
                if (!fieldName) return;

                const items = document.querySelectorAll(`#array-items-${fieldName} .array-item`);
                if (!items.length) return;

                items.forEach((item, index) => {
                    // タイトルを更新
                    const title = item.querySelector('h6');
                    if (title) {
                        title.textContent = `項目 #${index + 1}`;
                    }

                    // 入力フィールドの名前属性を更新
                    const inputs = item.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => {
                        const name = input.name;
                        if (!name) return;

                        // 正規表現で現在のインデックスを抽出
                        const pattern = new RegExp(`${fieldName}\\[(\\d+)\\]`);
                        const match = name.match(pattern);

                        if (match) {
                            const oldIndex = match[1];
                            const newName = name.replace(`${fieldName}[${oldIndex}]`, `${fieldName}[${index}]`);
                            input.name = newName;

                            // IDも更新
                            if (input.id && input.id.includes(`${fieldName}_${oldIndex}`)) {
                                const newId = input.id.replace(`${fieldName}_${oldIndex}`, `${fieldName}_${index}`);
                                input.id = newId;

                                // ラベルのforも更新
                                const labels = item.querySelectorAll(`label[for="${input.id}"]`);
                                labels.forEach(label => {
                                    label.setAttribute('for', newId);
                                });
                            }
                        }
                    });
                });
            }
        })();
    </script>
@endpush


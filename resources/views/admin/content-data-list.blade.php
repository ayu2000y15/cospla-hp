@extends('layouts.admin')

@section('title', $master->title . ' - データ一覧')

@section('content')
    <div class="d-flex justify-content-between align-items-center page-title mb-4">
        <h2>{{ $master->title }} - データ一覧</h2>
        <div>
            <a href="{{ route('admin.content-data') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> 戻る
            </a>
            <a href="{{ route('admin.content-data.create', ['masterId' => $master->master_id]) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> 新規登録
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0 fw-bold"><i class="fas fa-table me-2"></i>データ一覧</h5>
        </div>
        <div class="card-body">
            @if(count($data) > 0)
                <div class="table-container">
                    <table class="table table-striped table-hover wide-table">
                        <thead class="table-primary sticky-header">
                            <tr>
                                <th class="col-actions">操作</th>
                                <th class="col-status">公開状態</th>
                                <th class="col-sort">表示順</th>
                                @if(isset($master->schema) && is_array($master->schema))
                                                    @php
                                                        // スキーマを表示順でソート
                                                        $sortedSchema = collect($master->schema)->sortBy('sort_order')->values()->all();
                                                    @endphp
                                                    @foreach($sortedSchema as $field)
                                                        @if($field['public_flg'] == '1')
                                                            <th class="col-data">{{ $field['view_name'] }}</th>
                                                        @endif
                                                    @endforeach
                                @endif
                                <th class="col-date">登録日時</th>
                                <th class="col-date">更新日時</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-items">
                            @foreach($data as $item)
                                <tr data-id="{{ $item->data_id }}" data-sort-order="{{ $item->sort_order ?? 0 }}">
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.content-data.edit', ['dataId' => $item->data_id]) }}"
                                                class="btn btn-sm btn-warning btn-action">
                                                <i class="fas fa-edit"></i> 編集
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger btn-action" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $item->data_id }}">
                                                <i class="fas fa-trash"></i> 削除
                                            </button>
                                        </div>

                                        <!-- 削除確認モーダル -->
                                        <div class="modal fade" id="deleteModal{{ $item->data_id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">削除確認</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="閉じる"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>このデータを削除してもよろしいですか？</p>
                                                        <p>この操作は取り消せません。</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">キャンセル</button>
                                                        <form
                                                            action="{{ route('admin.content-data.delete', ['dataId' => $item->data_id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">削除する</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button"
                                            class="btn btn-sm toggle-public-btn {{ $item->public_flg == '1' ? 'btn-success' : 'btn-secondary' }}"
                                            data-id="{{ $item->data_id }}" data-status="{{ $item->public_flg }}"
                                            title="{{ $item->public_flg == '1' ? '公開中（クリックで非公開に切り替え）' : '非公開（クリックで公開に切り替え）' }}">
                                            <i class="fas {{ $item->public_flg == '1' ? 'fa-eye' : 'fa-eye-slash' }} me-1"></i>
                                            {{ $item->public_flg == '1' ? '公開' : '非公開' }}
                                        </button>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="sort-handle me-2"><i class="fas fa-grip-vertical text-muted"></i></span>
                                            <span class="sort-order badge bg-secondary">{{ $item->sort_order ?? 0 }}</span>
                                            <div class="ms-2">
                                                <button type="button" class="btn btn-sm btn-outline-secondary move-up-btn"
                                                    title="上に移動">
                                                    <i class="fas fa-arrow-up"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary move-down-btn"
                                                    title="下に移動">
                                                    <i class="fas fa-arrow-down"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    @if(isset($master->schema) && is_array($master->schema))
                                        @foreach($sortedSchema as $field)
                                            @if($field['public_flg'] == '1')
                                                <td class="cell-content">
                                                    @if(isset($item->content[$field['col_name']]))
                                                        @if($field['type'] == 'textarea')
                                                            <div class="text-content">
                                                                {!! nl2br(e($item->content[$field['col_name']])) !!}
                                                            </div>
                                                        @elseif($field['type'] == 'file')
                                                            @if(!empty($item->content[$field['col_name']]))
                                                                <a href="{{ asset($item->content[$field['col_name']]) }}" target="_blank"
                                                                    class="image-preview">
                                                                    <img src="{{ asset($item->content[$field['col_name']]) }}" alt="画像"
                                                                        class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                                                </a>
                                                            @else
                                                                <span class="text-muted">ファイルなし</span>
                                                            @endif
                                                        @elseif($field['type'] == 'array')
                                                            @if(!empty($item->content[$field['col_name']]) && is_array($item->content[$field['col_name']]))
                                                                <div class="array-data-preview">
                                                                    <button type="button" class="btn btn-sm btn-outline-info array-preview-toggle"
                                                                        data-bs-toggle="collapse"
                                                                        data-bs-target="#array-preview-{{ $item->data_id }}-{{ $field['col_name'] }}">
                                                                        {{ count($item->content[$field['col_name']]) }}個の項目 <i
                                                                            class="fas fa-chevron-down"></i>
                                                                    </button>
                                                                    <div class="collapse mt-2"
                                                                        id="array-preview-{{ $item->data_id }}-{{ $field['col_name'] }}">
                                                                        <div class="card card-body p-2">
                                                                            <div class="table-responsive">
                                                                                <table class="table table-sm table-bordered mb-0">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>#</th>
                                                                                            @if(isset($field['array_items']) && is_array($field['array_items']))
                                                                                                @foreach($field['array_items'] as $arrayItem)
                                                                                                    <th>{{ $arrayItem['name'] }}</th>
                                                                                                @endforeach
                                                                                            @endif
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        @foreach($item->content[$field['col_name']] as $index => $arrayItem)
                                                                                            <tr>
                                                                                                <td>{{ $index + 1 }}</td>
                                                                                                @if(isset($field['array_items']) && is_array($field['array_items']))
                                                                                                    @foreach($field['array_items'] as $arrayItemDef)
                                                                                                        <td>
                                                                                                            @if(isset($arrayItem[$arrayItemDef['name']]))
                                                                                                                @if($arrayItemDef['type'] == 'boolean')
                                                                                                                    <span
                                                                                                                        class="badge {{ $arrayItem[$arrayItemDef['name']] ? 'bg-success' : 'bg-secondary' }}">
                                                                                                                        {{ $arrayItem[$arrayItemDef['name']] ? '有効' : '無効' }}
                                                                                                                    </span>
                                                                                                                @elseif($arrayItemDef['type'] == 'date' || $arrayItemDef['type'] == 'month')
                                                                                                                    {{ $arrayItem[$arrayItemDef['name']] }}
                                                                                                                @elseif($arrayItemDef['type'] == 'select' || $arrayItemDef['type'] == 'radio')
                                                                                                                    @php
                                                                                                                        $selectedValue = $arrayItem[$arrayItemDef['name']] ?? '';
                                                                                                                        $selectedLabel = $selectedValue;

                                                                                                                        // 選択肢からラベルを取得
                                                                                                                        if (isset($arrayItemDef['options']) && is_array($arrayItemDef['options'])) {
                                                                                                                            foreach ($arrayItemDef['options'] as $option) {
                                                                                                                                if ($option['value'] == $selectedValue) {
                                                                                                                                    $selectedLabel = $option['label'];
                                                                                                                                    break;
                                                                                                                                }
                                                                                                                            }
                                                                                                                        }
                                                                                                                    @endphp
                                                                                                                    {{ $selectedLabel }}
                                                                                                                @elseif($arrayItemDef['type'] == 'textarea')
                                                                                                                    <div class="text-content">
                                                                                                                        {!! nl2br(e($arrayItem[$arrayItemDef['name']])) !!}
                                                                                                                    </div>
                                                                                                                @elseif($arrayItemDef['type'] == 'file')
                                                                                                                    @if(!empty($arrayItem[$arrayItemDef['name']]))
                                                                                                                        <a href="{{ asset($arrayItem[$arrayItemDef['name']]) }}" target="_blank" class="image-preview">
                                                                                                                            <img src="{{ asset($arrayItem[$arrayItemDef['name']]) }}" alt="画像" class="img-thumbnail" style="max-width: 50px; max-height: 50px;">
                                                                                                                        </a>
                                                                                                                    @else
                                                                                                                        <span class="text-muted">ファイルなし</span>
                                                                                                                    @endif
                                                                                                                @elseif($arrayItemDef['type'] == 'files')
                                                                                                                    @if(!empty($arrayItem[$arrayItemDef['name']]) && is_array($arrayItem[$arrayItemDef['name']]))
                                                                                                                        <div class="d-flex flex-wrap gap-1">
                                                                                                                            @foreach($arrayItem[$arrayItemDef['name']] as $filePath)
                                                                                                                                <a href="{{ asset($filePath) }}" target="_blank" class="image-preview">
                                                                                                                                    <img src="{{ asset($filePath) }}" alt="画像" class="img-thumbnail" style="width: 30px; height: 30px; object-fit: cover;">
                                                                                                                                </a>
                                                                                                                            @endforeach
                                                                                                                        </div>
                                                                                                                    @else
                                                                                                                        <span class="text-muted">ファイルなし</span>
                                                                                                                    @endif
                                                                                                                @elseif($arrayItemDef['type'] == 'url')
                                                                                                                    <a href="{{ $arrayItem[$arrayItemDef['name']] }}" target="_blank" class="text-break">
                                                                                                                        {{ $arrayItem[$arrayItemDef['name']] }}
                                                                                                                    </a>
                                                                                                                @elseif($arrayItemDef['type'] == 'email')
                                                                                                                    <a href="mailto:{{ $arrayItem[$arrayItemDef['name']] }}" class="text-break">
                                                                                                                        {{ $arrayItem[$arrayItemDef['name']] }}
                                                                                                                    </a>
                                                                                                                @elseif($arrayItemDef['type'] == 'tel')
                                                                                                                    <a href="tel:{{ $arrayItem[$arrayItemDef['name']] }}" class="text-break">
                                                                                                                        {{ $arrayItem[$arrayItemDef['name']] }}
                                                                                                                    </a>
                                                                                                                @else
                                                                                                                    {{ $arrayItem[$arrayItemDef['name']] }}
                                                                                                                @endif
                                                                                                            @endif
                                                                                                        </td>
                                                                                                    @endforeach
                                                                                                @endif
                                                                                            </tr>
                                                                                        @endforeach
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <span class="text-muted">データなし</span>
                                                            @endif
                                                        @else
                                                            {{ $item->content[$field['col_name']] ?? '' }}
                                                        @endif
                                                    @else
                                                        <span class="text-muted">データなし</span>
                                                    @endif
                                                </td>
                                            @endif
                                        @endforeach
                                    @endif
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->updated_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    データがありません。
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            // 公開/非公開トグルボタンの処理
            $('.toggle-public-btn').on('click', function() {
                var dataId = $(this).data('id');
                var currentStatus = $(this).data('status');
                var newStatus = currentStatus == '1' ? '0' : '1';
                var button = $(this);

                $.ajax({
                    url: '/admin/content-data/toggle-public/' + dataId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: newStatus
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            button.removeClass('btn-success btn-secondary');
                            button.find('i').removeClass('fa-eye fa-eye-slash');

                            if (newStatus == '1') {
                                button.addClass('btn-success');
                                button.find('i').addClass('fa-eye');
                                button.data('status', '1');
                                button.attr('title', '公開中（クリックで非公開に切り替え）');
                                button.text(' 公開'); // アイコンとのスペースを調整
                                button.prepend('<i class="fas fa-eye me-1"></i>'); // アイコンを先頭に追加
                            } else {
                                button.addClass('btn-secondary');
                                button.find('i').addClass('fa-eye-slash');
                                button.data('status', '0');
                                button.attr('title', '非公開（クリックで公開に切り替え）');
                                button.text(' 非公開'); // アイコンとのスペースを調整
                                button.prepend('<i class="fas fa-eye-slash me-1"></i>'); // アイコンを先頭に追加
                            }
                        } else {
                            alert('更新に失敗しました。');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert('エラーが発生しました。');
                    }
                });
            });

            // 並び替え機能
            $('#sortable-items').sortable({
                handle: '.sort-handle',
                axis: 'y',
                update: function(event, ui) {
                    var sortedIDs = $(this).sortable('toArray', {
                        attribute: 'data-id'
                    });
                    $.ajax({
                        url: '/admin/content-data/sort',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            ids: sortedIDs
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data.success) {
                                // 並び順を更新
                                sortedIDs.forEach(function(id, index) {
                                    $('tr[data-id="' + id + '"]').attr('data-sort-order', index + 1);
                                    $('tr[data-id="' + id + '"] .sort-order').text(index + 1);
                                });
                            } else {
                                alert('並び替えの更新に失敗しました。');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            alert('エラーが発生しました。');
                        }
                    });
                }
            });

            // 上へ移動ボタン
            $('.move-up-btn').on('click', function() {
                var row = $(this).closest('tr');
                var prevRow = row.prev('tr');
                if (prevRow.length) {
                    row.insertBefore(prevRow);
                    updateSortOrder();
                }
            });

            // 下へ移動ボタン
            $('.move-down-btn').on('click', function() {
                var row = $(this).closest('tr');
                var nextRow = row.next('tr');
                if (nextRow.length) {
                    row.insertAfter(nextRow);
                    updateSortOrder();
                }
            });

            function updateSortOrder() {
                var sortedIDs = $('#sortable-items').sortable('toArray', {
                    attribute: 'data-id'
                });
                $.ajax({
                    url: '/admin/content-data/sort',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ids: sortedIDs
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            // 並び順を更新
                            sortedIDs.forEach(function(id, index) {
                                $('tr[data-id="' + id + '"]').attr('data-sort-order', index + 1);
                                $('tr[data-id="' + id + '"] .sort-order').text(index + 1);
                            });
                        } else {
                            alert('並び替えの更新に失敗しました。');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert('エラーが発生しました。');
                    }
                });
            }
        });
    </script>
@endpush


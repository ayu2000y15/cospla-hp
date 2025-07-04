<div class="space-y-10">
    {{-- 1. 画像アップロードセクション --}}
    <div>
        <h2 class="text-xl font-semibold leading-6 text-gray-900">HP画像 新規登録</h2>
        <p class="mt-1 text-sm text-gray-500">サイト全体で使用する画像をアップロードします。ここで指定した設定は、選択したすべてのファイルに適用されます。</p>

        <form id="hp-upload-form" action="{{ route('admin.photos.upload') }}" method="POST"
            enctype="multipart/form-data" class="mt-6">
            @csrf

            {{-- ドラッグ＆ドロップ エリア --}}
            <div id="hp-drop-zone"
                class="flex justify-center w-full px-6 pt-5 pb-6 mt-1 border-2 border-gray-300 border-dashed rounded-md">
                <div class="space-y-1 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"
                        aria-hidden="true">
                        <path
                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600">
                        <label for="hp-photo-upload"
                            class="relative font-medium text-indigo-600 bg-white rounded-md cursor-pointer focus-within:outline-none hover:text-indigo-500">
                            <span>ファイルを選択</span>
                            <input id="hp-photo-upload" name="upfile[]" type="file" class="sr-only" multiple
                                accept="image/*">
                        </label>
                        <p class="pl-1">またはドラッグ＆ドロップ</p>
                    </div>
                </div>
            </div>
            <div id="hp-preview-container" class="grid grid-cols-3 gap-4 mt-4 sm:grid-cols-4 md:grid-cols-6"></div>
            <div class="flex justify-end mt-4">
                <button type="submit"
                    class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">アップロード</button>
            </div>
        </form>
    </div>

    {{-- 2. 登録済み画像一覧セクション --}}
    <div class="pt-8">
        <h2 class="text-xl font-semibold leading-6 text-gray-900">登録済み画像一覧</h2>
        <div class="mt-6 space-y-4">
            @forelse($imgList->groupBy('VIEW_FLG') as $viewFlg => $images)
                <details class="bg-white rounded-lg shadow group">
                    <summary class="flex items-center justify-between p-4 font-medium list-none cursor-pointer">
                        <span>{{ $viewFlags->where('VIEW_FLG', $viewFlg)->first()->COMMENT ?? '未分類' }}
                            ({{ count($images) }}枚)</span>
                        <svg class="w-5 h-5 transition-transform duration-300 transform group-open:rotate-180" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <div class="p-4 border-t border-gray-200">
                        <ul role="list"
                            class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                            @foreach($images as $img)
                                <li class="relative">
                                    <div class="block w-full overflow-hidden bg-gray-100 rounded-lg aspect-w-10 aspect-h-7">
                                        <img src="{{ asset($img->FILE_PATH . $img->FILE_NAME) }}" alt=""
                                            class="object-cover w-full h-48 pointer-events-none">
                                    </div>
                                    <form action="{{ route('admin.photos.update') }}" method="POST" class="mt-2 space-y-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="FILE_NAME" value="{{ $img->FILE_NAME }}">
                                        <div>
                                            <label for="VIEW_FLG_{{ $loop->parent->index }}_{{ $loop->index }}"
                                                class="block text-xs font-medium text-gray-600">表示先</label>
                                            <select name="VIEW_FLG_AFT"
                                                id="VIEW_FLG_{{ $loop->parent->index }}_{{ $loop->index }}"
                                                class="block w-full p-2 mt-1 text-sm bg-white border border-gray-300 rounded-md shadow-sm">
                                                @foreach($viewFlags as $flag)
                                                    <option value="{{ $flag->VIEW_FLG }}" {{ $flag->VIEW_FLG == $img->VIEW_FLG ? 'selected' : '' }}>
                                                        {{ $flag->COMMENT }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="PRIORITY_{{ $loop->parent->index }}_{{ $loop->index }}"
                                                class="block text-xs font-medium text-gray-600">優先順位</label>
                                            <input type="number" name="PRIORITY" value="{{ $img->PRIORITY }}"
                                                id="PRIORITY_{{ $loop->parent->index }}_{{ $loop->index }}" placeholder="優先度"
                                                class="block w-full p-2 mt-1 text-sm bg-white border border-gray-300 rounded-md shadow-sm">
                                        </div>
                                        <div class="flex items-center justify-between mt-2">
                                            <button type="submit"
                                                class="text-sm font-medium text-indigo-600 hover:text-indigo-800">更新</button>
                                            <button type="button" onclick="confirmDeletePhoto('{{ $img->FILE_NAME }}')"
                                                class="text-sm font-medium text-red-600 hover:text-red-800">削除</button>
                                        </div>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </details>
            @empty
                <p class="mt-6 text-sm text-gray-500">HP用の画像はまだ登録されていません。</p>
            @endforelse
        </div>
    </div>
</div>

{{-- 削除確認用のフォーム --}}
<form id="deletePhotoForm" action="{{ route('admin.photos.delete') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
    <input type="hidden" name="FILE_NAME" id="photoNameToDelete">
</form>

{{-- スクリプト --}}
<script>
    function setupDragAndDrop(dropZoneId, fileInputId, previewContainerId) {
        const dropZone = document.getElementById(dropZoneId);
        const fileInput = document.getElementById(fileInputId);
        const previewContainer = document.getElementById(previewContainerId);

        if (!dropZone || !fileInput || !previewContainer) return;

        const preventDefaults = e => { e.preventDefault(); e.stopPropagation(); };
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.add('border-indigo-500', 'bg-indigo-50'), false);
        });
        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.remove('border-indigo-500', 'bg-indigo-50'), false);
        });

        const handleFiles = (files) => {
            const dataTransfer = new DataTransfer();
            for (const file of files) {
                dataTransfer.items.add(file);
            }
            fileInput.files = dataTransfer.files;

            previewContainer.innerHTML = '';
            if (files.length > 0) {
                for (const file of files) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const div = document.createElement('div');
                        div.className = 'relative aspect-square';
                        div.innerHTML = `<img src="${e.target.result}" class="object-cover w-full h-full rounded-md">`;
                        previewContainer.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                }
            }
        };

        dropZone.addEventListener('drop', e => handleFiles(e.dataTransfer.files), false);
        fileInput.addEventListener('change', e => handleFiles(e.target.files), false);
    }

    document.addEventListener('DOMContentLoaded', () => {
        setupDragAndDrop('hp-drop-zone', 'hp-photo-upload', 'hp-preview-container');
    });

    function confirmDeletePhoto(fileName) {
        if (confirm(`画像「${fileName}」を本当に削除しますか？`)) {
            document.getElementById('photoNameToDelete').value = fileName;
            document.getElementById('deletePhotoForm').submit();
        }
    }
</script>
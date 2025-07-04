@extends('layouts.admin')

@section('content')
    <div class="space-y-10">
        <h1 class="text-2xl font-semibold text-gray-900">ORDERページ編集</h1>

        {{-- 1. 新規グループ登録フォーム --}}
        <details class="bg-white rounded-lg shadow group">
            <summary class="flex items-center justify-between p-4 font-medium list-none cursor-pointer">
                <h3 class="text-lg leading-6 text-gray-900">新規グループ登録</h3>
                <svg class="w-5 h-5 transition-transform duration-300 transform group-open:rotate-180" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </summary>
            <div class="p-6 border-t border-gray-200">
                <form action="{{ route('admin.order.client.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div class="sm:col-span-1"><label for="client_name"
                                class="block text-sm font-medium text-gray-700">グループ名・会社名 <span
                                    class="text-red-500">*</span></label><input type="text" name="client_name"
                                id="client_name" required
                                class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm"></div>
                        <div class="sm:col-span-1"><label for="client_name_kana"
                                class="block text-sm font-medium text-gray-700">ふりがな</label><input type="text"
                                name="client_name_kana" id="client_name_kana"
                                class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm"></div>
                        <div class="sm:col-span-2"><label for="description"
                                class="block text-sm font-medium text-gray-700">紹介文</label><textarea name="description"
                                id="description" rows="3"
                                class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm"></textarea>
                        </div>
                        <div class="sm:col-span-2"><label for="homepage_url"
                                class="block text-sm font-medium text-gray-700">ホームページURL</label><input type="url"
                                name="homepage_url" id="homepage_url"
                                class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm"></div>
                        <div class="sm:col-span-1"><label for="sns_x" class="block text-sm font-medium text-gray-700">X
                                (旧Twitter) URL</label><input type="url" name="sns_x" id="sns_x"
                                class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm"></div>
                        <div class="sm:col-span-1"><label for="sns_instagram"
                                class="block text-sm font-medium text-gray-700">Instagram URL</label><input type="url"
                                name="sns_instagram" id="sns_instagram"
                                class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm"></div>
                        <div class="sm:col-span-1"><label for="sns_tiktok"
                                class="block text-sm font-medium text-gray-700">TikTok URL</label><input type="url"
                                name="sns_tiktok" id="sns_tiktok"
                                class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm"></div>
                    </div>
                    <div class="flex justify-end"><button type="submit"
                            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700">グループを登録</button>
                    </div>
                </form>
            </div>
        </details>

        {{-- 2. 登録済みグループ一覧 --}}
        <div class="space-y-8">
            @forelse ($clients as $client)
                <div x-data="{ isEditing: false }" class="p-6 bg-white rounded-lg shadow">
                    {{-- 表示モード --}}
                    <div x-show="!isEditing">
                        <div class="md:flex md:justify-between md:items-start">
                            <div class="space-y-3 mb-4 md:mb-0">
                                <h3 class="text-xl font-semibold text-gray-800">{{ $client->client_name }}</h3>
                                <p class="text-sm text-gray-500">{{ $client->client_name_kana }}</p>
                                @if($client->description)
                                    <p class="text-sm text-gray-600 prose max-w-none">{!! nl2br(e($client->description)) !!}</p>
                                @endif
                                <div class="space-y-2">
                                    @if($client->homepage_url)
                                        <a href="{{ $client->homepage_url }}" target="_blank" rel="noopener"
                                            class="flex items-center text-sm text-indigo-600 hover:underline"><i
                                                class="fa-solid fa-link w-5 mr-1 text-center"></i><span
                                                class="truncate">{{ $client->homepage_url }}</span></a>
                                    @endif
                                    @if($client->sns_x)
                                        <a href="{{ $client->sns_x }}" target="_blank" rel="noopener"
                                            class="flex items-center text-sm text-gray-600 hover:text-black"><i
                                                class="fa-brands fa-x-twitter w-5 mr-1 text-center"></i><span
                                                class="truncate">{{ $client->sns_x }}</span></a>
                                    @endif
                                    @if($client->sns_instagram)
                                        <a href="{{ $client->sns_instagram }}" target="_blank" rel="noopener"
                                            class="flex items-center text-sm text-gray-600 hover:text-black"><i
                                                class="fa-brands fa-instagram w-5 mr-1 text-center"></i><span
                                                class="truncate">{{ $client->sns_instagram }}</span></a>
                                    @endif
                                    @if($client->sns_tiktok)
                                        <a href="{{ $client->sns_tiktok }}" target="_blank" rel="noopener"
                                            class="flex items-center text-sm text-gray-600 hover:text-black"><i
                                                class="fa-brands fa-tiktok w-5 mr-1 text-center"></i><span
                                                class="truncate">{{ $client->sns_tiktok }}</span></a>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-start space-x-2 flex-shrink-0">
                                <button @click="isEditing = true"
                                    class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700">編集</button>
                                <form action="{{ route('admin.order.client.destroy', $client) }}" method="POST"
                                    onsubmit="return confirm('このグループを画像ごと削除します。よろしいですか？')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">削除</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- 編集モード --}}
                    <form x-show="isEditing" x-cloak action="{{ route('admin.order.client.update', $client) }}" method="POST"
                        class="space-y-6">
                        @csrf @method('PUT')
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div class="sm:col-span-1"><label class="block text-sm font-medium">グループ名・会社名</label><input
                                    type="text" name="client_name" value="{{ $client->client_name }}" required
                                    class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md"></div>
                            <div class="sm:col-span-1"><label class="block text-sm font-medium">ふりがな</label><input type="text"
                                    name="client_name_kana" value="{{ $client->client_name_kana }}"
                                    class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md"></div>
                            <div class="sm:col-span-2"><label class="block text-sm font-medium">紹介文</label><textarea
                                    name="description" rows="3"
                                    class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md">{{ $client->description }}</textarea>
                            </div>
                            <div class="sm:col-span-2"><label class="block text-sm font-medium">HP URL</label><input type="url"
                                    name="homepage_url" value="{{ $client->homepage_url }}"
                                    class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md"></div>
                            <div class="sm:col-span-1"><label class="block text-sm font-medium">X URL</label><input type="url"
                                    name="sns_x" value="{{ $client->sns_x }}"
                                    class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md"></div>
                            <div class="sm:col-span-1"><label class="block text-sm font-medium">Instagram URL</label><input
                                    type="url" name="sns_instagram" value="{{ $client->sns_instagram }}"
                                    class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md"></div>
                            <div class="sm:col-span-1"><label class="block text-sm font-medium">TikTok URL</label><input
                                    type="url" name="sns_tiktok" value="{{ $client->sns_tiktok }}"
                                    class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md"></div>
                        </div>
                        <div class="flex justify-end gap-2"><button type="button" @click="isEditing = false"
                                class="px-4 py-2 text-sm bg-gray-200 rounded-md">キャンセル</button><button type="submit"
                                class="px-4 py-2 text-sm text-white bg-indigo-600 rounded-md">更新</button></div>
                    </form>

                    <hr class="my-4">

                    <div class="p-4 mt-4 bg-gray-50 border border-gray-200 rounded-lg">
                        <h4 class="text-base font-medium text-gray-700">画像を追加</h4>
                        <form action="{{ route('admin.order.images.upload') }}" method="POST" enctype="multipart/form-data"
                            class="mt-4">
                            @csrf
                            <input type="hidden" name="client_id" value="{{ $client->client_id }}">
                            <div id="drop-zone-{{ $client->client_id }}"
                                class="flex justify-center w-full px-6 pt-5 pb-6 mt-1 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center"><svg class="w-12 h-12 mx-auto text-gray-400"
                                        stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <div class="flex text-sm text-gray-600"><label for="images-upload-{{ $client->client_id }}"
                                            class="relative font-medium text-indigo-600 bg-white rounded-md cursor-pointer focus-within:outline-none hover:text-indigo-500"><span>ファイルを選択</span><input
                                                id="images-upload-{{ $client->client_id }}" name="images[]" type="file"
                                                class="sr-only file-input" multiple="" accept="image/*"
                                                data-preview-container="preview-container-{{ $client->client_id }}"></label>
                                        <p class="pl-1">またはドラッグ＆ドロップ</p>
                                    </div>
                                </div>
                            </div>
                            <div id="preview-container-{{ $client->client_id }}"
                                class="grid grid-cols-3 gap-4 mt-4 sm:grid-cols-4 md:grid-cols-6"></div>
                            <div class="flex justify-end mt-4">
                                <button type="submit"
                                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-white bg-green-600 rounded-md shadow-sm hover:bg-green-700">アップロード</button>
                            </div>
                        </form>
                    </div>
                    <div class="grid grid-cols-2 mt-6 gap-x-4 gap-y-8 sm:grid-cols-3 lg:grid-cols-4 xl:gap-x-8">
                        @forelse ($client->images as $image)
                            <div class="relative group">
                                <div class="block w-full overflow-hidden bg-gray-100 rounded-lg aspect-w-10 aspect-h-7">
                                    <img src="{{ asset($image->file_path . $image->file_name) }}" alt="{{ $image->alt_text }}"
                                        class="object-cover w-full h-48 pointer-events-none">
                                </div>
                                <form action="{{ route('admin.order.image.destroy', $image) }}" method="POST"
                                    onsubmit="return confirm('この画像を削除しますか？')" class="absolute top-1 right-1">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="p-1 text-white bg-red-600 bg-opacity-75 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">&times;</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 col-span-full">このグループの画像はまだ登録されていません。</p>
                        @endforelse
                    </div>
                </div>
            @empty
                <div class="p-6 text-sm text-center text-gray-500 bg-white rounded-lg shadow">まだグループが登録されていません。</div>
            @endforelse
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.file-input').forEach(fileInput => {
                const previewContainerId = fileInput.dataset.previewContainer;
                const dropZoneId = 'drop-zone-' + previewContainerId.split('-').pop();
                setupDragAndDrop(dropZoneId, fileInput.id, previewContainerId);
            });
        });

        function setupDragAndDrop(dropZoneId, fileInputId, previewContainerId) {
            const dropZone = document.getElementById(dropZoneId);
            const fileInput = document.getElementById(fileInputId);
            const previewContainer = document.getElementById(previewContainerId);

            if (!dropZone || !fileInput || !previewContainer) return;

            const preventDefaults = e => { e.preventDefault(); e.stopPropagation(); };
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });
            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => dropZone.classList.add('border-indigo-500', 'bg-indigo-50'), false);
            });
            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => dropZone.classList.remove('border-indigo-500', 'bg-indigo-50'), false);
            });

            const handleFiles = (files) => {
                const dataTransfer = new DataTransfer();
                for (const file of files) { dataTransfer.items.add(file); }
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
    </script>
@endpush
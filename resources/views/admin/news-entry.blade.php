<div class="space-y-10 divide-y divide-gray-200">

    <div>
        <h2 class="text-xl font-semibold leading-6 text-gray-900">ニュース登録・編集</h2>
        <p class="mt-1 text-sm text-gray-500">新しいニュースを登録、または一覧から選択して編集します。</p>

        <form id="adminForm" action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data"
            class="mt-6 space-y-6">
            @csrf
            <input type="hidden" name="NEWS_ID" id="NEWS_ID">

            <div>
                <label for="TITLE" class="block text-sm font-medium text-gray-700">タイトル</label>
                <div class="mt-1">
                    <input type="text" name="TITLE" id="TITLE" required
                        class="block w-full p-2 bg-white border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
            </div>

            <div>
                <label for="POST_DATE" class="block text-sm font-medium text-gray-700">投稿日</label>
                <div class="mt-1">
                    <input type="date" name="POST_DATE" id="POST_DATE" required value="{{ date('Y-m-d') }}"
                        class="block p-2 bg-white border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
            </div>

            <div>
                <label for="CONTENT" class="block text-sm font-medium text-gray-700">内容</label>
                <div class="mt-1">
                    <textarea id="CONTENT" name="CONTENT" rows="5" required
                        class="block w-full p-2 bg-white border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-200">
                <label class="block text-sm font-medium text-gray-700">タグ</label>
                <p class="text-xs text-gray-500">複数のタグをカンマ（,）で区切って入力してください。<br>
                    存在しないタグは自動で作成されます。<br>
                    新しく作成されるタグカラーはランダムで設定されます。<br>
                    各種設定のタグ管理より、タグカラーの変更が可能です。</p>
                <input type="text" name="tags" id="tags-input"
                    class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm"
                    placeholder="例: お知らせ, イベント, 重要">

                <div class="mt-2">
                    <h4 class="text-xs font-medium text-gray-600">既存のタグ</h4>
                    <p class="text-xs text-gray-500">クリックしてタグを追加できます。</p>
                    <div id="existing-tags-container" class="flex flex-wrap gap-2 mt-1">
                        {{-- AdminControllerから渡された$tagListを使ってタグを表示 --}}
                        @foreach($tagList as $tag)
                            <button type="button"
                                class="existing-tag-btn px-2 py-1 text-xs font-medium text-white rounded-full shadow-sm"
                                style="background-color: {{ $tag->TAG_COLOR }};" data-tag-name="{{ $tag->TAG_NAME }}">
                                #{{ $tag->TAG_NAME }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">画像・動画 (ドラッグ＆ドロップ対応)</label>
                <div id="drop-zone"
                    class="flex justify-center w-full px-6 pt-5 pb-6 mt-1 border-2 border-gray-300 border-dashed rounded-md">
                    <div class="space-y-1 text-center">
                        <svg class="w-12 h-12 mx-auto text-gray-400" stroke="currentColor" fill="none"
                            viewBox="0 0 48 48" aria-hidden="true">
                            <path
                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="photo-upload"
                                class="relative font-medium text-indigo-600 bg-white rounded-md cursor-pointer focus-within:outline-none hover:text-indigo-500">
                                <span>ファイルを選択</span>
                                <input id="photo-upload" name="upfile[]" type="file" class="sr-only" multiple
                                    accept="image/*,video/*">
                            </label>
                            <p class="pl-1">またはドラッグ＆ドロップ</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF, MP4, MOV up to 10MB</p>
                    </div>
                </div>
                <div id="preview-container" class="grid grid-cols-3 gap-4 mt-4 sm:grid-cols-4 md:grid-cols-6"></div>
            </div>

            <div id="current-images-section" class="hidden">
                <label class="block text-sm font-medium text-gray-700">登録済みのメディア</label>
                <div id="current-images-container" class="grid grid-cols-3 gap-4 mt-2 sm:grid-cols-4 md:grid-cols-6">
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="resetForm()"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">リセット</button>
                <button type="submit" id="submitBtn"
                    class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700">登録</button>
            </div>
        </form>
    </div>

    <div class="pt-8">
        <h2 class="text-xl font-semibold leading-6 text-gray-900">ニュース一覧</h2>
        <div class="mt-6 -mx-4 overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">投稿日
                        </th>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            タイトル</th>
                        <th scope="col"
                            class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">タグ
                        </th>
                        <th scope="col"
                            class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">メディア
                        </th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6"><span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($newsList as $news)
                        <tr>
                            <td class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell">
                                {{ \Carbon\Carbon::parse($news->POST_DATE)->format('Y-m-d') }}
                            </td>
                            <td
                                class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6">
                                {{ $news->TITLE }}
                                <dl class="font-normal lg:hidden">
                                    <dt class="sr-only">投稿日</dt>
                                    <dd class="mt-1 text-gray-500 truncate">
                                        {{ \Carbon\Carbon::parse($news->POST_DATE)->format('Y-m-d') }}
                                    </dd>
                                </dl>
                            </td>
                            <td class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($news->tags as $tag)
                                        <span class="px-2 py-1 text-xs font-medium text-white rounded-full"
                                            style="background-color: {{ $tag->TAG_COLOR }};">
                                            #{{ $tag->TAG_NAME }}
                                        </span>
                                    @empty
                                        <span>-</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell">
                                <div class="flex -space-x-1 overflow-hidden">
                                    @foreach ($news->images->take(4) as $img)
                                        @php
                                            $isVideo = in_array(strtolower(pathinfo($img->FILE_NAME, PATHINFO_EXTENSION)), ['mp4', 'mov', 'webm']);
                                        @endphp
                                        @if($isVideo)
                                            <div class="relative inline-block w-8 h-8 overflow-hidden bg-black rounded-full ring-2 ring-white">
                                                <video src="{{ asset($img->FILE_PATH . $img->FILE_NAME) }}#t=0.1" class="object-cover w-full h-full" muted playsinline preload="metadata"></video>
                                                <div class="absolute inset-0 flex items-center justify-center text-white bg-black bg-opacity-40">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"></path></svg>
                                                </div>
                                             </div>
                                        @else
                                            <img class="inline-block object-cover w-8 h-8 rounded-full ring-2 ring-white"
                                                src="{{ asset($img->FILE_PATH . $img->FILE_NAME) }}" alt="">
                                        @endif
                                    @endforeach
                                    @if($news->images->count() > 4)
                                        <div
                                            class="inline-flex items-center justify-center w-8 h-8 text-xs font-medium text-gray-500 bg-gray-100 rounded-full ring-2 ring-white">
                                            +{{ $news->images->count() - 4 }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                                <button onclick='editItem({!! json_encode($news->load('tags')) !!})'
                                    class="text-indigo-600 hover:text-indigo-900">編集</button>
                                <form action="{{ route('admin.news.delete', $news->NEWS_ID) }}" method="POST"
                                    class="inline ml-4" onsubmit="return confirm('本当に削除しますか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">削除</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
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
            previewContainer.innerHTML = '';
            fileInput.files = files; // Store files in the input
            if (files.length > 0) {
                for (const file of files) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const div = document.createElement('div');
                        div.className = 'relative aspect-square';
                        if (file.type.startsWith('video/')) {
                            div.innerHTML = `<video src="${e.target.result}" class="object-cover w-full h-full rounded-md" muted playsinline controls></video>`;
                        } else {
                            div.innerHTML = `<img src="${e.target.result}" class="object-cover w-full h-full rounded-md">`;
                        }
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
        setupDragAndDrop('drop-zone', 'photo-upload', 'preview-container');

        const tagsInput = document.getElementById('tags-input');
        const existingTagsContainer = document.getElementById('existing-tags-container');

        if (tagsInput && existingTagsContainer) {
            existingTagsContainer.addEventListener('click', function (e) {
                if (e.target.classList.contains('existing-tag-btn')) {
                    const tagName = e.target.dataset.tagName;
                    let currentTags = tagsInput.value
                        .split(',')
                        .map(t => t.trim())
                        .filter(t => t.length > 0);

                    if (!currentTags.includes(tagName)) {
                        currentTags.push(tagName);
                        tagsInput.value = currentTags.join(', ');
                    }
                }
            });
        }
    });

    const adminForm = document.getElementById('adminForm');
    const submitBtn = document.getElementById('submitBtn');
    const newsIdInput = document.getElementById('NEWS_ID');

    function editItem(item) {
        newsIdInput.value = item.NEWS_ID;
        document.getElementById('TITLE').value = item.TITLE;
        document.getElementById('POST_DATE').value = item.POST_DATE;
        document.getElementById('CONTENT').value = item.CONTENT;

        if (item.tags && Array.isArray(item.tags)) {
            document.getElementById('tags-input').value = item.tags.map(tag => tag.TAG_NAME).join(', ');
        } else {
            document.getElementById('tags-input').value = '';
        }

        adminForm.action = `{{ url('admin/news') }}/${item.NEWS_ID}`;

        submitBtn.textContent = '更新';
        document.getElementById('preview-container').innerHTML = '';
        loadCurrentImages(item.NEWS_ID);

        adminForm.scrollIntoView({ behavior: 'smooth' });
    }

    function resetForm() {
        adminForm.reset();
        newsIdInput.value = '';
        adminForm.action = "{{ route('admin.news.store') }}";
        submitBtn.textContent = '登録';
        document.getElementById('tags-input').value = '';
        document.getElementById('preview-container').innerHTML = '';
        document.getElementById('current-images-section').classList.add('hidden');
        document.getElementById('current-images-container').innerHTML = '';
    }

    async function loadCurrentImages(newsId) {
        const container = document.getElementById('current-images-container');
        const section = document.getElementById('current-images-section');
        container.innerHTML = '<p class="text-sm text-gray-500 col-span-full">画像を読み込み中...</p>';
        section.classList.remove('hidden');

        try {
            const response = await fetch(`{{ url('admin/news/images') }}/${newsId}`);
            if (!response.ok) throw new Error('Network response was not ok');
            const images = await response.json();
            container.innerHTML = '';
            if (images.length > 0) {
                images.forEach(img => {
                    const div = document.createElement('div');
                    div.className = 'relative group';
                    const isVideo = ['.mp4', '.mov', '.webm'].some(ext => img.FILE_NAME.toLowerCase().endsWith(ext));
                    let mediaElement;
                    if (isVideo) {
                        mediaElement = `<video src="{{ asset('/') }}${img.FILE_PATH}${img.FILE_NAME}#t=0.1" class="object-contain w-full h-32 bg-black rounded-md" controls playsinline preload="metadata"></video>`;
                    } else {
                        mediaElement = `<img src="{{ asset('/') }}${img.FILE_PATH}${img.FILE_NAME}" class="object-contain w-full h-32 bg-black rounded-md">`;
                    }
                    div.innerHTML = `
                        ${mediaElement}
                        <button type="button" onclick="confirmDeleteImage('${img.FILE_NAME}')" class="absolute top-1 right-1 p-0.5 bg-red-600 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    `;
                    container.appendChild(div);
                });
            } else {
                container.innerHTML = '<p class="text-sm text-gray-500 col-span-full">登録済みのメディアはありません。</p>';
            }
        } catch (error) {
            container.innerHTML = '<p class="text-sm text-red-500 col-span-full">メディアの読み込みに失敗しました。</p>';
        }
    }

    function confirmDeleteImage(fileName) {
        if (confirm(`メディア「${fileName}」を削除しますか？この操作は元に戻せません。`)) {
            deleteImage(fileName);
        }
    }

    async function deleteImage(fileName) {
        try {
            const response = await fetch(`{{ url('admin/news/delete-image') }}/${fileName}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            const result = await response.json();
            if (result.success) {
                loadCurrentImages(newsIdInput.value);
            } else {
                alert('エラー: ' + result.error);
            }
        } catch (error) {
            alert('メディアの削除中にエラーが発生しました。');
        }
    }
</script>

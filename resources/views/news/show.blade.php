@extends('layouts.app')

@section('title', $newsItem->TITLE . ' - コスプラットフォーム株式会社')

@section('content')
    <main class="pt-16">
        <section class="relative h-[300px] bg-cover bg-center pt-16"
            style="background-image: url('{{ asset($topImg->FILE_PATH . $topImg->FILE_NAME) }}')">
        </section>
        <h1 class="mt-12 mb-4 text-5xl font-extrabold text-center text-white drop-shadow-md">
            NEWS
        </h1>
        <div class="container px-4 mx-auto max-w-6xl">
            <div class="p-8 my-16 bg-white/80 text-purple-900 rounded-3xl">

                {{-- News Header --}}
                <div class="pb-6 mb-6 border-b border-gray-300">
                    <h1 class="mb-2 text-3xl font-bold text-gray-800 md:text-4xl">
                        {{ $newsItem->TITLE }}
                    </h1>
                    <p class="text-sm text-gray-500">
                        <time datetime="{{ \Carbon\Carbon::parse($newsItem->POST_DATE)->format('Y-m-d') }}">
                            公開日: {{ \Carbon\Carbon::parse($newsItem->POST_DATE)->format('Y/m/d') }}
                        </time>
                    </p>
                </div>

                {{-- News Content --}}
                <div class="prose max-w-none prose-lg text-gray-700 leading-relaxed">
                    <p>
                        {!! nl2br(e($newsItem->CONTENT)) !!}
                    </p>
                </div>

                {{-- Media Gallery --}}
                @if($mediaItems->isNotEmpty())
                    <div class="pt-6 mt-8 border-t border-gray-300">
                        <h2 class="mb-4 text-xl font-bold text-gray-800">関連メディア</h2>
                        <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                            @foreach ($mediaItems as $index => $media)
                                <div class="relative overflow-hidden rounded-lg shadow-md group bg-black">
                                    @if($media['isVideo'])
                                        <video
                                            class="object-cover w-full h-full aspect-video transition-transform duration-300 group-hover:scale-110"
                                            src="{{ $media['src'] }}#t=0.1" playsinline muted loop preload="metadata"></video>
                                        {{-- Clickable Overlay with Play Icon --}}
                                        <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-20 cursor-pointer"
                                            onclick="openMediaPreview({{ $index }})">
                                            <svg class="w-12 h-12 text-white transition-transform duration-300 opacity-80 drop-shadow-lg group-hover:scale-125"
                                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    @else
                                        <img class="object-cover w-full h-full cursor-pointer aspect-video transition-transform duration-300 ease-in-out group-hover:scale-110"
                                            src="{{ $media['src'] }}" alt="{{ $media['alt'] }}"
                                            onclick="openMediaPreview({{ $index }})">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($newsItem->tags->isNotEmpty())
                    <div class="flex flex-wrap items-center gap-2 mt-6 pt-4 border-t border-gray-300">
                        @foreach($newsItem->tags as $tag)
                            <a href="{{ route('tags.search', ['tagName' => $tag->TAG_NAME]) }}"
                                class="px-3 py-1 text-xs font-medium text-white rounded-full transition-transform transform hover:scale-105"
                                style="background-color: {{ $tag->TAG_COLOR }}">
                                #{{ $tag->TAG_NAME }}
                            </a>
                        @endforeach
                    </div>
                @endif

                {{-- Back Button --}}
                <div class="pt-8 mt-8 text-center border-t border-gray-300">
                    <a href="{{ route('news.index') }}#news"
                        class="inline-block px-6 py-3 font-semibold text-white transition-colors duration-300 bg-purple-600 rounded-lg shadow-md hover:bg-purple-700">
                        ニュース一覧へ戻る
                    </a>
                </div>

            </div>
        </div>

        {{-- Media Preview Modal with Arrows --}}
        <div class="fixed inset-0 z-50 items-center justify-center hidden bg-black bg-opacity-80 backdrop-blur-sm"
            id="mediaPreview">
            <span class="absolute text-4xl text-white cursor-pointer top-5 right-9" onclick="closeMediaPreview()">×</span>
            <button id="prevArrow"
                class="absolute p-2 -translate-y-1/2 bg-black bg-opacity-50 rounded-full cursor-pointer left-4 md:left-8 top-1/2"
                onclick="prevMedia()">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <img class="hidden max-w-[85%] max-h-[85%] object-contain rounded-md" id="previewImage" src="" alt="">

            <video class="hidden max-w-[85%] max-h-[85%] object-contain rounded-md" id="previewVideo" src="" controls
                controlsList="nodownload" oncontextmenu="return false;"></video>

            <button id="nextArrow"
                class="absolute p-2 -translate-y-1/2 bg-black bg-opacity-50 rounded-full cursor-pointer right-4 md:right-8 top-1/2"
                onclick="nextMedia()">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        const media = @json($mediaItems);

        const previewOverlay = document.getElementById('mediaPreview');
        const previewImage = document.getElementById('previewImage');
        const previewVideo = document.getElementById('previewVideo');
        const prevButton = document.getElementById('prevArrow');
        const nextButton = document.getElementById('nextArrow');
        let currentIndex = 0;

        function openMediaPreview(index) {
            currentIndex = index;
            updatePreview();
            previewOverlay.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeMediaPreview() {
            previewOverlay.style.display = 'none';
            document.body.style.overflow = '';
            previewVideo.pause();
            previewVideo.currentTime = 0;
        }

        function updatePreview() {
            if (media.length > 0) {
                const currentMedia = media[currentIndex];
                if (currentMedia.isVideo) {
                    previewImage.classList.add('hidden');
                    previewVideo.classList.remove('hidden');
                    previewVideo.src = currentMedia.src;
                    previewVideo.play();
                } else {
                    previewVideo.classList.add('hidden');
                    previewImage.classList.remove('hidden');
                    previewImage.src = currentMedia.src;
                    previewImage.alt = currentMedia.alt;
                }
                prevButton.style.display = currentIndex > 0 ? 'block' : 'none';
                nextButton.style.display = currentIndex < media.length - 1 ? 'block' : 'none';
            }
        }

        function prevMedia() {
            if (currentIndex > 0) {
                currentIndex--;
                updatePreview();
            }
        }

        function nextMedia() {
            if (currentIndex < media.length - 1) {
                currentIndex++;
                updatePreview();
            }
        }

        if (previewOverlay) {
            previewOverlay.addEventListener('click', (e) => (e.target === previewOverlay) && closeMediaPreview());
            document.addEventListener('keydown', (e) => {
                if (previewOverlay.style.display !== 'flex') return;
                if (e.key === 'Escape') closeMediaPreview();
                if (e.key === 'ArrowLeft') prevMedia();
                if (e.key === 'ArrowRight') nextMedia();
            });
        }
    </script>
@endpush
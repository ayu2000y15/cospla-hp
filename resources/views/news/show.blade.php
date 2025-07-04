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
                            公開日: {{ \Carbon\Carbon::parse($newsItem->POST_DATE)->format('Y年n月j日') }}
                        </time>
                    </p>
                </div>

                {{-- News Content --}}
                <div class="prose max-w-none prose-lg text-gray-700 leading-relaxed">
                    <p>
                        {!! nl2br(e($newsItem->CONTENT)) !!}
                    </p>
                </div>

                {{-- Image Gallery --}}
                @php
                    // ->values() を使ってキーを0からの連番にリセットする
                    $images = $newsImgList->where('NEWS_ID', $newsItem->NEWS_ID)->values();
                @endphp

                @if($images->isNotEmpty())
                    <div class="pt-6 mt-8 border-t border-gray-300">
                        <h2 class="mb-4 text-xl font-bold text-gray-800">関連画像</h2>
                        <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                            @foreach ($images as $index => $img)
                                <div class="overflow-hidden rounded-lg shadow-md">
                                    {{-- onclickで画像のインデックスを渡す --}}
                                    <img class="object-cover w-full h-full cursor-pointer aspect-video transition-transform duration-300 ease-in-out hover:scale-110"
                                        src="{{ asset($img->FILE_PATH . $img->FILE_NAME) }}" alt="{{ $img->COMMENT }}"
                                        onclick="openImagePreview({{ $index }})">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Back Button --}}
                <div class="pt-8 mt-8 text-center border-t border-gray-300">
                    <a href="{{ route('home') }}#news"
                        class="inline-block px-6 py-3 font-semibold text-white transition-colors duration-300 bg-purple-600 rounded-lg shadow-md hover:bg-purple-700">
                        ニュース一覧へ戻る
                    </a>
                </div>

            </div>
        </div>

        {{-- Image Preview Modal with Arrows --}}
        <div class="fixed inset-0 z-50 items-center justify-center hidden bg-black bg-opacity-80 backdrop-blur-sm"
            id="imagePreview">
            <span class="absolute text-4xl text-white cursor-pointer top-5 right-9" onclick="closeImagePreview()">×</span>
            {{-- 矢印ボタンにIDを付与 --}}
            <button id="prevArrow"
                class="absolute p-2 -translate-y-1/2 bg-black bg-opacity-50 rounded-full cursor-pointer left-4 md:left-8 top-1/2"
                onclick="prevImage()">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <img class="max-w-[85%] max-h-[85%] object-contain rounded-md" id="previewImage" src="" alt="">
            <button id="nextArrow"
                class="absolute p-2 -translate-y-1/2 bg-black bg-opacity-50 rounded-full cursor-pointer right-4 md:right-8 top-1/2"
                onclick="nextImage()">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        // Laravelから画像の配列をJavaScriptの配列として受け取る
        const images = @json($images->map(function ($img) {
            return [
                'src' => asset($img->FILE_PATH . $img->FILE_NAME),
                'alt' => $img->COMMENT
            ];
        }));

        const previewOverlay = document.getElementById('imagePreview');
        const previewImage = document.getElementById('previewImage');
        const prevButton = document.getElementById('prevArrow');
        const nextButton = document.getElementById('nextArrow');
        let currentIndex = 0;

        function openImagePreview(index) {
            currentIndex = index;
            updatePreview();
            previewOverlay.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeImagePreview() {
            previewOverlay.style.display = 'none';
            document.body.style.overflow = '';
        }

        // 画像と矢印の表示を更新する関数
        function updatePreview() {
            if (images.length > 0) {
                previewImage.src = images[currentIndex].src;
                previewImage.alt = images[currentIndex].alt;
                // 最初の画像なら「前へ」ボタンを非表示
                prevButton.style.display = currentIndex > 0 ? 'block' : 'none';
                // 最後の画像なら「次へ」ボタンを非表示
                nextButton.style.display = currentIndex < images.length - 1 ? 'block' : 'none';
            }
        }

        function prevImage() {
            if (currentIndex > 0) {
                currentIndex--;
                updatePreview();
            }
        }

        function nextImage() {
            if (currentIndex < images.length - 1) {
                currentIndex++;
                updatePreview();
            }
        }

        // モーダルの外側やキーボード操作で閉じるイベント
        if (previewOverlay) {
            previewOverlay.addEventListener('click', (e) => (e.target === previewOverlay) && closeImagePreview());
            document.addEventListener('keydown', (e) => {
                if (previewOverlay.style.display !== 'flex') return;
                if (e.key === 'Escape') closeImagePreview();
                if (e.key === 'ArrowLeft') prevImage();
                if (e.key === 'ArrowRight') nextImage();
            });
        }
    </script>
@endpush
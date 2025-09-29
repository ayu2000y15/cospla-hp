@extends('layouts.app')

@section('title', $talent->LAYER_NAME . ' - コスプラットフォーム株式会社')

@section('content')
<main class="pt-16">
    <section class="relative h-[300px] bg-cover bg-center"
             style="background-image: url('{{ asset($topImg->FILE_PATH . $topImg->FILE_NAME) }}')">
    </section>

    <h1 class="mt-12 mb-4 text-5xl font-extrabold text-center text-white drop-shadow-md">
        TALENT
    </h1>

    <div class="container px-4 mx-auto max-w-6xl">
        <div class="p-4 my-16 md:p-8 bg-white/60 text-purple-900 rounded-3xl">
            <section class="flex flex-col items-center">

                {{-- プロフィール全体を囲むコンテナ --}}
                <div class="flex flex-col w-full gap-4 md:flex-row">

                    {{-- 左側: 画像 --}}
                    <div class="w-full md:w-1/3">
                        @if($talentImgTop)
                            {{-- index と同じ比率ボックス + absolute 画像配置に揃える --}}
                            <div class="relative w-full mb-4 talent-image-container" style="padding-top: 133.33%;">
                                <div class="absolute inset-0">
                                    <img class="absolute inset-0 object-cover w-full h-full p-2.5 transition-opacity duration-500 ease-in-out rounded-2xl "
                                        src="{{ asset($talentImgTop->FILE_PATH . $talentImgTop->FILE_NAME) }}"
                                        alt="{{ $talent->LAYER_NAME }}">
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- 右側: 情報 --}}
                    <div class="w-full md:w-2/3">
                        {{-- SNSアイコン --}}
                        <div class="flex items-center gap-3 mb-2">
                            @if($talentProfile->SNS_1_FLG === '1' && $talent->SNS_1)
                            <a href="{{ $talent->SNS_1 }}" aria-label="X (Twitter)" target="_blank" rel="noopener" class="group flex items-center justify-center w-10 h-10 transition-all duration-300 bg-slate-100 rounded-full hover:bg-pink-400 hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-gray-700 transition-colors duration-300 group-hover:text-white">
                                    <path d="M4 4l11.733 16h4.267l-11.733 -16z" />
                                    <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772" />
                                </svg>
                            </a>
                            @endif
                            @if($talentProfile->SNS_2_FLG === '1' && $talent->SNS_2)
                            <a href="{{ $talent->SNS_2 }}" aria-label="Instagram" target="_blank" rel="noopener" class="group flex items-center justify-center w-10 h-10 transition-all duration-300 bg-slate-100 rounded-full hover:bg-pink-400 hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-gray-700 transition-colors duration-300 group-hover:text-white">
                                    <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                    <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>
                                </svg>
                            </a>
                            @endif
                            @if($talentProfile->SNS_3_FLG === '1' && $talent->SNS_3)
                            <a href="{{ $talent->SNS_3 }}" aria-label="TikTok" target="_blank" rel="noopener" class="group flex items-center justify-center w-10 h-10 transition-all duration-300 bg-slate-100 rounded-full hover:bg-pink-400 hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-gray-700 transition-colors duration-300 group-hover:text-white">
                                    <path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path>
                                </svg>
                            </a>
                            @endif
                        </div>
                        <h2 class="text-3xl mb-2">{{ $talent->LAYER_NAME }}</h2>
                        <h3 class="italic text-lg text-gray-600 mb-4">{{ $talent->LAYER_FURIGANA_EN }}</h3>
                        <hr class="border-t-2 border-purple-800 my-4">
                        <div class="w-full mb-6">
                            <table class="w-full text-left">
                                <tbody>
                                    @if($talentProfile->BIRTHDAY_FLG === '1' || $talentProfile->BIRTHDAY_FLG === '2')
                                    <tr class="border-b border-gray-300">
                                        <th class="py-2 pr-4 font-bold text-purple-900 w-1/3">BIRTHDAY</th>
                                        <td class="py-2">
                                            @if($talentProfile->BIRTHDAY_FLG === '1')
                                                {{ date('Y/n/j', strtotime($talent->BIRTHDAY)) }}
                                            @elseif($talentProfile->BIRTHDAY_FLG === '2')
                                                {{ date('n/j', strtotime($talent->BIRTHDAY)) }}
                                            @endif
                                        </td>
                                    </tr>
                                    @endif
                                    @if($talentProfile->AGE_FLG === '1' && $talent->AGE)
                                    <tr class="border-b border-gray-300">
                                        <th class="py-2 pr-4 font-bold text-purple-900">AGE</th>
                                        <td class="py-2">{{ $talent->AGE }}</td>
                                    </tr>
                                    @endif
                                    @if($talentProfile->FOLLOWERS_FLG === '1' && $talent->FOLLOWERS)
                                     <tr class="border-b border-gray-300">
                                        <th class="py-2 pr-4 font-bold text-purple-900">FOLLOWERS</th>
                                        <td class="py-2">{{ number_format($talent->FOLLOWERS) }}</td>
                                    </tr>
                                    @endif
                                     @if($talentProfile->HEIGHT_FLG === '1' && $talent->HEIGHT)
                                    <tr class="border-b border-gray-300">
                                        <th class="py-2 pr-4 font-bold text-purple-900">SIZE</th>
                                        <td class="py-2">Height: {{ $talent->HEIGHT }} cm</td>
                                    </tr>
                                    @endif
                                    @if($talentProfile->THREE_SIZES_FLG === '1')
                                     <tr class="border-b border-gray-300">
                                        <th class="py-2 pr-4 font-bold text-purple-900"></th>
                                        <td class="py-2">
                                            @if($talentProfile->THREE_SIZES_B_FLG === '1')B:{{ $talent->THREE_SIZES_B }} @endif
                                            @if($talentProfile->THREE_SIZES_W_FLG === '1')W:{{ $talent->THREE_SIZES_W }} @endif
                                            @if($talentProfile->THREE_SIZES_H_FLG === '1')H:{{ $talent->THREE_SIZES_H }} @endif
                                        </td>
                                    </tr>
                                    @endif
                                    @if($talentProfile->HOBBY_SPECIALTY_FLG === '1' && $talent->HOBBY_SPECIALTY)
                                    <tr class="border-b border-gray-300">
                                        <th class="py-2 pr-4 font-bold text-purple-900">HOBBY / SPECIALTY</th>
                                        <td class="py-2">{{ $talent->HOBBY_SPECIALTY }}</td>
                                    </tr>
                                    @endif
                                    @if($talentProfile->COMMENT_FLG === '1' && $talent->COMMENT)
                                    <tr class="border-b-0">
                                        <th class="py-2 pr-4 font-bold text-purple-900">COMMENT</th>
                                        <td class="py-2">{!! nl2br(e($talent->COMMENT)) !!}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="flex flex-wrap gap-2 mt-4">
                            @foreach($talentTag as $tag)
                                <a href="{{ route('tags.search', ['tagName' => $tag->TAG_NAME]) }}" class="px-3 py-1 text-sm font-medium text-white rounded-full transition-transform transform hover:scale-105" style="background-color: {{ $tag->TAG_COLOR }};">
                                    #{{ $tag->TAG_NAME }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- ボタンとコンテンツエリア --}}
                <div class="flex justify-center w-full gap-4 mt-8">
                    <button class="px-8 py-3 text-lg border-2 rounded-full cursor-pointer photos-button transition-colors duration-300 bg-purple-700 text-white border-purple-700">PHOTOS</button>
                    <button class="px-8 py-3 text-lg border-2 rounded-full cursor-pointer career-button transition-colors duration-300 bg-white text-purple-700 border-purple-700 hover:bg-purple-700 hover:text-white">CAREER</button>
                </div>

                {{-- Photos Gallery Area --}}
                <div class="w-full mt-8 photos-info">
                    <div class="relative photos-slider-container">
                        <div class="flex overflow-x-auto scrolling-touch photos-grid snap-x snap-mandatory">
                            @foreach($talentImg as $index => $img)
                            <div class="w-1/2 md:w-1/4 flex-shrink-0 snap-center p-2 photo-item" data-index="{{ $index }}">
                                <img src="{{ asset($img->FILE_PATH . $img->FILE_NAME) }}" alt="{{ $img->ALT }}" loading="lazy" class="object-cover w-full h-full rounded-lg shadow-md cursor-pointer aspect-square transition-transform duration-300 hover:scale-105">
                            </div>
                            @endforeach
                        </div>
                        <button class="absolute p-2 -translate-y-1/2 bg-black bg-opacity-50 rounded-full slider-arrow prev-arrow top-1/2 left-2" aria-label="前の画像へ">
                             <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <button class="absolute p-2 -translate-y-1/2 bg-black bg-opacity-50 rounded-full slider-arrow next-arrow top-1/2 right-2" aria-label="次の画像へ">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>

                {{-- Career Area --}}
                <div class="w-full mt-8 career-info" style="display: none;">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach($careerCategory as $category)
                        <div class="p-6 bg-gray-100 rounded-lg shadow-md">
                            <h3 class="text-xl font-bold text-purple-900">{{ $category->CAREER_CATEGORY_NAME }}</h3>
                            <hr class="my-2 border-t-2 border-purple-800">
                            <ul>
                                @foreach($talentCareer as $career)
                                    @if($category->CAREER_CATEGORY_ID === $career->CAREER_CATEGORY_ID)
                                    <li class="flex flex-col pt-3 pb-3 border-b border-dashed md:flex-row border-purple-300">
                                        {{-- === 日付表示ロジックをここに追加 === --}}
                                        <span class="w-full mb-1 font-semibold text-gray-600 md:w-1/3 md:mb-0">
                                            @if($career->SPARE2 === '1')
                                                {{ date('Y/n/j', strtotime($career->ACTIVE_DATE)) }}
                                            @elseif($career->SPARE2 === '2')
                                                {{ date('Y/n', strtotime($career->ACTIVE_DATE)) }}
                                            @elseif($career->SPARE2 === '3')
                                                {{ date('Y', strtotime($career->ACTIVE_DATE)) }}
                                            @endif
                                        </span>
                                        <span class="flex-1">{!! nl2br(e($career->CONTENT)) !!}</span>
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>

    {{-- 画像プレビュー用のモーダル --}}
    <div id="preview-overlay" class="fixed inset-0 z-50 items-center justify-center hidden bg-black bg-opacity-80 backdrop-blur-sm">
        <span class="absolute text-4xl text-white cursor-pointer top-4 right-6 close-preview">&times;</span>
        <button class="absolute p-2 -translate-y-1/2 bg-black bg-opacity-50 rounded-full preview-arrow preview-prev top-1/2 left-4 md:left-8" aria-label="前の画像">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <img class="max-w-[90%] max-h-[90%] object-contain rounded-md shadow-lg" id="preview-image" src="" alt="">
        <button class="absolute p-2 -translate-y-1/2 bg-black bg-opacity-50 rounded-full preview-arrow preview-next top-1/2 right-4 md:right-8" aria-label="次の画像">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
    </div>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const talentImages = @json($talentImg->map(function($img) {
        return ['src' => asset($img->FILE_PATH . $img->FILE_NAME), 'alt' => $img->ALT];
    })->values());

    // --- Tab Switching ---
    const careerButton = document.querySelector('.career-button');
    const photosButton = document.querySelector('.photos-button');
    const careerInfo = document.querySelector('.career-info');
    const photosInfo = document.querySelector('.photos-info');

    if (careerButton && photosButton && careerInfo && photosInfo) {
        const setActiveButton = (activeBtn) => {
            [photosButton, careerButton].forEach(btn => {
                btn.classList.remove('bg-purple-700', 'text-white');
                btn.classList.add('bg-white', 'text-purple-700');
            });
            activeBtn.classList.add('bg-purple-700', 'text-white');
            activeBtn.classList.remove('bg-white', 'text-purple-700');
        };

        careerButton.addEventListener('click', () => {
            careerInfo.style.display = 'block';
            photosInfo.style.display = 'none';
            setActiveButton(careerButton);
        });

        photosButton.addEventListener('click', () => {
            photosInfo.style.display = 'block';
            careerInfo.style.display = 'none';
            setActiveButton(photosButton);
        });
    }

    // --- Photo Gallery Slider ---
    const sliderContainer = document.querySelector('.photos-slider-container');
    const photosGrid = document.querySelector('.photos-grid');
    const prevArrow = document.querySelector('.prev-arrow');
    const nextArrow = document.querySelector('.next-arrow');

    if (sliderContainer && photosGrid && prevArrow && nextArrow) {
        const scrollAmount = photosGrid.querySelector('.photo-item').offsetWidth;
        prevArrow.addEventListener('click', () => {
            photosGrid.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        });
        nextArrow.addEventListener('click', () => {
            photosGrid.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        });
    }

    // --- Image Preview Modal ---
    const photoItems = document.querySelectorAll('.photo-item');
    const previewOverlay = document.getElementById('preview-overlay');
    const previewImage = document.getElementById('preview-image');
    const closePreviewBtn = document.querySelector('.close-preview');
    const prevPreviewBtn = document.querySelector('.preview-prev');
    const nextPreviewBtn = document.querySelector('.preview-next');
    let currentImageIndex = 0;

    if (previewOverlay) {
        const openPreview = (index) => {
            currentImageIndex = index;
            updatePreviewImage();
            previewOverlay.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        };

        const closePreview = () => {
            previewOverlay.style.display = 'none';
            document.body.style.overflow = '';
        };

        const updatePreviewImage = () => {
            previewImage.src = talentImages[currentImageIndex].src;
            previewImage.alt = talentImages[currentImageIndex].alt;
            prevPreviewBtn.style.display = currentImageIndex > 0 ? 'block' : 'none';
            nextPreviewBtn.style.display = currentImageIndex < talentImages.length - 1 ? 'block' : 'none';
        };

        photoItems.forEach(item => {
            item.addEventListener('click', () => {
                openPreview(parseInt(item.dataset.index));
            });
        });

        prevPreviewBtn.addEventListener('click', () => {
            if (currentImageIndex > 0) {
                currentImageIndex--;
                updatePreviewImage();
            }
        });
        nextPreviewBtn.addEventListener('click', () => {
            if (currentImageIndex < talentImages.length - 1) {
                currentImageIndex++;
                updatePreviewImage();
            }
        });

        closePreviewBtn.addEventListener('click', closePreview);
        previewOverlay.addEventListener('click', (e) => (e.target === previewOverlay) && closePreview());
        document.addEventListener('keydown', (e) => (e.key === 'Escape') && closePreview());
    }
});
</script>
@endpush

@extends('layouts.app')

@section('title', 'TALENT - COSPLATFORM')

@section('content')
<main>
    <section class="subpage-hero">
        <h1>TALENT</h1>
    </section>
    <div class="container">
        <div class="container-box profile">
            <section class="profile-page center-content">
                <div class="profile-content">
                    <div class="profile-image">
                        <img src="{{ asset($talentImgTop->FILE_PATH . $talentImgTop->FILE_NAME) }}"
                            alt="{{ $talent->LAYER_NAME }}">
                    </div>
                    <div class="profile-info">
                        <div class="social-icons profile">
                            @if($talentProfile->SNS_1_FLG === '1')
                            <a href="{{ $talent->SNS_1 }}" aria-label="X (Twitter)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M4 4l11.733 16h4.267l-11.733 -16z" />
                                    <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772" />
                                </svg>
                            </a>
                            @endif
                            @if($talentProfile->SNS_2_FLG === '1')
                            <a href="{{ $talent->SNS_2 }}" aria-label="Instagram">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                    <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>
                                </svg>
                            </a>
                            @endif
                            @if($talentProfile->SNS_3_FLG === '1')
                            <a href="{{ $talent->SNS_3 }}" aria-label="TikTok">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path>
                                </svg>
                            </a>
                            @endif
                        </div>
                        <h2 class="talent-name">{{ $talent->LAYER_NAME }}</h2>
                        <h3 class="talent-name-en">{{ $talent->LAYER_FURIGANA_EN }}</h3>
                        <hr class="hr-line">
                        <div class="talent-details">
                            <table>
                                @if($talentProfile->BIRTHDAY_FLG === '1' || $talentProfile->BIRTHDAY_FLG === '2')
                                <tr>
                                    <th>BIRTHDAY</th>
                                    <td>
                                        @if($talentProfile->BIRTHDAY_FLG === '1')
                                            {{ date('Y/n/j', strtotime($talent->BIRTHDAY)) }}
                                        @elseif($talentProfile->BIRTHDAY_FLG === '2')
                                            {{ date('n/j', strtotime($talent->BIRTHDAY)) }}
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @if($talentProfile->AGE_FLG === '1')
                                <tr>
                                    <th>AGE</th>
                                    <td>{{ $talent->AGE }}</td>
                                </tr>
                                @endif
                                @if($talentProfile->FOLLOWERS_FLG === '1')
                                <tr>
                                    <th>FOLLOWERS</th>
                                    <td>{{ $talent->FOLLOWERS }}</td>
                                </tr>
                                @endif
                                @if($talentProfile->HEIGHT_FLG === '1' || $talentProfile->THREE_SIZES_FLG === '1')
                                <tr>
                                    <th rowspan="{{ ($talentProfile->HEIGHT_FLG === '1' ? 1 : 0) + ($talentProfile->THREE_SIZES_FLG === '1' ? 1 : 0) + 1 }}">SIZE</th>
                                    <td style="display: none;"></td>
                                </tr>
                                @if($talentProfile->HEIGHT_FLG === '1')
                                <tr>
                                    <td colspan="1">Height: {{ $talent->HEIGHT }}</td>
                                </tr>
                                @endif
                                @if($talentProfile->THREE_SIZES_FLG === '1')
                                <tr>
                                    <td colspan="1">
                                        @if($talentProfile->THREE_SIZES_B_FLG === '1')
                                            B:{{ $talent->THREE_SIZES_B }}
                                        @endif
                                        @if($talentProfile->THREE_SIZES_W_FLG === '1')
                                            W:{{ $talent->THREE_SIZES_W }}
                                        @endif
                                        @if($talentProfile->THREE_SIZES_H_FLG === '1')
                                            H:{{ $talent->THREE_SIZES_H }}
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @endif
                                @if($talentProfile->HOBBY_SPECIALTY_FLG === '1')
                                <tr>
                                    <th>HOBBY / SPECIALTY</th>
                                    <td>{{ $talent->HOBBY_SPECIALTY }}</td>
                                </tr>
                                @endif
                                @if($talentProfile->COMMENT_FLG === '1')
                                <tr>
                                    <th>COMMENT</th>
                                    <td>{!! nl2br(e($talent->COMMENT)) !!}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div class="tag-container">
                            @foreach($talentTag as $tag)
                                <span class="tag" style="background-color: {{ $tag->TAG_COLOR }};">#{{ $tag->TAG_NAME }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="action-buttons">
                    <button class="button photos-button" active>PHOTOS</button>
                    <button class="button career-button">CAREER</button>
                </div>
                <div class="photos-info">
                    <div class="photos-slider-container">
                        <button class="slider-arrow prev-arrow" aria-label="前の画像へ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M15 18l-6-6 6-6" />
                            </svg>
                        </button>
                        <div class="photos-grid">
                            @foreach($talentImg as $img)
                            <div class="photo-item" tabindex="0">
                                <img src="{{ asset($img->FILE_PATH . $img->FILE_NAME) }}" alt="{{ $img->ALT }}" loading="lazy">
                            </div>
                            @endforeach
                        </div>
                        <button class="slider-arrow next-arrow" aria-label="次の画像へ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M9 18l6-6-6-6" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="career-info" style="display: none;">
                    <div class="career-categories">
                        @foreach($careerCategory as $category)
                        <div class="career-category">
                            <h3>{{ $category->CAREER_CATEGORY_NAME }}</h3>
                            <hr class="hr-line">
                            <ul>
                                @foreach($talentCareer as $career)
                                @php
                                \Debugbar::addMessage($career);
                                @endphp
                                    @if($category->CAREER_CATEGORY_ID === $career->CAREER_CATEGORY_ID)
                                    <li>
                                        <span class="career-date">{{ $career->ACTIVE_DATE }}</span>
                                        <span class="career-content">{{ $career->CONTENT }}</span>
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
    <div class="preview-overlay">
        <img src="" alt="" class="preview-image">
        <span class="close-preview">&times;</span>
    </div>
</main>
@endsection

@push('styles')
<style>
    body {
        background-image: url("{{ asset($backImg->FILE_PATH . $backImg->FILE_NAME) }}");
    }

    .subpage-hero {
        background-image: url("{{ asset($topImg->FILE_PATH . $topImg->FILE_NAME) }}");
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const careerButton = document.querySelector('.career-button');
        const photosButton = document.querySelector('.photos-button');
        const careerInfo = document.querySelector('.career-info');
        const photosInfo = document.querySelector('.photos-info');
        const sliderContainer = document.querySelector('.photos-slider-container');
        const photosGrid = document.querySelector('.photos-grid');
        const prevArrow = document.querySelector('.prev-arrow');
        const nextArrow = document.querySelector('.next-arrow');
        const photoItems = document.querySelectorAll('.photo-item');
        const previewOverlay = document.querySelector('.preview-overlay');
        const previewImage = document.querySelector('.preview-image');
        const closePreview = document.querySelector('.close-preview');
        const previewPrevArrow = document.createElement('button');
        const previewNextArrow = document.createElement('button');

        let currentPosition = 0;
        let startX = 0;
        let scrollLeft = 0;
        let isDragging = false;
        let currentPreviewIndex = 0;

        // プレビューオーバーレイを初期状態で非表示にする
        previewOverlay.style.display = 'none';

        function hideAllSections() {
            careerInfo.style.display = 'none';
            photosInfo.style.display = 'none';
            careerButton.classList.remove('active');
            photosButton.classList.remove('active');
        }

        careerButton.addEventListener('click', function() {
            hideAllSections();
            careerInfo.style.display = 'block';
            careerButton.classList.add('active');
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

        // プレビュー機能の拡張
        previewPrevArrow.classList.add('preview-arrow', 'preview-prev-arrow');
        previewPrevArrow.innerHTML = '&lt;';
        previewPrevArrow.setAttribute('aria-label', '前の画像');
        previewNextArrow.classList.add('preview-arrow', 'preview-next-arrow');
        previewNextArrow.innerHTML = '&gt;';
        previewNextArrow.setAttribute('aria-label', '次の画像');
        previewOverlay.appendChild(previewPrevArrow);
        previewOverlay.appendChild(previewNextArrow);

        function showPreview(index) {
            const img = photoItems[index].querySelector('img');
            previewImage.src = img.src;
            previewImage.alt = img.alt;
            previewOverlay.style.display = 'flex';
            currentPreviewIndex = index;
            updatePreviewArrows();
        }

        function updatePreviewArrows() {
            previewPrevArrow.style.display = currentPreviewIndex > 0 ? 'block' : 'none';
            previewNextArrow.style.display = currentPreviewIndex < photoItems.length - 1 ? 'block' : 'none';
        }

        photoItems.forEach((item, index) => {
            item.addEventListener('click', function() {
                showPreview(index);
            });

            item.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    showPreview(index);
                }
            });
        });

        previewPrevArrow.addEventListener('click', function() {
            if (currentPreviewIndex > 0) {
                showPreview(currentPreviewIndex - 1);
            }
        });

        previewNextArrow.addEventListener('click', function() {
            if (currentPreviewIndex < photoItems.length - 1) {
                showPreview(currentPreviewIndex + 1);
            }
        });

        closePreview.addEventListener('click', function() {
            previewOverlay.style.display = 'none';
        });

        previewOverlay.addEventListener('click', function(e) {
            if (e.target === this) {
                this.style.display = 'none';
            }
        });

        // キーボードナビゲーションの追加
        document.addEventListener('keydown', function(e) {
            if (previewOverlay.style.display === 'flex') {
                if (e.key === 'ArrowLeft' && currentPreviewIndex > 0) {
                    showPreview(currentPreviewIndex - 1);
                } else if (e.key === 'ArrowRight' && currentPreviewIndex < photoItems.length - 1) {
                    showPreview(currentPreviewIndex + 1);
                } else if (e.key === 'Escape') {
                    previewOverlay.style.display = 'none';
                }
            }
        });

        function getVisibleSlides() {
            if (window.innerWidth >= 1024) return 4;
            if (window.innerWidth >= 768) return 3;
            if (window.innerWidth >= 640) return 2;
            return 1;
        }

        function updateSliderLayout() {
            const visibleSlides = getVisibleSlides();
            const slideWidth = 100 / visibleSlides;
            photoItems.forEach(item => {
                item.style.flex = `0 0 ${slideWidth}%`;
                item.style.maxWidth = `${slideWidth}%`;
            });
            currentPosition = 0;
            updateSlidePosition();
            updateArrowVisibility();
        }

        function updateSlidePosition() {
            photosGrid.style.transition = 'transform 0.5s ease';
            photosGrid.style.transform = `translateX(-${currentPosition}%)`;
        }

        function moveSlider(direction) {
            const slideWidth = 100 / getVisibleSlides();
            const maxPosition = (photoItems.length - getVisibleSlides()) * slideWidth;
            currentPosition = Math.max(0, Math.min(currentPosition + direction * slideWidth, maxPosition));
            updateSlidePosition();
            updateArrowVisibility();
        }

        function updateArrowVisibility() {
            const maxPosition = (photoItems.length - getVisibleSlides()) * (100 / getVisibleSlides());
            prevArrow.style.display = currentPosition <= 0 ? 'none' : 'flex';
            nextArrow.style.display = currentPosition >= maxPosition ? 'none' : 'flex';
        }

        prevArrow.addEventListener('click', () => moveSlider(-1));
        nextArrow.addEventListener('click', () => moveSlider(1));

        // タッチイベントの処理
        function handleTouchStart(e) {
            isDragging = true;
            startX = e.touches[0].pageX - sliderContainer.offsetLeft;
            scrollLeft = currentPosition;
            photosGrid.style.transition = 'none';
        }

        function handleTouchMove(e) {
            if (!isDragging) return;
            e.preventDefault();
            const x = e.touches[0].pageX - sliderContainer.offsetLeft;
            const walk = (x - startX) * 2;
            currentPosition = scrollLeft - walk / sliderContainer.offsetWidth * 100;
            photosGrid.style.transform = `translateX(-${currentPosition}%)`;
        }

        function handleTouchEnd() {
            isDragging = false;
            photosGrid.style.transition = 'transform 0.5s ease';
            snapToNearestSlide();
            updateArrowVisibility();
        }

        function snapToNearestSlide() {
            const slideWidth = 100 / getVisibleSlides();
            const nearestSlide = Math.round(currentPosition / slideWidth);
            currentPosition = nearestSlide * slideWidth;
            updateSlidePosition();
        }

        sliderContainer.addEventListener('touchstart', handleTouchStart, {
            passive: false
        });
        sliderContainer.addEventListener('touchmove', handleTouchMove, {
            passive: false
        });
        sliderContainer.addEventListener('touchend', handleTouchEnd);

        window.addEventListener('resize', () => {
            currentPosition = 0;
            updateSliderLayout();
        });

        updateSliderLayout();
    });
</script>
@endpush
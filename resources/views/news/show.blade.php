@extends('layouts.app')

@section('title', 'NEWS - コスプラットフォーム株式会社')

@section('content')
    <main>
        <section class="subpage-hero">
            <h1>NEWS</h1>
        </section>
        <div class="container">
            <div class="container-box news-page">
                <div class="news-page-header">
                    <h2>{{ $newsItem->TITLE }}</h2>
                    <div class="news-page-date">
                        <p>{{ $newsItem->POST_DATE }}</p>
                    </div>
                </div>
                <hr class="hr-line">
                @php
                    if (class_exists('App\Services\PlanetextToUrl')) {
                        $convert = new \App\Services\PlanetextToUrl;
                        $newsItem->CONTENT = $convert->convertLink($newsItem->CONTENT);
                    }
                @endphp
                <p>{!! nl2br($newsItem->CONTENT) !!}</p>

                @php
                    $imageCount = 0;
                    foreach ($newsImgList as $img) {
                        if ($newsItem->NEWS_ID == $img->NEWS_ID) {
                            $imageCount++;
                        }
                    }
                @endphp

                <div class="news-img {{ $imageCount === 1 ? 'single-image' : '' }}">
                    @foreach ($newsImgList as $img)
                        @if($newsItem->NEWS_ID == $img->NEWS_ID)
                            <img class="news-photo" src="{{ asset($img->FILE_PATH . $img->FILE_NAME) }}" alt="{{ $img->COMMENT }}"
                                onclick="openImagePreview('{{ asset($img->FILE_PATH . $img->FILE_NAME) }}', '{{ $img->COMMENT }}')">
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <!-- 画像プレビューオーバーレイ -->
        <div class="preview-overlay" id="imagePreview">
            <span class="close-preview" onclick="closeImagePreview()">&times;</span>
            <img class="preview-image" id="previewImage" src="/placeholder.svg" alt="">
            <button class="preview-arrow preview-prev-arrow" id="prevImage"
                onclick="changePreviewImage(-1)">&#10094;</button>
            <button class="preview-arrow preview-next-arrow" id="nextImage"
                onclick="changePreviewImage(1)">&#10095;</button>
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
        // 画像プレビュー機能
        let currentImageIndex = 0;
        let newsImages = [];

        // 画像データを配列に格納
        @foreach ($newsImgList as $img)
            @if($newsItem->NEWS_ID == $img->NEWS_ID)
                newsImages.push({
                    src: "{{ asset($img->FILE_PATH . $img->FILE_NAME) }}",
                    alt: "{{ $img->COMMENT }}"
                });
            @endif
        @endforeach

            function openImagePreview(src, alt) {
                const preview = document.getElementById('imagePreview');
                const previewImg = document.getElementById('previewImage');

                // クリックされた画像のインデックスを取得
                currentImageIndex = newsImages.findIndex(img => img.src === src);

                previewImg.src = src;
                previewImg.alt = alt;
                preview.style.display = 'flex';

                // 画像が1枚しかない場合は矢印を非表示
                const prevArrow = document.getElementById('prevImage');
                const nextArrow = document.getElementById('nextImage');

                if (newsImages.length <= 1) {
                    prevArrow.style.display = 'none';
                    nextArrow.style.display = 'none';
                } else {
                    prevArrow.style.display = 'block';
                    nextArrow.style.display = 'block';
                }

                // スクロールを無効化
                document.body.style.overflow = 'hidden';
            }

        function closeImagePreview() {
            document.getElementById('imagePreview').style.display = 'none';
            // スクロールを有効化
            document.body.style.overflow = '';
        }

        function changePreviewImage(step) {
            currentImageIndex = (currentImageIndex + step + newsImages.length) % newsImages.length;
            const previewImg = document.getElementById('previewImage');
            previewImg.src = newsImages[currentImageIndex].src;
            previewImg.alt = newsImages[currentImageIndex].alt;
        }

        // ESCキーでプレビューを閉じる
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeImagePreview();
            } else if (event.key === 'ArrowLeft') {
                changePreviewImage(-1);
            } else if (event.key === 'ArrowRight') {
                changePreviewImage(1);
            }
        });
    </script>
@endpush
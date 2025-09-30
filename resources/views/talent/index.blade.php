@extends('layouts.app')

@section('title', 'TALENT - コスプラットフォーム株式会社')

@section('content')
    <style>
        /* ページ全体のスムーズスクロール */
        html {
            scroll-behavior: smooth;
        }

        /* 横スクロールのギャラリーも滑らかに */
        .photos-grid,
        .photos-slider-container,
        .photos-info {
            scroll-behavior: smooth;
        }
    </style>

    <main class="pt-16">
        <section class="relative h-[300px] bg-cover bg-center pt-16"
            style="background-image: url('{{ asset($topImg->FILE_PATH . $topImg->FILE_NAME) }}')">
        </section>
        <h1 class="mt-12 mb-4 text-5xl font-extrabold text-center text-white drop-shadow-md">
            TALENT
        </h1>
        <div class="container px-4 mx-auto max-w-6xl">
            <div class="p-8 my-16 bg-white/60 text-purple-900 rounded-3xl">
                <section class="px-4">
                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                        @foreach($talentImg as $talent)
                            <div class="flex flex-col items-center mb-4 text-center">
                                {{-- フォームでの画面遷移に変更 --}}
                                <form action="{{ route('talent.show') }}" method="POST" class="w-full">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $talent->TALENT_ID }}">
                                    {{-- 画像を重ねるコンテナと、その上に透明な送信ボタンを配置 --}}
                                    <div class="relative w-full mb-4 talent-image-container" style="padding-top: 133.33%;">
                                        <div class="absolute inset-0">
                                            {{-- 通常時の画像 --}}
                                            <img class="absolute inset-0 object-cover w-full h-full p-2.5 transition-opacity duration-500 ease-in-out rounded-2xl"
                                                style="background: linear-gradient(to right, #ffd1dc, #e6e6fa);"
                                                src="{{ asset($talent->FILE_PATH1 . $talent->FILE_NAME1) }}"
                                                alt="{{ $talent->ALT1 }}">
                                            {{-- ホバー/タップ時の画像 --}}
                                            <img class="absolute inset-0 object-cover w-full h-full p-2.5 transition-opacity duration-500 ease-in-out rounded-2xl opacity-0"
                                                style="background: linear-gradient(to right, #ffd1dc, #e6e6fa);"
                                                src="{{ asset($talent->FILE_PATH2 . $talent->FILE_NAME2) }}"
                                                alt="{{ $talent->ALT2 }}">
                                            {{-- クリック/タップを検知するための透明なボタン --}}
                                            <button type="submit"
                                                class="absolute inset-0 w-full h-full bg-transparent border-none cursor-pointer"></button>
                                        </div>
                                    </div>
                                </form>
                                <h2 class="text-xl font-semibold break-words md:text-2xl">{{ $talent->LAYER_NAME }}</h2>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const talentImageContainers = document.querySelectorAll('.talent-image-container');

            talentImageContainers.forEach(container => {
                const images = container.querySelectorAll('img');
                if (images.length < 2) return;

                const originalImage = images[0];
                const hoverImage = images[1];

                // 画像を切り替える関数
                const showHoverImage = () => {
                    originalImage.classList.add('opacity-0');
                    hoverImage.classList.remove('opacity-0');
                };
                const showOriginalImage = () => {
                    hoverImage.classList.add('opacity-0');
                    originalImage.classList.remove('opacity-0');
                };

                // PCでのマウスホバー操作
                container.addEventListener('mouseenter', showHoverImage);
                container.addEventListener('mouseleave', showOriginalImage);

                // スマートフォンでのタップ操作
                const button = container.querySelector('button');
                button.addEventListener('touchend', function (e) {
                    // 2枚目の画像が表示されている（=既に一度タップされている）かチェック
                    const isHovered = !hoverImage.classList.contains('opacity-0');

                    if (!isHovered) {
                        // 最初のタップなら、ページの遷移をキャンセルして画像を切り替える
                        e.preventDefault();
                        showHoverImage();
                    }
                    // 2回目のタップであれば、デフォルトの動作（フォーム送信）が実行される
                });

                // 他の場所をタップしたら画像を元に戻す
                document.addEventListener('click', function (event) {
                    if (!container.contains(event.target)) {
                        showOriginalImage();
                    }
                }, true);
            });
        });
    </script>
@endpush
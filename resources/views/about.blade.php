@extends('layouts.app')

@section('title', 'ABOUT - コスプラットフォーム株式会社')

@section('content')
    <main class="pt-16">
        {{-- ご指定のタイトル部に差し替え --}}
        <section class="relative h-[300px] bg-cover bg-center pt-16"
            style="background-image: url('{{ asset($topImg->FILE_PATH . $topImg->FILE_NAME) }}')">
        </section>
        <h1 class="mt-12 mb-4 text-5xl font-extrabold text-center text-white drop-shadow-md">
            ABOUT
        </h1>

        <div class="container px-4 mx-auto max-w-6xl">
            <div class="p-8 my-16 bg-white/60 text-purple-900 rounded-3xl">
                <section class="about-content">
                    <div class="company-philosophy">
                        @foreach($aboutImg as $img)
                            {{-- スマホ表示の際の余白を調整 --}}
                            <div class="flex items-center justify-center mb-8">
                                <img src="{{ asset($img->FILE_PATH . $img->FILE_NAME) }}" alt="{{ $img->ALT }}"
                                    class="max-w-full max-h-[60vh] object-contain">
                            </div>
                        @endforeach
                        <p class="text-center text-2xl">日本のポップカルチャーとして浸透しているアニメ、ゲーム、マンガ。</p>
                        <p class="text-center text-2xl">そこから生まれた新たな文化"コスプレ"を通じて世界とつながる。</p>
                    </div>
                    <br>
                    <hr class="border-t-2 border-purple-800 my-4">
                    <div class="flex flex-col md:flex-row gap-8 mt-4">
                        <div class="flex-1 min-w-[300px]">
                            <h2 class="text-center text-3xl font-bold mb-4">会社情報</h2>
                            <table class="w-full border-collapse">
                                @foreach($company as $info)
                                    <tr>
                                        <th class="p-2 border-b border-gray-300 text-left w-1/3 font-bold">社名</th>
                                        <td class="p-2 border-b border-gray-300">{{ $info->COMPANY_NAME }}</td>
                                    </tr>
                                    <tr>
                                        <th class="p-2 border-b border-gray-300 text-left w-1/3 font-bold">設立</th>
                                        <td class="p-2 border-b border-gray-300">{{ $info->ESTABLISHMENT_DATE }}</td>
                                    </tr>
                                    <tr>
                                        <th class="p-2 border-b border-gray-300 text-left w-1/3 font-bold">代表者</th>
                                        <td class="p-2 border-b border-gray-300">{{ $info->DIRECTOR }}</td>
                                    </tr>
                                    <tr>
                                        <th class="p-2 border-b border-gray-300 text-left w-1/3 font-bold">所在地</th>
                                        <td class="p-2 border-b border-gray-300">
                                            〒{{ $info->POST_CODE }}<br>{{ $info->LOCATION }}</td>
                                    </tr>
                                    <tr>
                                        <th class="p-2 border-b border-gray-300 text-left w-1/3 font-bold">事業内容</th>
                                        <td class="p-2 border-b border-gray-300">{{ $info->CONTENT }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="flex-1 min-w-[300px]">
                            <div class="h-72 w-full">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3242.037965847441!2d139.7522089744507!3d35.65143623161238!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188bc9aa4d5501%3A0xe102ca70d90a035!2z44CSMTA1LTAwMTQg5p2x5Lqs6YO95riv5Yy66Iqd77yR5LiB55uu77yZ4oiS77ySIOODmeODq-ODoeOCvuODs-iKnQ!5e0!3m2!1sja!2sjp!4v1729588892291!5m2!1sja!2sjp"
                                    class="w-full h-full" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>
@endsection
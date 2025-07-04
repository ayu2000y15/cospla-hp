@extends('layouts.app')

@section('title', 'プライバシーポリシー - コスプラットフォーム株式会社')

@section('content')
    <main>
        <section class="relative h-[300px] bg-cover bg-center pt-16"
            style="background-image: url('{{ asset($topImg->FILE_PATH . $topImg->FILE_NAME) }}')">
        </section>
        <h1 class="mt-12 mb-4 text-5xl font-extrabold text-center text-white drop-shadow-md">
            プライバシーポリシー
        </h1>
        <div class="container px-4 mx-auto max-w-6xl">
            <div class="p-8 my-16 bg-white/60 text-purple-900 rounded-3xl">
                <div class="max-w-3xl p-5 mx-auto">
                    <section class="mb-4">
                        <h2 class="text-2xl mt-6 mb-2">1. 個人情報の収集について</h2>
                        <p class="mb-4">当社は、以下の場合に個人情報を収集することがあります：</p>
                        <ul class="pl-5 mb-4 list-disc">
                            <li>ウェブサイトでのアカウント作成時</li>
                            <li>お問い合わせフォームの利用時</li>
                            <li>ニュースレターの購読時</li>
                        </ul>
                    </section>

                    <section class="mb-4">
                        <h2 class="text-2xl mt-6 mb-2">2. 個人情報の利用目的</h2>
                        <p class="mb-4">収集した個人情報は、以下の目的で利用します：</p>
                        <ul class="pl-5 mb-4 list-disc">
                            <li>サービスの提供および改善</li>
                            <li>お客様からのお問い合わせへの対応</li>
                            <li>新サービスや更新情報のお知らせ</li>
                        </ul>
                    </section>

                    <section class="mb-4">
                        <h2 class="text-2xl mt-6 mb-2">3. 個人情報の第三者提供</h2>
                        <p class="mb-4">当社は、法令に基づく場合を除き、お客様の同意なく個人情報を第三者に提供することはありません。</p>
                    </section>

                    <section class="mb-4">
                        <h2 class="text-2xl mt-6 mb-2">4. セキュリティ対策</h2>
                        <p class="mb-4">当社は、個人情報の漏洩、滅失、毀損の防止その他の個人情報の安全管理のために必要かつ適切な措置を講じます。</p>
                    </section>

                    <section class="mb-4">
                        <h2 class="text-2xl mt-6 mb-2">5. プライバシーポリシーの変更</h2>
                        <p class="mb-4">当社は、必要に応じて、このプライバシーポリシーを変更することがあります。変更後のプライバシーポリシーは、本ウェブサイトに掲載したときから効力を生じるものとします。
                        </p>
                    </section>

                    <section class="mb-4">
                        <h2 class="text-2xl mt-6 mb-2">6. お問い合わせ</h2>
                        <p class="mb-4">本プライバシーポリシーに関するお問い合わせは、以下の連絡先までお願いいたします。</p>
                        <p class="mb-4">メールアドレス: form@cosplatform.co.jp</p>
                    </section>
                </div>
            </div>
        </div>
    </main>
@endsection
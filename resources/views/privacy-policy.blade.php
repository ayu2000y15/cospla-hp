@extends('layouts.app')

@section('title', 'プライバシーポリシー - COSPLATFORM')

@section('content')
<main>
    <section class="subpage-hero">
        <h1>プライバシーポリシー</h1>
    </section>
    <div class="container">
        <div class="container-box privacy">
            <div class="privacy-policy-content">
                <section>
                    <h2>1. 個人情報の収集について</h2>
                    <p>当社は、以下の場合に個人情報を収集することがあります：</p>
                    <ul>
                        <li>ウェブサイトでのアカウント作成時</li>
                        <li>お問い合わせフォームの利用時</li>
                        <li>ニュースレターの購読時</li>
                    </ul>
                </section>

                <section>
                    <h2>2. 個人情報の利用目的</h2>
                    <p>収集した個人情報は、以下の目的で利用します：</p>
                    <ul>
                        <li>サービスの提供および改善</li>
                        <li>お客様からのお問い合わせへの対応</li>
                        <li>新サービスや更新情報のお知らせ</li>
                    </ul>
                </section>

                <section>
                    <h2>3. 個人情報の第三者提供</h2>
                    <p>当社は、法令に基づく場合を除き、お客様の同意なく個人情報を第三者に提供することはありません。</p>
                </section>

                <section>
                    <h2>4. セキュリティ対策</h2>
                    <p>当社は、個人情報の漏洩、滅失、毀損の防止その他の個人情報の安全管理のために必要かつ適切な措置を講じます。</p>
                </section>

                <section>
                    <h2>5. プライバシーポリシーの変更</h2>
                    <p>当社は、必要に応じて、このプライバシーポリシーを変更することがあります。変更後のプライバシーポリシーは、本ウェブサイトに掲載したときから効力を生じるものとします。</p>
                </section>

                <section>
                    <h2>6. お問い合わせ</h2>
                    <p>本プライバシーポリシーに関するお問い合わせは、以下の連絡先までお願いいたします。</p>
                    <p>メールアドレス: form@cosplatform.co.jp</p>
                </section>
            </div>
        </div>
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

.privacy-policy-content {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.privacy-policy-content h1 {
    font-size: 2.5em;
    margin-bottom: 1em;
}

.privacy-policy-content h2 {
    font-size: 1.8em;
    margin-top: 1.5em;
    margin-bottom: 0.5em;
}

.privacy-policy-content p,
.privacy-policy-content ul {
    margin-bottom: 1em;
}

.privacy-policy-content ul {
    padding-left: 20px;
}
</style>
@endpush
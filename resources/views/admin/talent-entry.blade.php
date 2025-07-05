<details class="bg-white rounded-lg shadow group">
    <summary class="flex items-center justify-between p-4 font-medium list-none cursor-pointer">
        <h3 class="text-lg leading-6 text-gray-900">新規タレント登録フォーム</h3>
        <svg class="w-5 h-5 transition-transform duration-300 transform group-open:rotate-180" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </summary>

    <div class="p-6 border-t border-gray-200">
        <form action="{{ route('admin.talent.store') }}" method="POST" class="space-y-8"
            onsubmit="return confirm('この内容でタレントを登録しますか？');">
            @csrf

            {{-- 基本情報セクション --}}
            <div>
                <h4 class="text-base font-semibold text-gray-800">基本情報</h4>
                <p class="mt-1 text-sm text-gray-500">内部管理用の情報です。</p>
                <div class="grid grid-cols-1 mt-4 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="TALENT_NAME" class="block text-sm font-medium text-gray-700">タレント名（本名）</label>
                        <input type="text" name="TALENT_NAME" id="TALENT_NAME" placeholder="山田太郎"
                            class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div class="sm:col-span-3">
                        <label for="TALENT_FURIGANA_JP" class="block text-sm font-medium text-gray-700">ふりがな</label>
                        <input type="text" name="TALENT_FURIGANA_JP" id="TALENT_FURIGANA_JP" placeholder="やまだたろう"
                            class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div class="sm:col-span-3">
                        <label for="AFFILIATION_DATE" class="block text-sm font-medium text-gray-700">所属日</label>
                        <input type="date" name="AFFILIATION_DATE" id="AFFILIATION_DATE" value="{{ date('Y-m-d') }}"
                            class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div class="sm:col-span-3">
                        <label for="MAIL" class="block text-sm font-medium text-gray-700">メールアドレス</label>
                        <input type="email" name="MAIL" id="MAIL" placeholder="example@gmail.com"
                            class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div class="sm:col-span-3">
                        <label for="TEL_NO" class="block text-sm font-medium text-gray-700">電話番号</label>
                        <input type="tel" name="TEL_NO" id="TEL_NO" placeholder="080-1234-5678"
                            class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>
            </div>

            {{-- HP公開情報セクション --}}
            <div class="pt-8">
                <h4 class="text-base font-semibold text-gray-800">HP公開情報</h4>
                <p class="mt-1 text-sm text-gray-500">ホームページに表示される情報です。各項目で公開・非公開を設定できます。</p>
                <div class="grid grid-cols-1 mt-4 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="LAYER_NAME" class="block text-sm font-medium text-gray-700">レイヤーネーム <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="LAYER_NAME" id="LAYER_NAME" required placeholder="やまだ"
                            class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div class="sm:col-span-3">
                        <label for="LAYER_FURIGANA_EN"
                            class="block text-sm font-medium text-gray-700">レイヤーネーム（ローマ字）</label>
                        <input type="text" name="LAYER_FURIGANA_EN" id="LAYER_FURIGANA_EN" placeholder="Yamada"
                            class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="sm:col-span-3">
                        <label for="COS_FLG" class="block text-sm font-medium text-gray-700">コスプレの種類</label>
                        <select id="COS_FLG" name="COS_FLG"
                            class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                            <option value="1">男装</option>
                            <option value="2">女装</option>
                            <option value="3" selected>男装・女装</option>
                        </select>
                    </div>
                    <div class="sm:col-span-3">
                        <label for="STREAM_FLG" class="block text-sm font-medium text-gray-700">配信</label>
                        <select id="STREAM_FLG" name="STREAM_FLG"
                            class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                            <option value="0">不可</option>
                            <option value="1">可</option>
                        </select>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="CONTRACT_TYPE" class="block text-sm font-medium text-gray-700">契約形態</label>
                        <fieldset class="mt-2">
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center">
                                    <input id="contract_type_0" name="CONTRACT_TYPE" type="radio" value="0" checked
                                        class="w-4 h-4 text-indigo-600 border-gray-300">
                                    <label for="contract_type_0" class="ml-2 text-sm text-gray-700">通常</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="contract_type_1" name="CONTRACT_TYPE" type="radio" value="1"
                                        class="w-4 h-4 text-indigo-600 border-gray-300">
                                    <label for="contract_type_1" class="ml-2 text-sm text-gray-700">専属</label>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    @php
                        $fields = [
                            ['id' => 'FOLLOWERS', 'label' => 'フォロワー数（およそ）', 'type' => 'number', 'placeholder' => '10000'],
                            ['id' => 'HEIGHT', 'label' => '身長 (cm)', 'type' => 'number', 'placeholder' => '172'],
                            ['id' => 'BIRTHDAY', 'label' => '誕生日', 'type' => 'date', 'extra_options' => [['value' => '2', 'label' => '日付のみ公開']]],
                            ['id' => 'AGE', 'label' => '年齢 (誕生日から自動計算)', 'type' => 'number', 'readonly' => true],
                            ['id' => 'THREE_SIZES_B', 'label' => 'スリーサイズ (B)', 'type' => 'number', 'placeholder' => '85'],
                            ['id' => 'THREE_SIZES_W', 'label' => 'スリーサイズ (W)', 'type' => 'number', 'placeholder' => '60'],
                            ['id' => 'THREE_SIZES_H', 'label' => 'スリーサイズ (H)', 'type' => 'number', 'placeholder' => '88'],
                            ['id' => 'HOBBY_SPECIALTY', 'label' => '趣味・特技', 'type' => 'text', 'placeholder' => 'ゲーム、食べること'],
                            ['id' => 'SNS_1', 'label' => 'X (旧Twitter) URL', 'type' => 'url', 'placeholder' => 'https://x.com/...'],
                            ['id' => 'SNS_2', 'label' => 'Instagram URL', 'type' => 'url', 'placeholder' => 'https://instagram.com/...'],
                            ['id' => 'SNS_3', 'label' => 'TikTok URL', 'type' => 'url', 'placeholder' => 'https://tiktok.com/...'],
                        ];
                    @endphp

                    @foreach($fields as $field)
                        <div class="sm:col-span-6">
                            <label for="{{ $field['id'] }}"
                                class="block text-sm font-medium text-gray-700">{{ $field['label'] }}</label>
                            <input type="{{ $field['type'] }}" name="{{ $field['id'] }}" id="{{ $field['id'] }}"
                                placeholder="{{ $field['placeholder'] ?? '' }}" @if($field['id'] === 'BIRTHDAY')
                                onchange="calculateAge()" @endif {{-- 読み取り専用の属性を追加 --}} {{ $field['readonly'] ?? false ? 'readonly' : '' }}
                                class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm {{ $field['readonly'] ?? false ? 'bg-gray-100 cursor-not-allowed' : '' }}">
                            <fieldset class="mt-2">
                                <legend class="sr-only">{{ $field['label'] }}の公開設定</legend>
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center"><input id="{{ $field['id'] }}_flg_1"
                                            name="{{ $field['id'] }}_FLG" type="radio" value="1"
                                            class="w-4 h-4 text-indigo-600 border-gray-300"><label
                                            for="{{ $field['id'] }}_flg_1" class="ml-2 text-sm text-gray-700">公開</label>
                                    </div>
                                    <div class="flex items-center"><input id="{{ $field['id'] }}_flg_0"
                                            name="{{ $field['id'] }}_FLG" type="radio" value="0" checked
                                            class="w-4 h-4 text-indigo-600 border-gray-300"><label
                                            for="{{ $field['id'] }}_flg_0" class="ml-2 text-sm text-gray-700">非公開</label>
                                    </div>
                                    @if(isset($field['extra_options']))
                                        @foreach($field['extra_options'] as $option)
                                            <div class="flex items-center"><input id="{{ $field['id'] }}_flg_{{ $option['value'] }}"
                                                    name="{{ $field['id'] }}_FLG" type="radio" value="{{ $option['value'] }}"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300"><label
                                                    for="{{ $field['id'] }}_flg_{{ $option['value'] }}"
                                                    class="ml-2 text-sm text-gray-700">{{ $option['label'] }}</label></div>
                                        @endforeach
                                    @endif
                                </div>
                            </fieldset>
                        </div>
                    @endforeach
                    <div class="sm:col-span-6">
                        <label for="COMMENT" class="block text-sm font-medium text-gray-700">紹介文・コメント</label>
                        <textarea id="COMMENT" name="COMMENT" rows="3"
                            class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm"></textarea>
                        <fieldset class="mt-2">
                            <legend class="sr-only">紹介文・コメントの公開設定</legend>
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center"><input id="COMMENT_flg_1" name="COMMENT_FLG" type="radio"
                                        value="1" class="w-4 h-4 text-indigo-600 border-gray-300"><label
                                        for="COMMENT_flg_1" class="ml-2 text-sm text-gray-700">公開</label></div>
                                <div class="flex items-center"><input id="COMMENT_flg_0" name="COMMENT_FLG" type="radio"
                                        value="0" checked class="w-4 h-4 text-indigo-600 border-gray-300"><label
                                        for="COMMENT_flg_0" class="ml-2 text-sm text-gray-700">非公開</label></div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>

            <div class="pt-5">
                <div class="flex justify-end">
                    <button type="button" onclick="this.form.reset()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">クリア</button>
                    <button type="submit"
                        class="inline-flex justify-center px-4 py-2 ml-3 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700">登録する</button>
                </div>
            </div>
        </form>
    </div>
</details>

<script>
    function calculateAge() {
        const birthdayInput = document.getElementById('BIRTHDAY');
        const ageInput = document.getElementById('AGE');
        if (birthdayInput.value) {
            const birthday = new Date(birthdayInput.value);
            const today = new Date();
            let age = today.getFullYear() - birthday.getFullYear();
            const m = today.getMonth() - birthday.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthday.getDate())) {
                age--;
            }
            ageInput.value = age;
        }
    }
</script>
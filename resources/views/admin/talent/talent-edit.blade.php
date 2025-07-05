<div class="p-6 bg-white rounded-lg shadow">
    <form action="{{ route('admin.talent.edit') }}" method="POST" class="space-y-8"
        onsubmit="return confirm('タレント情報を更新しますか？');">
        @csrf
        @method('PUT')
        <input type="hidden" name="TALENT_ID" value="{{ $talent->TALENT_ID }}">

        {{-- 基本情報セクション --}}
        <div>
            <h4 class="text-base font-semibold text-gray-800">基本情報 (内部管理用)</h4>
            <div class="grid grid-cols-1 mt-4 gap-y-6 gap-x-4 sm:grid-cols-6">
                <div class="sm:col-span-3">
                    <label for="edit_TALENT_NAME" class="block text-sm font-medium text-gray-700">タレント名（本名）</label>
                    <input type="text" name="TALENT_NAME" id="edit_TALENT_NAME"
                        value="{{ old('TALENT_NAME', $talent->TALENT_NAME) }}"
                        class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="sm:col-span-3">
                    <label for="edit_TALENT_FURIGANA_JP" class="block text-sm font-medium text-gray-700">ふりがな</label>
                    <input type="text" name="TALENT_FURIGANA_JP" id="edit_TALENT_FURIGANA_JP"
                        value="{{ old('TALENT_FURIGANA_JP', $talent->TALENT_FURIGANA_JP) }}"
                        class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="sm:col-span-3">
                    <label for="edit_AFFILIATION_DATE" class="block text-sm font-medium text-gray-700">所属日</label>
                    <input type="date" name="AFFILIATION_DATE" id="edit_AFFILIATION_DATE"
                        value="{{ old('AFFILIATION_DATE', optional($talent->AFFILIATION_DATE)->format('Y-m-d')) }}"
                        class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="sm:col-span-3">
                    <label for="edit_MAIL" class="block text-sm font-medium text-gray-700">メールアドレス</label>
                    <input type="email" name="MAIL" id="edit_MAIL" value="{{ old('MAIL', $talent->MAIL) }}"
                        class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="sm:col-span-3">
                    <label for="edit_TEL_NO" class="block text-sm font-medium text-gray-700">電話番号</label>
                    <input type="tel" name="TEL_NO" id="edit_TEL_NO" value="{{ old('TEL_NO', $talent->TEL_NO) }}"
                        class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                </div>
            </div>
        </div>

        {{-- HP公開情報セクション --}}
        <div class="pt-8 border-t border-gray-200">
            <h4 class="text-base font-semibold text-gray-800">HP公開情報</h4>
            <div class="grid grid-cols-1 mt-4 gap-y-6 gap-x-4 sm:grid-cols-6">
                <div class="sm:col-span-3">
                    <label for="edit_LAYER_NAME" class="block text-sm font-medium text-gray-700">レイヤーネーム <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="LAYER_NAME" id="edit_LAYER_NAME" required
                        value="{{ old('LAYER_NAME', $talent->LAYER_NAME) }}"
                        class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="sm:col-span-3">
                    <label for="edit_LAYER_FURIGANA_EN"
                        class="block text-sm font-medium text-gray-700">レイヤーネーム（ローマ字）</label>
                    <input type="text" name="LAYER_FURIGANA_EN" id="edit_LAYER_FURIGANA_EN"
                        value="{{ old('LAYER_FURIGANA_EN', $talent->LAYER_FURIGANA_EN) }}"
                        class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="sm:col-span-3">
                    <label for="edit_COS_FLG" class="block text-sm font-medium text-gray-700">コスプレの種類</label>
                    <select id="edit_COS_FLG" name="COS_FLG"
                        class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                        <option value="1" {{ old('COS_FLG', $talent->COS_FLG) == '1' ? 'selected' : '' }}>男装</option>
                        <option value="2" {{ old('COS_FLG', $talent->COS_FLG) == '2' ? 'selected' : '' }}>女装</option>
                        <option value="3" {{ old('COS_FLG', $talent->COS_FLG) == '3' ? 'selected' : '' }}>男装・女装</option>
                    </select>
                </div>
                <div class="sm:col-span-3">
                    <label for="edit_STREAM_FLG" class="block text-sm font-medium text-gray-700">配信</label>
                    <select id="edit_STREAM_FLG" name="STREAM_FLG"
                        class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                        <option value="0" {{ old('STREAM_FLG', $talent->STREAM_FLG) == '0' ? 'selected' : '' }}>不可
                        </option>
                        <option value="1" {{ old('STREAM_FLG', $talent->STREAM_FLG) == '1' ? 'selected' : '' }}>可</option>
                    </select>
                </div>

                <div class="sm:col-span-3">
                    <label for="edit_CONTRACT_TYPE" class="block text-sm font-medium text-gray-700">契約形態</label>
                    <fieldset class="mt-2">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <input id="edit_contract_type_0" name="CONTRACT_TYPE" type="radio" value="0" {{ old('CONTRACT_TYPE', $talent->CONTRACT_TYPE) == '0' ? 'checked' : '' }}
                                    class="w-4 h-4 text-indigo-600 border-gray-300">
                                <label for="edit_contract_type_0" class="ml-2 text-sm text-gray-700">通常</label>
                            </div>
                            <div class="flex items-center">
                                <input id="edit_contract_type_1" name="CONTRACT_TYPE" type="radio" value="1" {{ old('CONTRACT_TYPE', $talent->CONTRACT_TYPE) == '1' ? 'checked' : '' }}
                                    class="w-4 h-4 text-indigo-600 border-gray-300">
                                <label for="edit_contract_type_1" class="ml-2 text-sm text-gray-700">専属</label>
                            </div>
                        </div>
                    </fieldset>
                </div>

                @php
                    $fields = [
                        ['id' => 'FOLLOWERS', 'label' => 'フォロワー数（およそ）', 'type' => 'number', 'value' => $talent->FOLLOWERS, 'flag' => $talentInfo->FOLLOWERS_FLG],
                        ['id' => 'HEIGHT', 'label' => '身長 (cm)', 'type' => 'number', 'value' => $talent->HEIGHT, 'flag' => $talentInfo->HEIGHT_FLG],
                        ['id' => 'BIRTHDAY', 'label' => '誕生日', 'type' => 'date', 'value' => optional($talent->BIRTHDAY)->format('Y-m-d'), 'flag' => $talentInfo->BIRTHDAY_FLG, 'extra_options' => [['value' => '2', 'label' => '日付のみ公開']]],
                        ['id' => 'AGE', 'label' => '年齢 (誕生日から自動計算)', 'type' => 'number', 'value' => $talent->AGE, 'flag' => $talentInfo->AGE_FLG, 'readonly' => true],
                        ['id' => 'THREE_SIZES_B', 'label' => 'スリーサイズ (B)', 'type' => 'number', 'value' => $talent->THREE_SIZES_B, 'flag' => $talentInfo->THREE_SIZES_B_FLG],
                        ['id' => 'THREE_SIZES_W', 'label' => 'スリーサイズ (W)', 'type' => 'number', 'value' => $talent->THREE_SIZES_W, 'flag' => $talentInfo->THREE_SIZES_W_FLG],
                        ['id' => 'THREE_SIZES_H', 'label' => 'スリーサイズ (H)', 'type' => 'number', 'value' => $talent->THREE_SIZES_H, 'flag' => $talentInfo->THREE_SIZES_H_FLG],
                        ['id' => 'HOBBY_SPECIALTY', 'label' => '趣味・特技', 'type' => 'text', 'value' => $talent->HOBBY_SPECIALTY, 'flag' => $talentInfo->HOBBY_SPECIALTY_FLG],
                        ['id' => 'SNS_1', 'label' => 'X (旧Twitter) URL', 'type' => 'url', 'value' => $talent->SNS_1, 'flag' => $talentInfo->SNS_1_FLG],
                        ['id' => 'SNS_2', 'label' => 'Instagram URL', 'type' => 'url', 'value' => $talent->SNS_2, 'flag' => $talentInfo->SNS_2_FLG],
                        ['id' => 'SNS_3', 'label' => 'TikTok URL', 'type' => 'url', 'value' => $talent->SNS_3, 'flag' => $talentInfo->SNS_3_FLG],
                    ];
                @endphp

                @foreach($fields as $field)
                    <div class="sm:col-span-6">
                        <label for="edit_{{ $field['id'] }}"
                            class="block text-sm font-medium text-gray-700">{{ $field['label'] }}</label>
                        <input type="{{ $field['type'] }}" name="{{ $field['id'] }}" id="edit_{{ $field['id'] }}"
                            value="{{ old($field['id'], $field['value']) }}" @if($field['id'] === 'BIRTHDAY')
                            onchange="calculateAgeEdit()" @endif {{ $field['readonly'] ?? false ? 'readonly' : '' }}
                            class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm {{ $field['readonly'] ?? false ? 'bg-gray-100 cursor-not-allowed' : '' }}">
                        <fieldset class="mt-2">
                            <legend class="sr-only">{{ $field['label'] }}の公開設定</legend>
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center"><input id="edit_{{ $field['id'] }}_flg_1"
                                        name="{{ $field['id'] }}_FLG" type="radio" value="1" {{ old($field['id'] . '_FLG', $field['flag']) == '1' ? 'checked' : '' }}
                                        class="w-4 h-4 text-indigo-600 border-gray-300"><label
                                        for="edit_{{ $field['id'] }}_flg_1" class="ml-2 text-sm text-gray-700">公開</label>
                                </div>
                                <div class="flex items-center"><input id="edit_{{ $field['id'] }}_flg_0"
                                        name="{{ $field['id'] }}_FLG" type="radio" value="0" {{ old($field['id'] . '_FLG', $field['flag']) == '0' ? 'checked' : '' }}
                                        class="w-4 h-4 text-indigo-600 border-gray-300"><label
                                        for="edit_{{ $field['id'] }}_flg_0" class="ml-2 text-sm text-gray-700">非公開</label>
                                </div>
                                @if(isset($field['extra_options']))
                                    @foreach($field['extra_options'] as $option)
                                        <div class="flex items-center"><input
                                                id="edit_{{ $field['id'] }}_flg_{{ $option['value'] }}"
                                                name="{{ $field['id'] }}_FLG" type="radio" value="{{ $option['value'] }}" {{ old($field['id'] . '_FLG', $field['flag']) == $option['value'] ? 'checked' : '' }}
                                                class="w-4 h-4 text-indigo-600 border-gray-300"><label
                                                for="edit_{{ $field['id'] }}_flg_{{ $option['value'] }}"
                                                class="ml-2 text-sm text-gray-700">{{ $option['label'] }}</label></div>
                                    @endforeach
                                @endif
                            </div>
                        </fieldset>
                    </div>
                @endforeach

                <div class="sm:col-span-6">
                    <label for="edit_COMMENT" class="block text-sm font-medium text-gray-700">紹介文・コメント</label>
                    <textarea id="edit_COMMENT" name="COMMENT" rows="3"
                        class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">{{ old('COMMENT', $talent->COMMENT) }}</textarea>
                    <fieldset class="mt-2">
                        <legend class="sr-only">紹介文・コメントの公開設定</legend>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center"><input id="edit_COMMENT_flg_1" name="COMMENT_FLG"
                                    type="radio" value="1" {{ old('COMMENT_FLG', $talentInfo->COMMENT_FLG) == '1' ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300"><label
                                    for="edit_COMMENT_flg_1" class="ml-2 text-sm text-gray-700">公開</label></div>
                            <div class="flex items-center"><input id="edit_COMMENT_flg_0" name="COMMENT_FLG"
                                    type="radio" value="0" {{ old('COMMENT_FLG', $talentInfo->COMMENT_FLG) == '0' ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300"><label
                                    for="edit_COMMENT_flg_0" class="ml-2 text-sm text-gray-700">非公開</label></div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>

        <div class="pt-5">
            <div class="flex justify-end">
                <button type="submit"
                    class="inline-flex justify-center px-4 py-2 ml-3 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700">更新する</button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
    <script>
        function calculateAgeEdit() {
            const birthdayInput = document.getElementById('edit_BIRTHDAY');
            const ageInput = document.getElementById('edit_AGE');
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
        document.addEventListener('DOMContentLoaded', calculateAgeEdit);
    </script>
@endpush
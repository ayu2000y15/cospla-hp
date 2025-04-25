<main>
    <div class="form-area">
        <h2>タレント情報変更</h2>

        <form onsubmit="return checkSubmit('変更');" action="{{ route('admin.talent.edit') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="TALENT_ID" value="{{ $talent->TALENT_ID }}">

            <div class="form-group">
                <label for="TALENT_NAME">タレント名（本名）<span class="required">※HPには表示されません</span></label>
                <input type="text" id="TALENT_NAME" name="TALENT_NAME" placeholder="山田太郎"
                    value="{{ old('TALENT_NAME', $talent->TALENT_NAME) }}" />
            </div>
            <div class="form-group">
                <label for="TALENT_FURIGANA_JP">タレント名　ふりがな（ひらがな）<span class="required">※HPには表示されません</span></label>
                <input type="text" id="TALENT_FURIGANA_JP" name="TALENT_FURIGANA_JP" placeholder="やまだたろう"
                    value="{{ old('TALENT_FURIGANA_JP', $talent->TALENT_FURIGANA_JP) }}" />
            </div>
            <div class="form-group">
                <label for="TALENT_FURIGANA_EN">タレント名　ふりがな（ローマ字）<span class="required">※HPには表示されません</span></label>
                <input type="text" id="TALENT_FURIGANA_EN" name="TALENT_FURIGANA_EN" placeholder="YamadaTaro"
                    value="{{ old('TALENT_FURIGANA_EN', $talent->TALENT_FURIGANA_EN) }}" />
            </div>
            <div class="form-group">
                <label for="LAYER_NAME">レイヤーネーム（HPに表示する名前）<span class="required">必須</span></label>
                <input type="text" id="LAYER_NAME" name="LAYER_NAME" placeholder="やまだ"
                    value="{{ old('LAYER_NAME', $talent->LAYER_NAME) }}" required />
            </div>
            <div class="form-group">
                <label for="LAYER_FURIGANA_JP">レイヤーネーム　ふりがな（ひらがな）<span class="required"></span></label>
                <input type="text" id="LAYER_FURIGANA_JP" name="LAYER_FURIGANA_JP" placeholder="やまだ"
                    value="{{ old('LAYER_FURIGANA_JP', $talent->LAYER_FURIGANA_JP) }}" />
            </div>
            <div class="form-group">
                <label for="LAYER_FURIGANA_EN">レイヤーネーム　ふりがな（ローマ字）<span class="required"></span></label>
                <input type="text" id="LAYER_FURIGANA_EN" name="LAYER_FURIGANA_EN" placeholder="Yamada"
                    value="{{ old('LAYER_FURIGANA_EN', $talent->LAYER_FURIGANA_EN) }}" />
            </div>
            <div class="form-group">
                <label for="AFFILIATION_DATE">所属日<span class="required"></span></label>
                <input type="date" id="AFFILIATION_DATE" name="AFFILIATION_DATE"
                    value="{{ old('AFFILIATION_DATE', $talent->AFFILIATION_DATE) }}" />
            </div>
            <div class="form-group">
                <label for="RETIREMENT_DATE">退職日<span class="required"></span></label>
                <input type="date" id="RETIREMENT_DATE" name="RETIREMENT_DATE"
                    value="{{ old('RETIREMENT_DATE', $talent->RETIREMENT_DATE)=== '2099-01-01' ? '' : $talent->RETIREMENT_DATE }}"" />
            </div>
            <div class="form-group">
                <label for="MAIL">メールアドレス<span class="required"></span></label>
                <input type="email" id="MAIL" name="MAIL" placeholder="example@gmail.com"
                    value="{{ old('MAIL', $talent->MAIL) }}" />
            </div>
            <div class="form-group">
                <label for="TEL_NO">電話番号<span class="required"></span></label>
                <input type="tel" id="TEL_NO" name="TEL_NO" pattern="\d{2,4}-?\d{2,4}-?\d{3,4}"
                    value="{{ old('TEL_NO', $talent->TEL_NO) }}" placeholder="080-1234-5678" />
            </div>

            <!-- ここから表示情報 -->
            <div class="form-group">
                <label for="STREAM_FLG">配信可・不可<span class="required"></span></label>
                <select id="STREAM_FLG" name="STREAM_FLG">
                    <option value="0" {{ old('STREAM_FLG', $talent->STREAM_FLG) === '0' ? 'selected' : '' }}>配信不可
                    </option>
                    <option value="1" {{ old('STREAM_FLG', $talent->STREAM_FLG) === '1' ? 'selected' : '' }}>配信可
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label for="COS_FLG">コスプレの種類（男装、女装）<span class="required"></span></label>
                <select id="COS_FLG" name="COS_FLG">
                    <option value="1" {{ old('COS_FLG', $talent->COS_FLG) == '1' ? 'selected' : '' }}>男装</option>
                    <option value="2" {{ old('COS_FLG', $talent->COS_FLG) == '2' ? 'selected' : '' }}>女装</option>
                    <option value="3" {{ old('COS_FLG', $talent->COS_FLG) == '3' ? 'selected' : '' }}>男装・女装</option>
                </select>
            </div>
            <div class="form-group">
                <div class="check-area">
                    <label for="FOLLOWERS">フォロワー数（およそ）<span class="required"></span></label>
                    <div class="check-box">
                        <label class="checkbox-label">
                            <input type="radio" name="FOLLOWERS_FLG" value="0"
                                {{ old('FOLLOWERS_FLG', $talentInfo->FOLLOWERS_FLG) == '0' ? 'checked' : '' }} />
                            非公開
                        </label>
                        <label class="checkbox-label">
                            <input type="radio" name="FOLLOWERS_FLG" value="1"
                                {{ old('FOLLOWERS_FLG', $talentInfo->FOLLOWERS_FLG) == '1' ? 'checked' : '' }} />
                            公開する
                        </label>
                    </div>
                </div>
                <input type="number" id="FOLLOWERS" name="FOLLOWERS" placeholder="100"
                    value="{{ old('FOLLOWERS', $talent->FOLLOWERS) }}" />
            </div>
            <div class="form-group">
                <div class="check-area">
                    <label for="HEIGHT">身長<span class="required"></span></label>
                    <div class="check-box">
                        <label class="checkbox-label">
                            <input type="radio" name="HEIGHT_FLG" value="0"
                                {{ old('HEIGHT_FLG', $talentInfo->HEIGHT_FLG) == '0' ? 'checked' : '' }} />
                            非公開
                        </label>
                        <label class="checkbox-label">
                            <input type="radio" name="HEIGHT_FLG" value="1"
                                {{ old('HEIGHT_FLG', $talentInfo->HEIGHT_FLG) == '1' ? 'checked' : '' }} />
                            公開する
                        </label>
                    </div>
                </div>
                <input type="number" id="HEIGHT" name="HEIGHT" placeholder="172"
                    value="{{ old('HEIGHT', $talent->HEIGHT) }}" />
            </div>
            <div class="form-group">
                <div class="check-area">
                    <label for="AGE">年齢<span class="required">※誕生日をもとに入力するため入力は不要です。</span></label>
                    <div class="check-box">
                        <label class="checkbox-label">
                            <input type="radio" name="AGE_FLG" value="0"
                                {{ old('AGE_FLG', $talentInfo->AGE_FLG) == '0' ? 'checked' : '' }} />
                            非公開
                        </label>
                        <label class="checkbox-label">
                            <input type="radio" name="AGE_FLG" value="1"
                                {{ old('AGE_FLG', $talentInfo->AGE_FLG) == '1' ? 'checked' : '' }} />
                            公開する
                        </label>
                    </div>
                </div>
                <input type="number" id="AGE" name="AGE" value="{{ old('AGE', $talent->AGE) }}" readonly/>
            </div>
            <div class="form-group">
                <div class="check-area">
                    <label for="BIRTHDAY">誕生日<span class="required">※※年を非公開にする場合は年を入力しても表示されません。</span></label>
                    <div class="check-box">
                        <label class="checkbox-label">
                            <input type="radio" name="BIRTHDAY_FLG" value="0"
                                {{ old('BIRTHDAY_FLG', $talentInfo->BIRTHDAY_FLG) == '0' ? 'checked' : '' }} />
                            非公開
                        </label>
                        <label class="checkbox-label">
                            <input type="radio" name="BIRTHDAY_FLG" value="1"
                                {{ old('BIRTHDAY_FLG', $talentInfo->BIRTHDAY_FLG) == '1' ? 'checked' : '' }} />
                            公開する
                        </label>
                        <label class="checkbox-label">
                            <input type="radio" name="BIRTHDAY_FLG" value="2"
                                {{ old('BIRTHDAY_FLG', $talentInfo->BIRTHDAY_FLG) == '2' ? 'checked' : '' }} />
                            年は非公開で日付だけ公開する
                        </label>
                    </div>
                </div>
                <input type="date" id="BIRTHDAY" name="BIRTHDAY" value="{{ old('BIRTHDAY', $talent->BIRTHDAY) }}" onchange="calculateAge()"/>
            </div>
            <div class="form-group">
                <div class="check-area">
                    <label for="THREE_SIZES_B">スリーサイズ　バスト<span class="required"></span></label>
                    <div class="check-box">
                        <label class="checkbox-label">
                            <input type="radio" name="THREE_SIZES_B_FLG" value="0"
                                {{ old('THREE_SIZES_B_FLG', $talentInfo->THREE_SIZES_B_FLG) == '0' ? 'checked' : '' }} />
                            非公開
                        </label>
                        <label class="checkbox-label">
                            <input type="radio" name="THREE_SIZES_B_FLG" value="1"
                                {{ old('THREE_SIZES_B_FLG', $talentInfo->THREE_SIZES_B_FLG) == '1' ? 'checked' : '' }} />
                            公開する
                        </label>
                    </div>
                </div>
                <input type="number" id="THREE_SIZES_B" name="THREE_SIZES_B" placeholder="75"
                    value="{{ old('THREE_SIZES_B', $talent->THREE_SIZES_B) }}" />
            </div>
            <div class="form-group">
                <div class="check-area">
                    <label for="THREE_SIZES_W">スリーサイズ　ウエスト<span class="required"></span></label>
                    <div class="check-box">
                        <label class="checkbox-label">
                            <input type="radio" name="THREE_SIZES_W_FLG" value="0"
                                {{ old('THREE_SIZES_W_FLG', $talentInfo->THREE_SIZES_W_FLG) == '0' ? 'checked' : '' }} />
                            非公開
                        </label>
                        <label class="checkbox-label">
                            <input type="radio" name="THREE_SIZES_W_FLG" value="1"
                                {{ old('THREE_SIZES_W_FLG', $talentInfo->THREE_SIZES_W_FLG) == '1' ? 'checked' : '' }} />
                            公開する
                        </label>
                    </div>
                </div>
                <input type="number" id="THREE_SIZES_W" name="THREE_SIZES_W" placeholder="55"
                    value="{{ old('THREE_SIZES_W', $talent->THREE_SIZES_W) }}" />
            </div>
            <div class="form-group">
                <div class="check-area">
                    <label for="THREE_SIZES_W">スリーサイズ　ヒップ<span class="required"></span></label>
                    <div class="check-box">
                        <label class="checkbox-label">
                            <input type="radio" name="THREE_SIZES_H_FLG" value="0"
                                {{ old('THREE_SIZES_H_FLG', $talentInfo->THREE_SIZES_H_FLG) == '0' ? 'checked' : '' }} />
                            非公開
                        </label>
                        <label class="checkbox-label">
                            <input type="radio" name="THREE_SIZES_H_FLG" value="1"
                                {{ old('THREE_SIZES_H_FLG', $talentInfo->THREE_SIZES_H_FLG) == '1' ? 'checked' : '' }} />
                            公開する
                        </label>
                    </div>
                </div>
                <input type="number" id="THREE_SIZES_H" name="THREE_SIZES_H" placeholder="75"
                    value="{{ old('THREE_SIZES_H', $talent->THREE_SIZES_H) }}" />
            </div>
            <div class="form-group">
                <div class="check-area">
                    <label for="HOBBY_SPECIALTY">趣味・特技<span class="required"></span></label>
                    <div class="check-box">
                        <label class="checkbox-label">
                            <input type="radio" name="HOBBY_SPECIALTY_FLG" value="0"
                                {{ old('HOBBY_SPECIALTY_FLG', $talentInfo->HOBBY_SPECIALTY_FLG) == '0' ? 'checked' : '' }} />
                            非公開
                        </label>
                        <label class="checkbox-label">
                            <input type="radio" name="HOBBY_SPECIALTY_FLG" value="1"
                                {{ old('HOBBY_SPECIALTY_FLG', $talentInfo->HOBBY_SPECIALTY_FLG) == '1' ? 'checked' : '' }} />
                            公開する
                        </label>
                    </div>
                </div>
                <input type="text" id="HOBBY_SPECIALTY" name="HOBBY_SPECIALTY" placeholder="カラオケ・食べること"
                    value="{{ old('HOBBY_SPECIALTY', $talent->HOBBY_SPECIALTY) }}" />
            </div>
            <div class="form-group">
                <div class="check-area">
                    <label for="COMMENT">紹介文・コメント<span class="required"></span></label>
                    <div class="check-box">
                        <label class="checkbox-label">
                            <input type="radio" name="COMMENT_FLG" value="0"
                                {{ old('COMMENT_FLG', $talentInfo->COMMENT_FLG) == '0' ? 'checked' : '' }} />
                            非公開
                        </label>
                        <label class="checkbox-label">
                            <input type="radio" name="COMMENT_FLG" value="1"
                                {{ old('COMMENT_FLG', $talentInfo->COMMENT_FLG) == '1' ? 'checked' : '' }} />
                            公開する
                        </label>
                    </div>
                </div>
                <textarea id="COMMENT" name="COMMENT" rows="5"
                    placeholder="ここに紹介文を入れる">{{ old('COMMENT', $talent->COMMENT) }}</textarea>
            </div>
            <div class="form-group">
                <div class="check-area">
                    <label for="SNS_1">X(旧Twitter) ID<span class="required"></span></label>
                    <div class="check-box">
                        <label class="checkbox-label">
                            <input type="radio" name="SNS_1_FLG" value="0"
                                {{ old('SNS_1_FLG', $talentInfo->SNS_1_FLG) == '0' ? 'checked' : '' }} />
                            非公開
                        </label>
                        <label class="checkbox-label">
                            <input type="radio" name="SNS_1_FLG" value="1"
                                {{ old('SNS_1_FLG', $talentInfo->SNS_1_FLG) == '1' ? 'checked' : '' }} />
                            公開する
                        </label>
                    </div>
                </div>
                <input type="text" id="SNS_1" name="SNS_1" value="{{ old('SNS_1', $talent->SNS_1) }}" />
            </div>
            <div class="form-group">
                <div class="check-area">
                    <label for="SNS_2">instagram ID<span class="required"></span></label>
                    <div class="check-box">
                        <label class="checkbox-label">
                            <input type="radio" name="SNS_2_FLG" value="0"
                                {{ old('SNS_2_FLG', $talentInfo->SNS_2_FLG) == '0' ? 'checked' : '' }} />
                            非公開
                        </label>
                        <label class="checkbox-label">
                            <input type="radio" name="SNS_2_FLG" value="1"
                                {{ old('SNS_2_FLG', $talentInfo->SNS_2_FLG) == '1' ? 'checked' : '' }} />
                            公開する
                        </label>
                    </div>
                </div>
                <input type="text" id="SNS_2" name="SNS_2" value="{{ old('SNS_2', $talent->SNS_2) }}" />
            </div>
            <div class="form-group">
                <div class="check-area">
                    <label for="SNS_3">TikTok ID<span class="required"></span></label>
                    <div class="check-box">
                        <label class="checkbox-label">
                            <input type="radio" name="SNS_3_FLG" value="0"
                                {{ old('SNS_3_FLG', $talentInfo->SNS_3_FLG) == '0' ? 'checked' : '' }} />
                            非公開
                        </label>
                        <label class="checkbox-label">
                            <input type="radio" name="SNS_3_FLG" value="1"
                                {{ old('SNS_3_FLG', $talentInfo->SNS_3_FLG) == '1' ? 'checked' : '' }} />
                            公開する
                        </label>
                    </div>
                </div>
                <input type="text" id="SNS_3" name="SNS_3" value="{{ old('SNS_3', $talent->SNS_3) }}" />
            </div>
            <button type="submit" class="submit-button">送信する</button>
        </form>
    </div>
</main>

@push('scripts')
<script src="{{ asset('js/admin-script.js') }}"></script>
<script>
    function calculateAge() {
    var birthday = new Date(document.getElementById('BIRTHDAY').value);
    var today = new Date();
    var age = today.getFullYear() - birthday.getFullYear();
    var m = today.getMonth() - birthday.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthday.getDate())) {
        age--;
    }
    document.getElementById('AGE').value = age;
}
</script>

@endpush
<main>
    <div class="form-area">
        <h2>ACメーラーリスト登録・変更</h2>
        @if(!isset($acmailEdit))
        <form action="{{ route('admin.ac.entry') }}" onsubmit="return checkSubmit('登録');" method="POST">
            @csrf
            <div class="form-group">
                <label for="MAIL">メールアドレス<span class="required">※必須</span></label>
                <input type="email" id="MAIL" name="MAIL" placeholder="example@mail" required/>
            </div>
            <div class="form-group">
                <label for="COL1">項目１<span class="required"></span></label>
                <input type="text" id="COL1" name="COL1" />
            </div>
            <div class="form-group">
                <label for="COL2">項目２<span class="required"></span></label>
                <input type="text" id="COL2" name="COL2" />
            </div>
            <div class="form-group">
                <label for="COL3">項目３<span class="required"></span></label>
                <input type="text" id="COL3" name="COL3" />
            </div>
            <div class="form-group">
                <label for="COL4">項目４<span class="required"></span></label>
                <input type="text" id="COL4" name="COL4" />
            </div>
            <div class="form-group">
                <label for="COL5">項目５<span class="required"></span></label>
                <input type="text" id="COL5" name="COL5" />
            </div>
            <div class="form-group">
                <label for="COL6">項目６<span class="required"></span></label>
                <input type="text" id="COL6" name="COL6" />
            </div>
            <div class="form-group">
                <label for="COL7">項目７<span class="required"></span></label>
                <input type="text" id="COL7" name="COL7" />
            </div>
            <div class="form-group">
                <label for="COL8">項目８<span class="required"></span></label>
                <input type="text" id="COL8" name="COL8" />
            </div>
            <div class="form-group">
                <label for="COL9">項目９<span class="required"></span></label>
                <input type="text" id="COL9" name="COL9" />
            </div>
            <div class="form-group">
                <label for="COL10">項目１０<span class="required"></span></label>
                <input type="text" id="COL10" name="COL10" />
            </div>
            <div class="form-group">
                <label for="DELIVERY_FLG">配信フラグ<span class="required"></span></label>
                <select id="DELIVERY_FLG" name="DELIVERY_FLG">
                    <option value="" selected>配信しない</option>
                    <option value="1">配信する</option>
                </select>
            </div>
            <button type="submit" class="submit-button">送信する</button>
        </form>

        @else
        <form action="{{ route('admin.ac.update') }}" onsubmit="return checkSubmit('登録');" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="AC_ID" name="AC_ID" value="{{ $acmailEdit->AC_ID }}" />
            <div class="form-group">
                <label for="MAIL">メールアドレス<span class="required">※必須</span></label>
                <input type="email" id="MAIL" name="MAIL" value="{{ $acmailEdit->MAIL }}" required/>
            </div>
            <div class="form-group">
                <label for="COL1">項目１<span class="required"></span></label>
                <input type="text" id="COL1" name="COL1" value="{{ $acmailEdit->COL1 }}"/>
            </div>
            <div class="form-group">
                <label for="COL2">項目２<span class="required"></span></label>
                <input type="text" id="COL2" name="COL2" value="{{ $acmailEdit->COL2 }}"/>
            </div>
            <div class="form-group">
                <label for="COL3">項目３<span class="required"></span></label>
                <input type="text" id="COL3" name="COL3" value="{{ $acmailEdit->COL3 }}"/>
            </div>
            <div class="form-group">
                <label for="COL4">項目４<span class="required"></span></label>
                <input type="text" id="COL4" name="COL4" value="{{ $acmailEdit->COL4 }}"/>
            </div>
            <div class="form-group">
                <label for="COL5">項目５<span class="required"></span></label>
                <input type="text" id="COL5" name="COL5" value="{{ $acmailEdit->COL5 }}"/>
            </div>
            <div class="form-group">
                <label for="COL6">項目６<span class="required"></span></label>
                <input type="text" id="COL6" name="COL6" value="{{ $acmailEdit->COL6 }}"/>
            </div>
            <div class="form-group">
                <label for="COL7">項目７<span class="required"></span></label>
                <input type="text" id="COL7" name="COL7" value="{{ $acmailEdit->COL7 }}"/>
            </div>
            <div class="form-group">
                <label for="COL8">項目８<span class="required"></span></label>
                <input type="text" id="COL8" name="COL8" value="{{ $acmailEdit->COL8 }}"/>
            </div>
            <div class="form-group">
                <label for="COL9">項目９<span class="required"></span></label>
                <input type="text" id="COL9" name="COL9" value="{{ $acmailEdit->COL9 }}"/>
            </div>
            <div class="form-group">
                <label for="COL10">項目１０<span class="required"></span></label>
                <input type="text" id="COL10" name="COL10" value="{{ $acmailEdit->COL10 }}"/>
            </div>
            <div class="form-group">
                <label for="DELIVERY_FLG">配信フラグ<span class="required"></span></label>
                <select id="DELIVERY_FLG" name="DELIVERY_FLG">
                    <option value="" {{ old('DELIVERY_FLG', $acmailEdit->DELIVERY_FLG) === '' ? 'selected' : '' }}>配信しない</option>
                    <option value="1" {{ old('DELIVERY_FLG', $acmailEdit->DELIVERY_FLG) === '1' ? 'selected' : '' }}>配信する</option>
                </select>
            </div>
            <button type="submit" class="submit-button">送信する</button>
        </form>
        @endif
    </div>
</main>

@push('scripts')
<script src="{{ asset('js/admin-script.js') }}"></script>

@endpush

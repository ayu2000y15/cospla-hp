<main>
    <div class="form-area">
        <h3>◆問い合わせお知らせメールアドレス登録</h3>
        <p>※最大2人まで登録が可能です。<br>
        </p>
        <form action="{{ route('admin.company.mail') }}" onsubmit="return checkSubmit('登録');" method="POST">
            @csrf
            <div class="form-group">
                <label for="SPARE1">メールアドレス[to]<span class="required">※必須</span></label>
                <input type="email" id="SPARE1" name="SPARE1" value="{{ $company->SPARE1 }}" placeholder="example@gmail.com" required/>
            </div>
            <div class="form-group">
                <label for="SPARE2">メールアドレス[cc]<span class="required"></span></label>
                <input type="email" id="SPARE2" name="SPARE2" value="{{ $company->SPARE2 }}" placeholder="example@gmail.com" />
            </div>

            <button type="submit" class="submit-button">送信する</button>
        </form>

        <hr class="hr-line">
        <h3>◆会社情報変更</h3>
        <form action="{{ route('admin.company.update') }}" onsubmit="return checkSubmit('登録');" method="POST">
            @csrf
            <div class="form-group">
                <label for="COMPANY_NAME">会社名<span class="required">※必須</span></label>
                <input type="text" id="COMPANY_NAME" name="COMPANY_NAME" value="{{ $company->COMPANY_NAME }}" required/>
            </div>
            <div class="form-group">
                <label for="ESTABLISHMENT_DATE">設立日<span class="required">※必須</span></label>
                <input type="date" id="ESTABLISHMENT_DATE" name="ESTABLISHMENT_DATE" value="{{ $company->ESTABLISHMENT_DATE }}" required/>
            </div>
            <div class="form-group">
                <label for="DIRECTOR">代表取締役<span class="required">※必須</span></label>
                <input type="text" id="DIRECTOR" name="DIRECTOR" value="{{ $company->DIRECTOR }}" required/>
            </div>
            <div class="form-group">
                <label for="POST_CODE">郵便番号<span class="required">※必須</span></label>
                <input type="text" id="POST_CODE" name="POST_CODE" value="{{ $company->POST_CODE }}" pattern="\d{3}-?\d{4}" required/>
            </div>
            <div class="form-group">
                <label for="DIRECTOR">代表取締役<span class="required">※必須</span></label>
                <input type="text" id="DIRECTOR" name="DIRECTOR" value="{{ $company->DIRECTOR }}" required/>
            </div>
            <div class="form-group">
                <label for="LOCATION">所在地<span class="required">※必須</span></label>
                <input type="text" id="LOCATION" name="LOCATION" value="{{ $company->LOCATION }}" required/>
            </div>
            <div class="form-group">
                <label for="CONTENT">事業内容<span class="required">※必須</span></label>
                <input type="text" id="CONTENT" name="CONTENT" value="{{ $company->CONTENT }}" required/>
            </div>
            <div class="form-group">
                <label for="SNS_1">X(旧Twitter) ID<span class="required"></span></label>
                <input type="text" id="SNS_1" name="SNS_1" value="{{ $company->SNS_1 }}" />
            </div>
            <div class="form-group">
                <label for="SNS_2">instagram ID<span class="required"></span></label>
                <input type="text" id="SNS_2" name="SNS_2" value="{{ $company->SNS_2 }}" />
            </div>
            <div class="form-group">
                <label for="SNS_3">TikTok ID<span class="required"></span></label>
                <input type="text" id="SNS_3" name="SNS_3" value="{{ $company->SNS_3 }}" />
            </div>
            <button type="submit" class="submit-button">送信する</button>
        </form>
    </div>
</main>

@push('scripts')
<script src="{{ asset('js/admin-script.js') }}"></script>
@endpush
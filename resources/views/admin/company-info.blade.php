<div class="space-y-10">
    {{-- 問い合わせお知らせメールアドレス登録 --}}
    <div class="p-6 bg-white rounded-lg shadow">
        <h3 class="text-lg font-medium leading-6 text-gray-900">問い合わせお知らせメールアドレス登録</h3>
        <p class="mt-1 text-sm text-gray-500">HPからの問い合わせがあった際に通知を受け取るメールアドレスを設定します。最大2つまで登録可能です。</p>
        <form action="{{ route('admin.company.mail') }}" method="POST" class="mt-6 space-y-4">
            @csrf
            <div>
                <label for="SPARE1" class="block text-sm font-medium text-gray-700">メールアドレス (To) <span
                        class="text-red-500">*</span></label>
                <div class="mt-1">
                    <input type="email" name="SPARE1" id="SPARE1" value="{{ $company->SPARE1 }}" required
                        class="block w-full p-2 bg-white border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
            </div>
            <div>
                <label for="SPARE2" class="block text-sm font-medium text-gray-700">メールアドレス (Cc)</label>
                <div class="mt-1">
                    <input type="email" name="SPARE2" id="SPARE2" value="{{ $company->SPARE2 }}"
                        class="block w-full p-2 bg-white border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
            </div>
            <div class="flex justify-end pt-2">
                <button type="submit"
                    class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700">メール設定を保存</button>
            </div>
        </form>
    </div>

    {{-- 会社情報変更 --}}
    <div class="p-6 bg-white rounded-lg shadow">
        <h3 class="text-lg font-medium leading-6 text-gray-900">会社情報変更</h3>
        <p class="mt-1 text-sm text-gray-500">サイトのフッターやABOUTページに表示される情報を編集します。</p>
        <form action="{{ route('admin.company.update') }}" method="POST" class="mt-6 space-y-4">
            @csrf
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="COMPANY_NAME" class="block text-sm font-medium text-gray-700">会社名 <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="COMPANY_NAME" id="COMPANY_NAME" value="{{ $company->COMPANY_NAME }}"
                        required class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="ESTABLISHMENT_DATE" class="block text-sm font-medium text-gray-700">設立日 <span
                            class="text-red-500">*</span></label>
                    <input type="date" name="ESTABLISHMENT_DATE" id="ESTABLISHMENT_DATE"
                        value="{{ $company->ESTABLISHMENT_DATE }}" required
                        class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="DIRECTOR" class="block text-sm font-medium text-gray-700">代表取締役 <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="DIRECTOR" id="DIRECTOR" value="{{ $company->DIRECTOR }}" required
                        class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="POST_CODE" class="block text-sm font-medium text-gray-700">郵便番号 <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="POST_CODE" id="POST_CODE" value="{{ $company->POST_CODE }}"
                        pattern="\d{3}-?\d{4}" required
                        class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="sm:col-span-2">
                    <label for="LOCATION" class="block text-sm font-medium text-gray-700">所在地 <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="LOCATION" id="LOCATION" value="{{ $company->LOCATION }}" required
                        class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="sm:col-span-2">
                    <label for="CONTENT" class="block text-sm font-medium text-gray-700">事業内容 <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="CONTENT" id="CONTENT" value="{{ $company->CONTENT }}" required
                        class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="sm:col-span-2">
                    <label for="SNS_1" class="block text-sm font-medium text-gray-700">X (旧Twitter) URL</label>
                    <input type="url" name="SNS_1" id="SNS_1" value="{{ $company->SNS_1 }}"
                        class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="sm:col-span-2">
                    <label for="SNS_2" class="block text-sm font-medium text-gray-700">Instagram URL</label>
                    <input type="url" name="SNS_2" id="SNS_2" value="{{ $company->SNS_2 }}"
                        class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="sm:col-span-2">
                    <label for="SNS_3" class="block text-sm font-medium text-gray-700">TikTok URL</label>
                    <input type="url" name="SNS_3" id="SNS_3" value="{{ $company->SNS_3 }}"
                        class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                </div>
            </div>
            <div class="flex justify-end pt-4 mt-4 border-t border-gray-200">
                <button type="submit"
                    class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700">会社情報を保存</button>
            </div>
        </form>
    </div>
</div>
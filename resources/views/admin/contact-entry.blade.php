<details class="bg-white rounded-lg shadow group">
    <summary class="flex items-center justify-between p-4 font-medium list-none cursor-pointer">
        <h3 class="text-lg leading-6 text-gray-900">問い合わせカテゴリ設定</h3>
        <svg class="w-5 h-5 transition-transform duration-300 transform group-open:rotate-180" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </summary>
    <div class="p-6 border-t border-gray-200">
        <div class="space-y-8">
            <div>
                <h4 class="text-base font-medium leading-6 text-gray-900">カテゴリ新規登録</h4>
                <form action="{{ route('admin.contact.entry') }}" method="POST"
                    class="mt-4 space-y-4 sm:flex sm:items-end sm:space-y-0 sm:space-x-3">
                    @csrf
                    <div class="flex-grow">
                        <label for="CONTACT_CATEGORY_NAME" class="block text-sm font-medium text-gray-700">カテゴリ名</label>
                        <input type="text" name="CONTACT_CATEGORY_NAME" id="CONTACT_CATEGORY_NAME" required
                            class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div class="sm:w-32">
                        <label for="REFERENCE_CODE" class="block text-sm font-medium text-gray-700">問い合わせコード
                            (2文字)</label>
                        <input type="text" name="REFERENCE_CODE" id="REFERENCE_CODE" required maxlength="2"
                            class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm">
                    </div>
                    <button type="submit"
                        class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm sm:w-auto hover:bg-indigo-700">作成</button>
                </form>
            </div>

            <div class="pt-8 border-t border-gray-200">
                <h4 class="text-base font-medium leading-6 text-gray-900">登録済み問い合わせカテゴリ一覧</h4>
                <div class="mt-4 flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full divide-y divide-gray-300">
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($contactList as $contact)
                                        <tr>
                                            <td class="w-full py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
                                                <form
                                                    action="{{ route('admin.contact.update', $contact->CONTACT_CATEGORY_ID) }}"
                                                    method="POST" class="flex items-center justify-between gap-x-4">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="CONTACT_CATEGORY_ID"
                                                        value="{{ $contact->CONTACT_CATEGORY_ID }}">
                                                    <input type="text" name="CONTACT_CATEGORY_NAME"
                                                        value="{{ $contact->CONTACT_CATEGORY_NAME }}"
                                                        class="flex-grow p-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm">
                                                    <span
                                                        class="px-3 text-sm text-gray-500">{{ $contact->REFERENCE_CODE }}</span>
                                                    <button type="submit"
                                                        class="text-sm font-medium text-indigo-600 hover:text-indigo-800">更新</button>
                                                </form>
                                            </td>
                                            <td
                                                class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                                                <form
                                                    action="{{ route('admin.contact.delete', ['id' => $contact->CONTACT_CATEGORY_ID]) }}"
                                                    method="POST" onsubmit="return confirm('このカテゴリを削除しますか？');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-800">削除</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-3 py-4 text-sm text-center text-gray-500">
                                                カテゴリはまだ登録されていません。</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</details>
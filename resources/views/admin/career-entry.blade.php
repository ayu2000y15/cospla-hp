<details class="bg-white rounded-lg shadow group">
    <summary class="flex items-center justify-between p-4 font-medium list-none cursor-pointer">
        <h3 class="text-lg leading-6 text-gray-900">経歴カテゴリ設定</h3>
        <svg class="w-5 h-5 transition-transform duration-300 transform group-open:rotate-180" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </summary>
    <div class="p-6 border-t border-gray-200">
        <div class="space-y-8">
            <div>
                <h4 class="text-base font-medium leading-6 text-gray-900">カテゴリ新規登録</h4>
                <form action="{{ route('admin.career.entry') }}" method="POST"
                    class="mt-4 sm:flex sm:items-end sm:space-x-3">
                    @csrf
                    <div class="flex-grow">
                        <label for="CAREER_CATEGORY_NAME" class="block text-sm font-medium text-gray-700">カテゴリ名</label>
                        <div class="mt-1">
                            <input type="text" name="CAREER_CATEGORY_NAME" id="CAREER_CATEGORY_NAME" required
                                class="block w-full p-2 bg-white border border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>
                    <button type="submit"
                        class="inline-flex items-center justify-center w-full px-4 py-2 mt-4 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm sm:mt-0 sm:w-auto hover:bg-indigo-700">作成</button>
                </form>
            </div>

            <div class="pt-8 border-t border-gray-200">
                <h4 class="text-base font-medium leading-6 text-gray-900">登録済みカテゴリ一覧</h4>
                <div class="mt-4 flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full divide-y divide-gray-300">
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($careerList as $career)
                                        <tr>
                                            <td class="w-full py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
                                                <form
                                                    action="{{ route('admin.career.update', $career->CAREER_CATEGORY_ID) }}"
                                                    method="POST" class="flex items-center justify-between gap-x-4">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="CAREER_CATEGORY_ID"
                                                        value="{{ $career->CAREER_CATEGORY_ID }}">
                                                    <input type="text" name="CAREER_CATEGORY_NAME"
                                                        value="{{ $career->CAREER_CATEGORY_NAME }}"
                                                        class="flex-grow p-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm">
                                                    <button type="submit"
                                                        class="text-sm font-medium text-indigo-600 hover:text-indigo-800">更新</button>
                                                </form>
                                            </td>
                                            <td
                                                class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                                                <form
                                                    action="{{ route('admin.career.delete', ['id' => $career->CAREER_CATEGORY_ID]) }}"
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
                                            <td colspan="2" class="px-3 py-4 text-sm text-center text-gray-500">
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
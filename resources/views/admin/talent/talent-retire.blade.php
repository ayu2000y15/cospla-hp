<div class="p-6 bg-white rounded-lg shadow">
    <h3 class="text-lg font-medium leading-6 text-gray-900">タレント退職処理</h3>
    <form method="POST" action="{{ route('admin.talent.retire') }}" class="mt-4"
        onsubmit="return confirm('このタレントを退職済みにしますか？');">
        @csrf
        @method('PUT')
        <input type="hidden" name="TALENT_ID" value="{{ $talent->TALENT_ID }}">
        <input type="hidden" name="activeTab" :value="activeTab">
        <div>
            <label for="RETIREMENT_DATE" class="block text-sm font-medium text-gray-700">退職日</label>
            <div class="mt-1">
                <input type="date" id="RETIREMENT_DATE" name="RETIREMENT_DATE" required
                    value="{{ old('RETIREMENT_DATE', $talent->RETIREMENT_DATE) === '2099-01-01' ? '' : \Carbon\Carbon::parse($talent->RETIREMENT_DATE)->format('Y-m-d') }}"
                    class="block p-2 bg-white border border-gray-300 rounded-md shadow-sm">
            </div>
        </div>
        <div class="mt-4">
            <button type="submit"
                class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700">退職日を設定する</button>
        </div>
    </form>
</div>
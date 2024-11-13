<main>
    <div class="form-area">
        <h2>タレント退職</h2>

        <form method="POST" onsubmit="return checkSubmit('登録');" action="{{ route('admin.talent.retire') }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="TALENT_ID" value="{{ $talent->TALENT_ID }}">
            <div class="form-group">
                <label for="RETIREMENT_DATE">退職日</label>
                <input type="date" id="RETIREMENT_DATE" name="RETIREMENT_DATE" value="{{ old('RETIREMENT_DATE', $talent->RETIREMENT_DATE) }}" required />
            </div>
            <button type="submit" class="submit-button">送信する</button>
        </form>
    </div>
</main>

@push('scripts')
<script src="{{ asset('js/admin-script.js') }}"></script>
@endpush
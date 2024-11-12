<div class="form-area list">
    <h2>登録済みタレント一覧</h2>
    <p>※タレント名をクリックすることでタレント詳細ページに遷移します。<br>
        　タレント詳細ページではタレントの写真や経歴、ハッシュタグの情報の更新が行えます。<br></p>
    <br>
    <div class="table-container talent">
        <table>
            <tr>
                <th>タレントID</th>
                <th>レイヤーネーム</th>
                <th>所属日</th>
                <th>退職日</th>
                <th>在籍状況</th>
            </tr>
            @foreach ($talentList as $talent)
            @csrf
            @method('PUT')
            <tr data-talent-id="{{ $talent->TALENT_ID }}">
                <td>{{ $talent->TALENT_ID }}</td>
                <td>{{ $talent->LAYER_NAME }}</td>
                <td>{{ $talent->AFFILIATION_DATE }}</td>
                <td>
                    @if($talent->RETIREMENT_DATE != '2099-01-01')
                        {{ $talent->RETIREMENT_DATE }}
                    @endif
                </td>
                <td>
                    @if($talent->RETIREMENT_DATE <= date('Y-m-d') && $talent->DEL_FLG === '1')
                        退職済み
                    @else
                        在籍
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/admin-script.js') }}"></script>
@endpush
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const table = document.querySelector('table');
    table.addEventListener('click', function(e) {
        const row = e.target.closest('tr');
        if (row && row.dataset.talentId) {
            row.classList.toggle('selected');
            const form = document.createElement('form');
            form.method = 'post';
            form.action = '{{ route( 'admin.talent.detail' )}}';
            const talentIdInput = document.createElement('input');
            talentIdInput.type = 'hidden';
            talentIdInput.name = 'TALENT_ID';
            talentIdInput.value = row.dataset.talentId;
            const tokenInput = document.createElement('input');
            tokenInput.type = 'hidden';
            tokenInput.name = '_token';
            tokenInput.value = '{{ csrf_token() }}';
            form.appendChild(talentIdInput);
            form.appendChild(tokenInput);
            document.body.appendChild(form);
            form.submit();
        }
    });
});
</script>
@endpush
<table class="ui table celled">
    <thead>
    <tr>
        <th class="center aligned" style="width: 50%">Status</th>
        <th class="center aligned" style="width: 50%">Waktu</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="center aligned">
            @if(!$submit->sent)
                {{ 'Tersimpan' }}
            @elseif($submit->verified)
                {{ 'Terverifikasi' }}
            @elseif($submit->sent)
                {{ 'Terkirim' }}
            @endif
        </td>
        <td class="center aligned">{{ $submit->updated_at }}</td>
    </tr>
    </tbody>
</table>

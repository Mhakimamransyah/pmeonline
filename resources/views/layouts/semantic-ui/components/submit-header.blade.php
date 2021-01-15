<table class="ui table celled">
    <thead>
    <tr>
        <th class="center aligned" style="width: 20%">Kode Peserta</th>
        <th class="center aligned" style="width: 40%">Instansi</th>
        <th class="center aligned" style="width: 40%">Personil Penghubung</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="center aligned">{{ $submit->participant_number }}</td>
        <td class="center aligned">{{ $submit->laboratory_name }}</td>
        <td class="center aligned">{{ $submit->contact_person_name }}</td>
    </tr>
    </tbody>
</table>
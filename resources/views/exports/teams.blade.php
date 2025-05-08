<table>
    <thead>
        <tr>
            <th colspan="18">Data Tim Debat</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($teams as $index => $team)
            <tr>
                <td colspan="18"><strong>Tim: {{ $team->name }}</strong></td>
            </tr>
            <tr>
                <td colspan="9"><strong>Alasan:</strong> {{ $team->reason }}</td>
                <td colspan="5"><strong>Metode:</strong> {{ $team->payment_method }}</td>
                <td colspan="4"><strong>Status:</strong> {{ $team->payment_validated ? 'Valid' : 'Belum Valid' }}</td>
            </tr>
            <tr>
                <td><strong>Debater</strong></td>
                <td><strong>Nama</strong></td>
                <td><strong>NPM</strong></td>
                <td><strong>Prodi</strong></td>
                <td><strong>Gender</strong></td>
                <td><strong>No HP</strong></td>
                <td><strong>Alamat</strong></td>
                <td colspan="2"><strong>Tanggal Daftar</strong></td>
            </tr>
            @foreach ($team->debaters as $debater)
                <tr>
                    <td>{{ ucfirst(str_replace('_', ' ', $debater->position)) }}</td>
                    <td>{{ $debater->name }}</td>
                    <td>{{ $debater->npm }}</td>
                    <td>{{ $debater->study_program }}</td>
                    <td>{{ $debater->gender }}</td>
                    <td>{{ $debater->phone }}</td>
                    <td>{{ $debater->address }}</td>
                    <td colspan="2">{{ $team->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach

            <tr><td colspan="18"></td></tr> {{-- Spacer --}}
        @endforeach
    </tbody>
</table>

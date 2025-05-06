<?php

namespace App\Imports;

use App\Models\Team;
use App\Models\Debater;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class TeamsImport implements ToCollection, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (empty($row['nama_tim_debat'])) {
                continue;
            }

            $team = Team::create([
                'name' => $row['nama_tim_debat'] ?? 'Tim Tanpa Nama',
                'reason' => $row['alasan_mengikuti_lomba'] ?? '-',
                'payment_method' => $row['metode_pembayaran'] ?? 'Manual',
                'payment_validated' => strtolower($row['validasi_pembayaran'] ?? 'false') === 'true',
            ]);

            Debater::create([
                'team_id' => $team->id,
                'position' => 'debater_1',
                'name' => $row['nama_debater_1'] ?? '',
                'npm' => (string)($row['npm_debater_1'] ?? ''),
                'study_program' => $row['program_studi_debater_1'] ?? '',
                'gender' => $row['jenis_kelamin_debater_1'] ?? '',
                'phone' => $row['no_hp_debater_1'] ?? '',
                'address' => $row['alamat_debater_1'] ?? '',
            ]);

            Debater::create([
                'team_id' => $team->id,
                'position' => 'debater_2',
                'name' => $row['nama_debater_2'] ?? '',
                'npm' => (string)($row['npm_debater_2'] ?? ''),
                'study_program' => $row['program_studi_debater_2'] ?? '',
                'gender' => $row['jenis_kelamin_debater_2'] ?? '',
                'phone' => $row['no_hp_debater_2'] ?? '',
                'address' => $row['alamat_debater_2'] ?? '',
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'nama_tim_debat' => 'required',
            'nama_debater_1' => 'required',
            'npm_debater_1' => 'required',
            'nama_debater_2' => 'required',
            'npm_debater_2' => 'required',
        ];
    }
}

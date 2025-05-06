<?php

namespace App\Exports;

use App\Models\Team;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class TeamsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Team::with('debaters')->orderBy('name')->get();
    }

    public function headings(): array
    {
        return [
            'NO',
            'NAMA TIM',
            'ALASAN MENGIKUTI',
            'METODE PEMBAYARAN',
            'STATUS PEMBAYARAN',
            'DEBATER 1 - NAMA',
            'DEBATER 1 - NPM',
            'DEBATER 1 - PROGRAM STUDI',
            'DEBATER 1 - JENIS KELAMIN',
            'DEBATER 1 - NO HP',
            'DEBATER 1 - ALAMAT',
            'DEBATER 2 - NAMA',
            'DEBATER 2 - NPM',
            'DEBATER 2 - PROGRAM STUDI',
            'DEBATER 2 - JENIS KELAMIN',
            'DEBATER 2 - NO HP',
            'DEBATER 2 - ALAMAT',
            'TANGGAL DAFTAR'
        ];
    }

    public function map($team): array
    {
        $debater1 = $team->debaters->where('position', 'debater_1')->first();
        $debater2 = $team->debaters->where('position', 'debater_2')->first();

        return [
            '', // Nomor urut akan diisi oleh Excel
            $team->name,
            $team->reason,
            $team->payment_method,
            $team->payment_validated ? 'Valid' : 'Belum Valid',
            $debater1->name ?? '',
            $debater1->npm ?? '',
            $debater1->study_program ?? '',
            $debater1->gender ?? '',
            $debater1->phone ?? '',
            $debater1->address ?? '',
            $debater2->name ?? '',
            $debater2->npm ?? '',
            $debater2->study_program ?? '',
            $debater2->gender ?? '',
            $debater2->phone ?? '',
            $debater2->address ?? '',
            $team->created_at->format('d/m/Y H:i')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style untuk header
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '3498db']]
            ],

            // Style untuk kolom
            'A:R' => [
                'alignment' => ['vertical' => 'center']
            ],

            // Auto size kolom
            'A:R' => [
                'autoSize' => true
            ]
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_TEXT, // Kolom NPM sebagai text
            'L' => NumberFormat::FORMAT_TEXT, // Kolom NPM sebagai text
            'Q' => NumberFormat::FORMAT_DATE_DDMMYYYY, // Format tanggal
        ];
    }
}

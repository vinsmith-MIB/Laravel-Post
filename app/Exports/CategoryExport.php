<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CategoryExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'id',
            'Category Name',
            'Slug',
            'Created at',
            'Updated at',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Apply bold font and background color to the header row
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'FFA07A']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Center-align all cells in the sheet
        $sheet->getStyle('A:E')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('1:1')->getFont()->setBold(true); // Set bold font for the first row

        return $sheet;
    }

    public function collection()
    {
        return Category::all();
    }
}

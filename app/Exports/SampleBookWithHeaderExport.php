<?php


namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class SampleBookWithHeaderExport implements FromArray, WithHeadings, WithTitle
{

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'tieu_de',
            'tac_gia',
            'danh_muc',
            'ghi_chu'
        ];
    }

    /**
     * @return array
     */
    public function array(): array
    {
        return [
            ['Chiến lược đại dương xanh',
                'W. Chan Kim & Renee Mauborgne',
                'Quản trị, doanh nghiệp',
                'Sách nhập thử'
            ]
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Sach';
    }
}

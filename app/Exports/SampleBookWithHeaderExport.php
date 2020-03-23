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
            'barcode',
            'danh_muc',
            'nhom_tuoi',
            'nha_xuat_ban'
        ];
    }

    /**
     * @return array
     */
    public function array(): array
    {
        return [
            ['Lập trình JavaScript',
                'CodeGym',
                '123456',
                'Lập trình',
                '13-30',
                'Nội bộ']
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

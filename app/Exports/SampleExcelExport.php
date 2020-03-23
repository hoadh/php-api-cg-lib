<?php


namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SampleExcelExport implements WithMultipleSheets
{

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new SampleBookWithHeaderExport();
        $sheets[] = new CategoriesExport();

        return $sheets;
    }

}

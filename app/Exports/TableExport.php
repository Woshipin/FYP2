<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Table;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TableExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Table::select('title')->get();
    }

    public function headings(): array
    {
        return [
            'Table_Title',
        ];
    }
}

<?php

namespace App\Imports;

use App\Models\Facility;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class FacilityImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            // 跳过表头
            if ($index === 0) continue;

            Facility::create([
                'name'          => $row[0],
                'icon_class'    => $row[1],
                'charge_type'   => $row[2],
                'display_order' => $row[3],
            ]);
        }
    }
}


<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContactExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Contact::select('name', 'email', 'phone', 'subject', 'message')->get();
    }

    public function headings(): array
    {
        return [
            'User Name',
            'User Email',
            'Phone Number',
            'Subject',
            'Message',
        ];
    }
}

<?php

namespace App\Exports;

use App\Models\Users;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Excel;

class UsersExample implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize, Responsable
{

    use Exportable;

    private $fileName = 'users_example.xlsx';
    private $writerType = Excel::XLSX;
    private $headers = [
        'Content-Type' => 'text/csv'
    ];


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([
            [
                'name' => 'Excel Admin',
                'email' => 'excel.admin4@example.com',
                'password' => 'ExcelAdmin123!',
                'role' => 1,
            ],
            [
                'name' => 'Excel User',
                'email' => 'excel.user4@example.com',
                'password' => 'ExcelUser123!',
                'role' => 2,
            ],
            [
                'name' => 'Excel Operator',
                'email' => 'excel.operator4@example.com',
                'password' => 'ExcelOperator123!',
                'role' => 3,
            ],
            [
                'name' => 'Excel Manager',
                'email' => 'excel.manager4@example.com',
                'password' => 'ExcelManager123!',
                'role' => 1,
            ],
        ]);
    }

    public function headings(): array
    {

        return [

            'name',
            'email',
            'password',
            'role'
        ];
    }

    public function title(): string
    {
        return "User Import Example";
    }
}

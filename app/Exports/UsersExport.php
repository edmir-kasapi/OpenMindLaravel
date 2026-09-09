<?php

namespace App\Exports;

//use App\Exports\Sheets\AdminsSheet;
//use App\Exports\Sheets\OperatorsSheet;
//use App\Exports\Sheets\UsersSheet;
//use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport extends DocumentExport
{
    protected string $activeName = 'active_users';
    protected string $trashedName = 'deleted_users';
    protected string $extension = ".xlsx";

    protected string $dateColumn;
    protected string $createtAtColumn = 'registered_at';
    protected string $deletedAtColumn = 'deleted_at';

    protected string $activeTitle = 'Users';
    protected string $trashedTitle = 'Inactive Users';

    /*
    public function sheets(): array
    {
        return[
            new UsersSheet(),
            new OperatorsSheet(),
            new AdminsSheet()
        ];
    }
    */

    public function headings(): array
    {

        return [
            'id',
            'name',
            'email',
            'role',
            $this->dateColumn,
            'status',
            'verified_at'
        ];
    }

    public function map($user): array
    {
        $date_val = $this-> parseDateColumn($user);

        return [
            $user->id,
            $user->name,
            $user->email,
            $user->role->getRoleName(),
            Carbon::parse($date_val)->format('H:i:s d-m-Y'),
            $user->getVerificationStatus(),
            $user->getverificationDate()
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $highestRow = $sheet->getHighestRow();

        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            "B2:B{$highestRow}" => ['font' => ['italic' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => [self::class, 'aftersheet']
        ];
    }

    public static function afterSheet(AfterSheet $event)
    {
        $sheet = $event->sheet->getDelegate();
        $highestRow = $sheet->getHighestRow();

        $range1 = "D2:D{$highestRow}";
        $range2 = "F2:F{$highestRow}";

        //Role Column
        $sheet->getStyle($range1)
            ->setConditionalStyles([
                self::conditionalColor('Admin', Color::COLOR_RED),
                self::conditionalColor('User', Color::COLOR_BLUE),
                self::conditionalColor('Store Operator', Color::COLOR_DARKYELLOW)
            ]);

        //Status Column
        $sheet->getStyle($range2)
            ->setConditionalStyles([
                self::conditionalColor('Unverified', Color::COLOR_RED),
                self::conditionalColor('Verified', Color::COLOR_DARKGREEN)
            ]);

        $sheet->setSelectedCell('A1');
    }
}

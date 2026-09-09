<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Style\Color;

abstract class DocumentExport implements FromQuery, WithHeadings, WithMapping, WithTitle, ShouldAutoSize, WithStyles, WithEvents, Responsable
{
    use Exportable;

    protected string $fileName;
    protected string $activeName;
    protected string $trashedName;
    protected string $extension;

    protected string $dateColumn;
    protected string $createtAtColumn;
    protected string $deletedAtColumn;

    protected string $activeTitle;
    protected string $trashedTitle;

    protected Builder $query;
    protected bool $onlyTrashed;

    private $writerType = Excel::XLSX;
    private $headers = [
        'Content-Type' => 'text/csv'
    ];

    public function __construct(
        Builder $query,
        ?bool $onlyTrashed = false
    ) {
        $this->query = $query;
        $this->onlyTrashed = $onlyTrashed;

        $this->initFileName();
        $this->initDateColumn();
    }

    public function query(): Builder
    {
        return $this->query;
    }

    protected function initFileName(): void
    {
        $this->fileName =  $this->fileName = ($this->onlyTrashed ? $this->trashedName : $this->activeName) . $this->extension;
    }

    protected function initDateColumn(): void
    {
        $this->dateColumn = $this-> onlyTrashed ? $this->deletedAtColumn : $this->createtAtColumn;
    }

    protected function parseDateColumn(Model $obj)
    {
        $date_val = $this-> onlyTrashed ? $obj->deleted_at : $obj->created_at;

        return Carbon::parse($date_val)->format('H:i:s d-m-Y');
    }

    public function title(): string
    {
        $title = $this->onlyTrashed ? $this->trashedTitle : $this->activeTitle;

        return $title;
    }

    protected static function conditionalColor(string $value, string $color): Conditional
    {
        $conditional = new Conditional();

        $conditional->setConditionType(Conditional::CONDITION_CELLIS);
        $conditional->setOperatorType(Conditional::OPERATOR_EQUAL);
        $conditional->addCondition('"' . $value . '"');
        $conditional->getStyle()
            ->getFont()
            ->setcolor(new Color($color));

        return $conditional;
    }
}

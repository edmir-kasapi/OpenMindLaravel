<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

abstract class DocumentImport implements ToCollection, WithHeadingRow, WithValidation
{
    use Importable;

    protected $rules;

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows): void
    {
        $records = [];

        foreach($rows as $index => $row)
        {
            $data = $row->toArray();

            $records[] = $data;
        }

        DB::transaction(function() use ($records){
            foreach($records as $data)
            {
                $this->insertRecordToDb($data);
            }
        });
    }

    public function rules(): array
    {
        return $this->rules;
    }

    abstract protected function insertRecordToDb($record): void;
}

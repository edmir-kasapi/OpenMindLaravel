<?php

namespace App\Livewire;

use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;
use Edmirkasapi\LiveDatatable\abstracts\LiveDatatable;

abstract class FileUploadDataTable extends LiveDatatable
{
    use WithFileUploads;

    public ?UploadedFile $importFile = null;

    public function downloadExample()
    {

    }

    public function exportData()
    {

    }

    public function importData(): void
    {

    }
}

<?php

namespace App\Traits\Datatable;

use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;

trait WithFileImportExport
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

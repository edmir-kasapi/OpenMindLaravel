<?php

namespace App\Imports;

use App\Models\User;
use App\Services\Auth\RegistrationService;
use App\Services\User\UserService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;

class UsersImport extends DocumentImport
{
    protected RegistrationService $registrationService;

    public function __construct()
    {
        $this->registrationService = new RegistrationService();
        $this->rules = [
                    "name" => ['required','string','max:100'],
                    "email" => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    "password" => ['required','string', 'min:8'],
                    "role" => ['required', 'exists:roles,id']
                ];
    }

    protected function insertRecordToDb($record): void
    {
       $this->registrationService->register($record);
    }


    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    public function model(array $row)
    {
        return new User([
            'name' => $row[0],
            'email' => $row[1],
            'password' => Hash::make($row[2]),
            'role_id' => match ($row[3]) {
                'Admin' => 1,
                'User' => 2,
                'Store Operator' => 3
            },
        ]);
    }

    public function onRow(Row $row): void
    {
        $cells = $row;

        User::create([
            'name' => $row[0],
            'email' => $row[1],
            'password' => Hash::make($row[2]),
            'role_id' => match ($row[3]) {
                'Admin' => 1,
                'User' => 2,
                'Store Operator' => 3
            },
        ]);
    }
    */


}

<?php

namespace App\Exports\Sheets;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class UsersSheet implements FromQuery, WithHeadings, WithMapping, WithTitle
{

    public function query(): Builder
        {
            return User::query()->with(['role'])->searchRole(2);
        }
    /*
    public function view(): View
    public function collection(): Collection
    {
        return User::query()->searchRole(2)->get();
    }
    */

    /*
    public function view(): View
    {
        return view("pages.admin.users.users",
        ['users' => User::query()->searchRole(1)->get()]);
    }
    */

    public function headings(): array
    {
        return [
            'id',
            'name',
            'email',
            'role',
            'date_joined',
            'status',
            'verified_at'
        ];
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->role->getRoleName(),
            Carbon::parse($user->created_at)->format('H:i:s d-m-Y'),
            $user->getVerificationStatus(),
            $user->getverificationDate()
        ];
    }

    public function title(): string
    {
        return 'Users';
    }
}

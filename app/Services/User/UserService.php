<?php

namespace App\Services\User;

use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class UserService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getActiveUsersforLivewire(
        ?string $name = null,
        ?string $email = null,
        ?string $role_id = null,
        ?string $status_id = null,
        ?int $per_page = 10,
        ?string $sort_type = null,
    ) {
        return User::query()
            ->with(['profile'])
            ->where('id', '!=', auth()->user()->id)
            ->searchName($name)
            ->searchEmail($email)
            ->searchRole($role_id)
            ->filterStatus($status_id)
            ->sortBy($sort_type)
            ->paginate($per_page)
            ->onEachSide(2);
    }

    public function getTrashedUsersforLivewire(
        ?string $name = null,
        ?string $email = null,
        ?string $role_id = null,
        ?string $status_id = null,
        ?int $per_page = 10,
        ?string $sort_type = null,
    ) {
        return User::onlyTrashed()
            ->with(['profile'])
            ->where('id', '!=', auth()->user()->id)
            ->searchName($name)
            ->searchEmail($email)
            ->searchRole($role_id)
            ->filterStatus($status_id)
            ->sortBy($sort_type)
            ->paginate($per_page)
            ->onEachSide(2);
    }

    public function updateUserInfo(User $user, array $data)
    {
        $user->update($data);
    }

    public function deleteUser(User $user)
    {
        $user->delete();
    }

    public function restoreUser(User $user): bool
    {
        if (User::where('email', $user->email)->exists()) {
            //return back()->with('error', "Cannot restore {$user->email} because another active user is using that email");
            return false;
        }

        $user->restore();
        return true;
    }

    public function forceDeleteUser(User $user)
    {
        $user->forceDelete();
    }

    public function exportUsers(Builder $query) {

        return new UsersExport($query);

    }

    public function exportTrashedUsers(Builder $query)
    {
        return new UsersExport(
            $query,
            true
        );
    }

    public function importUsers(UploadedFile $file)
    {
        (new UsersImport)->import($file);
    }
}

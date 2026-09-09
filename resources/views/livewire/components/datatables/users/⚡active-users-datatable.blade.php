<?php

use App\Models\User;
use App\Exports\UsersExample;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Traits\Datatable\WithFileImportExport;
use Edmirkasapi\LiveDatatable\abstracts\LiveDatatable;
use App\Services\User\UserService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Validators\ValidationException;

new class extends LiveDatatable {

    use WithFileImportExport;

    protected array $columnOrder = ['name', 'email', 'role_id', 'created_at', 'status', 'actions'];

    public ?string $userToDelete = null;
    protected UserService $userService;


    public function boot(UserService $userService): void
    {
        $this->userService = $userService;
    }

    public function prepareDeleteUser(string $id): void
    {
        $this->userToDelete = $id;
        $this->dispatch('show-modal', modalId: 'modal-delete-user');
    }

    public function proceedDeletion(): void
    {
        if (!$this->userToDelete) {
            return;
        }

        $user = User::find($this->userToDelete);

        if (!$user) {
            $this->userToDelete = null;
            $this->dispatch('show-error-message', message: 'Invalid User ID provided. Cannot delete.');
            return;
        }

        $this->userService->deleteUser($user);
        $this->dispatch('show-success-message', message: 'User deleted successfully');
        $this->goToPreviousPageIfEmpty($this->query());
    }

    public function cancelDeletion(): void
    {
        $this->userToDelete = null;
    }

    #[Override]
    public function exportData(): UsersExport
    {
        $query = $this->query();
        $query = $this->applySearch($query);
        $query = $this->applyFilters($query);
        $query = $this->applySorting($query);

        return $this->userService->exportUsers($query);
    }

    #[Override]
    public function importData(): void
    {
        if (!$this->importFile) {
            $this->dispatch('show-error-message', message: 'File not uploaded.');
            return;
        }

        $validated = $this->validate([
            'importFile' => ['required', 'file', 'mimes:xlsx,xls', 'max:10240'],
        ]);

        try {
            $this->userService->importUsers($validated['importFile']);

            $this->dispatch('show-success-message', message: 'Import successful.');
            $this->dispatch('hide-modal', modalId: 'modal-import-file');

            $this->resetPage();
        } catch (ValidationException $e) {
            $failures = $e->failures();

            $errors = collect($failures)
                ->flatMap(function ($failure) {
                    return collect($failure->errors())->map(fn($error) => "Row {$failure->row()} ({$failure->attribute()}): {$error}");
                })
                ->implode("\n");

            $this->dispatch('show-error-message', message: $errors);
        }
    }

    #[Override]
    public function downloadExample(): UsersExample
    {
        return new UsersExample();
    }

    /*
    public function exception($e, $stopPropagation)
    {
        if($e instanceof ValidationException)
        {
            $this->dispatch('show-error-message', message: $e->getMessage());
            $stopPropagation();
        }
    }
    */

    #[Override]
    protected function columns(): array
    {
        return [
            'name' => [
                'label' => __('admin/users.user_column'),
                'sortable' => true,
            ],

            'email' => [
                'label' => __('admin/users.email'),
                'sortable' => true,
            ],

            'role_id' => [
                'label' => __('admin/users.role'),
                'sortable' => true,
            ],

            'created_at' => [
                'label' => __('admin/users.joined'),
                'sortable' => true,
            ],

            'status' => [
                'label' => __('admin/users.status'),
            ],

            'actions' => [
                'label' => __('admin/users.actions'),
            ],
        ];
    }

    #[Override]
    protected function query(): Builder
    {
        return User::query()
            ->with(['profile'])
            ->where('id', '!=', auth()->user()->id);
    }

    #[Override]
    protected function applyFilters(Builder $query): Builder
    {
        foreach ($this->filters as $column => $value) {
            //$value = $this->filters[$filter] ?? null;

            if(blank($value) || !$this->isValidFilter($column))
            {
                continue;
            }

            switch ($column) {
                case 'name':
                case 'email':
                    $query->where($column, 'LIKE', "%{$value}%");
                    break;

                case 'status':
                    $query->filterStatus($value);
                    break;

                default:
                    $query->where($column, $value);
                    break;
            }
        }

        return $query;
    }

    #[Override]
    protected function searchable(): array
    {
        return [
            'name',
            'email'
            ];
    }
};
?>

@php
    $orderedColumns = $this->getOrderedColumns();
@endphp

<section class="w-75 mx-auto">

    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-12">
                    <!--begin::Card-->
                    <div class="card mb-4">
                        <!--begin::Card Header-->
                        <div class="card-header">
                            <div class="row g-2 align-items-center">
                                <div class="col-12 col-md-4">
                                    <h3 class="card-title">{{ __('admin/users.user_directory') }}</h3>
                                </div>
                                <div class="col-12 col-md-8">
                                    <div class="d-flex flex-wrap justify-content-md-end gap-3">

                                        <a href="{{ route('admin.trashed.users') }}" class="btn btn-sm btn-danger">
                                            <i class="bi bi-person-slash me-1" aria-hidden="true"> </i>
                                            {{ __('app.users_trashed') }}
                                        </a>


                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modal-add-user">
                                            <i class="bi bi-person-plus-fill me-1" aria-hidden="true"> </i>
                                            {{ __('admin/users.new_user') }}
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Card Header-->
                        <!--begin::Card Body-->
                        <div class="card-body p-0">
                            <div class="table-responsive">

                                <div class="dt-layout-row d-flex justify-content-start gap-3 bg-body-secondary">

                                    <div class="dt-layout-cell dt-layout-start d-flex">
                                        <div
                                            class="dt-length d-flex align-items-center gap-2 mb-3 ms-3 p-2 w-auto my-3 bg-light border rounded">
                                            <label class="mb-0 text-muted small fw-semibold">
                                                {{ __('admin/users.entries_per_page') }}
                                            </label>
                                            <select wire:model.live="perPage" wire:change="$dispatch('filters-updated')"
                                                class="dt-input form-select form-select-sm" style="width: 80px;">
                                                <option value="5">5</option>
                                                <option value="10" selected>10</option>
                                                <option value="15">15</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="dt-layout-cell dt-layout-start d-flex">
                                        <div
                                            class="dt-length d-flex align-items-center gap-2 mb-3 mr-3 p-2 w-auto my-3 bg-light border rounded">
                                            <label class="mb-0 text-muted small fw-semibold">
                                                {{ __('admin/users.search') }} </label>
                                                <input type="text" wire:model.live="search"
                                                    @input="$dispatch('filters-updated')" class="form-control">
                                        </div>
                                    </div>

                                    <div class="dt-layout-cell dt-layout-start d-flex">
                                        <div
                                            class="dt-length d-flex align-items-center mb-3 mr-3 p-2 gap-1 w-auto my-3">
                                            <button wire:click="exportData()" class="btn btn-light text-secondary">
                                                <i class="bi bi-file-earmark-excel-fill"></i>
                                                {{ __('admin/users.export_excel') }}
                                            </button>

                                            <button class="btn btn-light text-secondary" data-bs-toggle="modal"
                                                data-bs-target="#modal-import-file">
                                                <i class="bi bi-upload"></i>
                                                {{ __('admin/users.import_excel') }}
                                            </button>
                                        </div>
                                    </div>

                                </div>

                                <table class="table table-hover align-middle m-0" id="" role="table">
                                    <thead>
                                        <tr>
                                            @foreach ($orderedColumns as $key => $column)
                                                <th scope="col" wire:click="sortBy('{{ $key }}')"
                                                    class="text-nowrap user-select-none"
                                                    @if ($this->isSortable($key))  style="cursor: pointer" @endif
                                                    aria-sort="{{ $key === $this->sortColumn ? ($this->sortDirection === 'asc' ? 'ascending' : 'descending') : 'none' }}">
                                                    <div
                                                        class="d-flex align-items-center justify-content-between gap-2">
                                                        <span>{{ $column['label'] }}</span>

                                                        @if ($this->isSortable($key))
                                                            <span class="sort-icon">
                                                            @if ($key === $this->sortColumn && !blank($this->sortDirection))
                                                                @if ($this->sortDirection === 'asc')
                                                                    <i class="bi bi-arrow-up"></i>
                                                                @else
                                                                    <i class="bi bi-arrow-down"></i>
                                                                @endif
                                                            @else
                                                                <i class="bi bi-arrow-down-up"></i>
                                                            @endif
                                                        </span>
                                                        @endif
                                                    </div>
                                                </th>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            @foreach ($orderedColumns as $key => $column)
                                                <th scope="col">

                                                    @switch($key)
                                                        @case('name')
                                                            <input type="text" wire:model.live="filters.name"
                                                                @input="$dispatch('filters-updated')" class="form-control">
                                                        @break

                                                        @case('email')
                                                            <input type="text" wire:model.live="filters.email"
                                                                @input="$dispatch('filters-updated')" class="form-control">
                                                        @break

                                                        @case('role_id')
                                                            <select wire:model.live="filters.role_id"
                                                                wire:change="$dispatch('filters-updated')" class="form-control">
                                                                <option value="">{{ __('admin/users.all') }}</option>
                                                                <option value="1">{{ __('admin/users.admin') }}</option>
                                                                <option value="2">{{ __('admin/users.user') }}</option>
                                                                <option value="3">{{ __('admin/users.store_operator') }}
                                                                </option>
                                                            </select>
                                                        @break

                                                        @case('status')
                                                            <select wire:model.live="filters.status"
                                                                wire:change="$dispatch('filters-updated')" class="form-control">
                                                                <option value="">{{ __('admin/users.all') }}</option>
                                                                <option value="verified">{{ __('admin/users.verified') }}
                                                                </option>
                                                                <option value="unverified">{{ __('admin/users.unverified') }}
                                                                </option>
                                                            </select>
                                                        @break

                                                        @default
                                                    @endswitch

                                                </th>
                                            @endforeach
                                        </tr>

                                    </thead>
                                    <tbody>
                                        @foreach ($data as $user)
                                            <tr>
                                                @foreach ($orderedColumns as $key => $column)
                                                    <td scope="col">

                                                        @switch($key)
                                                            @case('name')
                                                                <x-datatable.user-table-cell :user="$user" />
                                                            @break

                                                            @case('role_id')
                                                                <x-datatable.badges.role-badge :role="$user->role->getRoleName()" />
                                                            @break

                                                            @case('status')
                                                                <x-datatable.badges.verified-badge :verified="$user->isVerified()" />
                                                            @break

                                                            @case('actions')
                                                                <x-datatable.buttons.button-layout>
                                                                    <a href=" {{ route('admin.users.inspect', $user->id) }} "
                                                                        class="btn btn-outline-secondary">
                                                                        <i class="bi bi-pencil" aria-hidden="true"> </i>
                                                                    </a>

                                                                    <x-datatable.buttons.action-button-mk2 type="danger"
                                                                        icon="trash"
                                                                        wire:click="prepareDeleteUser({{ $user->id }})" />
                                                                </x-datatable.buttons.button-layout>
                                                            @break

                                                            @default
                                                                {{ data_get($user, $key) }}
                                                        @endswitch

                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!--end::Card Body-->
                        <!--begin::Card Footer-->

                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-end">
                                {{ $data->links(data: ['scrollTo' => false]) }}
                            </ul>
                        </div>

                    </div>
                    <!--end::Card Footer-->
                </div>
                <!--end::Card-->
            </div>
            <!-- /.col -->
        </div>
        <!--end::Row-->

    </div>

    <!--end::Container-->

    <x-modals.import-file-modal id="modal-import-file" title="{{ __('admin/users.import_users') }}"
        message="{{ __('admin/users.import_users_message') }}" submit-text="{{ __('admin/users.import') }}"
        wire-submit="importData" wire-model="importFile" />

    <x-modals.confirm-modal-mk2 id="modal-delete-user" type="danger"
        title="{{ __('modals/delete-modal.delete_user') }}"
        message="{{ __('modals/delete-modal.delete_confirmation') }}"
        submit-text="{{ __('modals/delete-modal.delete_user_button') }}" wire-confirm="proceedDeletion()"
        wire-cancel="cancelDeletion()" />

</section>


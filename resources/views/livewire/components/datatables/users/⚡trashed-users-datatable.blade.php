<?php

use Livewire\Component;
use App\Services\User\UserService;
use App\Models\User;
use App\Exports\UsersExport;
use App\Traits\Datatable\WithFileImportExport;
use Edmirkasapi\LiveDatatable\abstracts\LiveDatatable;
use Illuminate\Database\Eloquent\Builder;
use App\Exports\TrashedUsersExport;
use Illuminate\Pagination\LengthAwarePaginator;

new class extends LiveDatatable {

    use WithFileImportExport;

    protected array $order = ['name', 'email', 'role_id', 'deleted_at', 'status', 'actions'];

    public ?string $userToRestore = null;
    public ?string $userToForceDelete = null;
    protected UserService $userService;

    public function boot(UserService $userService): void
    {
        $this->userService = $userService;
    }

    public function prepareRestoreUser(string $id): void
    {
        $this->userToRestore = $id;
        $this->dispatch('show-modal', modalId: 'modal-restore-user');
    }

    public function prepareForceDeleteUser(string $id): void
    {
        $this->userToForceDelete = $id;
        $this->dispatch('show-modal', modalId: 'modal-force-delete-user');
    }

    public function proceedRestore(): void
    {
        if (!$this->userToRestore) {
            return;
        }

        $user = User::onlyTrashed()->find($this->userToRestore);

        if (!$user) {
            $this->userToRestore = null;
            $this->dispatch('show-error-message', message: 'Invalid User ID provided. Cannot Restore.');
            return;
        }

        $this->userService->restoreUser($user);
        $this->dispatch('show-success-message', message: 'User restored successfully');
        $this->goToPreviousPageIfEmpty($this->query());
    }

    public function proceedForceDelete(): void
    {
        if (!$this->userToForceDelete) {
            return;
        }

        $user = User::onlyTrashed()->find($this->userToForceDelete);

        if (!$user) {
            $this->userToForceDelete = null;
            $this->dispatch('show-error-message', message: 'Invalid User ID provided. Cannot Force Delete.');
            return;
        }

        $this->userService->forceDeleteUser($user);
        $this->dispatch('show-success-message', message: 'User permanently deleted');
        $this->goToPreviousPageIfEmpty($this->getData());
    }

    public function cancelRestore(): void
    {
        $this->userToRestore = null;
    }

    public function cancelForceDelete(): void
    {
        $this->userToForceDelete = null;
    }

    #[Override]
    public function exportData(): UsersExport
    {
        $query = $this->query();
        $query = $this->applySearch($query);
        $query = $this->applyFilters($query);
        $query = $this->applySorting($query);

        return $this->userService->exportTrashedUsers($query);
    }

    #[Override]
    protected function columns(): array
    {
        return [
            'name' => [
                'label' => __('admin/users.user_column'),
                'sortable' => true
            ],

            'email' => [
                'label' => __('admin/users.email'),
                'sortable' => true
            ],

            'role_id' => [
                'label' => __('admin/users.role'),
                'sortable' => true
            ],

            'deleted_at' => [
                'label' => __('admin/users.deleted_at'),
                'sortable' => true
            ],

            'status' => [
                'label' => __('admin/users.status'),
            ],

            'actions' => [
                'label' => __('admin/users.actions'),
                'field' => 'actions',
            ],
        ];
    }

    #[Override]
    protected function query(): Builder
    {
        return User::onlyTrashed()->with(['profile']);
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
                                    <h3 class="card-title">{{ __('admin/users.deleted_users_list') }}</h3>
                                </div>
                                <div class="col-12 col-md-8">
                                    <div class="d-flex flex-wrap justify-content-md-end gap-3">

                                        <a href="{{ route('admin.users') }}">
                                            <button type="button" class="btn btn-sm btn-primary">
                                                <i class="bi bi-person-check me-1" aria-hidden="true"> </i>
                                                {{ __('app.users_active') }}
                                            </button>
                                        </a>

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
                                            <select wire:model.live="perPage"
                                                wire:change="$dispatch('filters-updated')"
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
                                        </div>
                                    </div>

                                </div>

                                <table class="table table-hover align-middle m-0" id="" role="table">
                                    <thead>
                                        <tr>
                                            @foreach ($orderedColumns as $key => $column)
                                                <th scope="col" wire:click="sortBy('{{ $key }}')"
                                                    class="text-nowrap user-select-none"
                                                    @if ($this->isSortable($key)) style="cursor: pointer" @endif
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
                                                                    <x-datatable.buttons.action-button-mk2 type="success"
                                                                        icon="arrow-repeat"
                                                                        wire:click="prepareRestoreUser({{ $user->id }})" />


                                                                    <x-datatable.buttons.action-button-mk2 type="danger"
                                                                        icon="clipboard2-x"
                                                                        wire:click="prepareForceDeleteUser({{ $user->id }})" />
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

    <x-modals.confirm-modal-mk2 id="modal-restore-user" type="success"
        title="{{ __('modals/restore-user-modal.restore_user') }}"
        message="{{ __('modals/restore-user-modal.restore_confirmation') }}"
        submit-text="{{ __('modals/restore-user-modal.restore_user_button') }}" wire-confirm="proceedRestore()"
        wire-cancel="cancelRestore()" />

    <x-modals.confirm-modal-mk2 id="modal-force-delete-user" type="danger"
        title="{{ __('modals/force-delete-modal.force_delete_user') }}"
        message="{{ __('modals/force-delete-modal.force_delete_confirmation') }}"
        submit-text="{{ __('modals/force-delete-modal.force_delete_user_button') }}"
        wire-confirm="proceedForceDelete()" wire-cancel="cancelForceDelete()" />

</section>

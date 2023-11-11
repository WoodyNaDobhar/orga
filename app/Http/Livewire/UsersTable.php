<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;

class UsersTable extends DataTableComponent
{
    protected $model = User::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        User::find($id)->delete();
        Flash::success('User deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Email", "email")
                ->sortable()
                ->searchable(),
            Column::make("Email Verified At", "email_verified_at")
                ->sortable()
                ->searchable(),
            Column::make("Password", "password")
                ->sortable()
                ->searchable(),
            Column::make("Remember Token", "remember_token")
                ->sortable()
                ->searchable(),
            Column::make("Is Restricted", "is_restricted")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('users.show', $row->id),
                        'editUrl' => route('users.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

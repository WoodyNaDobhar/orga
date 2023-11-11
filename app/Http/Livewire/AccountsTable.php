<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Account;

class AccountsTable extends DataTableComponent
{
    protected $model = Account::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Account::find($id)->delete();
        Flash::success('Account deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Parent Id", "parent_id")
                ->sortable()
                ->searchable(),
            Column::make("Accountable Type", "accountable_type")
                ->sortable()
                ->searchable(),
            Column::make("Accountable Id", "accountable_id")
                ->sortable()
                ->searchable(),
            Column::make("Name", "name")
                ->sortable()
                ->searchable(),
            Column::make("Type", "type")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('accounts.show', $row->id),
                        'editUrl' => route('accounts.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

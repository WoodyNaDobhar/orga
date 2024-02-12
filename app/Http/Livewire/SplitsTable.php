<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Split;

class SplitsTable extends DataTableComponent
{
    protected $model = Split::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Split::find($id)->delete();
        Flash::success('Split deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Account Id", "account_id")
                ->sortable()
                ->searchable(),
            Column::make("Persona Id", "persona_id")
                ->sortable()
                ->searchable(),
            Column::make("Transaction Id", "transaction_id")
                ->sortable()
                ->searchable(),
            Column::make("Amount", "amount")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('splits.show', $row->id),
                        'editUrl' => route('splits.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

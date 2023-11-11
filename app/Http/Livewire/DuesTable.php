<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Due;

class DuesTable extends DataTableComponent
{
    protected $model = Due::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Due::find($id)->delete();
        Flash::success('Due deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Persona Id", "persona_id")
                ->sortable()
                ->searchable(),
            Column::make("Transaction Id", "transaction_id")
                ->sortable()
                ->searchable(),
            Column::make("Dues On", "dues_on")
                ->sortable()
                ->searchable(),
            Column::make("Intervals", "intervals")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('dues.show', $row->id),
                        'editUrl' => route('dues.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

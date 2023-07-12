<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Reconciliation;

class ReconciliationsTable extends DataTableComponent
{
    protected $model = Reconciliation::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Reconciliation::find($id)->delete();
        Flash::success('Reconciliation deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Archetype Id", "archetype_id")
                ->sortable()
                ->searchable(),
            Column::make("User Id", "user_id")
                ->sortable()
                ->searchable(),
            Column::make("Is Reconciled", "is_reconciled")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('reconciliations.show', $row->id),
                        'editUrl' => route('reconciliations.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

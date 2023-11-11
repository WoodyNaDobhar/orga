<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Suspension;

class SuspensionsTable extends DataTableComponent
{
    protected $model = Suspension::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Suspension::find($id)->delete();
        Flash::success('Suspension deleted successfully.');
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
            Column::make("Kingdom Id", "kingdom_id")
                ->sortable()
                ->searchable(),
            Column::make("Suspended By", "suspended_by")
                ->sortable()
                ->searchable(),
            Column::make("Suspended At", "suspended_at")
                ->sortable()
                ->searchable(),
            Column::make("Expires At", "expires_at")
                ->sortable()
                ->searchable(),
            Column::make("Cause", "cause")
                ->sortable()
                ->searchable(),
            Column::make("Is Propogating", "is_propogating")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('suspensions.show', $row->id),
                        'editUrl' => route('suspensions.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Crat;

class CratsTable extends DataTableComponent
{
    protected $model = Crat::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Crat::find($id)->delete();
        Flash::success('Crat deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Event Id", "event_id")
                ->sortable()
                ->searchable(),
            Column::make("Persona Id", "persona_id")
                ->sortable()
                ->searchable(),
            Column::make("Role", "role")
                ->sortable()
                ->searchable(),
            Column::make("Is Autocrat", "is_autocrat")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('crats.show', $row->id),
                        'editUrl' => route('crats.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

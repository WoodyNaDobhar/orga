<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Parkrank;

class ParkranksTable extends DataTableComponent
{
    protected $model = Parkrank::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Parkrank::find($id)->delete();
        Flash::success('Parkrank deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Kingdom Id", "kingdom_id")
                ->sortable()
                ->searchable(),
            Column::make("Name", "name")
                ->sortable()
                ->searchable(),
            Column::make("Rank", "rank")
                ->sortable()
                ->searchable(),
            Column::make("Minimumattendance", "minimumattendance")
                ->sortable()
                ->searchable(),
            Column::make("Minimumcutoff", "minimumcutoff")
                ->sortable()
                ->searchable(),
            Column::make("Period", "period")
                ->sortable()
                ->searchable(),
            Column::make("Period Length", "period_length")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('parkranks.show', $row->id),
                        'editUrl' => route('parkranks.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Tournament;

class TournamentsTable extends DataTableComponent
{
    protected $model = Tournament::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Tournament::find($id)->delete();
        Flash::success('Tournament deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Tournamentable Type", "tournamentable_type")
                ->sortable()
                ->searchable(),
            Column::make("Tournamentable Id", "tournamentable_id")
                ->sortable()
                ->searchable(),
            Column::make("Name", "name")
                ->sortable()
                ->searchable(),
            Column::make("Description", "description")
                ->sortable()
                ->searchable(),
            Column::make("Url", "url")
                ->sortable()
                ->searchable(),
            Column::make("Occured At", "occured_at")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('tournaments.show', $row->id),
                        'editUrl' => route('tournaments.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

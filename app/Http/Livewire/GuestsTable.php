<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Guest;

class GuestsTable extends DataTableComponent
{
    protected $model = Guest::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Guest::find($id)->delete();
        Flash::success('Guest deleted successfully.');
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
            Column::make("Chapter Id", "chapter_id")
                ->sortable()
                ->searchable(),
            Column::make("Is Followedup", "is_followedup")
                ->sortable()
                ->searchable(),
            Column::make("Notes", "notes")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('guests.show', $row->id),
                        'editUrl' => route('guests.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

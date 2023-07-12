<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Park;

class ParksTable extends DataTableComponent
{
    protected $model = Park::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Park::find($id)->delete();
        Flash::success('Park deleted successfully.');
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
            Column::make("Parkrank Id", "parkrank_id")
                ->sortable()
                ->searchable(),
            Column::make("Location Id", "location_id")
                ->sortable()
                ->searchable(),
            Column::make("Name", "name")
                ->sortable()
                ->searchable(),
            Column::make("Abbreviation", "abbreviation")
                ->sortable()
                ->searchable(),
            Column::make("Heraldry", "heraldry")
                ->sortable()
                ->searchable(),
            Column::make("Url", "url")
                ->sortable()
                ->searchable(),
            Column::make("Is Active", "is_active")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('parks.show', $row->id),
                        'editUrl' => route('parks.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

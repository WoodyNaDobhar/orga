<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Title;

class TitlesTable extends DataTableComponent
{
    protected $model = Title::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Title::find($id)->delete();
        Flash::success('Title deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Titleable Type", "titleable_type")
                ->sortable()
                ->searchable(),
            Column::make("Titleable Id", "titleable_id")
                ->sortable()
                ->searchable(),
            Column::make("Name", "name")
                ->sortable()
                ->searchable(),
            Column::make("Rank", "rank")
                ->sortable()
                ->searchable(),
            Column::make("Peerage", "peerage")
                ->sortable()
                ->searchable(),
            Column::make("Is Roaming", "is_roaming")
                ->sortable()
                ->searchable(),
            Column::make("Is Active", "is_active")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('titles.show', $row->id),
                        'editUrl' => route('titles.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

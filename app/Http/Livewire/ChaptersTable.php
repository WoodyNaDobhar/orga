<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Chapter;

class ChaptersTable extends DataTableComponent
{
    protected $model = Chapter::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Chapter::find($id)->delete();
        Flash::success('Chapter deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Realm Id", "kingdom_id")
                ->sortable()
                ->searchable(),
            Column::make("Chaptertype Id", "chaptertype_id")
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
                        'showUrl' => route('chapters.show', $row->id),
                        'editUrl' => route('chapters.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

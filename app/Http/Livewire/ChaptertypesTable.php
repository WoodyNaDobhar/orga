<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Chaptertype;

class ChaptertypesTable extends DataTableComponent
{
    protected $model = Chaptertype::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Chaptertype::find($id)->delete();
        Flash::success('Chaptertype deleted successfully.');
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
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('chaptertypes.show', $row->id),
                        'editUrl' => route('chaptertypes.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

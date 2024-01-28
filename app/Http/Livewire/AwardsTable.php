<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Award;

class AwardsTable extends DataTableComponent
{
    protected $model = Award::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Award::find($id)->delete();
        Flash::success('Award deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Awarder Type", "awarder_type")
                ->sortable()
                ->searchable(),
            Column::make("Awarder Id", "awarder_id")
                ->sortable()
                ->searchable(),
            Column::make("Name", "name")
                ->sortable()
                ->searchable(),
            Column::make("Is Ladder", "is_ladder")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('awards.show', $row->id),
                        'editUrl' => route('awards.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\KingdomTitle;

class KingdomTitlesTable extends DataTableComponent
{
    protected $model = KingdomTitle::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        KingdomTitle::find($id)->delete();
        Flash::success('Kingdom Title deleted successfully.');
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
            Column::make("Title Id", "title_id")
                ->sortable()
                ->searchable(),
            Column::make("Custom Name", "custom_name")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('kingdom-titles.show', $row->id),
                        'editUrl' => route('kingdom-titles.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

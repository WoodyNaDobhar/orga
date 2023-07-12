<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Kingdom;

class KingdomsTable extends DataTableComponent
{
    protected $model = Kingdom::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Kingdom::find($id)->delete();
        Flash::success('Kingdom deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Parent Id", "parent_id")
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
            Column::make("Is Active", "is_active")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('kingdoms.show', $row->id),
                        'editUrl' => route('kingdoms.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

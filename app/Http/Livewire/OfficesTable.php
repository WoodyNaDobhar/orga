<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Office;

class OfficesTable extends DataTableComponent
{
    protected $model = Office::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Office::find($id)->delete();
        Flash::success('Office deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Officeable Type", "officeable_type")
                ->sortable()
                ->searchable(),
            Column::make("Officeable Id", "officeable_id")
                ->sortable()
                ->searchable(),
            Column::make("Name", "name")
                ->sortable()
                ->searchable(),
            Column::make("Duration", "duration")
                ->sortable()
                ->searchable(),
            Column::make("Order", "order")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('offices.show', $row->id),
                        'editUrl' => route('offices.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

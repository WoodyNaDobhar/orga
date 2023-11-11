<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Reign;

class ReignsTable extends DataTableComponent
{
    protected $model = Reign::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Reign::find($id)->delete();
        Flash::success('Reign deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Reignable Type", "reignable_type")
                ->sortable()
                ->searchable(),
            Column::make("Reignable Id", "reignable_id")
                ->sortable()
                ->searchable(),
            Column::make("Name", "name")
                ->sortable()
                ->searchable(),
            Column::make("Starts On", "starts_on")
                ->sortable()
                ->searchable(),
            Column::make("Ends On", "ends_on")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('reigns.show', $row->id),
                        'editUrl' => route('reigns.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

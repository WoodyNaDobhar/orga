<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\KingdomOffice;

class KingdomOfficesTable extends DataTableComponent
{
    protected $model = KingdomOffice::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        KingdomOffice::find($id)->delete();
        Flash::success('Kingdom Office deleted successfully.');
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
            Column::make("Office Id", "office_id")
                ->sortable()
                ->searchable(),
            Column::make("Custom Name", "custom_name")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('kingdom-offices.show', $row->id),
                        'editUrl' => route('kingdom-offices.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

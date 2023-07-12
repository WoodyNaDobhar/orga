<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Officer;

class OfficersTable extends DataTableComponent
{
    protected $model = Officer::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Officer::find($id)->delete();
        Flash::success('Officer deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Office Id", "office_id")
                ->sortable()
                ->searchable(),
            Column::make("User Id", "user_id")
                ->sortable()
                ->searchable(),
            Column::make("Authorized By", "authorized_by")
                ->sortable()
                ->searchable(),
            Column::make("Officerable Type", "officerable_type")
                ->sortable()
                ->searchable(),
            Column::make("Officerable Id", "officerable_id")
                ->sortable()
                ->searchable(),
            Column::make("Scope", "scope")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('officers.show', $row->id),
                        'editUrl' => route('officers.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

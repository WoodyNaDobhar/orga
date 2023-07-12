<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Attendance;

class AttendancesTable extends DataTableComponent
{
    protected $model = Attendance::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Attendance::find($id)->delete();
        Flash::success('Attendance deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("User Id", "user_id")
                ->sortable()
                ->searchable(),
            Column::make("Archetype Id", "archetype_id")
                ->sortable()
                ->searchable(),
            Column::make("Attendable Type", "attendable_type")
                ->sortable()
                ->searchable(),
            Column::make("Attendable Id", "attendable_id")
                ->sortable()
                ->searchable(),
            Column::make("Attended At", "attended_at")
                ->sortable()
                ->searchable(),
            Column::make("Credits", "credits")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('attendances.show', $row->id),
                        'editUrl' => route('attendances.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

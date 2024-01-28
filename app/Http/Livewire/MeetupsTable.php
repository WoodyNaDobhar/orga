<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Meetup;

class MeetupsTable extends DataTableComponent
{
    protected $model = Meetup::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Meetup::find($id)->delete();
        Flash::success('Meetup deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Chapter Id", "chapter_id")
                ->sortable()
                ->searchable(),
            Column::make("Location Id", "location_id")
                ->sortable()
                ->searchable(),
            Column::make("Is Active", "is_active")
                ->sortable()
                ->searchable(),
            Column::make("Purpose", "purpose")
                ->sortable()
                ->searchable(),
            Column::make("Recurrence", "recurrence")
                ->sortable()
                ->searchable(),
            Column::make("Week Of Month", "week_of_month")
                ->sortable()
                ->searchable(),
            Column::make("Week Day", "week_day")
                ->sortable()
                ->searchable(),
            Column::make("Month Day", "month_day")
                ->sortable()
                ->searchable(),
            Column::make("Occurs At", "occurs_at")
                ->sortable()
                ->searchable(),
            Column::make("Description", "description")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('meetups.show', $row->id),
                        'editUrl' => route('meetups.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Realm;

class RealmsTable extends DataTableComponent
{
    protected $model = Realm::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Realm::find($id)->delete();
        Flash::success('Realm deleted successfully.');
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
            Column::make("Color", "color")
                ->sortable()
                ->searchable(),
            Column::make("Heraldry", "heraldry")
                ->sortable()
                ->searchable(),
            Column::make("Is Active", "is_active")
                ->sortable()
                ->searchable(),
            Column::make("Credit Minimum", "credit_minimum")
                ->sortable()
                ->searchable(),
            Column::make("Credit Maximum", "credit_maximum")
                ->sortable()
                ->searchable(),
            Column::make("Daily Minimum", "daily_minimum")
                ->sortable()
                ->searchable(),
            Column::make("Weekly Minimum", "weekly_minimum")
                ->sortable()
                ->searchable(),
            Column::make("Average Period Type", "average_period_type")
                ->sortable()
                ->searchable(),
            Column::make("Average Period", "average_period")
                ->sortable()
                ->searchable(),
            Column::make("Dues Amount", "dues_amount")
                ->sortable()
                ->searchable(),
            Column::make("Dues Intervals Type", "dues_intervals_type")
                ->sortable()
                ->searchable(),
            Column::make("Dues Intervals", "dues_intervals")
                ->sortable()
                ->searchable(),
            Column::make("Dues Take", "dues_take")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('realms.show', $row->id),
                        'editUrl' => route('realms.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Configuration;

class ConfigurationsTable extends DataTableComponent
{
    protected $model = Configuration::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Configuration::find($id)->delete();
        Flash::success('Configuration deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Configurable Type", "configurable_type")
                ->sortable()
                ->searchable(),
            Column::make("Configurable Id", "configurable_id")
                ->sortable()
                ->searchable(),
            Column::make("Key", "key")
                ->sortable()
                ->searchable(),
            Column::make("Value", "value")
                ->sortable()
                ->searchable(),
            Column::make("Is User Setting", "is_user_setting")
                ->sortable()
                ->searchable(),
            Column::make("Allowed Values", "allowed_values")
                ->sortable()
                ->searchable(),
            Column::make("Modified", "modified")
                ->sortable()
                ->searchable(),
            Column::make("Var Type", "var_type")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('configurations.show', $row->id),
                        'editUrl' => route('configurations.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Social;

class SocialsTable extends DataTableComponent
{
    protected $model = Social::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Social::find($id)->delete();
        Flash::success('Social deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Sociable Type", "sociable_type")
                ->sortable()
                ->searchable(),
            Column::make("Sociable Id", "sociable_id")
                ->sortable()
                ->searchable(),
            Column::make("Media", "media")
                ->sortable()
                ->searchable(),
            Column::make("Value", "value")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('socials.show', $row->id),
                        'editUrl' => route('socials.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

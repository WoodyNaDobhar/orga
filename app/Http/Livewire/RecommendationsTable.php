<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Recommendation;

class RecommendationsTable extends DataTableComponent
{
    protected $model = Recommendation::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Recommendation::find($id)->delete();
        Flash::success('Recommendation deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Persona Id", "persona_id")
                ->sortable()
                ->searchable(),
            Column::make("Recommendable Type", "recommendable_type")
                ->sortable()
                ->searchable(),
            Column::make("Recommendable Id", "recommendable_id")
                ->sortable()
                ->searchable(),
            Column::make("Rank", "rank")
                ->sortable()
                ->searchable(),
            Column::make("Is Anonymous", "is_anonymous")
                ->sortable()
                ->searchable(),
            Column::make("Reason", "reason")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('recommendations.show', $row->id),
                        'editUrl' => route('recommendations.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

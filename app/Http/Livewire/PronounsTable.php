<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Pronoun;

class PronounsTable extends DataTableComponent
{
    protected $model = Pronoun::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Pronoun::find($id)->delete();
        Flash::success('Pronoun deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Subject", "subject")
                ->sortable()
                ->searchable(),
            Column::make("Object", "object")
                ->sortable()
                ->searchable(),
            Column::make("Possessive", "possessive")
                ->sortable()
                ->searchable(),
            Column::make("Possessivepronoun", "possessivepronoun")
                ->sortable()
                ->searchable(),
            Column::make("Reflexive", "reflexive")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('pronouns.show', $row->id),
                        'editUrl' => route('pronouns.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

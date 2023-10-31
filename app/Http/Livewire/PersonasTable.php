<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Persona;

class PersonasTable extends DataTableComponent
{
    protected $model = Persona::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Persona::find($id)->delete();
        Flash::success('Persona deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Park Id", "park_id")
                ->sortable()
                ->searchable(),
            Column::make("User Id", "user_id")
                ->sortable()
                ->searchable(),
            Column::make("Pronoun Id", "pronoun_id")
                ->sortable()
                ->searchable(),
            Column::make("Mundane", "mundane")
                ->sortable()
                ->searchable(),
            Column::make("Persona", "persona")
                ->sortable()
                ->searchable(),
            Column::make("Heraldry", "heraldry")
                ->sortable()
                ->searchable(),
            Column::make("Image", "image")
                ->sortable()
                ->searchable(),
            Column::make("Restricted", "restricted")
                ->sortable()
                ->searchable(),
            Column::make("Waivered", "waivered")
                ->sortable()
                ->searchable(),
            Column::make("Waiver Ext", "waiver_ext")
                ->sortable()
                ->searchable(),
            Column::make("Penalty Box", "penalty_box")
                ->sortable()
                ->searchable(),
            Column::make("Is Active", "is_active")
                ->sortable()
                ->searchable(),
            Column::make("Reeve Qualified Expires", "reeve_qualified_expires")
                ->sortable()
                ->searchable(),
            Column::make("Corpora Qualified Expires", "corpora_qualified_expires")
                ->sortable()
                ->searchable(),
            Column::make("Joined Park At", "joined_park_at")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('personas.show', $row->id),
                        'editUrl' => route('personas.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

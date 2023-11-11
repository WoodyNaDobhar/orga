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
            Column::make("Chapter Id", "chapter_id")
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
            Column::make("Name", "name")
                ->sortable()
                ->searchable(),
            Column::make("Heraldry", "heraldry")
                ->sortable()
                ->searchable(),
            Column::make("Image", "image")
                ->sortable()
                ->searchable(),
            Column::make("Is Active", "is_active")
                ->sortable()
                ->searchable(),
            Column::make("Reeve Qualified Expires At", "reeve_qualified_expires_at")
                ->sortable()
                ->searchable(),
            Column::make("Corpora Qualified Expires At", "corpora_qualified_expires_at")
                ->sortable()
                ->searchable(),
            Column::make("Joined Chapter At", "joined_chapter_at")
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

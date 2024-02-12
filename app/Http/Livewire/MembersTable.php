<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Member;

class MembersTable extends DataTableComponent
{
    protected $model = Member::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Member::find($id)->delete();
        Flash::success('Member deleted successfully.');
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
            Column::make("Unit Id", "unit_id")
                ->sortable()
                ->searchable(),
            Column::make("Is Head", "is_head")
                ->sortable()
                ->searchable(),
            Column::make("Is Voting", "is_voting")
                ->sortable()
                ->searchable(),
            Column::make("Joined At", "joined_at")
                ->sortable()
                ->searchable(),
            Column::make("Left At", "left_at")
                ->sortable()
                ->searchable(),
            Column::make("Notes", "notes")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('members.show', $row->id),
                        'editUrl' => route('members.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Waiver;

class WaiversTable extends DataTableComponent
{
    protected $model = Waiver::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Waiver::find($id)->delete();
        Flash::success('Waiver deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Guest Id", "guest_id")
                ->sortable()
                ->searchable(),
            Column::make("Location Id", "location_id")
                ->sortable()
                ->searchable(),
            Column::make("Pronoun Id", "pronoun_id")
                ->sortable()
                ->searchable(),
            Column::make("Persona Id", "persona_id")
                ->sortable()
                ->searchable(),
            Column::make("Waiverable Type", "waiverable_type")
                ->sortable()
                ->searchable(),
            Column::make("Waiverable Id", "waiverable_id")
                ->sortable()
                ->searchable(),
            Column::make("File", "file")
                ->sortable()
                ->searchable(),
            Column::make("Player", "player")
                ->sortable()
                ->searchable(),
            Column::make("Email", "email")
                ->sortable()
                ->searchable(),
            Column::make("Phone", "phone")
                ->sortable()
                ->searchable(),
            Column::make("Dob", "dob")
                ->sortable()
                ->searchable(),
            Column::make("Age Verified At", "age_verified_at")
                ->sortable()
                ->searchable(),
            Column::make("Age Verified By", "age_verified_by")
                ->sortable()
                ->searchable(),
            Column::make("Guardian", "guardian")
                ->sortable()
                ->searchable(),
            Column::make("Emergency Name", "emergency_name")
                ->sortable()
                ->searchable(),
            Column::make("Emergency Relationship", "emergency_relationship")
                ->sortable()
                ->searchable(),
            Column::make("Emergency Phone", "emergency_phone")
                ->sortable()
                ->searchable(),
            Column::make("Signed At", "signed_at")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('waivers.show', $row->id),
                        'editUrl' => route('waivers.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

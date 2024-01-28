<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Issuance;

class IssuancesTable extends DataTableComponent
{
    protected $model = Issuance::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Issuance::find($id)->delete();
        Flash::success('Issuance deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Issuable Type", "issuable_type")
                ->sortable()
                ->searchable(),
            Column::make("Issuable Id", "issuable_id")
                ->sortable()
                ->searchable(),
            Column::make("Whereable Type", "whereable_type")
                ->sortable()
                ->searchable(),
            Column::make("Whereable Id", "whereable_id")
                ->sortable()
                ->searchable(),
            Column::make("Authority Type", "authority_type")
                ->sortable()
                ->searchable(),
            Column::make("Authority Id", "authority_id")
                ->sortable()
                ->searchable(),
            Column::make("Recipient Type", "recipient_type")
                ->sortable()
                ->searchable(),
            Column::make("Recipient Id", "recipient_id")
                ->sortable()
                ->searchable(),
            Column::make("Issuer Id", "issuer_id")
                ->sortable()
                ->searchable(),
            Column::make("Custom Name", "custom_name")
                ->sortable()
                ->searchable(),
            Column::make("Rank", "rank")
                ->sortable()
                ->searchable(),
            Column::make("Issued At", "issued_at")
                ->sortable()
                ->searchable(),
            Column::make("Reason", "reason")
                ->sortable()
                ->searchable(),
            Column::make("Image", "image")
                ->sortable()
                ->searchable(),
            Column::make("Revoked By", "revoked_by")
                ->sortable()
                ->searchable(),
            Column::make("Revoked At", "revoked_at")
                ->sortable()
                ->searchable(),
            Column::make("Revocation", "revocation")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('issuances.show', $row->id),
                        'editUrl' => route('issuances.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

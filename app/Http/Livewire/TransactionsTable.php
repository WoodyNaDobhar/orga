<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Transaction;

class TransactionsTable extends DataTableComponent
{
    protected $model = Transaction::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Transaction::find($id)->delete();
        Flash::success('Transaction deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Description", "description")
                ->sortable()
                ->searchable(),
            Column::make("Memo", "memo")
                ->sortable()
                ->searchable(),
            Column::make("Transaction At", "transaction_at")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('transactions.show', $row->id),
                        'editUrl' => route('transactions.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

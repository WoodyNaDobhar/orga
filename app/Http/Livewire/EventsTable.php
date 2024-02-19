<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Event;

class EventsTable extends DataTableComponent
{
	protected $model = Event::class;

	protected $listeners = ['deleteRecord' => 'deleteRecord'];

	public function deleteRecord($id)
	{
		Event::find($id)->delete();
		Flash::success('Event deleted successfully.');
		$this->emit('refreshDatatable');
	}

	public function configure(): void
	{
		$this->setPrimaryKey('id');
	}

	public function columns(): array
	{
		return [
			Column::make("Eventable Type", "eventable_type")
				->sortable()
				->searchable(),
			Column::make("Eventable Id", "eventable_id")
				->sortable()
				->searchable(),
			Column::make("Sponsorable Type", "sponsorable_type")
				->sortable()
				->searchable(),
			Column::make("Sponsorable Id", "sponsorable_id")
				->sortable()
				->searchable(),
			Column::make("Location Id", "location_id")
				->sortable()
				->searchable(),
			Column::make("Name", "name")
				->sortable()
				->searchable(),
			Column::make("Description", "description")
				->sortable()
				->searchable(),
			Column::make("Image", "image")
				->sortable()
				->searchable(),
			Column::make("Is Active", "is_active")
				->sortable()
				->searchable(),
			Column::make("Is Demo", "is_demo")
				->sortable()
				->searchable(),
			Column::make("Event Started At", "event_started_at")
				->sortable()
				->searchable(),
			Column::make("Event Ended At", "event_ended_at")
				->sortable()
				->searchable(),
			Column::make("Price", "price")
				->sortable()
				->searchable(),
			Column::make("Actions", 'id')
				->format(
					fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
						'showUrl' => route('events.show', $row->id),
						'editUrl' => route('events.edit', $row->id),
						'recordId' => $row->id,
					])
				)
		];
	}
}

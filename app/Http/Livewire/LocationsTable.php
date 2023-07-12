<?php

namespace App\Http\Livewire;

use Laracasts\Flash\Flash;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Location;

class LocationsTable extends DataTableComponent
{
    protected $model = Location::class;

    protected $listeners = ['deleteRecord' => 'deleteRecord'];

    public function deleteRecord($id)
    {
        Location::find($id)->delete();
        Flash::success('Location deleted successfully.');
        $this->emit('refreshDatatable');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Address", "address")
                ->sortable()
                ->searchable(),
            Column::make("City", "city")
                ->sortable()
                ->searchable(),
            Column::make("Province", "province")
                ->sortable()
                ->searchable(),
            Column::make("Postal Code", "postal_code")
                ->sortable()
                ->searchable(),
            Column::make("Google Geocode", "google_geocode")
                ->sortable()
                ->searchable(),
            Column::make("Latitude", "latitude")
                ->sortable()
                ->searchable(),
            Column::make("Longitude", "longitude")
                ->sortable()
                ->searchable(),
            Column::make("Location", "location")
                ->sortable()
                ->searchable(),
            Column::make("Map Url", "map_url")
                ->sortable()
                ->searchable(),
            Column::make("Description", "description")
                ->sortable()
                ->searchable(),
            Column::make("Directions", "directions")
                ->sortable()
                ->searchable(),
            Column::make("Actions", 'id')
                ->format(
                    fn($value, $row, Column $column) => view('common.livewire-tables.actions', [
                        'showUrl' => route('locations.show', $row->id),
                        'editUrl' => route('locations.edit', $row->id),
                        'recordId' => $row->id,
                    ])
                )
        ];
    }
}

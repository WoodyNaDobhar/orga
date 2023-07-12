<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateKingdomOfficeRequest;
use App\Http\Requests\UpdateKingdomOfficeRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\KingdomOfficeRepository;
use Illuminate\Http\Request;
use Flash;

class KingdomOfficeController extends AppBaseController
{
    /** @var KingdomOfficeRepository $kingdomOfficeRepository*/
    private $kingdomOfficeRepository;

    public function __construct(KingdomOfficeRepository $kingdomOfficeRepo)
    {
        $this->kingdomOfficeRepository = $kingdomOfficeRepo;
    }

    /**
     * Display a listing of the KingdomOffice.
     */
    public function index(Request $request)
    {
        return view('kingdom_offices.index');
    }

    /**
     * Show the form for creating a new KingdomOffice.
     */
    public function create()
    {
        return view('kingdom_offices.create');
    }

    /**
     * Store a newly created KingdomOffice in storage.
     */
    public function store(CreateKingdomOfficeRequest $request)
    {
        $input = $request->all();

        $kingdomOffice = $this->kingdomOfficeRepository->create($input);

        Flash::success('Kingdom Office saved successfully.');

        return redirect(route('kingdomOffices.index'));
    }

    /**
     * Display the specified KingdomOffice.
     */
    public function show($id)
    {
        $kingdomOffice = $this->kingdomOfficeRepository->find($id);

        if (empty($kingdomOffice)) {
            Flash::error('Kingdom Office not found');

            return redirect(route('kingdomOffices.index'));
        }

        return view('kingdom_offices.show')->with('kingdomOffice', $kingdomOffice);
    }

    /**
     * Show the form for editing the specified KingdomOffice.
     */
    public function edit($id)
    {
        $kingdomOffice = $this->kingdomOfficeRepository->find($id);

        if (empty($kingdomOffice)) {
            Flash::error('Kingdom Office not found');

            return redirect(route('kingdomOffices.index'));
        }

        return view('kingdom_offices.edit')->with('kingdomOffice', $kingdomOffice);
    }

    /**
     * Update the specified KingdomOffice in storage.
     */
    public function update($id, UpdateKingdomOfficeRequest $request)
    {
        $kingdomOffice = $this->kingdomOfficeRepository->find($id);

        if (empty($kingdomOffice)) {
            Flash::error('Kingdom Office not found');

            return redirect(route('kingdomOffices.index'));
        }

        $kingdomOffice = $this->kingdomOfficeRepository->update($request->all(), $id);

        Flash::success('Kingdom Office updated successfully.');

        return redirect(route('kingdomOffices.index'));
    }

    /**
     * Remove the specified KingdomOffice from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $kingdomOffice = $this->kingdomOfficeRepository->find($id);

        if (empty($kingdomOffice)) {
            Flash::error('Kingdom Office not found');

            return redirect(route('kingdomOffices.index'));
        }

        $this->kingdomOfficeRepository->delete($id);

        Flash::success('Kingdom Office deleted successfully.');

        return redirect(route('kingdomOffices.index'));
    }
}

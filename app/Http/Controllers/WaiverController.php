<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWaiverRequest;
use App\Http\Requests\UpdateWaiverRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\WaiverRepository;
use Illuminate\Http\Request;
use Flash;

class WaiverController extends AppBaseController
{
    /** @var WaiverRepository $waiverRepository*/
    private $waiverRepository;

    public function __construct(WaiverRepository $waiverRepo)
    {
        $this->waiverRepository = $waiverRepo;
    }

    /**
     * Display a listing of the Waiver.
     */
    public function index(Request $request)
    {
        return view('waivers.index');
    }

    /**
     * Show the form for creating a new Waiver.
     */
    public function create()
    {
        return view('waivers.create');
    }

    /**
     * Store a newly created Waiver in storage.
     */
    public function store(CreateWaiverRequest $request)
    {
        $input = $request->all();

        $waiver = $this->waiverRepository->create($input);

        Flash::success('Waiver saved successfully.');

        return redirect(route('waivers.index'));
    }

    /**
     * Display the specified Waiver.
     */
    public function show($id)
    {
        $waiver = $this->waiverRepository->find($id);

        if (empty($waiver)) {
            Flash::error('Waiver not found');

            return redirect(route('waivers.index'));
        }

        return view('waivers.show')->with('waiver', $waiver);
    }

    /**
     * Show the form for editing the specified Waiver.
     */
    public function edit($id)
    {
        $waiver = $this->waiverRepository->find($id);

        if (empty($waiver)) {
            Flash::error('Waiver not found');

            return redirect(route('waivers.index'));
        }

        return view('waivers.edit')->with('waiver', $waiver);
    }

    /**
     * Update the specified Waiver in storage.
     */
    public function update($id, UpdateWaiverRequest $request)
    {
        $waiver = $this->waiverRepository->find($id);

        if (empty($waiver)) {
            Flash::error('Waiver not found');

            return redirect(route('waivers.index'));
        }

        $waiver = $this->waiverRepository->update($request->all(), $id);

        Flash::success('Waiver updated successfully.');

        return redirect(route('waivers.index'));
    }

    /**
     * Remove the specified Waiver from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $waiver = $this->waiverRepository->find($id);

        if (empty($waiver)) {
            Flash::error('Waiver not found');

            return redirect(route('waivers.index'));
        }

        $this->waiverRepository->delete($id);

        Flash::success('Waiver deleted successfully.');

        return redirect(route('waivers.index'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGuestRequest;
use App\Http\Requests\UpdateGuestRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\GuestRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class GuestController extends AppBaseController
{
    /** @var GuestRepository $guestRepository*/
    private $guestRepository;

    public function __construct(GuestRepository $guestRepo)
    {
        $this->guestRepository = $guestRepo;
    }

    /**
     * Display a listing of the Guest.
     */
    public function index(Request $request)
    {
        return view('guests.index');
    }

    /**
     * Show the form for creating a new Guest.
     */
    public function create()
    {
        return view('guests.create');
    }

    /**
     * Store a newly created Guest in storage.
     */
    public function store(CreateGuestRequest $request)
    {
        $input = $request->all();

        $guest = $this->guestRepository->create($input);

        Flash::success('Guest saved successfully.');

        return redirect(route('guests.index'));
    }

    /**
     * Display the specified Guest.
     */
    public function show($id)
    {
        $guest = $this->guestRepository->find($id);

        if (empty($guest)) {
            Flash::error('Guest not found');

            return redirect(route('guests.index'));
        }

        return view('guests.show')->with('guest', $guest);
    }

    /**
     * Show the form for editing the specified Guest.
     */
    public function edit($id)
    {
        $guest = $this->guestRepository->find($id);

        if (empty($guest)) {
            Flash::error('Guest not found');

            return redirect(route('guests.index'));
        }

        return view('guests.edit')->with('guest', $guest);
    }

    /**
     * Update the specified Guest in storage.
     */
    public function update($id, UpdateGuestRequest $request)
    {
        $guest = $this->guestRepository->find($id);

        if (empty($guest)) {
            Flash::error('Guest not found');

            return redirect(route('guests.index'));
        }

        $guest = $this->guestRepository->update($request->all(), $id);

        Flash::success('Guest updated successfully.');

        return redirect(route('guests.index'));
    }

    /**
     * Remove the specified Guest from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $guest = $this->guestRepository->find($id);

        if (empty($guest)) {
            Flash::error('Guest not found');

            return redirect(route('guests.index'));
        }

        $this->guestRepository->delete($id);

        Flash::success('Guest deleted successfully.');

        return redirect(route('guests.index'));
    }
}
